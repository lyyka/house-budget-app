<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // How ocurrances will work
    // Each day, a function would be called, that would check:
    // 1. Get daily expenses and apply them to the budget
    // 2. Get all expenses ...
    // 3. Get all expenses made on Nth day in the month (the current day) and see if they are monthly and apply them

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $expense = \App\Expense::findOrFail($id);
        if($expense != null & Gate::allows('delete-expense', $expense->household)){
            if(Auth::user()->hasVerifiedEmail()){
                // if(date("m", strtotime($expense->created_at)) == date("m")){
                //     $expense->household->current_state += $expense->amount;
                //     $expense->household->save();
                // }
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
