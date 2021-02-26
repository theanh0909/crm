<?php

namespace App\Exports;


use App\Models\License;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportLicense implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct($productType, $status, $qty )
    {
        $this->productType  = $productType;
        $this->status       = $status;
        $this->qty          = $qty;
    }

    public function collection()
    {
        $datas = License::where('product_type', $this->productType)
            ->where('status', $this->status)
            ->where('status_email', 0)
            ->where('exported', 0)
            ->with('product')
            ->select(
                'id',
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
            ->orderBy('id', 'ASC')
            ->limit($this->qty)
            ->get();

        $idsUpdate = [];
        foreach ($datas as $data) {
            $idsUpdate[] = $data->id;
        }

        License::whereIn('id', $idsUpdate)->update(['exported_status' => License::EP_EXPORT_EXCEL]);

        return $datas;
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
