<?php

namespace App\Imports;

use App\Household;
use App\Expense;
use App\ExpenseCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ExpensesImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    protected $household;

    public function __construct(Household $household){
        $this->household = $household;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(isset($row['name']) && isset($row['amount']) && isset($row['category'])){
            $default_category = 'Miscellaneous';

            $category = ExpenseCategory::where('name', '=', $row['category'])->get();
            if($category != null){
                $category_id = $category[0]->id;
            }
            else{
                $category_id = ExpenseCategory::where('name', '=', $default_category)->first()->id;
            }

            $expense = new Expense([
                'household_id' => $this->household->id,
                'name' => $row['name'],
                'amount' => $row['amount'],
                'category_id' => $category_id
            ]);

            $this->household->current_state -= $row['amount'];
            $this->household->save();

            return $expense;
        }
        else{
            return null;
        }
    }

    public function batchSize(): int
    {
        return 500;
    }
}
