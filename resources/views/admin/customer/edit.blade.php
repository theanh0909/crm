@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Edit'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">CHỈNH SỬA THÔNG TIN KHÁCH HÀNG - {{$customer->customer_name}}</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::model($customer,['url' => route('admin.customer.update', ['id' => $customer->id]), 'method' => 'PUT']) }}
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Tên khách hàng:</label>
                        {{Form::text('customer_name', $customer->customer_name, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Email:</label>
                        {{Form::text('customer_email', $customer->customer_email, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Số điện thoại khách hàng:</label>
                        {{Form::text('customer_phone', $customer->customer_phone, ['class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Địa chỉ:</label>
                        {{Form::text('customer_address', $customer->customer_address, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-6">
                        <label>Thành phố:</label>
                        {{Form::text('customer_cty', $customer->customer_cty, ['class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>License KEY:</label>
                        {{Form::text('', $customer->license_original, ['class' => 'form-control', 'readonly' => true])}}
                    </div>
                    <div class="col-lg-6">
                        <label>Hardware ID:</label>
                        {{Form::text('hardware_id', $customer->hardware_id, ['class' => 'form-control', 'readonly' => false])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Sản phẩm:</label>
                        <select name="product_type" id="kt_select2_1" class="form-control">
                            @foreach($listProduct as $productItem)
                                <option @if($productItem->product_type == $customer->product_type){{'selected'}}@endif value="{{$productItem->product_type}}">
                                    {{$productItem->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if($customer->hardware_id != 'KHOACUNG' && $customer->license)
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Loại key:</label>
                            <div class="radio-inline">
                                <label class="radio radio-solid">
                                    {{Form::radio('license_status', '1', ($customer->license->status == 1) ? true : false, ['class' => 'form-check-input'] )}}
                                    <span></span>Thương mại
                                </label>
                                <label class="radio radio-solid">
                                    {{Form::radio('license_status', '0', ($customer->license->status == 0) ? true : false, ['class' => 'form-check-input'] )}}
                                    <span></span>Thử nghiệm
                                </label>
                                <label class="radio radio-solid">
                                    {{Form::radio('license_status', '0', ($customer->license->status == 2) ? true : false, ['class' => 'form-check-input'] )}}
                                    <span></span>Lớp học
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
                @if($customer->hardware_id != 'KHOACUNG')
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label>Số lần đã đổi key:</label>
                            {{Form::text('', $customer->number_has_change_key, ['class' => 'form-control', 'readonly' => 'true'])}}
                        </div>
                        <div class="col-lg-3">
                            <label>Số lần tối đa có thể đổi key:</label>
                            {{Form::number('number_can_change_key', $customer->number_can_change_key, ['class' => 'form-control'])}}
                        </div>
                        <div class="col-lg-3">
                            <label>Ngày kích hoạt</label>
                            {{Form::text('', \Carbon\Carbon::parse($customer->license_activation_date)->format("Y-m-d"), ['class' => 'form-control', 'readonly' => 'true'])}}
                        </div>
                        <div class="col-lg-3">
                            <label>Ngày hết hạn</label>
                            <div class="input-group date">
                                <input value="{{$customer->license_expire_date}}" type="text" name="license_expire_date" class="form-control" id="kt_datepicker_2" readonly="readonly" placeholder="Ngày tạo..." />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Ngày HĐ cuối cùng:</label>
                        {{Form::text('', $customer->last_runing_date, ['class' => 'form-control', 'readonly' => 'true'])}}
                    </div>
                    <div class="col-lg-6">
                        <label>Giá:</label>
                        {{Form::text('', $customer->transaction ? $customer->transaction->price : '', ['class' => 'form-control', 'readonly' => 'true'])}}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Cập nhật</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
            </div>
       {{ Form::close() }}
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
<script>
    $('#kt_datepicker_2').datepicker({
       rtl: KTUtil.isRTL(),
       todayHighlight: true,
       orientation: "bottom left",
       format: 'yyyy-mm-dd'
      });
</script>
@endsection
