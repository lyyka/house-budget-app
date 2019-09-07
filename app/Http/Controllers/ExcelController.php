<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
// export
use App\Exports\ExpensesExport;
// import
use App\Imports\ExpensesImport;

class ExcelController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function export(Request $request){
        $rules = [
            'household_id' => 'required|integer|min:1|exists:households,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|before_or_equal:' . date("Y-m-d"),
            'export_categories.*' => 'nullable|string|exists:expense_categories,name',
            'min_amount' => 'nullable|double', 
            'max_amount' => 'nullable|double'
        ];

        $request->validate($rules);

        $household_id = $request->input('household_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $export_categories = $request->input('export_categories');
        $min_amount = $request->input('min_amount');
        $max_amount = $request->input('max_amount');

        if($min_amount != null && $max_amount != null){
            if($min_amount > $max_amount){
                $errors = array();
                $errors['min_amount'] = ['Min. amount must be less than max. amount'];
                $errors['max_amount'] = ['Max. amount must be greater than min. amount'];
                throw \Illuminate\Validation\ValidationException::withMessages($errors);
            }
        }

        $household = \App\Household::findOrFail($household_id);
        if($household != null && $household->authUserHasAccess()){
            $expenses = $household->expenses();

            if($start_date != null){
                $expenses = $expenses->where('created_at', '>=', $start_date);
            }
            if($end_date != null){
                $expenses = $expenses->where('created_at', '<=', $end_date);
            }

            if($export_categories != null && count($export_categories) > 0){
                $expenses = $expenses->whereHas('category', function (Builder $query) use($export_categories){
                    $query->where('name', '=', $export_categories[0]);
                    for($i = 1; $i < count($export_categories); $i++) {
                        $query->orWhere('name', '=', $export_categories[$i]);
                    }
                });
            }
            if($min_amount != null){
                $expenses = $expenses->where('amount', '>=', $min_amount);
            }
            if($max_amount != null){
                $expenses = $expenses->where('amount', '<=', $max_amount);
            }
            
            $expenses = $expenses->orderBy('created_at', 'asc')->get();
            $download_id = uniqid();
            Session::put('expenses_to_export_' . $download_id, $expenses);

            return response()->json(['success' => true, 'download_id' => $download_id]);
        }
        else{
            return response()->json(['success' => false]);
        }

    }

    public function import(Request $request){
        $request->validate([
            'excel_import_table' => 'required|mimes:xlsx|max:5120',
            'household_id' => 'required|integer|min:1|exists:households,id'
        ]);

        $household = \App\Household::findOrFail($request->input('household_id'));

        if($household != null && $household->authUserHasAccess()){
            if($request->hasFile('excel_import_table')){
                $file = $request->file('excel_import_table');
                $import = new ExpensesImport($household);
                Excel::import($import, $file);

                toastr()->success('Expenses imported successfully');
                return redirect()->back();
            }
            else{
                toastr()->error('No file selected');
                return redirect()->back();
            }
        }
        else{
            toastr()->error('You can not import to this household');
            return redirect()->back();
        }
    }

    public function download(Request $request, $download_id){
        $name = 'expenses_to_export_' . $download_id;
        if(Session::has($name)){
            $export = new ExpensesExport(Session::get($name));
            Session::forget($name);
            return Excel::download($export, 'Expense Report Generated On ' . date("Y-m-d") . '.xlsx');
        }
        else{
            abort(404, "File you are looking for is expired");
        }
    }
}
