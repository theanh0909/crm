@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Edit'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Sửa đơn hàng</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        <form action="{{route('admin.customer.edit-certificate-post', ['id' => $transaction->id])}}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Họ tên:</label>
                        {{Form::text('customer_name', $transaction->customer_name, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Số điện thoại:</label>
                        {{Form::text('customer_phone', $transaction->customer_phone, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Email:</label>
                        {{Form::text('customer_email', $transaction->customer_email, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Địa chỉ:</label>
                        {{Form::text('customer_address', $transaction->customer_address, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Lĩnh vực theo nghị định:</label>
                        <textarea class="form-control" name="decree" id="" cols="30" rows="2">{{$transaction->decree}}</textarea>
                    </div>
                    <div class="col-lg-4">
                        <label>Lĩnh vực:</label>
                        <textarea class="form-control" name="type_exam" id="" cols="30" rows="2">{{$transaction->type_exam}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Hạng:</label>
                        <textarea class="form-control" name="class" id="" cols="30" rows="2">{{$transaction->class}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Ghi chú</label>
                        {{Form::text('note', $transaction->note, ['class' => 'form-control', 'rows' => 3])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <p style="color: red">* Chú ý: (Mỗi nghị định, lĩnh vực, hạng cách nhau bằng dấu ; và không được đặt dấu ; ở cuối)</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Gửi yêu cầu</button>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
@endsection

@section('script')
<style>
    .content table tr td * {
        font-size: 10px;
    }
</style>
<style>
        .content table tr td *{
            font-size: 13.5px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection