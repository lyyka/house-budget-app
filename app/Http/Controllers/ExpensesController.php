<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function fetchExpense(Request $request, $id){
        $expense = \App\Expense::findOrFail($id);
        if($expense != null && $expense->household->owner->id == Auth::id()){
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
            'name' => 'required|string|max:191',
            'amount' => 'required|numeric|min:1',
            'category_id' => 'required|integer|min:1',
            'household_id' => 'required|integer|min:1|exists:households,id'
        ];

        $request->validate($validation);

        // check if the household belongs to this user
        $household = \App\Household::findOrFail($request->input('household_id'));
        $category = \App\ExpenseCategory::findOrFail($request->input('category_id'));
        if($household->user_id == Auth::id() && $category != null){
            $expense = new \App\Expense();
            $expense->household_id = $request->input('household_id');
            $expense->category_id = $request->input('category_id');
            $expense->name = $request->input('name');
            $expense->amount = $request->input('amount');
            $expense->created_at = date("Y-m-d H:i:s");
            $expense->save();

            // $household->current_state -= $expense->amount;
            // $household->save();

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
        if($expense != null & $expense->household->owner->id == Auth::id()){
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
