@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Password', 'item2' => 'Đổi mật khẩu'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Cập nhật hồ sơ của - <i>{{$user->fullname}}</i>
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::open(['url' => route('admin.user.update-profile'), 'method' => 'POST', 'files' => true]) }}
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Tên đăng nhập</label>
                        {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Tên đăng nhập'])}}
                        @if($errors->has('name'))
                            <span class="text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Email</label>
                        {{Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email đăng nhập'])}}
                        @if($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label >Tên hiển thị</label>
                        {{Form::text('fullname', $user->fullname, ['class' => 'form-control', 'placeholder' => 'Tên hiển thị'])}}
                        @if($errors->has('fullname'))
                            <span class="text-danger">{{$errors->first('fullname')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Mật khẩu cũ</label>
                        {{Form::password('old_password', ['class' => 'form-control', 'placeholder' => ''])}}
                        @if($errors->has('old_password'))
                            <span class="text-danger">{{$errors->first('old_password')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Mật khẩu</label>
                        {{Form::password('password', ['class' => 'form-control', 'placeholder' => ''])}}
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Xác nhận lại mật khẩu</label>
                        {{Form::password('password_confirm', ['class' => 'form-control', 'placeholder' => ''])}}
                        @if($errors->has('password_confirm'))
                            <span class="text-danger">{{$errors->first('password_confirm')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Avatar</label>
                        {{Form::file('avatar', ['class' => 'form-control'])}}
                        @if($errors->has('name'))
                            <span class="text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <label>Link cá nhân</label>
                        <input class="form-control" value="{{route('certificate-form', ['id' => auth()->user()->id])}}">
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
