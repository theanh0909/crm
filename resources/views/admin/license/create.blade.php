@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'License', 'item2' => 'Tạo mới key bản quyền'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Tạo mới key bản quyền</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        <form class="form" method="post" action="{{route('admin.license.store')}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Ngày tạo:</label>
                        <div class="input-group date">
                            <input value="{{date('d/m/Y')}}" type="text" name="license_created_date" class="form-control" id="kt_datepicker_2" readonly="readonly" placeholder="Ngày tạo..." />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label>Số lượng máy sử dụng:</label>
                        <input type="number" class="form-control" value="1" name="license_no_computers">
                        @if($errors->has('license_no_computers'))
                            <span class="form-text text-muted ">{{$errors->first('license_no_computers')}}</span>
                        @endif
                    </div>
                    
                    <div class="col-lg-4">
                        <label>Số dãy mã cần tạo:</label>
                        <input type="number" class="form-control" value="1" name="no_keys">
                        @if($errors->has('no_keys'))
                            <span class="form-text text-muted ">{{$errors->first('no_keys')}}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Loại key:</label>
                        <div class="radio-inline">
                            <label class="radio radio-solid">
                                <input type="radio" name="status" checked="checked" value="1" />
                                <span></span>Thương mại
                            </label>
                            <label class="radio radio-solid">
                                <input type="radio" name="status" value="0" />
                                <span></span>Thử nghiệm
                            </label>
                            <label class="radio radio-solid">
                                <input type="radio" name="status" value="2" />
                                <span></span>Lớp học
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label>Thời gian sử dụng:</label>
                        {{Form::select('type_expire_date', $typeExpireDate, 365, ['class' => 'form-control select2', 'id' => 'kt_select2_2'])}}
                        @if($errors->has('type_expire_date'))
                            <span class="form-text text-muted ">{{$errors->first('type_expire_date')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Số bản được cài trên 1 máy:</label>
                        <input type="number" class="form-control" value="1" name="license_no_instance">
                        @if($errors->has('license_no_instance'))
                            <span class="form-text text-muted ">{{$errors->first('license_no_instance')}}</span>
                        @endif
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Chuyển key cho user</label>
                        {{Form::select('id_user',$users, \Illuminate\Support\Facades\Auth::user()->id, ['class' => 'form-control select2', 'id' => 'kt_select2_1'])}}
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phần mềm:</label>
                        <div class="radio-inline row">
                            @php($i = 0)
                            @foreach($products as $key => $val)
                                <?php $checked = ($i == 0) ? true : false; ?>
                                <label class="col-lg-2 radio radio-solid">
                                    <input type="radio" name="product_type" value="{{$key}}" />
                                    <span></span>{{$val}}
                                </label>
                                @php($i++)
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Gửi bằng Email:</label>
                        <div class="radio-inline">
                            <label class="radio radio-solid">
                                <input type="checkbox" name="status_email" value="1" />
                                <span></span>
                            </label>
                        </div>
                        @if($errors->has('status_email'))
                            <span class="form-text text-muted ">{{$errors->first('status_email')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Gửi</button>
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