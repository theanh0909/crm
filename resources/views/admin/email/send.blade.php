@extends('admin.layouts.app_new')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('tags/amsify.suggestags.css')}}">
@endsection

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Email', 'item2' => 'Edit'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Gửi mail thông báo
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        <form method="post" action="{{route('admin.email.send')}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Chọn khách hàng</label>
                        <input type="text" name="email" value="{{$email}}" class="form-control">
                        @if($errors->has('subject'))
                            <span class="text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Chọn sản phẩm</label>
                        <select name="product_type" class="form-control" id="kt_select2_2">
                            <option value="NULL">Chọn sản phẩm</option>
                            @foreach ($products as $product)
                                <option value="{{$product->name}}">
                                    {{$product->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Chọn mẫu email gửi</label>
                        <select name="mail_id" class="form-control" id="kt_select2_1">
                            @foreach ($emailModel as $mail)
                                <option value="{{$mail->id}}">
                                    {{$mail->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Gửi</button>
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
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="{{asset('tags/jquery.amsify.suggestags.js')}}"></script>
<script>
    $('input[name="email"]').amsifySuggestags({
        type : 'amsify',
        suggestionsAction : {
            url : "{{route('admin.email.customer')}}"
        }
    });
</script>
@endsection