<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Session;

class ExpensesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /*
     * Based on current session data adds or decreases current viewing month by $interval
     *
     * @param  \App\Household  $household
     * @param  String $interval
     * @return \Illuminate\Http\Response
     */
    private function goThroughTimeForExpensesList($household, $interval){
        if(Gate::allows('view-charts', $household)){
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
    }

    /**
     * Load expenses from previous month. Base on current viewing month from session sets the previous month data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loadExpensesFromPreviousMonth(Request $request, $id){
        $household = \App\Household::findOrFail($id);
        if($household != null && Gate::allows('view-charts', $household)){
            $this->goThroughTimeForExpensesList($household, "-1 months");
            return redirect()->back();
        }
        else{
            return redirect()->back()->with('error', 'Access denied');
        }
    }

    /**
     * Load expenses from next month. Base on current viewing month from session sets the next month data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loadExpensesFromNextMonth(Request $request, $id){
        $household = \App\Household::findOrFail($id);
        if($household != null && Gate::allows('view-charts', $household)){
            $this->goThroughTimeForExpensesList($household, "+1 months");
            return redirect()->back();
        }
        else{
            return redirect()->back()->with('error', 'Access denied');
        }
    }

    /**
     * Resets expenses list session variables to current month.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetExpensesList(Request $request){
        Session::forget('expense_list_view_year');
        Session::forget('expense_list_view_month');
        return redirect()->back();
    }

    /**
     * Return expense data as JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetchExpense(Request $request, $id){
        $expense = \App\Expense::findOrFail($id);
        if($expense != null && Gate::allows('view-expense', $expense->household)){
            return response()->json([
                'success' => true,
                'expense_data' => $expense,
                'expense_category' => $expense->category
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = [
            'ocurrance' => 'required|string|in:one_time,daily,weekly,monthly,yearly',
            'name' => 'required|string|max:191',
            'amount' => 'required|numeric|min:1',
            'category_id' => 'required|integer|min:1',
            'household_id' => 'required|integer|min:1|exists:households,id'
        ];

        $request->validate($validation);

        // check if the household belongs to this user
        $household = \App\Household::findOrFail($request->input('household_id'));
        $category = \App\ExpenseCategory::findOrFail($request->input('category_id'));
        if(Gate::allows('add-expense', $household) && $category != null){
            $expense = new \App\Expense();
            $expense->household_id = $request->input('household_id');
            $expense->category_id = $request->input('category_id');
            $expense->name = $request->input('name');
            $expense->amount = $request->input('amount');
            $expense->ocurrance = $request->input('ocurrance');
            $expense->save();

            toastr()->success('Expenses added');
            return redirect()->back();
        }
        else if($category == null){
            toastr()->error('Category does not exist');
            return redirect('/dashboard');
        }
        else{
            toastr()->error('There was an error adding the expense');
            return redirect('/dashboard');
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
        $expense = \App\Expense::findOrFail($id);
        if($expense != null & Gate::allows('delete-expense', $expense->household)){
            if(Auth::user()->hasVerifiedEmail()){
                $expense->delete();
                toastr()->success('Expense removed');
            }
            else{
                toastr()->error('Please verify your email address first');
            }
        }
        else{
            toastr()->error('Error occured');
        }
        return redirect()->back();
    }
}
