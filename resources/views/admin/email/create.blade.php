@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Email', 'item2' => 'Edit'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Thêm mẫu gửi mail
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        <form method="post" action="{{route('admin.email.create')}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <p style="color: red">Ký hiệu viết mail: tên sản phẩm ([product], tên khách hàng [name])</p>
                        <label>Tên mẫu email</label>
                        {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Mãu email gửi key hết hạn'])}}
                        @if($errors->has('subject'))
                            <span class="text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Sản phẩm</label>
                        <select name="product_type" class="form-control" id="kt_select2_1">
                            <option value="NULL">Chọn sản phẩm</option>
                            @foreach ($products as $product)
                                <option value="{{$product->product_type}}">
                                    {{$product->name}}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('product_type'))
                            <span class="text-danger">{{$errors->first('product_type')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Tiêu đề:</label>
                        {{Form::text('subject', '', ['class' => 'form-control', 'placeholder' => 'Xin chào [name]'])}}
                        @if($errors->has('subject'))
                            <span class="text-danger">{{$errors->first('title')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Nội dung:</label>
                        {{Form::textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Nội dung email', 'id' => 'editor-full'])}}
                        @if($errors->has('content'))
                            <span class="text-danger">{{$errors->first('content')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Lưu lại</button>
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
<script src="{{asset('limitless/global_assets/js/plugins/editors/ckeditor/ckeditor.js')}}"></script>
<script>
    CKEDITOR.replace('editor-full', {
        height: 400,
        extraPlugins: 'forms'
    });
</script>
<script>
    CKEDITOR.replace('editor-full-trial', {
        height: 400,
        extraPlugins: 'forms'
    });
</script>
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
@endsection