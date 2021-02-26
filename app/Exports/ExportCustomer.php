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

class ExportCustomer implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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

        $datas = Registered::whereNotIn('hardware_id', ['KHOACUNG', 'KHOAHOC'])
            ->whereBetween('created_at', [$formDate, $toDate])
            ->with(['user', 'product'])
            ->select(
                'customer_name',
                'product_type',
                'license_original',
                'customer_phone',
                'customer_email',
                'customer_address',
                'customer_cty',
                'user_support_id'
            )
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
            'Địa chỉ liên hệ',
            'Tỉnh thành',
            'NV quản lý',
        ];
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function map($customer): array
    {
        return [
            $customer->customer_name,
            ($customer->product) ? $customer->product->name : '',
            $customer->license_original,
            $customer->customer_phone,
            $customer->customer_email,
            $customer->customer_address,
            $customer->customer_cty,
            ($customer->user) ? $customer->user->email : '',
        ];
    }
}
