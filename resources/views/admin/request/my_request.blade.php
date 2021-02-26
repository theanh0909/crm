@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Request', 'item2' => 'Tất cả yêu cầu của bạn'])
<div class="container">
    @include('admin.layouts.partitals.notify')
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Tất cả yêu cầu của bạn</h3>
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Đơn hàng</th>
                        <th scope="col">Thông tin</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">SL</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">TT</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $item)
                        <?php
                            $keyType = ($item->type == 0) ? 'Key thử nghiệm': 'Key thương mại';
                            if ($item->product->type == 0)
                                $totalPrice = ($item->qty * $item->product->price);
                            else
                                $totalPrice = ($item->qty * $item->price) - $item->discount;
                        ?>
                        <tr id="rqrow-{{$item->id}}">
                            <td scope="row">{{$loop->index + 1}}</td>
                            <td scope="row">
                                <p>
                                    @if($item->customer_type == 0)
                                        <span class="label label-lg label-light-primary label-inline">Khóa mềm</span>
                                    @endif
                                    @if($item->customer_type == 1)
                                        <span class="label label-lg label-light-warning label-inline">Khóa cứng</span>
                                    @endif
                                    @if($item->customer_type == 2)
                                        <span class="label label-lg label-light-success label-inline">Khóa học</span>
                                    @endif
                                    @if($item->customer_type == 3)
                                        <span class="label label-lg label-light-danger label-inline">Chứng chỉ</span>
                                    @endif
                                </p>
                                <p>
                                    Tạo đơn: {{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}
                                </p>
                                
                                @if($item->customer_type == 2)
                                    @if($item->donate_key == 1)
                                        <p>Tặng kèm: {{$item->donateproduct->name}}
                                            @if($item->license)
                                                <p>
                                                    Mã key: {{ $item->license->license_key }}
                                                </p>
                                            @endif
                                        </p>
                                    @endif
                                @endif
                            </td>

                            <td scope="row">
                                <p>SP: {{$item->product->name}}</p>
                                @if($item->customer_type == 0)
                                    <p>Loại key: <span style="color: {{$item->type == 0 ? '#1BC5BD' : '#FFA800'}}">{{$keyType}}</span></p>
                                    <p>Số ngày: {{$item->number_day}}</p>
                                @endif
                                @if($item->customer_type == 1)
                                    <p>Mã khóa: {{$item->license_original}}</p>
                                    <p>Giảm giá: {{number_format($item->discount, 0, ',', '.')}}</p>
                                @endif
                                @if($item->customer_type == 2)
                                    <p>Lựa chọn: Học {{$item->option}}</p>
                                @endif
                            </td>
                            <td>
                                <p><i style="margin-right: 5px" class="flaticon2-user"></i> {{$item->customer_name}}</p>
                                <p style="display: flex;"><i style="margin-right: 5px" class="flaticon2-new-email"></i> {{$item->customer_email}}</p>
                                <p><i style="margin-right: 5px" class="flaticon2-phone"></i>{{$item->customer_phone}}</p>
                            </td>
                            <td scope="row">{{$item->qty}}</td>
                            <td scope="row">{{number_format($item->price, 0, ',', '.')}}</td>
                            <td scope="row">{{number_format($totalPrice, 0, ',', '.')}}</td>
                            <td scope="row">
                                @if($item->status == 0)
                                    <span class="text-warning">Đang chờ</span>
                                @endif
                                @if($item->status == 1)
                                    <span class="text-success">Đã gửi</span>
                                @endif
                                @if($item->status == 2)
                                    <span class="text-danger">Hủy bỏ</span>
                                @endif
                            </td>
                            <td width="100">
                                @if($item->note == '')
                                    <span class="text-warning">Không</span>
                                @else
                                    {{$item->note}}
                                @endif
                            </td>
                            <td width="150">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown">
                                        <i class="flaticon2-gear text-primary"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm">
                                        <ul class="navi">
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
                                                     {{Form::open(['url' => route('admin.request.delete', ['id' => $item->id]), 'method' => 'DELETE'])}}
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
        // me.hide();
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