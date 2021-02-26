<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CertificatePerMonthSheet implements FromView, WithTitle
{
    private $sheet;

    private $date_exam;

    private $stt;

    public function __construct($sheet, $date_exam, $stt)
    {
        $this->sheet = $sheet;
        $this->date_exam = $date_exam;
        $this->stt = $stt;
    }

    public function view(): View
    {
        if ($this->sheet == '1') {
            $certificates = Transaction::where('date_exam', $this->date_exam)->get();

            return view('admin.certificates.first_sheet_trich_ngang', compact('certificates'));
        } else {
            $certificates = Transaction::where('date_exam', $this->date_exam)
                                    ->where('type_exam', 'like', '%' . $this->sheet . '%')
                                    ->get();

            return view('admin.certificates.view_file_export', [
            'certificates' => $certificates,
            'type' => $this->sheet
            ]);
        }
        
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sheet ' . $this->stt;
    }
}