@extends('admin.layouts.app')

@section('content')
    <style>
        .block-course, .block-hardkey {
            display: none;
        }
    </style>
    <!-- Page header -->
    <div class="page-header page-header-light">


        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="#" class="breadcrumb-item">Request</a>
                    <span class="breadcrumb-item active">Create new request</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">

        @include('admin.layouts.partitals.notify')

        <div class="card">
            <div class="card-body">
                {{ Form::open(['route' => 'admin.request.store', 'method' => 'POST', 'files' => true]) }}

                <div class="tab-content">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Gửi key kích hoạt GXD</legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Loại Khóa</label>
                            <div class="col-lg-10">
                                @foreach(\App\Models\Product::$typeLabel as $k => $v)
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">{{Form::radio('customer_type', $k, $k == 0, ['class' => 'form-check-input customer_type'])}} {{$v}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tên khách hàng</label>
                            <div class="col-lg-10">
                                {{Form::text('customer_name', '', ['required' => 'required','class' => 'form-control', 'placeholder' => 'Nhập tên khách hàng'])}}
                                @if($errors->has('customer_name'))
                                    <span class="text-danger">{{$errors->first('customer_name')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Email khách hàng</label>
                            <div class="col-lg-10">
                                {{Form::text('customer_email', '', ['required' => 'required', 'type' => 'email','class' => 'form-control', 'placeholder' => 'Nhập Email khách hàng'])}}
                                @if($errors->has('customer_email'))
                                    <span class="text-danger">{{$errors->first('customer_email')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Số điện thoại khách hàng </label>
                            <div class="col-lg-10">
                                {{Form::text('customer_phone', '', ['class' => 'form-control', 'placeholder' => 'Nhập SDT khách hàng'])}}
                                @if($errors->has('customer_phone'))
                                    <span class="text-danger">{{$errors->first('customer_phone')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Phần mềm</label>
                            <div class="col-lg-10">
                                @foreach($products as $key => $val)
                                    <?php $checked = ($key == 'DutoanGXD') ? true : false; ?>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">{{Form::radio('product_type', $key, $checked, ['class' => 'form-check-input'])}} {{$val}}</label>
                                    </div>
                                @endforeach

                                @if($errors->has('product_type'))
                                    <span class="text-danger">{{$errors->first('product_type')}}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Loại Key</label>
                            <div class="col-lg-10">

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">{{Form::radio('type', '1', true, ['class' => 'form-check-input'])}} Key thương mại</label>
                                </div>


                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">{{Form::radio('type', '0', false, ['class' => 'form-check-input'])}} Key thử nghiệm</label>
                                </div>
                                @if($errors->has('status'))
                                    <span class="text-danger">{{$errors->first('type')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Số ngày</label>
                            <div class="col-lg-10">
                                {{Form::select('number_day',$typeExpireDate, 365, ['class' => 'form-control'])}}
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Số lượng key cần gửi</label>
                            <div class="col-lg-10">
                                {{Form::number('qty', 1, ['class' => 'form-control'])}}
                                @if($errors->has('qty'))
                                    <span class="text-danger">{{$errors->first('qty')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="block-hardkey block-course">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Đơn giá</label>
                                <div class="col-lg-10">
                                    {{Form::number('price', 0, ['class' => 'form-control price'])}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Giảm giá</label>
                                <div class="col-lg-10">
                                    {{Form::number('discount', 0, ['class' => 'form-control price'])}}
                                </div>
                            </div>
                        </div>
                        <div class="block-course">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Option</label>
                                <div class="col-lg-10">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">{{Form::radio('option', 'online', true, ['class' => 'form-check-input'])}} Online</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">{{Form::radio('option', 'offline', false, ['class' => 'form-check-input'])}} Offline</label>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Ghi chú</label>
                            <div class="col-lg-10">
                                {{Form::textarea('note', '', ['class' => 'form-control', 'rows' => 3])}}
                                @if($errors->has('note'))
                                    <span class="text-danger">{{$errors->first('note')}}</span>
                                @endif
                            </div>
                        </div>


                    </fieldset>

                    <div>
                        <button class="btn btn-success" type="submit">Gửi yêu cầu</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>


    </div>
    <!-- /content area -->
    <script>
        $('input[type=radio][name=customer_type]').change(function() {
            if(this.value == 0) {
                $('.block-course, .block-hardkey').hide();
            }
            if(this.value == 1) {
                $('.block-course, .block-hardkey').hide();
                $('.block-hardkey').show();
            }
            if(this.value == 2) {
                $('.block-course, .block-hardkey').hide();
                $('.block-course').show();
            }
        });
    </script>
@endsection
