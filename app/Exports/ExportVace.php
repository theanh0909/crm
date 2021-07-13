<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportVace implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct($dateStart, $dateEnd)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function collection()
    {
        $transactions = Transaction::where('product_type', 'like', 'kte%')
                                   ->where('status', 1)
                                   ->whereBetween('time_approve', [$this->dateStart, $this->dateEnd])
                                   ->get();

        return $transactions;
    }

    public function headings(): array
    {
        return [
            'Trạng Thái',
            'Khách hàng',
            'Sản phẩm',
            'Tạo đơn',
            'Duyệt đơn',
            'Tiền vào (đ)',
            'Tiền đi (đ)',
            'GXD (đ)',
            'Nhân viên',
            'Nơi thi',
            'Ghi chú',
        ];
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function map($transactionItem): array
    {
        return [
            ($transactionItem->status_vace == 0) ? 'Chưa trả' : 'Đã trả',
            empty($transactionItem->customer) ? $transactionItem->customer_name : $transactionItem->customer->name,
            $transactionItem->product->name,
            date('d/m/Y' ,strtotime($transactionItem->updated_at)),
            date('d/m/Y' ,strtotime($transactionItem->time_approve)),
            $transactionItem->price,
            $transactionItem->product->input_price * $transactionItem->qty,
            $transactionItem->price - $transactionItem->product->input_price * $transactionItem->qty,
            $transactionItem->user->fullname,
            $transactionItem->customer_cty,
            $transactionItem->note
        ];
    }
}
