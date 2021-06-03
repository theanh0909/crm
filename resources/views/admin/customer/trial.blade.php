@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Danh sách khách dùng thử'])
<div class="container">
    <div class="card card-custom overflow-x">
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
                <h3 class="card-label">Danh sách khách dùng thử</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-body" style="padding-bottom: 0px">
            <form method="GET">
                <div class="mt-2 mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                    <input type="text" name="query" class="form-control" placeholder="Tìm kiếm" value="{{(isset($inputs['query'])) ? $inputs['query'] : ''}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="js-example-basic-single form-control" id="kt_select2_1" name="product_type">
                                        <option value="0">Sản phẩm</option>
                                        @foreach($productTypes as $productType)
                                            <option
                                                    {{(isset($inputs['product_type']) && $inputs['product_type'] == $productType->product_type ) ? 'selected' : ''}}
                                                    value="{{$productType->product_type}}">{{$productType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="js-example-basic-single form-control" id="kt_select2_2" name="customer_cty">
                                        <option value="0">-- Thành phố --</option>
                                        @foreach($provinces as $province)
                                            <option
                                                    {{(isset($inputs['customer_cty']) && $inputs['customer_cty'] == $province->customer_cty ) ? 'selected' : ''}}
                                                    value="{{$province->customer_cty}}">{{$province->customer_cty}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class='input-group' id='kt_daterangepicker_6'>
                                        <label class="radio radio-solid" style="margin-right: 10px">
                                            <input type="checkbox" name="use_date" value="1" @if(isset($inputs['use_date']) && $inputs['use_date'] == 1)checked @endif/>
                                            <span></span>
                                        </label>
                                        <input type='text' value="{{!empty($inputs['date']) ? $inputs['date'] : ''}}" name="date" class="form-control" readonly  placeholder="Chọn thời gian"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <br>
                    <div class="row">
                        <div class="col-md-12">
                            <center>
                                <button type="submit" class="btn btn-primary px-6 font-weight-bold"><i class="flaticon-search-magnifier-interface-symbol"></i>Tìm kiếm</button>
                                <a class="btn btn-success px-6 font-weight-bold" href="{{route('admin.customer.listHashKeyCustomer')}}">
                                    Bộ lọc
                                </a>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exportModal">
                                    <i class="fa fa-file-excel-o"></i> Export
                                </button>
                            </center>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Search Form-->
        </div>
        <div class="card-header">
            <!-- Modal -->
            <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        {!! Form::open(['url' => route('admin.customer.exportCustomerTrial'), 'method' => 'POST', 'target' => '_blank']) !!}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Export khách hàng dùng thử</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">Từ ngày</label>
                                <div class="col-lg-12">
                                    <input type="date" name="date_from" class="form-control" value="{{date('d-m-Y')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">Đến ngày</label>
                                <div class="col-lg-12">
                                    <input type="date" name="date_to" class="form-control" value="{{date('d-m-Y')}}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Export</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr align="center">
                    <th>Sản phẩm</th>
                    <th>Khách hàng</th>
                    <th>Quản lý</th>
                    <th>Ghi chú</th>
                    <th width="200">Hành động</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($customers as $item)
                        <tr>
                            <td>
                                <p>
                                    <b class="text-success">{{($item->product) ? $item->product->name : ''}}</b> :
                                    {{($item->product) ? number_format($item->product->price, 0, '.', '.') : ''}} VND
                                </p>
                                <p>
                                    <b class="text-success">Key:</b>
                                    {{$item->license_original}}
                                </p>
                                <p>
                                    <b class="text-success">Loại Key:</b>
                                    @if($item->license)
                                        @if($item->license->status == 0)
                                            Key dùng thử
                                        @else
                                            Key thương mại
                                        @endif
                                    @endif
                                </p>
                                <p><b class="text-success">Ngày hết hạn:</b> {{$item->license_expire_date}}</p>
                            </td>
                            <td>
                                <p class="text-success"><b>{{$item->customer_name}}</b></p>
                                <p><b class="text-info">{{$item->customer_phone}}</b> / <span class="text-secondary">{{$item->customer_email}}</span></p>
                                <p><b class="text-success">Ngày HĐ cuối:</b> {{$item->last_runing_date}}</p>
                                <p>
                                    <button data-background="info" data-id="{{$item->id}}" class="status_action btn btn-sm
                                            @if($item->background == 'info') btn-info @else btn-light @endif">Xong</button>
                                    <button data-background="warning" data-id="{{$item->id}}" class="status_action btn btn-sm
                                            @if($item->background == 'warning') btn-warning @else btn-light @endif">Chờ</button>
                                    <button data-background="danger" data-id="{{$item->id}}" class="status_action btn btn-sm
                                            @if($item->background == 'danger') btn-danger @else btn-light @endif">Hủy</button>
                                    <button class="btn btn-light btn-sm">Chuyển</button>
                                </p>
                            </td>
                            <td>
                                <span class="text-success">
                                    @if($item->license && $item->license->user) {{$item->license->user->fullname}} @endif
                                </span>
                            </td>
                            <td>
                                <textarea cols="30" rows="4" data-table="registered" class="noteaction form-control" data-id="{{$item->id}}">{{$item->note}}</textarea>
                            </td>
                            <td class="action">
                                <center>
                                    {{Form::open(['url' => route('admin.customer.reset-key', ['id' => $item->id]), 'method' => 'POST'])}}
                                    @if(can('customer-edit'))
                                        <a href="{{route('admin.customer.edit', ['id' => $item->id])}}" class="btn btn-warning" data-toggle="tooltip" data-theme="dark"  title="Sửa"><i class="flaticon-edit-1"></i></a>
                                    @endif
                                    @if(can('customer-renewed'))
                                        <a href="{{route('admin.customer.getRenewed', ['id' => $item->id])}}" class="btn btn-success" data-toggle="tooltip" data-theme="dark" title="Gia hạn Key"><i class="flaticon-calendar-with-a-clock-time-tools"></i></a>
                                    @endif
                                    @if(can('customer-remake-key'))
                                        <button class="btn btn-danger" data-toggle="tooltip" data-theme="dark" title="Đặt lại key"
                                                type="submit" onclick="return confirm('Xác nhận đặt lại key?')"><i class="fa fa-key"></i>
                                        </button>
                                    @endif
                                    {{Form::close()}}
                                </center>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                {!! $customers->links() !!}
            </div>            
        </div>
    </div>
</div>
<style type="text/css">
    .action i{
        font-size: 13px !important;
    }
</style>
@endsection

@section('script')
<script src="{{asset('js/sweetalert2@10.js')}}"></script>
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
<script>
    $('.status_action').click(function (e) {
        var me = $(this);
        var dataPost = {
            id:   me.data('id'),
            background: me.data('background'),
            _token: "{{csrf_token()}}"
        };

        $('.status_action').attr('class', 'status_action btn btn-sm btn-light');
        me.attr('class', 'status_action btn btn-sm btn-' + me.data('background'));

        $.ajax({
            url: "{{route('admin.customer.editBackground')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật thành công',
                    timer: 800
                })
            }
        })

    });

    $('.noteaction').keyup(debounce(function(e){
        var me = $(this);
        var dataPost = {
            id:   me.data('id'),
            note: me.val(),
            _token: "{{csrf_token()}}"
        };
        $.ajax({
            url: "{{route('admin.customer.editComment')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật thành công',
                    timer: 800
                })
            }
        })
    },1000));
</script>
@endsection