<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Transaction;

class ExportStatisticalAll implements FromView
{
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $transactions = Transaction::where('status', 1)
                                    ->where('free', 0)
                                    ->whereBetween('time_approve', [$this->startDate, $this->endDate])
                                    ->with(['product'])
                                    ->latest()
                                    ->get();

        return view('admin.statistic.export_user_consolidated', [
            'transactions' => $transactions
        ]);
    }
}