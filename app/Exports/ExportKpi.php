<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportKpi implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct($users, $month, $year, $date, $type)
    {
        $this->users = $users;
        $this->month = $month;
        $this->year = $year;
        $this->date = $date;
        $this->type = $type;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'Nhân viên',
            'Doanh số',
            'Thưởng',
        ];
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function map($userItem): array
    {
        $total = \App\Helpers\Helper::getKpi($this->date, $userItem->id, $this->type, $this->year);
        $bonus = 0;
        
        if ($this->type == 0) {
            if($total >= 300000000 && $total < 600000000) {
                $bonus = number_format(1000000);
            } elseif ($total >= 600000000 && $total <= 1200000000) {
                $bonus = number_format(1500000);
            } elseif ($total > 1200000000) {
                $bonus = number_format(2000000);
            }
        } elseif ($this->type == 1) {
            if ($total >= 10000000 && $total <= 24000000) {
                $bonus = number_format(500000);
            } elseif ($total >= 25000000 && $total <= 49000000) {
                $bonus = number_format(1000000);
            } elseif ($total >= 50000000 && $total <= 100000000) {
                $bonus = number_format(2000000);
            } elseif($total >= 100000000) {
                $bonus = number_format(3000000);
            }
        }

        return [
            $userItem->fullname,
            $total,
            $bonus,
        ];
    }
}
