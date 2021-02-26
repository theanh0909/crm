@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Password', 'item2' => 'Đổi mật khẩu'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Đổi mật khẩu
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::open(['route' => 'admin.user.update-password', 'method' => 'POST']) }}
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Mật khẩu cũ:</label>
                        {{Form::password('old_password', ['class' => 'form-control', 'placeholder' => ''])}}
                        @if($errors->has('old_password'))
                            <span class="text-danger">{{$errors->first('old_password')}}</span>
                        @endif
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Mật khẩu mới:</label>
                        {{Form::password('password', ['class' => 'form-control', 'placeholder' => ''])}}
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Xác nhận lại mật khẩu</label>
                        {{Form::password('password_confirm', ['class' => 'form-control', 'placeholder' => ''])}}
                        @if($errors->has('password_confirm'))
                            <span class="text-danger">{{$errors->first('password_confirm')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Cập nhật</button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
@endsection
