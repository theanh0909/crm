<?php

namespace App\Exports;


use App\Models\License;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportStatistical implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct($userId, $startDate, $endDate, $between)
    {
        $this->userId  = $userId;
        $this->startDate       = $startDate;
        $this->endDate          = $endDate;
        $this->between = $between;
    }

    public function collection()
    {
        if ($this->userId == -1) {
            $datas = Transaction::where('status', 1)
            ->where('free', 0)
            ->whereBetween('time_approve', [$this->startDate, $this->endDate])
            ->whereBetween('customer_type', $this->between)
            ->with(['product'])
            ->get();

        } else {
            $datas = Transaction::where('status', 1)
            ->where('user_request_id', $this->userId)
            ->where('free', 0)
            ->whereBetween('time_approve', [$this->startDate, $this->endDate])
            ->whereBetween('customer_type', $this->between)
            ->with(['product'])
            ->get();
        }
        
        return $datas;
    }

    public function headings(): array
    {
        return [
            'Khách hàng',
            'SĐT',
            'Email',
            'Tên sản phẩm',
            'Tạo đơn',
            'Duyệt đơn',
            //'Số lượng',
            //'Đơn giá',
            'Tiền vào',
            'Tiền ra',
            'Tỷ lệ',
            'Hoa hồng',
            'Người bán',
            'Ghi chú'
        ];
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function map($item): array
    {
        $sl = $item->qty;
        $inputPrice = $item->price * $sl;
        $outputPriceItem = ($item->product) ? $item->product->input_price : 0; // số tiền phải đóng cho hội nhà thầu
        $outputPrice =  $inputPrice - $outputPriceItem * $sl;
        $discount = ($item->product) ? $item->product->discount : 0;
        $profit = $outputPrice * $discount / 100;

        return [
            // $item->customer_name,
            // $item->customer_phone,
            // $item->customer_email,
            !empty($item->customer) ? $item->customer->name : $item->customer_name,
            !empty($item->customer) ? $item->customer->email : $item->customer_email,
            !empty($item->customer) ? $item->customer->phone : $item->customer_phone,
            ($item->product) ? $item->product->name : $item->product_type,
            date('d/m/Y', strtotime($item->created_at)),
            date('d/m/Y', strtotime($item->time_approve)),
            //$item->qty,
            //number_format($price, 0, ',', '.'),
            $inputPrice,
            $outputPrice,
            $discount,
            $profit,
            $item->user->fullname,
            $item->note
        ];
    }
}
