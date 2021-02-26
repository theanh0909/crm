@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'License', 'item2' => 'Sửa license'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Chỉnh sửa LICENSE - {{$license->license_key}}</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        <form class="form" method="POST" action="{{route('admin.license.update', ['id' => $license->id])}}">
            @csrf
            <input name="_method" type="hidden" value="PUT">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Ngày tạo:</label>
                        <div class="input-group date">
                            <input value="{{date('d/m/Y', strtotime($license->license_created_date))}}" type="text" name="license_created_date" class="form-control" id="kt_datepicker_2" readonly="readonly" placeholder="Ngày tạo..." />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label>Mã License:</label>
                        {{Form::text('key_license_date', $license->license_key, ['class' => 'form-control', 'readonly' => true])}}
                        @if($errors->has('key_license_date'))
                            <span class="form-text text-muted ">{{$errors->first('key_license_date')}}</span>
                        @endif
                    </div>
                    
                    <div class="col-lg-4">
                        <label>Mã License serial:</label>
                        {{Form::text('key_license_date', $license->license_serial, ['class' => 'form-control', 'readonly' => true])}}
                        @if($errors->has('key_license_date'))
                            <span class="form-text text-muted ">{{$errors->first('key_license_date')}}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Loại key:</label>
                        <div class="radio-inline">
                            <label class="radio radio-solid">
                                <input @if($license->status == 1){{'checked'}}@endif type="radio" name="status" checked="checked" value="1" />
                                <span></span>Thương mại
                            </label>
                            <label class="radio radio-solid">
                                <input  @if($license->status == 0){{'checked'}}@endif type="radio" name="status" value="0" />
                                <span></span>Thử nghiệm
                            </label>
                            <label class="radio radio-solid">
                                <input  @if($license->status == 2){{'checked'}}@endif type="radio" name="status" value="2" />
                                <span></span>Lớp học
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label>Thời gian sử dụng:</label>
                        {{Form::select('type_expire_date', $typeExpireDate, $license->type_expire_date, ['class' => 'form-control', 'id' => 'kt_select2_2'])}}
                        @if($errors->has('type_expire_date'))
                            <span class="form-text text-muted ">{{$errors->first('type_expire_date')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Số bản được cài trên 1 máy:</label>
                        {{Form::number('license_no_instance', $license->license_no_instance, ['class' => 'form-control', 'placeholder' => 'Số bản được cài trên 1 máy'])}}
                        @if($errors->has('license_no_instance'))
                            <span class="form-text text-muted ">{{$errors->first('license_no_instance')}}</span>
                        @endif
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Chuyển key cho user</label>
                        {{Form::select('id_user', $users, $license->id_user, ['class' => 'form-control', 'id' => 'kt_select2_1'])}}
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phần mềm:</label>
                        <div class="radio-inline row">
                            @foreach($products as $key => $val)
                                <label class="col-lg-2 radio radio-solid">
                                    <input @if($key == $license->product_type){{'checked'}}@endif type="radio" name="product_type" value="{{$key}}" />
                                    <span></span>{{$val}}
                                </label>
                            @endforeach
                        </div>
                        @if($errors->has('product_type'))
                            <span class="form-text text-muted ">{{$errors->first('product_type')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Cập nhật</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script>
    $('#kt_datepicker_2').datepicker({
       rtl: KTUtil.isRTL(),
       todayHighlight: true,
       orientation: "bottom left",
       format: 'dd/mm/yyyy'
      });
    $('input[name=status]').change(function(e) {
       var me = $(this);
       if(me.val() == 0) {
           $('select[name=type_expire_date]').val(7).change();
       }
       if(me.val() == 1) {
           $('select[name=type_expire_date]').val(365).change();
       }
    });
</script>
@endsection