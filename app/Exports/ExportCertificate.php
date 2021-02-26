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

class ExportCertificate implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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

        $datas = Registered::where('hardware_id', 'CHUNGCHI')
                    ->whereBetween('created_at', [$formDate, $toDate])
                    ->with(['user'])
                    ->select(
                        'created_at',
                        'customer_name',
                        'customer_phone',
                        'price',
                        'price',
                        'product_type',
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
            'Tạo đơn',
            'Họ tên',
            'Số điện thoại',
            'Tiền nộp vào',
            'Tiền nộp đi',
            'Tiền GXD',
            'Lĩnh vực *',
            'Nơi thi',
            'Nhân viên',
        ];
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function map($customer): array
    {
        return [
            $customer->created_at->format('d-m-Y'),
            $customer->customer_name,
            $customer->customer_phone,
            $customer->price,
            $customer->price*0,
            $customer->price*0,
            ($customer->product) ? $customer->product->name : '',
            $customer->customer_cty,
            ($customer->user) ? $customer->user->fullname : '',
        ];
    }
}
