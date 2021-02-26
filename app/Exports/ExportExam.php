<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\CertificatePerMonthSheet;

class ExportExam implements WithMultipleSheets
{
    use Exportable;

    protected $date_exam;

    protected $sheetList;

    public function __construct($date_exam, $sheetList)
    {
        $this->date_exam = $date_exam;
        $this->sheetList = $sheetList;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $list = [];
        $stt = 2;
        $sheetAll = [];
        

        foreach ($this->sheetList as $key => $item) {
            foreach (explode(';', $key) as $keyItem) {
                //$sheets[] = new CertificatePerMonthSheet(trim($keyItem), $this->nameUpload, $stt);
                $sheets[] = trim($keyItem);
                //$stt++;
            }
        }
        $sheets = array_unique($sheets);
        $sheetAll['all'] = new CertificatePerMonthSheet('1', $this->date_exam, '1');
        foreach ($sheets as $sheetItem) {
            $sheetAll[] = new CertificatePerMonthSheet(trim($sheetItem), $this->date_exam, $stt);
            $stt++;
        }

        return $sheetAll;
    }
}