@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Chứng chỉ', 'item2' => 'Thêm'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Thông tin học viên</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::open(['url' => route('admin.request.store'), 'method' => 'POST']) }}
            @csrf
            <div class="card-body">
                <input type="hidden" name="customer_type" value="3">  <!-- /Loại Học viên -->
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Họ tên <i class="fa fa-asterisk color-red font-size-7"></i></label>
                        {{Form::text('customer_name', '', ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Số điện thoại <i class="fa fa-asterisk color-red font-size-7"></i></label>
                        {{Form::text('customer_phone', '', ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Email <i class="fa fa-asterisk color-red font-size-7"></i></label>
                        {{Form::text('customer_email', '', ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Địa chỉ</label>
                        {{Form::text('customer_address', '', ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Thành phố</label>
                        {{Form::text('customer_cty', 'Hà Nội', ['class' => 'form-control', 'placeholder' => 'Hà Nội', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Loại chứng chỉ</label>
                        <select class="form-control select" name="product_type">
                            @foreach($product as $prd)
                                <option value="{{$prd->product_type}}" price="{{$prd->price}}">{{$prd->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label>Số lĩnh vực</label>
                        {{Form::number('qty',1, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-3">
                        <label>Đơn giá</label>
                        {{Form::number('price',3000000, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-3">
                        <label>Giảm giá</label>
                        {{Form::number('discount',0, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-3">
                        <label>Thành tiền</label>
                        {{Form::number('money',0, ['class' => 'form-control', 'required' => 'required', 'readonly' => true])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Ghi chú</label>
                        {{Form::textarea('note', '', ['class' => 'form-control', 'rows' => 3])}}
                        @if($errors->has('note'))
                            <span class="text-danger">{{$errors->first('note')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Tạo yêu cầu</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
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
<style type="text/css">
    i.fa.fa-asterisk.color-red.font-size-7{
        font-size: 8px;
        color: red;
    }
</style>
<script>
    $('.select').select2();
    //Set Default Price
    var firstProduct = $('select[name=product_type]').find('option:selected');
    $('input[name=price]').val(firstProduct.attr('price'));

    //
    $('select[name=product_type]').change(function() {
        var element = $(this).find('option:selected');
        $('input[name=price]').val(element.attr('price'));
    });

    function getMoney() {
        var price       = $('input[name=price]').val();
        var total       = $('input[name=qty]').val();
        var discount    = $('input[name=discount]').val();

        var money = (price * total) - (total - 1) * 800000  - discount;
        if (total == 0) {
            $('input[name=money]').val(0);
        } else {
            $('input[name=money]').val(money);
        }
        
    }

    getMoney();

    $('input[name=price], input[name=qty], input[name=discount]').change(function () {
        getMoney();
    });

    $('#donate_key').change(function () {
        $('.donate_product').toggle();
    });
</script>

@endsection