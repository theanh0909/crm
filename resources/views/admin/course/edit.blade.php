@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Học viên', 'item2' => 'Edit'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Chỉnh sửa thông tin học viên - {{$customer->customer_name}}
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::model($customer,['url' => route('admin.course.update', ['id' => $customer->id]), 'method' => 'PUT']) }}
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Tên khách hàng</label>
                        {{Form::text('customer_name', $customer->customer_name, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Điện thoại</label>
                        {{Form::text('customer_phone', $customer->customer_phone, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Email</label>
                        {{Form::text('customer_email', $customer->customer_email, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Địa chỉ</label>
                        {{Form::text('customer_address', $customer->customer_address, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Thành phố</label>
                        {{Form::text('customer_cty', $customer->customer_cty, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Khóa học</label>
                        {{Form::select('product_type',$product, $customer->product_type, ['class' => 'form-control select'])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Ghi chú</label>
                        {{Form::textarea('note', '', ['class' => 'form-control', 'rows' => 3])}}
                        @if($errors->has('note'))
                            <span class="text-danger">{{$errors->first('note')}}</span>
                        @endif
                    </div>
                    
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button style="width: 100%" type="submit" class="btn btn-primary mr-2">Cập nhật</button>
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
<script>
    $('.select').select2();
</script>
@endsection