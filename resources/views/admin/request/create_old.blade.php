@extends('admin.layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="#" class="breadcrumb-item">Request</a>
                    <span class="breadcrumb-item active">Thông tin yêu cầu gửi key</span>
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
                        {{--<h4 class="card-title">Thông tin gửi key</h4><hr/>--}}
                        <input type="hidden" name="customer_type" value="0">  <!-- /Loại Khóa mềm -->
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Tên khách hàng</label>
                            <div class="col-lg-10">
                                {{Form::text('customer_name', '', ['class' => 'form-control', 'placeholder' => 'Nhập tên khách hàng'])}}
                                @if($errors->has('customer_name'))
                                    <span class="text-danger">{{$errors->first('customer_name')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Email khách hàng <i class="fa fa-asterisk color-red font-size-7"></i></label>
                            <div class="col-lg-10">
                                {{Form::text('customer_email', '', ['required' => 'required', 'type' => 'email','class' => 'form-control', 'placeholder' => 'Nhập Email khách hàng'])}}
                                @if($errors->has('customer_email'))
                                    <span class="text-danger">{{$errors->first('customer_email')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Số điện thoại khách hàng</label>
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
                                @php($i = 0)
                                @foreach($products as $key => $val)
                                    <?php $checked = ($i == 0) ? true : false; ?>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">{{Form::radio('product_type', $key, $checked, ['class' => 'form-check-input'])}} {{$val}}</label>
                                    </div>
                                    @php($i++)
                                @endforeach

                                @if($errors->has('product_type'))
                                    <span class="text-danger">{{$errors->first('product_type')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="row">
                                    <label class="col-form-label col-lg-4">Loại Key</label>
                                    <div class="col-lg-8">

                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">{{Form::radio('type', '1', true, ['class' => 'form-check-input'])}} Key thương mại</label>
                                        </div>


                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">{{Form::radio('type', '0', false, ['class' => 'form-check-input'])}} Key thử nghiệm</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">{{Form::radio('type', '2', false, ['class' => 'form-check-input'])}} Key lớp học</label>
                                        </div>
                                        @if($errors->has('status'))
                                            <span class="text-danger">{{$errors->first('type')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <div class="row">
                                <div class="col-lg-7">
                                    {{Form::checkbox('free', 1, false)}} <label class="col-form-label">Key nội bộ</label>
                                </div>
                                </div>
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
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Gửi yêu cầu</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
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

    </div>
    <!-- /content area -->

@endsection
