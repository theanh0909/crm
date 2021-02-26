@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Product type', 'item2' => 'Create'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Tạo sản phẩm mới
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::open(['route' => 'admin.product.store', 'method' => 'POST', 'files' => true]) }}
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Tên sản phẩm:</label>
                        <div class="input-group date">
                            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Nhập tên sản phẩm'])}}
                            @if($errors->has('name'))
                                <span class="text-danger">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label>Chiết khấu %:</label>
                        {{Form::text('discount', 10, ['class' => 'form-control', 'placeholder' => '%'])}}
                        @if($errors->has('name'))
                            <span class="text-danger">{{$errors->first('discount')}}</span>
                        @endif
                    </div>
                    
                    <div class="col-lg-4">
                        <label>Product type (Product code)</label>
                        {{Form::text('product_type', '', ['class' => 'form-control', 'placeholder' => 'Nhập tên product type'])}}
                        @if($errors->has('product_type'))
                            <span class="text-danger">{{$errors->first('product_type')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Số lần được đổi máy:</label>
                        {{Form::number('number_of_change', 5, ['class' => 'form-control', 'placeholder' => '5'])}}
                        @if($errors->has('number_of_change'))
                            <span class="text-danger">{{$errors->first('number_of_change')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Giá:</label>
                        {{Form::number('price', 0, ['class' => 'form-control', 'placeholder' => 'Giá'])}}
                        @if($errors->has('price'))
                            <span class="text-danger">{{$errors->first('price')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Icon:</label>
                        {{Form::file('icon', ['class' => 'form-control'])}}
                        @if($errors->has('icon'))
                            <span class="text-danger">{{$errors->first('icon')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Versions</label>
                        {{Form::text('version', '', ['class' => 'form-control', 'placeholder' => 'Nhập Version'])}}
                        @if($errors->has('version'))
                            <span class="text-danger">{{$errors->first('version')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Key version:</label>
                        {{Form::text('key_version', '', ['class' => 'form-control', 'placeholder' => 'Nhập Key Version'])}}
                        @if($errors->has('key_version'))
                            <span class="text-danger">{{$errors->first('key_version')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Danh mục:</label>
                        {{Form::select('type', \App\Models\Product::$typeLabel, 0, ['class' => 'form-control'])}}
                        @if($errors->has('type'))
                            <span class="text-danger">{{$errors->first('type')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Trạng thái</label>
                        {{Form::select('status',[0 => 'Đang phát triển', 1 => 'Công bố'], 1, ['class' => 'form-control'])}}
                        @if($errors->has('status'))
                            <span class="text-danger">{{$errors->first('status')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>API kết nối Sendy</label>
                        {{Form::text('api', '', ['class' => 'form-control', 'placeholder' => 'Nhập mã API'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Tiền nộp đi</label>
                        {{Form::text('input_price', '', ['class' => 'form-control', 'placeholder' => 'Nhập số tiền'])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Mô tả</label>
                        {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Nhập mô tả'])}}
                        @if($errors->has('description'))
                            <span class="text-danger">{{$errors->first('description')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Thêm mới</button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
        <!--end::Form-->
    </div>
</div>
@endsection
