@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Request', 'item2' => 'Duyệt đơn hàng'])
<div class="container">
    @include('admin.layouts.partitals.notify')
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Tất cả yêu cầu của bạn</h3><br>
        </div>
        <div class="card-header" style="align-content: center; justify-content: left">
            {!! Form::open(['url' => route('admin.request.approveAll', ['type' => 0])]) !!}
                <button onclick="return confirm('Xác nhận?');" type="submit" class="btn btn-primary"><i style="font-size: 12px" class="flaticon2-check-mark"></i>Duyệt tất cả khóa mềm</button>
            {!! Form::close() !!}
            <span style="margin: 0px 10px"></span>
            {!! Form::open(['url' => route('admin.request.approveAll', ['type' => 1])]) !!}
            <button onclick="return confirm('Xác nhận?');" type="button" class="btn btn-success"><i style="font-size: 12px" class="flaticon2-check-mark"></i> Duyệt tất cả khóa cứng</button>
            {!! Form::close() !!}
            <span style="margin: 0px 10px"></span>
            {!! Form::open(['url' => route('admin.request.approveAll', ['type' => 2])]) !!}
            <button onclick="return confirm('Xác nhận?');" type="button" class="btn btn-warning"><i style="font-size: 12px" class="flaticon2-check-mark"></i> Duyệt tất cả khóa học</button>
            {!! Form::close() !!}
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Đơn hàng</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Nhân viên</th>
                        <th scope="col">SL</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Thành tiền</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $key => $item)
                        <?php
                            $keyType = ($item->type == 0) ? 'Key thử nghiệm': 'Key thương mại';
                            if($item->product->type == 0)
                                $totalPrice = ($item->qty * $item->product->price);
                            else
                                $totalPrice = ($item->qty * $item->price) - $item->discount;
                        ?>
                        <tr scope="row" id="rqrow-{{$item->id}}">
                        <!-- Đánh STT tự động -->
                            <td scope="row">
                                {{ ($datas->currentpage()-1) * $datas->perpage() + $key + 1 }}
                            </td>
                            <td scope="row">
                                <p>Sản phẩm: {{$item->product->name}}</p>
                                @if($item->customer_type == 0)
                                    <p>Số ngày: {{$item->number_day}}</p>
                                @endif
                                @if($item->customer_type == 1)
                                    <p>Mã khóa: {{$item->license_original}}</p>
                                @endif
                                @if($item->customer_type == 2)
                                    <p>Lựa chọn: Học {{$item->option}}</p>
                                @endif
                                <p>
                                    @if($item->customer_type == 0)
                                        <span class="label label-lg label-light-primary label-inline">Khóa mềm</span>
                                    @endif
                                    @if($item->customer_type == 1)
                                        <span class="label label-lg label-light-warning label-inline">Khóa cứng</span>
                                    @endif
                                    @if($item->customer_type == 2)
                                        <span class="label label-lg label-light-success label-inline">Khóa học</span>
                                    @elseif($item->customer_type == 3)
                                        <span class="label label-lg label-light-danger label-inline">Chứng chỉ</span>
                                    @endif
                                </p>
                                <p>Ngày tạo: {{date('d/m/Y', strtotime($item->created_at))}}</p>
                                @if($item->donate_key == 1 && $item->donateproduct)
                                    <p style="color:red">Key tặng kèm: {{$item->donateproduct->name}}</p>
                                @endif
                            </td>

                            <td>
                                <p><i style="margin-right: 5px" class="flaticon2-user"></i>{{!empty($item->customer) ? $item->customer->name : ''}}</p>
                                <p style="display: flex;"><i style="margin-right: 5px" class="flaticon2-new-email"></i>{{!empty($item->customer) ? $item->customer->email : ''}}</p>
                                <p><i style="margin-right: 5px" class="flaticon2-phone"></i>{{!empty($item->customer) ? $item->customer->phone : ''}}</p>
                            </td>
                            <td scope="row">
                                <span class="label label-xl label-info label-inline mr-2">
                                    {{$item->user->fullname}}
                                </span>
                            
                            </td>
                            <!-- Cột khối lượng -->
                            <td scope="row">{{$item->qty}}</td>
                            <!-- Cột Đơn giá -->
                            <td scope="row">
                                @php $price = $totalPrice/$item->qty; @endphp
                                {{number_format($price, 0, ',', '.')}}</br>
                                @if ($item->discount>0)
                                    Giảm giá: {{number_format($item->discount, 0, ',', '.')}}
                                @endif
                            </td>
                            <!-- Cột Thành tiền -->
                            <td scope="row">{{number_format($totalPrice, 0, ',', '.')}}</td>
                            <!-- Cột ghi chú -->
                            <td style="width: 100px">{{$item->note}}</td>
                            <!-- Cột thao tác -->
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown">
                                        <i class="flaticon2-gear text-primary"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm">
                                        <ul class="navi">
                                            <li class="navi-item">
                                                <a data-id="{{$item->id}}" class="navi-link approve-request" style="cursor: pointer;">
                                                    <span class="navi-icon"><i class="flaticon2-check-mark"></i></span>
                                                    <span class="navi-text">Phê duyệt</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a class="navi-link" target="_blank" href="{{route('admin.request.print', ['id' => $item->id])}}">
                                                    <span class="navi-icon"><i class="flaticon2-printer"></i></span>
                                                    <span class="navi-text">In hóa đơn</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="{{route('admin.input-edit-form', ['id' => $item->id])}}" class="navi-link" href="#">
                                                    <span class="navi-icon"><i class="flaticon-edit-1"></i></span>
                                                    <span class="navi-text">Sửa</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a class="navi-link disabled" href="#">
                                                 <span class="navi-icon"><i class="flaticon2-rubbish-bin-delete-button"></i></span>
                                                 <span class="navi-text">
                                                     {{Form::open(['url' => route('admin.request.destroy', ['id' => $item->id]), 'method' => 'DELETE'])}}
                                                        
                                                        <button style="border: 0px; background: transparent;" type="submit" onclick="return confirm('Delete this item?')">
                                                            Xóa
                                                        </button>
                                                    {{Form::close()}}
                                                 </span>
                                                </a>
                                           </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                {{$datas->links()}}
            </div>            
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $('.approve-request').click(function(e) {
        e.preventDefault();
        var me = $(this);
        var id = me.data('id');
        me.hide();
        $.ajax({
            url: "{{route('admin.request.approve')}}",
            method: 'POST',
            data: {
                id: id,
                _token: "{{csrf_token()}}"
            },
            success: function(data) {
                if(data.success == false) {
                    alert(data.message);
                    me.show();
                }
                if(data.success == true) {
                    $('#rqrow-' + id).remove();
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    });
</script>
@endsection
