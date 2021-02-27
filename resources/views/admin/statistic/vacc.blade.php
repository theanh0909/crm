@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Thống kê', 'item2' => 'VACC'])
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
                <h3 class="card-label">Thống kê phải trả cho VACC</h3>
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
                                        <input class="form-control" type="text" placeholder="Tên nhân viên" name="customer_name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class='input-group' id='kt_daterangepicker_6'>
                                        <input type='text' value="{{date('d/m/Y', strtotime($dateStartToView))}} - {{date('d/m/Y', strtotime($dateEndToView))}}" name="date" class="form-control" readonly  placeholder="Chọn thời gian"/>
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
                                            <input type="radio" class="vacc" name="status_vacc" value="1"/>
                                            <span></span>Đã trả
                                        </label>
                                        <label class="radio radio-solid">
                                            <input type="radio" class="vacc" name="status_vacc" value="0"/>
                                            <span></span>Chưa
                                        </label>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                   
                </div>
            </form>
            <p>
                <b>Tổng số: </b> {{count($transactions)}}
            </p>
            <!--end::Search Form-->
        </div>
        <div class="card-header">
            <table class="table">
                    <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Khách hàng</th>
                            <th>Sản phẩm</th>
                            <th>Thời gian</th>
                            <th>Tiền vào (đ)</th>
                            <th>GXD (đ)</th>
                            <th >Tiền đi (đ)</th>
                            <th>Nhân viên</th>
                            <th>Ghi chú</th>
                            <th>
                                Trạng thái
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $total = 0; @endphp
                        @foreach($transactions as $key => $transactionItem)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>
                                    {{$transactionItem->customer_name}}
                                </td>
                                <td>
                                    <p>
                                    {{$transactionItem->product->name}}
                                    </p>                                    
                                </td>
                                <td>
                                    Tạo đơn: {{date('d/m/Y' ,strtotime($transactionItem->updated_at))}}<br>
                                    Duyệt đơn: {{date('d/m/Y' ,strtotime($transactionItem->time_approve))}}
                                </td>
                                <td style="text-align: center">
                                    {{number_format($transactionItem->price)}}
                                </td>
                                <td style="text-align: center">
                                    @php $total = $total + $transactionItem->product->input_price * $transactionItem->qty; @endphp
                                    {{number_format($transactionItem->product->input_price * $transactionItem->qty)}}
                                </td>
                                <td style="text-align: center">
                                    {{number_format(($transactionItem->product->price * $transactionItem->qty) - $transactionItem->product->input_price)}}
                                </td>
                                <td>
                                    {{$transactionItem->user->fullname}}
                                </td>
                                <td>
                                    <textarea class="form-control noteaction" data-id="{{$transactionItem->id}}" name="" id="" cols="20" rows="2">{{$transactionItem->note}}</textarea>
                                </td>
                                <td>
                                    <button data-id="{{$transactionItem->id}}" status="{{$transactionItem->status_vacc}}" style="margin-top: 10px" type="button" class="status-vacc btn btn-@if($transactionItem->status_vacc==0){{'danger'}}@else{{'primary'}}@endif">
                                        Trả VACC
                                    </button>
                                    {{-- <select style="background: @if($transactionItem->status_vacc == 0){{'red'}}@endif" data-id="{{$transactionItem->id}}" onchange="upadteStatusVaccItem()" class="form-control status-vacc">
                                        <option @if($transactionItem->status_vacc == 1){{'selected'}}@endif value="1">
                                            Đã trả
                                        </option>
                                        <option  @if($transactionItem->status_vacc == 0){{'selected'}}@endif value="0">
                                            Chưa trả
                                        </option>
                                    </select> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr align="center">
                            <td colspan="7" style="text-align: right">
                                <b>Tổng cộng:</b>
                            </td>
                            <td><b>{{\App\Helpers\Helper::vaccTotal($dateStartToView, $dateEndToView)}}</b></td>
                            <td></td>
                            <td></td>   
                        </tr>
                    </tfoot>
                </table>
            <div class="row">
                {{$transactions->links()}}              
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
    $('.noteaction').keyup(debounce(function(e){
        var me = $(this);
        var dataPost = {
          id:   me.data('id'),
          note: me.val(),
          _token: "{{csrf_token()}}"
        };
       $.ajax({
           url: "{{route('admin.statistic.edit-note')}}",
           method: 'POST',
           data: dataPost,
           success: function(e) {
                if (e == false) {
                    alert('Lỗi máy chủ');
                } else if (e == true) {
                    alert('Cập nhật thành công');
                }
           }
       })
    },1000));
    $('.status-vacc').click(function(){
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
            type: 'vacc',
            _token: "{{csrf_token()}}"
        };

        $.ajax({
            url: "{{route('admin.statistic.update-status-vacc-vace')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                
            }
        })
    })
    // $('.status-vacc').change(function(){
    //     status = $(this).val();

    //     if (status == 0) {
    //         $(this).css({'background':'red'});
    //     } else {
    //         $(this).css({'background':'#fff'});
    //     }
    //     id = $(this).attr('data-id');
    //     var dataPost = {
    //         type: "vacc",
    //         status:   status,
    //         id: id,
    //         _token: "{{csrf_token()}}"
    //     };

    //     $.ajax({
    //         url: "{{route('admin.statistic.update-status-vacc-vace')}}",
    //         method: 'POST',
    //         data: dataPost,
    //         success: function(e) {
                
    //         }
    //     })
    // });
    $('.vacc').click(function(){
        status = $(this).val();
        var dataPost = {
            type: "vacc",
            status:   status,
            id: '',
            date_start: "{{$dateStartToView}}",
            date_end: "{{$dateEndToView}}",
            _token: "{{csrf_token()}}"
        };
        $.ajax({
            url: "{{route('admin.statistic.update-status-vacc-vace')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                if (e == 'true') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cập nhật thành công',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    location.reload();
                } else if (e == 'false') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Vui lòng thử lại sau',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    location.reload();
                }
            }
        })
    })
</script>
@endsection