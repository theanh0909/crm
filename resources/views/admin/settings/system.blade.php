@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Setting', 'item2' => 'Cài đặt hệ thống'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Cài đặt hệ thống
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::open(['route' => 'admin.settings.update-system', 'method' => 'POST', 'files' => true]) }}
            <div class="card-body">
                <div class="form-group row">
                    @foreach($fields as $key => $val)
                        <div class="col-lg-6" style="margin-bottom: 20px">
                            <label>{{$val}}</label>
                            {{Form::text($key, ($setting && isset($setting->$key)) ? $setting->$key : '',
                            ['class' => 'form-control'])}}
                        </div>
                    @endforeach
                    <div class="col-lg-6">
                        <label>Bật/Tắt hệ thống</label>
                        <div class="radio-inline">
                            <label class="radio radio-solid">
                                {{Form::radio('status', '1', ($setting && $setting->status == 1) ? true : false, ['class' => 'form-check-input'] )}}
                                <span></span>Bật hệ thống
                            </label>
                            <label class="radio radio-solid">
                                {{Form::radio('status', '0', ($setting && $setting->status == 0) ? true : false, ['class' => 'form-check-input'] )}}
                                <span></span>Tắt hệ thống
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Lưu lại</button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
@endsection
