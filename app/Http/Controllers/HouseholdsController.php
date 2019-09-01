<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Household;
use Auth;

class HouseholdsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Get todays stats for the chart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response JSON
     */
    public function getTodaysData(Request $request, $id){
        $household = Household::findOrFail($id);
        if($household != null){
            // get monthly data
            $expenses = $household->expenses()
            ->whereDay('expense_made_at', '=', date('d'))
            ->whereMonth('expense_made_at', '=', date('m'))
            ->orderBy('expense_made_at', 'asc')->get();

            $amounts = array();
            $hours = array();
            $last_hour = null;
            $current_hour_amount = 0;
            foreach ($expenses as $expense) {
                $timestamp = strtotime($expense->expense_made_at);
                $hour = date('H', $timestamp);
                if($last_hour == null){
                    $current_hour_amount += $expense->amount;
                }
                elseif($last_hour == $hour){
                    $current_hour_amount += $expense->amount;
                }
                if($last_hour != null && $last_hour != $hour){
                    array_push($hours, $last_hour);
                    array_push($amounts, $current_hour_amount);
                    $current_hour_amount = $expense->amount;
                }
                $last_hour = $hour;
            }
            array_push($hours, $last_hour);
            array_push($amounts, $current_hour_amount);

            return response()->json([
                'success' => true,
                'values' => $amounts,
                'labels' => $hours,
            ]);
        }
        else{
            return response()->json(['success' => false]);
        }
    }

    /**
     * Get monthly stats for the chart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response JSON
     */
    public function getMonthlyData(Request $request, $id){
        $household = Household::findOrFail($id);
        if($household != null){
            // get monthly data
            $expenses = $household->expenses()->whereYear('expense_made_at', '=', date('Y'))->orderBy('expense_made_at', 'asc')->get();

            $amounts = array();
            $months = array();
            $last_month = null;
            $current_month_amount = 0;
            foreach ($expenses as $expense) {
                $timestamp = strtotime($expense->expense_made_at);
                $month = date('M', $timestamp);
                if($last_month == null){
                    $current_month_amount += $expense->amount;
                }
                elseif($last_month == $month){
                    $current_month_amount += $expense->amount;
                }
                if($last_month != null && $last_month != $month){
                    array_push($months, $last_month);
                    array_push($amounts, $current_month_amount);
                    $current_month_amount = $expense->amount;
                }
                $last_month = $month;
            }
            array_push($months, $last_month);
            array_push($amounts, $current_month_amount);

            return response()->json([
                'success' => true,
                'values' => $amounts,
                'labels' => $months,
            ]);
        }
        else{
            return response()->json(['success' => false]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $households = $user->households()->paginate(10);
        $data = [
            'households' => $households
        ];

        return view('households.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currenices = \App\Currency::all();
        $data = [
            'currencies' => $currenices
        ];
        return view('households.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currenices_count = count(\App\Currency::all());

        $validation = [
            'name' => 'required|string|max:191',
            'currency' => 'required|integer|min:1|max:' . $currenices_count,
            'monthly_income' => 'required|integer|min:100',
            'expected_monthly_savings' => 'required|integer|min:100',
            'current_state' => 'nullable|integer',
            'budget_reset_day' => 'required|integer|min:1|max:31'
        ];

        $request->validate($validation);

        $household = new Household();
        $household->user_id = Auth::id();
        $household->name = $request->input('name');
        $household->currency_id = $request->input('currency');
        $household->monthly_income = $request->input('monthly_income');
        $household->expected_monthly_savings = $request->input('expected_monthly_savings');
        if($request->input('current_state') != null){
            $household->current_state = $request->input('current_state');
        }
        else{
            $household->current_state = $request->input('monthly_income');
        }
        $household->budget_reset_day = $request->input('budget_reset_day');
        $household->save();

        toastr()->success('Household created!');

        return redirect('/households');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $household = Household::findOrFail($id);
        if($household != null && $household->user_id == Auth::id()){
            // get all expenses
            $expenses = $household->expenses()->whereYear('expense_made_at', '=', date('Y'))->whereMonth('expense_made_at', '=', date('m'))->orderBy('expense_made_at', 'desc')->paginate(10);

            // get all members
            $members = $household->members()->orderBy('additional_income', 'desc')->paginate(5);

            // generate monthly income base on monthly income from household + any other members that have additional income
            $monthly_income = $household->getTotalIncome();

            // get categories for expense form
            $categories = \App\ExpenseCategory::all();

            // get expenses by category
            $expenses_by_category = DB::table('expenses')
                                    ->select(DB::raw('sum(amount) as total'), 'category_id', 'expense_categories.name as category_name', 'expense_categories.hex_color as category_color')
                                    ->whereYear('expense_made_at', '=', date('Y'))
                                    ->whereMonth('expense_made_at', '=', date('m'))
                                    ->leftJoin('expense_categories', 'expenses.category_id', '=', 'expense_categories.id')
                                    ->groupBy('category_id')
                                    ->get();

            // var_dump($expenses_by_category);
            // exit();

            $data = [
                'household' => $household,
                'expenses' => $expenses,
                'members' => $members,
                'monthly_income' => $monthly_income,
                'expense_categories' => $categories,
                'expenses_by_category' => $expenses_by_category
            ];

            return view('households.show')->with($data);
        }
        else{
            toastr()->error('This is not your household');
            return redirect('/households');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
