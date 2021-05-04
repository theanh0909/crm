<table class="table">
    <thead>
        <tr>
            <th>Stt</th>
            <th>Khách hàng</th>
            <th>Sản phẩm</th>
            <td>Loại</td>
            <td>
                Tạo đơn
            </td>
            <td>Duyệt đơn</td>
            <th>Số lượng</th>
            <th>Đơn giá (đ)</th>
            <th>Tiền vào (đ)</th>
            <th>Tiền ra (đ)</th>
            <th>Tỷ lệ</th>
            <th>HH (đ)</th>
            <th>Nhân viên</th>
            <th>Lương</th>
            <th>
                Trả chứng chỉ
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $key => $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ !empty($item->customer) ? $item->customer->name : $item->customer_name }}
                </td>
                <td>
                    {{ $item->product->name }}
                </td>
                <td>
                    {{ getlabelTypeProduct($item->product->type) }}
                    
                </td>
                <td>
                    {{ date('d/m/Y', strtotime($item->created_at)) }}
                </td>
                <td>
                    {{ date('d/m/Y', strtotime($item->time_approve)) }}
                </td>
                <td align="center">{{ $item->qty }}</td>
                <td>
                    {{$item->price}}
                </td>
                <td>
                    {{$item->price * $item->qty}}
                </td>
                <td>
                    {{$item->product->input_price}}
                </td>
                <td align="center">{{ $item->product->discount }}%</td>
                {{-- Hoa hồng = (tiền vào - tiền ra) * chiết khấu % sản phẩm
                --}}
                <td>
                    {{($item->product->discount / 100) * ($item->price * $item->qty - $item->product->input_price)}}
                </td>
                <td>
                    {{ $item->user->fullname }}
                </td>
                <td>
                    @if($item->status_salary == 1)
                        Đã làm lương
                    @else
                        Chưa làm lương
                    @endif
                </td>
                <td>
                    @if($item->customer_type == 3 && (strpos($item->product_type, 'kte') >= 0 || strpos($item->product_type, 'hnt') >= 0))
                        @if($item->status_certificate == 1)
                            Đã trả
                        @else
                            Chưa trả
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
