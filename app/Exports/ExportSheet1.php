<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportSheet1 implements FromView, WithTitle
{
    private $date_exam;

    public function __construct($date_exam)
    {
        $this->date_exam = $date_exam;
    }

    public function view(): View
    {
        $certificates = Transaction::whereDate('date_exam', $this->date_exam)->get();

        return view('admin.certificates.first_sheet', compact('certificates'));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sheet 1';
    }
}