@extends('admin.layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">


        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="#" class="breadcrumb-item">Customer</a>
                    <span class="breadcrumb-item active">Edit</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">
        @include('admin.layouts.partitals.notify')
        <style>
            .content table tr td * {
                font-size: 10px;
            }
        </style>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h4 class="card-title">Khách hàng sử dụng KHÓA CỨNG</h4>
            </div>

            <div class="card-body">
                {{ Form::open(['url' => route('admin.customer.createHashKeyCustomer'), 'method' => 'POST']) }}
                <div class="tab-content">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold"> </legend>
                        <input type="hidden" name="customer_type" value="1">

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tên khách hàng</label>
                            <div class="col-lg-10">
                                {{Form::text('customer_name', '', ['class' => 'form-control'])}}

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Phần mềm</label>
                            <div class="col-lg-10">
                                {{Form::select('product_type',$product,'', ['class' => 'form-control', 'required' => 'required'])}}

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Đơn giá</label>
                            <div class="col-lg-10">
                                {{Form::number('price',0, ['class' => 'form-control', 'required' => 'required'])}}

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Mã khóa</label>
                            <div class="col-lg-10">
                                {{Form::text('license_original', '', ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Số điện thoại</label>
                            <div class="col-lg-10">
                                {{Form::text('customer_phone', '', ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Email </label>
                            <div class="col-lg-10">
                                {{Form::text('customer_email', '', ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Địa chỉ</label>
                            <div class="col-lg-10">
                                {{Form::text('customer_address', '', ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Thành phố</label>
                            <div class="col-lg-10">
                                {{Form::text('customer_cty', 'Hà Nội', ['class' => 'form-control', 'placeholder' => 'Hà Nội', 'required' => 'required'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Ghi chú</label>
                            <div class="col-lg-10">
                                {{Form::textarea('note', '', ['class' => 'form-control', 'rows' => 3])}}
                                @if($errors->has('note'))
                                    <span class="text-danger">{{$errors->first('note')}}</span>
                                @endif
                            </div>
                        </div>


                    </fieldset>

                    <div>
                        <button class="btn btn-success" type="submit">Cập nhật</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>


    </div>
    <!-- /content area -->

@endsection
