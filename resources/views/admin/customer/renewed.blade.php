@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Gia hạn'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">GIA HẠN KEY CHO KHÁCH HÀNG - {{$customer->customer_name}}</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::model($customer,['url' => route('admin.customer.postRenewed', ['id' => $customer->id]), 'method' => 'PUT', 'files' => true]) }}
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Số ngày được gia hạn:</label>
                        {{Form::select('renewed', $typeExpireDate,365, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Tên khách hàng</label>
                        {{Form::text('customer_name', $customer->customer_name, ['class' => 'form-control', 'readonly' => true])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Email</label>
                        {{Form::text('customer_name', $customer->customer_email, ['class' => 'form-control', 'readonly' => true])}}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Hardware ID</label>
                        {{Form::text('', $customer->hardware_id, ['class' => 'form-control', 'readonly' => true])}}
                    </div>
                    <div class="col-lg-6">
                        <label>Phần mềm</label>
                        {{Form::text('', $customer->product->name, ['class' => 'form-control', 'readonly' => true])}}
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Ngày kích hoạt:</label>
                        {{Form::text('', \Carbon\Carbon::parse($customer->license_created_date)->format("Y-m-d"), ['class' => 'form-control', 'readonly' => 'true'])}}
                    </div>
                    <div class="col-lg-6">
                        <label>Ngày hết hạn:</label>
                        {{Form::text('', $customer->license_expire_date, ['class' => 'form-control', 'readonly' => 'true'])}}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Gia hạn</button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
@endsection
