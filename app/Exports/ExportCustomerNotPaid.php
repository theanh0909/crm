<?php

namespace App\Exports;


use App\Models\License;
use App\Models\Registered;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class ExportCustomerNotPaid implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct($dateFrom, $dateTo )
    {
        $this->dateFrom     = $dateFrom;
        $this->dateTo       = $dateTo;
    }


    public function collection()
    {
        $formDate   = Carbon::parse($this->dateFrom)->format('Y-m-d 00:00:00');
        $toDate     = Carbon::parse($this->dateTo)->format('Y-m-d 23:59:59');

        $datas = License::where('status_sell', 1)
            ->whereBetween('created_at', [$formDate, $toDate])
            ->with(['product'])
            ->orderBy('id', 'DESC')
            ->get();
        return $datas;
    }

    public function headings(): array
    {
        return [
            'Tên khách hàng',
            'Loại phần mềm*',
            'Mã khóa (Serial)*',
            'Số điện thoại',
            'Email',
            'Ngày mua',
            'NV quản lý',
        ];
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function map($license): array
    {
        return [
            $license->customer_name,
            ($license->product) ? $license->product->name : '',
            $license->license_key,
            $license->customer_phone,
            $license->email_customer,
            $license->sell_date,
            ($license->user) ? $license->user->fullname : '',
        ];
    }
}
