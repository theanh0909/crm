@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Setting', 'item2' => 'Cấu hình nhận gửi Email'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Cấu hình nhận gửi Email
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::open(['route' => 'admin.settings.update-email', 'method' => 'POST', 'files' => true]) }}
            <div class="card-body">
                <div class="form-group row">
                    @foreach($fields as $key => $val)
                        <div class="col-lg-6" style="margin-bottom: 20px">
                            <label>{{$val}}</label>
                            <?php
                                $valuex = ($setting && isset($setting->$key)) ? $setting->$key : '';
                            ?>
                            @if($key == 'password')
                            <input type="password" value="{{$valuex}}" name="password" class="form-control">
                            @else
                            {{Form::text($key, $valuex, ['class' => 'form-control'])}}
                            @endif
                        </div>
                    @endforeach
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
