@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Request', 'item2' => 'Yêu cầu gửi key'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Sửa yêu cầu gửi key</h3>
        </div>
        @include('admin.layouts.partitals.notify')
{{--         {{dd($model)}}
 --}}        <!--begin::Form-->
        {{ Form::model($model, ['url' => route('admin.request.update', ['id' => $model->id]), 'method' => 'PUT']) }}
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Tên khách hàng:</label>
                        {{Form::text('customer_name', $model->customer_name, ['class' => 'form-control', 'placeholder' => 'Nhập tên khách hàng'])}}
                        @if($errors->has('customer_name'))
                            <span class="text-danger">{{$errors->first('customer_name')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Email:</label>
                        {{Form::text('customer_email', $model->customer_email, ['required' => 'required', 'type' => 'email','class' => 'form-control', 'placeholder' => 'Nhập Email khách hàng'])}}
                        @if($errors->has('customer_email'))
                            <span class="text-danger">{{$errors->first('customer_email')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Số điện thoại khách hàng:</label>
                        {{Form::text('customer_phone', $model->customer_phone, ['class' => 'form-control', 'placeholder' => 'Nhập SDT khách hàng'])}}
                        @if($errors->has('customer_phone'))
                            <span class="text-danger">{{$errors->first('customer_phone')}}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Loại key:</label>
                        <div class="radio-inline">
                            <label class="radio radio-solid">
                                <input @if($model->type == 1){{'checked'}}@endif type="radio" name="type" checked="checked" value="1" />
                                <span></span>Thương mại
                            </label>
                            <label class="radio radio-solid">
                                <input @if($model->type == 0){{'checked'}}@endif type="radio" name="type" value="0" />
                                <span></span>Dùng thử
                            </label>
                            <label class="radio radio-solid">
                                <input @if($model->type == 2){{'checked'}}@endif type="radio" name="type" value="2" />
                                <span></span>Lớp học
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label>Số ngày:</label>
                        {{Form::select('number_day',$typeExpireDate, $model->number_day, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Số lượng key cần gửi:</label>
                        {{Form::number('qty', $model->qty, ['class' => 'form-control'])}}
                        @if($errors->has('qty'))
                            <span class="text-danger">{{$errors->first('qty')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phần mềm:</label>
                        <div class="radio-inline row">
                            @php($i = 0)
                            @foreach($products as $key => $val)
                                <label class="col-lg-2 radio radio-solid">
                                    <input @if($key == $model->product_type){{'checked'}}@endif type="radio" name="product_type" value="{{$key}}" />
                                    <span></span>{{$val}}
                                </label>
                                @php($i++)
                            @endforeach
                            @if($errors->has('product_type'))
                                <span class="text-danger">{{$errors->first('product_type')}}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Ghi chú</label>
                        {{Form::textarea('note', $model->note, ['class' => 'form-control', 'rows' => 3])}}
                        @if($errors->has('note'))
                            <span class="text-danger">{{$errors->first('note')}}</span>
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

@section('script')
<script>
    $('input[name=type]').change(function(e) {
        var me = $(this);
        if(me.val() == 0) {
            $('select[name=number_day]').val(7).change();
        }
        if(me.val() == 1) {
            $('select[name=number_day]').val(365).change();
        }
    });
</script>
@endsection