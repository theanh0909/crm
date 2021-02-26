@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'License', 'item2' => 'Gửi key cho khách hàng'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Thông tin yêu cầu gửi key</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        <form class="form" method="post" action="{{route('admin.license.post-send-key')}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Tên khách hàng:</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Tên khách hàng..." />
                        @if($errors->has('customer_name'))
                            <span class="form-text text-muted ">{{$errors->first('customer_name')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Email:</label>
                        <input type="email" name="email_customer" class="form-control" placeholder="Nhập Email khách hàng..." />
                        @if($errors->has('email_customer'))
                            <span class="form-text text-muted ">{{$errors->first('email_customer')}}</span>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <label>Số điện thoại khách hàng:</label>
                        <input type="text" name="customer_phone" class="form-control" placeholder="Nhập SĐT khách hàng..." />
                        @if($errors->has('customer_phone'))
                            <span class="form-text text-muted ">{{$errors->first('customer_phone')}}</span>
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
                        <label>Số ngày:</label>
                        {{Form::select('type_expire_date', $typeExpireDate, 365, ['class' => 'form-control select2', 'id' => 'kt_select2_2'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Số lượng key cần gửi:</label>
                        <input type="number" class="form-control" value="1" name="n_key">
                        @if($errors->has('n_key'))
                            <span class="form-text text-muted ">{{$errors->first('n_key')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Người gửi</label>
                        {{Form::select('id_user',$users, auth()->user()->id, ['class' => 'form-control select2', 'id' => 'kt_select2_1'])}}
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
                        <label>Khách hàng đã thanh toán:</label>
                        <div class="radio-inline">
                            <label class="radio radio-solid">
                                <input type="checkbox" name="status_sell" checked="checked" value="1" />
                                <span></span>
                            </label>
                        </div>
                        @if($errors->has('status_sell'))
                            <span class="form-text text-muted ">{{$errors->first('status_sell')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button onclick="return confirm('Xác nhận gửi key cho khách hàng?')" type="submit" class="btn btn-primary mr-2">Gửi</button>
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
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script>
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