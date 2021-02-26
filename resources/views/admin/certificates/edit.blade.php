@extends('admin.layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="#" class="breadcrumb-item">Customer</a>
                    <span class="breadcrumb-item active">Edit</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">   
        @include('admin.layouts.partitals.notify')
        <style>
            .content table tr td * {
                font-size: 10px;
            }
        </style>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h4 class="card-title">Sửa đơn hàng</h4>
            </div>
            <div class="card-body">
            <form action="{{route('admin.certificate.edit-certificate', ['id' => $transaction->id])}}" method="post">
                @csrf
                <div class="tab-content">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold"> </legend>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label class="col-form-label">Họ tên <i class="fa fa-asterisk color-red font-size-7"></i></label>
                                {{Form::text('customer_name', $transaction->customer_name, ['class' => 'form-control'])}}
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Số điện thoại <i class="fa fa-asterisk color-red font-size-7"></i></label>
                                {{Form::text('customer_phone', $transaction->customer_phone, ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Email <i class="fa fa-asterisk color-red font-size-7"></i></label>
                                {{Form::text('customer_email', $transaction->customer_email, ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Địa chỉ</label>
                                {{Form::text('customer_address', $transaction->customer_address, ['class' => 'form-control'])}}
                            </div>
                            <div class="col-lg-4">
                                <label class="col-form-label">Lĩnh vực theo NĐ <i class="fa fa-asterisk color-red font-size-7"></i></label>
                                <textarea class="form-control" name="decree" id="" cols="30" rows="2">{{$transaction->decree}}</textarea>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Lĩnh vực <i class="fa fa-asterisk color-red font-size-7"></i></label>
                                <textarea class="form-control" name="type_exam" id="" cols="30" rows="2">{{$transaction->type_exam}}</textarea>
                            </div>
                            <div class="col-lg-2">
                                <label class="col-form-label">Hạng <i class="fa fa-asterisk color-red font-size-7"></i></label>
                                <textarea class="form-control" name="class" id="" cols="30" rows="2">{{$transaction->class}}</textarea>
                                
                            </div>
                            <div class="col-lg-12">
                                <p style="color: red">* Chú ý: (Mỗi nghị định, lĩnh vực, hạng cách nhau bằng dấu ; và không được đặt dấu ; ở cuối)</p>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Chọn sản phẩm</label>
                                <select name="product_type" id="" class="form-control">
                                    <option value="">Chọn Sản phẩm</option>
                                    @foreach($products as $productItem)
                                        <option price="{{$productItem->price}}" @if($productItem->product_type == $transaction->product_type) selected @endif value="{{$productItem->product_type}}">
                                            {{$productItem->product_type}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Giá</label>
                                <input type="text" name="price" value="{{$transaction->price}}" class="form-control" >
                            </div>
                            <div class="col-lg-12">
                                <label class="col-form-label">Ghi chú</label>
                                {{Form::text('note', $transaction->note, ['class' => 'form-control', 'rows' => 3])}}
                            </div>
                        </div>
                        
                    </fieldset>
                    <div>
                        <button class="btn btn-success" type="submit">Cập nhật</button>
                    </div>
                </div>
            </form>
            </div>

    </div>
    <style>
        .content table tr td *{
            font-size: 13.5px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
        $('select[name="product_type"]').change(function(){
            var price = $('option:selected', this).attr('price');
            $('input[name="price"]').val(price);
            // price = $(this).attr('price');
            // alert(price);
        })
    </script>
@endsection