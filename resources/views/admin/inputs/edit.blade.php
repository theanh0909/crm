@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Thêm đơn hàng'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Thêm đơn hàng</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        <form action="{{route('admin.input-edit', ['id' => $transaction->id])}}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label class="col-form-label">Họ tên <i class="fa fa-asterisk color-red font-size-7"></i></label>
                        {{Form::text('customer_name', $transaction->customer_name, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Số điện thoại <i class="fa fa-asterisk color-red font-size-7"></i></label>
                        {{Form::text('customer_phone', $transaction->customer_phone, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Email <i class="fa fa-asterisk color-red font-size-7"></i></label>
                        {{Form::text('customer_email', $transaction->customer_email, ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label class="col-form-label">Địa chỉ</label>
                        {{Form::text('customer_address', $transaction->customer_address, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Tỉnh thành</label>
                        <select class="js-example-basic-single form-control" name="custtomer_cty">
                            @foreach($provinces as $provinceItem)
                                @if ($provinceItem->provinceid == '01TTT' || $provinceItem->provinceid == '79TTT' || $provinceItem->provinceid == '56TTT')
                                    <option @if($transaction->customer_cty == $provinceItem->name){{'selected'}}@endif value="{{$provinceItem->name}}">{{$provinceItem->name}}</option>
                                @endif
                            @endforeach
                            @foreach($provinces as $provinceItem)
                                @if ($provinceItem->provinceid != '01TTT' && $provinceItem->provinceid != '79TTT' && $provinceItem->provinceid != '56TTT')
                                    <option @if($transaction->customer_cty == $provinceItem->name){{'selected'}}@endif value="{{$provinceItem->name}}">{{$provinceItem->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Ghi chú</label>
                        {{Form::text('note', $transaction->note, ['class' => 'form-control', 'rows' => 3])}}
                        @if($errors->has('note'))
                            <span class="text-danger">{{$errors->first('note')}}</span>
                        @endif
                    </div>
                </div>
                @if($transaction->customer_type == 3)
                    <div class="col-lg-4">
                        <label class="col-form-label">Lĩnh vực theo NĐ <i class="fa fa-asterisk color-red font-size-7"></i></label>
                        <textarea required class="form-control" name="decree" id="" cols="30" rows="2">{{$transaction->decree}}</textarea>
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Lĩnh vực <i class="fa fa-asterisk color-red font-size-7"></i></label>
                        <textarea required class="form-control" name="type_exam" id="" cols="30" rows="2">{{$transaction->type_exam}}</textarea>
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Hạng <i class="fa fa-asterisk color-red font-size-7"></i></label>
                        <textarea required class="form-control" name="class" id="" cols="30" rows="2">{{$transaction->class}}</textarea>
                    </div>
                    <div class="col-lg-12">
                        <p style="color: red">* Chú ý: (Mỗi nghị định, lĩnh vực, hạng cách nhau bằng dấu ; và không được đặt dấu ; ở cuối)</p>
                    </div>
                @endif
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="test1 form-group row">
                            <table class="table">
                                <thead style="background: #eee">
                                    <tr align="center">
                                        <th>Sản phẩm</th>
                                        <th>
                                            Loại sản phẩm
                                        </th>
                                        <th>Số lượng</th>
                                        <th>Khác</th>
                                        <th>Đơn giá</th>
                                        <!-- <th>Giảm giá</th> -->
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody class="product-lisst">
                                    <tr>
                                        <td>
                                        {{--$transaction->donate_product == $productItem->product_type--}}
                                            <select id="product" onchange="pickProduct()" class="js-example-basic-single" name="product_type">
                                                @foreach($products as $productItem)
                                                    <option @if($transaction->product->id == $productItem->id){{'selected'}}@endif value="{{$productItem->product_type}}">{{$productItem->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="customer_type" class="form-control">
                                                <option @if($transaction->customer_type == 0){{'selected'}}@endif value="0">Khóa mềm</option>
                                                <option @if($transaction->customer_type == 1){{'selected'}}@endif value="1">Khóa cứng</option>
                                                <option @if($transaction->customer_type == 2){{'selected'}}@endif value="2">Khóa học</option>
                                                <option @if($transaction->customer_type == 3){{'selected'}}@endif value="3">Chứng chỉ</option>
                                            </select>
                                        </td>
                                        <td style="width: 100px">
                                            <input class="form-control" type="number" name="qty" value="{{$transaction->qty}}">
                                        </td>
                                        <td>
                                            @if($transaction->customer_type == 0)
                                                <label for="">Số ngày</label>
                                                <select name="number_day" class="form-control">
                                                    @foreach($typeExpireDate as $key => $dayNumber)
                                                        <option @if($transaction->number_day == $key){{'selected'}}@endif value="{{$key}}">
                                                            {{$dayNumber}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="">Loại key</label>
                                                <select name="type" class="form-control" id="">
                                                    <option @if($transaction->type == 1){{'selected'}}@endif value="1">Thương mại</option>
                                                    <option @if($transaction->type == 0){{'selected'}}@endif value="0">Dùng thử</option>
                                                </select>
                                            @elseif($transaction->customer_type == 2)
                                                <label for="">Phương thức học</label>
                                                <select name="option" class="form-control">
                                                    <option @if($transaction->option == 'online'){{'selected'}}@endif value="online">Online</option>
                                                    <option @if($transaction->option == 'offline' || $transaction->option == ''){{'selected'}}@endif value="offline">Offline</option>
                                                </select>
                                                <label for="">Tặng key</label>
                                                <select class="form-control" name="donate_product">
                                                    @foreach($products as $productItem)
                                                        @if($productItem->type == 0)
                                                            <option @if($transaction->donate_product == $productItem->product_type){{'selected'}}@endif value="{{$productItem->product_type}}">
                                                                {{$productItem->name}}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                    <option @if($transaction->donate_key == 0){{'selected'}}@endif value="NULL">Không tặng</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" name="price" value="{{$transaction->price}}">
                                        </td>
                                        <td>
                                            {{number_format($transaction->price * $transaction->qty)}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button style="width: 100%" type="submit" class="btn btn-primary mr-2">Cập nhật đơn hàng</button>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
@endsection

@section('script')
<style>
    .content table tr td *{
        font-size: 13.5px;
    }
    i.fa.fa-asterisk.color-red.font-size-7{
        font-size: 8px;
        color: red;
    }
</style>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection