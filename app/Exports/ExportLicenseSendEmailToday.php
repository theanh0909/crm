<?php

namespace App\Exports;


use App\Models\License;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportLicenseSendEmailToday implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct()
    {

    }

    public function collection()
    {
        $datas = License::where('exported_status', 3)
            ->where('status', 0)
            ->whereBetween('updated_at', [Carbon::now()->format('Y-m-d 00:00:00'), Carbon::now()->format('Y-m-d 23:59:59')])
            ->with(['product'])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return $datas;
    }

    public function headings(): array
    {
        return [
            'License Serial',
            'License Key',
            'Product',
            'Customer Email',
            'Customer Phone',
            'Customer Name',
            'Created Date',
            'Type Expire Date',
            'Hardware',
            'No Instance',
            'No Computers',
            'Status'
        ];
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function map($license): array
    {
        return [
            $license->license_serial,
            $license->license_key,
            $license->product->name,
            $license->email_customer,
            $license->customer_phone,
            $license->customer_name,
            $license->license_created_date,
            $license->type_expire_date,
            $license->hardware_id,
            $license->license_no_instance,
            $license->license_no_computers,
            ($license->status == 0) ? "Key thử nghiệm" : "Key thương mại",

        ];
    }
}
