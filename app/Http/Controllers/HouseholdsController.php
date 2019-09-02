<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Household;
use Auth;
use Session;

class HouseholdsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function resetExpensesList(Request $request){
        Session::forget('expense_list_view_year');
        Session::forget('expense_list_view_month_string');
        Session::forget('expense_list_view_month');

        return redirect()->back();
    }

    public function goThroughTimeForExpensesList($household, $interval){
        if(!Session::has('expense_list_view_year') &&
        !Session::has('expense_list_view_month_string') &&
        !Session::has('expense_list_view_month')){
            Session::put('expense_list_view_year', date("Y"));
            Session::put('expense_list_view_month_string', date("M"));
            Session::put('expense_list_view_month', date("m"));
        }

        $current_view_month = Session::get('expense_list_view_month');
        $current_view_year = Session::get('expense_list_view_year');

        $datetime = new \DateTime($current_view_year . '-' . $current_view_month);
        $modified = $datetime->modify($interval);

        Session::put('expense_list_view_month_string', $modified->format('M'));
        Session::put('expense_list_view_month', $modified->format('m'));
        Session::put('expense_list_view_year', $modified->format('Y'));
    }

    // gets expenses from previous month (previous month from one stored in session)
    public function loadExpensesFromPreviousMonth(Request $request, $id){
        $household = \App\Household::findOrFail($id);
        if($household != null && $household->owner->id == Auth::id()){
            $this->goThroughTimeForExpensesList($household, "-1 months");

            return redirect()->back();
        }
        else{
            return redirect()->back()->with('error', 'Access denied');
        }
    }

    // gets expenses from next month (next month from one stored in session)
    public function loadExpensesFromNextMonth(Request $request, $id){
        $household = \App\Household::findOrFail($id);
        if($household != null && $household->owner->id == Auth::id()){
            $this->goThroughTimeForExpensesList($household, "+1 months");

            return redirect()->back();
        }
        else{
            return redirect()->back()->with('error', 'Access denied');
        }
    }
    
    // return expenses grouped by category
    public function getExpensesByCategory(Request $request, $id){
        $household = Household::findOrFail($id);
        if($household != null && $household->owner->id == Auth::id()){

            $expenses = $household->fetchExpensesByCategory(null, date('m'), date('Y'));

            return response()->json([
                'success' => true,
                'expenses' => $expenses
            ]);
        }
        else{
            return response()->json(['success' => false]);
        }
    }

    // returns current week data
    public function getCurrentWeekData(Request $request, $id){
        $household = Household::findOrFail($id);
        if($household != null && $household->owner->id == Auth::id()){

            $expenses = $household->fetchCurrentWeekData();

            return response()->json([
                'success' => true,
                'expenses' => $expenses
            ]);
        }
        else{
            return response()->json(['success' => false]);
        }
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
        if($household != null && $household->owner->id == Auth::id()){

            $expenses = $household->fetchDayExpenses(date('d'), date('m'), date('Y'));

            return response()->json([
                'success' => true,
                'expenses' => $expenses
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
        if($household != null && $household->owner->id == Auth::id()){

            $expenses = $household->fetchMonthlyExpenses(date("Y"));

            return response()->json([
                'success' => true,
                'expenses' => $expenses
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
            'expected_monthly_savings' => 'nullable|integer|min:0',
            'current_state' => 'nullable|integer|min:0',
            'budget_reset_day' => 'required|integer|min:1|max:31'
        ];

        $request->validate($validation);

        $household = new Household();
        $household->user_id = Auth::id();
        $household->name = $request->input('name');
        $household->currency_id = $request->input('currency');
        $household->monthly_income = $request->input('monthly_income');
        if($request->input('expected_monthly_savings') != null){
            $household->expected_monthly_savings = $request->input('expected_monthly_savings');
        }
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
            // viewing month for expenses table
            if(!Session::has('expense_list_view_year') &&
            !Session::has('expense_list_view_month_string') &&
            !Session::has('expense_list_view_month')){
                Session::put('expense_list_view_year', date("Y"));
                Session::put('expense_list_view_month_string', date("M"));
                Session::put('expense_list_view_month', date("m"));
            }

            // get all expenses
            $expenses = $household->fetchExpenses(null, Session::get('expense_list_view_month'), Session::get('expense_list_view_year'))->orderBy('expense_made_at', 'desc');

            $total_monthly_expenses = 0;
            foreach ($expenses->get() as $expense) {
                $total_monthly_expenses += $expense->amount;
            }

            // get all members
            $members = $household->members()->orderBy('additional_income', 'desc')->paginate(5);

            // generate monthly income base on monthly income from household + any other members that have additional income
            $monthly_income = $household->getTotalIncome();

            // get categories for expense form
            $categories = \App\ExpenseCategory::all();

            // viewing months for charts
            

            $data = [
                'currencies' => \App\Currency::all(), // for the household edit form
                'household' => $household, // household info
                'expenses' => $expenses->paginate(10), // expenses list
                'total_expenses' => $total_monthly_expenses, // total expenses from current month
                'members' => $members, // members of the household
                'monthly_income' => $monthly_income, // monthly income that is household.monthly_incom + each memebrs additional income
                'expense_categories' => $categories, // categories for expense form
                'expense_list_current_date' => [
                    'month' => Session::get('expense_list_view_month_string'),
                    'year' => Session::get('expense_list_view_year')
                ], // current date to show above expense list
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
        $currenices_count = count(\App\Currency::all());

        $validation = [
            'name' => 'required|string|max:191',
            'currency' => 'required|integer|min:1|max:' . $currenices_count,
            'monthly_income' => 'required|integer',
            'expected_monthly_savings' => 'nullable|integer|min:0',
            'budget_reset_day' => 'required|integer|min:1|max:31'
        ];

        $request->validate($validation);

        $household = \App\Household::findOrFail($id);
        if($household != null && $household->owner->id == Auth::id()){
            $household->name = $request->input('name');
            $household->currency_id = $request->input('currency');
            $household->monthly_income = $request->input('monthly_income');
            if($request->input('expected_monthly_savings') != null){
                $household->expected_monthly_savings = $request->input('expected_monthly_savings');
            }
            $household->budget_reset_day = $request->input('budget_reset_day');
            $household->save();

            toastr()->success('Household updated!');

            return redirect('/households' . '/' . $id);
        }
        else{
            toastr()->error('Access denied');
            return redirect()->back();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $household = \App\Household::findOrFail($id);
        if($household != null && $household->owner->id == Auth::id()){
            $household->delete();

            toastr()->success('Household removed!');
            return redirect('/dashboard');
        }
        else{
            toastr()->error('Household not found!');
            return redirect('/dashboard');
        }
    }
}
