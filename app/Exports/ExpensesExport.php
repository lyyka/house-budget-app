<?php

namespace App\Exports;

use App\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExpensesExport implements FromCollection, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize
{
    protected $expenses;

    public function __construct($expenses_to_export){
        $this->expenses = $expenses_to_export;
    }

    public function map($expense): array
    {
        return [
            $expense->id,
            $expense->household->name,
            $expense->name,
            $expense->household->currency->currency_short . ' ' . $expense->amount,
            Date::dateTimeToExcel($expense->created_at),
            $expense->category->name
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Household',
            'Expense Name',
            'Amount',
            'Created at',
            'Category',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->expenses;
    }
}
