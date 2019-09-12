<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Household;

class ChartDataController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Returns expenses grouped by category
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response JSON
     */
    public function getExpensesByCategory(Request $request, $id){
        $household = Household::findOrFail($id);
        if($household != null && Gate::allows('view-charts', $household)){

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

    /**
     * Gets expenses from custom date range, defaults to current week
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response JSON
     */
    public function getCustomDataRange(Request $request, $id){
        $household = Household::findOrFail($id);
        if($household != null && Gate::allows('view-charts', $household)){

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
     * Gets expenses data for a specific day, grouped by hour.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response JSON
     */
    public function getDailyDataByHour(Request $request, $id, $day = null){
        $household = Household::findOrFail($id);
        if($household != null && Gate::allows('view-charts', $household)){

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
        if($household != null && Gate::allows('view-charts', $household)){

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
}
