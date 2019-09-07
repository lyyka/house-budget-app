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

    // EXPENSES LIST BACK AND FORTH WITH THE MONTHS
    public function resetExpensesList(Request $request){
        Session::forget('expense_list_view_year');
        Session::forget('expense_list_view_month');

        return redirect()->back();
    }

    // changes session variables for expenses list
    public function goThroughTimeForExpensesList($household, $interval){
        if(!Session::has('expense_list_view_year') &&
        !Session::has('expense_list_view_month')){
            Session::put('expense_list_view_year', date("Y"));
            Session::put('expense_list_view_month', date("m"));
        }

        $current_view_month = Session::get('expense_list_view_month');
        $current_view_year = Session::get('expense_list_view_year');

        $datetime = new \DateTime($current_view_year . '-' . $current_view_month);
        $modified = $datetime->modify($interval);

        Session::put('expense_list_view_month', $modified->format('m'));
        Session::put('expense_list_view_year', $modified->format('Y'));
    }

    // gets expenses from previous month (previous month from one stored in session)
    public function loadExpensesFromPreviousMonth(Request $request, $id){
        $household = \App\Household::findOrFail($id);
        if($household != null && $household->authUserHasAccess()){
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
        if($household != null && $household->authUserHasAccess()){
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
        if($household != null && $household->authUserHasAccess()){

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

    // returns custom data range (by default returns this week only)
    public function getCustomDataRange(Request $request, $id){
        $household = Household::findOrFail($id);
        if($household != null && $household->authUserHasAccess()){

            $query_start_date = $request->query('start');
            $query_end_date = $request->query('end');
            $expenses = $household->fetchDataRange($query_start_date, $query_end_date);

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
    public function getDailyDataByHour(Request $request, $id, $day = null){
        $household = Household::findOrFail($id);
        if($household != null && $household->authUserHasAccess()){

            $display_day = date('d');
            $display_month = date('m');
            $display_year = date('Y');
            if($day != null){
                $carbon = \Carbon\Carbon::parse($day);
                $display_day = $carbon->format('d');
                $display_month = $carbon->format('m');
                $display_year = $carbon->format('Y');
            }
            $expenses = $household->fetchDayExpenses($display_day, $display_month, $display_year);

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
    public function getMonthlyData(Request $request, $id, $year){
        $household = Household::findOrFail($id);
        if($household != null && $household->authUserHasAccess()){

            $expenses = $household->fetchMonthlyExpenses($year);

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
        $shared_households = $user->sharedHouseholds;
        $data = [
            'households' => $households,
            'shared_households' => $shared_households
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
        $household->options = null;
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
        if($household != null && $household->authUserHasAccess()){
            // viewing month for expenses table
            if(!Session::has('expense_list_view_year') &&
            !Session::has('expense_list_view_month')){
                Session::put('expense_list_view_year', date("Y"));
                Session::put('expense_list_view_month', date("m"));
            }

            // get all expenses
            $expenses = $household->fetchExpenses(null, Session::get('expense_list_view_month'), Session::get('expense_list_view_year'))->orderBy('created_at', 'desc');

            $total_monthly_expenses = 0;
            foreach ($expenses->get() as $expense) {
                $total_monthly_expenses += $expense->amount;
            }

            // get all members
            if($household->authUserCanViewMembers()){
                $members = $household->members()->orderBy('additional_income', 'desc')->paginate(5);
            }

            // generate monthly income base on monthly income from household + any other members that have additional income
            $monthly_income = $household->getTotalIncome();

            // get categories for expense form
            $categories = \App\ExpenseCategory::all();

            // shared with
            $shared_with_currently = $household->getShares;
            $sharing_permissions_list = \App\SharingPermission::all();

            $data = [
                'currencies' => \App\Currency::all(), // for the household edit form
                'household' => $household, // household info
                'expenses' => $expenses->paginate(10), // expenses list
                'total_expenses' => $total_monthly_expenses, // total expenses from current month
                'members' => $members, // members of the household
                'monthly_income' => $monthly_income, // monthly income that is household.monthly_incom + each memebrs additional income
                'expense_categories' => $categories, // categories for expense form
                'expense_list_current_date' => [
                    'month' => Session::get('expense_list_view_month'),
                    'year' => Session::get('expense_list_view_year')
                ], // current date to show above expense list,
                'shared_with' => $shared_with_currently, // all emails (and users) with which this household is shared
                'sharing_permissions_list' => $sharing_permissions_list // list of all permissions to load into a sharing form
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
            'budget_reset_day' => 'required|integer|min:1|max:31',
            'allow_low_balance_emails' => 'nullable'
        ];

        $request->validate($validation);

        $household = \App\Household::findOrFail($id);
        if($household != null && $household->authUserHasAccess()){
            $household->name = $request->input('name');
            $household->currency_id = $request->input('currency');
            $household->monthly_income = $request->input('monthly_income');
            if($request->input('expected_monthly_savings') != null){
                $household->expected_monthly_savings = $request->input('expected_monthly_savings');
            }
            $household->budget_reset_day = $request->input('budget_reset_day');

            // options
            $current_options = $household->options; // load from db
            if($current_options == null){ // if no options were previously set
                $current_options = json_decode("{}"); // init empty array
            }
            else{
                $current_options = json_decode($current_options); // convert from json to array
            }

            $current_options->allow_low_balance_emails = $request->input('allow_low_balance_emails') != null;
            $household->options = json_encode($current_options); // convert from array to json and set it
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
        if($household != null && $household->authUserHasAccess()){
            if(Auth::user()->hasVerifiedEmail()){
                $household->delete();

                toastr()->success('Household removed!');
                return redirect('/dashboard');
            }
            else{
                toastr()->error('Please verify your email address first');
                return redirect()->back();
            }
        }
        else{
            toastr()->error('Household not found!');
            return redirect('/dashboard');
        }
    }
}
