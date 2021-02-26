<?php

namespace App\Exports;


use App\Models\License;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LicenseAfterCreateExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $data = License::whereIn('id', $this->ids)
            ->with('product')
            ->select(
                'license_serial',
                'license_key',
                'license_created_date',
                'type_expire_date',
                'hardware_id',
                'license_no_instance',
                'license_no_computers',
                'status',
                'product_type'
            )
            ->get();

        return $data;
//        dd($data);
    }

    public function headings(): array
    {
        return [
            'License Serial',
            'License Key',
            'Product',
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
            $license->license_created_date,
            $license->type_expire_date,
            $license->hardware_id,
            $license->license_no_instance,
            $license->license_no_computers,
            ($license->status == 0) ? "Key thử nghiệm" : "Key thương mại",

        ];
    }
}
