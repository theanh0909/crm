@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Add'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Thông tin khách hàng</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::open(['url' => route('admin.customer.createHashKeyCustomer'), 'method' => 'POST']) }}
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Tên khách hàng:</label>
                        {{Form::text('customer_name', '', ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Số điện thoại</label>
                        {{Form::text('customer_phone', '', ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Email</label>
                        {{Form::text('customer_email', '', ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Địa chỉ</label>
                        {{Form::text('customer_address', '', ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Thành phố</label>
                        {{Form::text('customer_cty', 'Hà Nội', ['class' => 'form-control', 'placeholder' => 'Hà Nội', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-4">
                        <label>Phần mềm:</label>
                        <select id="kt_select2_1" class="form-control" name="product_type">
                            @foreach($product as $prd)
                                <option value="{{$prd->product_type}}" price="{{$prd->price}}">{{$prd->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label>Số lượng:</label>
                        {{Form::number('qty',1, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-3">
                        <label>Đơn giá:</label>
                        {{Form::number('price',0, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-3">
                        <label>Giảm giá:</label>
                        {{Form::number('discount',0, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-3">
                        <label>Thành tiền:</label>
                        {{Form::number('money',0, ['class' => 'form-control', 'required' => 'required', 'readonly' => true])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Mã khóa</label>
                        {{Form::text('license_original', '', ['class' => 'form-control'])}}
                    </div>


                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Ghi chú</label>
                        {{Form::textarea('note', '', ['class' => 'form-control', 'rows' => 3])}}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Tạo yêu cầu</button>
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
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script>
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

            var money = (price * total) - discount;
            $('input[name=money]').val(money);
        }

        getMoney();

        $('input[name=price], input[name=qty], input[name=discount]').change(function () {
            getMoney();
        });
    </script>

@endsection