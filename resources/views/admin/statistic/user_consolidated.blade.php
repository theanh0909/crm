@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Thống kê', 'item2' => 'Chi tiết bán hàng của nhân viên'])
<div class="container">
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title">
                <span class="card-icon">
                    <span class="svg-icon svg-icon-md svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5" />
                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5" />
                                <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero" />
                                <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5" />
                            </g>
                        </svg>
                    </span>
                </span>
                <h3 class="card-label">Thống kê chi tiết bán hàng</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-body">
            <form method="GET">
                <div class="mt-2 mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-4 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <input class="form-control" value="{{$customer_name}}" type="text" placeholder="Tên nhân viên" name="customer_name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class='input-group' id='kt_daterangepicker_6'>
                                        <input type='text' value="{{date('d/m/Y', strtotime($startDate))}} - {{date('d/m/Y', strtotime($endDate))}}" name="date" class="form-control" readonly  placeholder="Chọn thời gian"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                        </div>
                                   </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" name="submit" value="thongke" class="btn btn-light-primary px-6 font-weight-bold">Thống kê</button>
                                    <button class="btn btn-light-success px-6 font-weight-bold" name="submit" type="submit" value="export">Xuất Excel</button>
                                </div>
                                <div class="col-md-2">
                                    <div class="radio-inline">
                                        <label class="radio radio-solid">
                                            <input type="radio" class="salary" name="status_salary" value="1"/>
                                            <span></span>Đã trả
                                        </label>
                                        <label class="radio radio-solid">
                                            <input type="radio" class="salary" name="status_salary" value="0"/>
                                            <span></span>Chưa
                                        </label>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <br>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <p><span style="color: red">Ghi chú: </span> Thống kê theo ngày phải xóa tên</p>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Search Form-->
        </div>
        <div class="card-header">
            <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Stt</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">SP</th>
                            <th scope="col">SL</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Tiền vào</th>
                            <th scope="col">Tiền ra</th>
                            <th scope="col">TL</th>
                            <th scope="col">HH</th>
                            <th scope="col">Nhân viên</th>
                            <th scope="col">HĐ</th>
                            <th scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($transactions as $key => $item)
                            
                            <tr>
                                <td>
                                    {{$key+1}}
                                </td>
                                <td style="width: 6%">
                                    
                                    {{!empty($item->customer) ? $item->customer->name : $item->customer_name}}
                                </td>
                                <td>
                                    <p>Tên SP: {{$item->product->name}}</p>
                                    <p>
                                        @if(!empty($item->product))
                                            @if($item->product->type == 0)
                                                <span class="label label-lg label-light-primary label-inline">Khóa mềm</span>
                                            @endif
                                            @if($item->product->type == 1)
                                                <span class="label label-lg label-light-warning label-inline">Khóa cứng</span>
                                            @endif
                                            @if($item->product->type == 2)
                                                <span class="label label-lg label-light-success label-inline">Khóa học</span>
                                            @elseif($item->product->type == 3)
                                                <span class="label label-lg label-light-danger label-inline">Chứng chỉ</span>
                                            @endif
                                        @endif
                                    </p>
                                    
{{--                                     <p>Loại: {{getlabelTypeProduct($item->product->type)}}</p>
 --}}                               <p>Tạo: {{date('d/m/Y', strtotime($item->created_at))}}</p>
                                    <p>Duyệt: {{date('d/m/Y', strtotime($item->time_approve))}}</p>
                                </td>
                                <td align="center">{{$item->qty}}</td>
                                <td>
                                    {{number_format($item->price, 0, ',', '.')}}
                                </td>                                
                                <td>
                                    {{number_format(($item->price * $item->qty), 0, ',', '.')}}                                
                                </td>
                                <td>
                                    {{number_format($item->product->input_price * $item->qty, 0, ',', '.')}}
                                </td>
                                <td align="center">{{$item->product->discount}}%</td>
                            {{-- Hoa hồng = (tiền vào - tiền ra) * chiết khấu % sản phẩm --}}
                                <td>
                                    {{number_format($item->product->discount/100 * ($item->price * $item->qty - $item->product->input_price), 0, ',', '.')}}
                                </td>
                                <td>
                                    {{!empty($item->user) ? $item->user->fullname : ''}}
                                </td>
                                @if(auth()->user()->level > 0)
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown">
                                                <i class="flaticon2-gear text-primary"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-sm">
                                                <ul class="navi">
                                                    <li class="navi-item">
                                                        <a href="{{route('admin.input-edit-form', ['id' => $item->id])}}" class="navi-link">
                                                            <span class="navi-icon"><i class="flaticon-edit-1"></i></span>
                                                            <span class="navi-text">Sửa</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')" href="{{route('admin.chart.usersDetail-delete', ['id' => $item->id])}}" class="navi-link">
                                                            <span class="navi-icon"><i class="flaticon2-rubbish-bin-delete-button"></i></span>
                                                            <span class="navi-text">Xóa</span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                                <td>
                                    @if($item->customer_type == 3 && (strpos($item->product_type, 'kte') >= 0 || strpos($item->product_type, 'hnt') >= 0))
                                        <button data-id="{{$item->id}}" status="{{$item->status_certificate}}" type="button" class="status-certificate btn btn-@if($item->status_certificate==0){{'danger'}}@else{{'primary'}}@endif">
                                            Trả cc
                                        </button>
                                    @endif
                                    <button data-id="{{$item->id}}" status="{{$item->status_salary}}" type="button" class="status-salary btn btn-@if($item->status_salary==0){{'danger'}}@else{{'primary'}}@endif">
                                        Lương
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align: right" colspan="6">
                                Tổng
                            </th>
                            <th>
                                {{number_format($inputPriceTotal)}}
                            </th>
                            <th>
                                {{number_format($outputPriceTotal)}}
                            </th>
                            <th></th>
                            <th>
                                {{number_format($profitTotal)}}
                            </th>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            <div class="row">
                {{$transactions->appends(['customer_name' => $customer_name, 'date' => date('d/m/Y', strtotime($startDate)) . '-' . date('d/m/Y', strtotime($endDate)), 'submit' => 'thongke'])->links()}}
            </div>            
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
<script src="{{asset('js/sweetalert2@10.js')}}"></script>
<script>
    $('.salary').click(function(){
            if($(this).is(':checked')) {
                status_salary = $(this).val();
                date = $('.daterange-predefined-value').val();
                var dataPost = {
                    status_salary:   status_salary,
                    date: date,
                    _token: "{{csrf_token()}}"
                };
                $.ajax({
                    url: "{{route('admin.statistic.update-salary')}}",
                    method: 'POST',
                    data: dataPost,
                    success: function(e) {
                        alert('Update thành công');
                        location.reload();
                    }
                })
            }
        })

        $('.status-salary').click(function(){
            status = $(this).attr('status');

            if (status == 0) {
                $(this).css({'background':'#2196f3'});
                $(this).attr('status', 1);
                status = 1;
            } else if (status == 1) {
                $(this).css({'background':'#f44336'});
                $(this).attr('status', 0);
                status = 0
            }

            id = $(this).attr('data-id');
            var dataPost = {
                status:   status,
                id: id,
                _token: "{{csrf_token()}}"
            };

            $.ajax({
                url: "{{route('admin.statistic.update-salary-item')}}",
                method: 'POST',
                data: dataPost,
                success: function(e) {
                    
                }
            })
        })

        $('.status-certificate').click(function(){
            status = $(this).attr('status');

            if (status == 0) {
                $(this).css({'background':'#2196f3'});
                $(this).attr('status', 1);
                status = 1;
            } else if (status == 1) {
                $(this).css({'background':'#f44336'});
                $(this).attr('status', 0);
                status = 0
            }

            id = $(this).attr('data-id');
            var dataPost = {
                status:   status,
                id: id,
                _token: "{{csrf_token()}}"
            };

            $.ajax({
                url: "{{route('admin.statistic.update-certificate-item')}}",
                method: 'POST',
                data: dataPost,
                success: function(e) {
                    
                }
            })
        })
</script>
@endsection