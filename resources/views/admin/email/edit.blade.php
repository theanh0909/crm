@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Email', 'item2' => 'Edit'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Sửa email cho sản phẩm - <i>{{$product->name}}</i>
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::model($email, ['url' => route('admin.email.update', ['product_id' => $product->id]), 'method' => 'POST', 'files' => true]) }}
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Tiêu đề:</label>
                        {{Form::text('subject', (isset($email->subject)) ? $email->subject : '', ['class' => 'form-control', 'placeholder' => 'Subject'])}}
                        @if($errors->has('subject'))
                            <span class="text-danger">{{$errors->first('subject')}}</span>
                        @endif
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Content:</label>
                        {{Form::textarea('content', (isset($email->content)) ? $email->content : '', ['class' => 'form-control', 'placeholder' => 'Content', 'id' => 'editor-full'])}}
                        @if($errors->has('content'))
                            <span class="text-danger">{{$errors->first('content')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <h4>Content Email cho bản dùng thử</h4>
                        <hr>
                    </div>
                    <div class="col-lg-12">
                        <label>Subject bản dùng thử</label>
                        {{Form::text('subject_trial', (isset($email->subject_trial)) ? $email->subject_trial : '', ['class' => 'form-control', 'placeholder' => 'Subject trial'])}}
                        @if($errors->has('subject_trial'))
                            <span class="text-danger">{{$errors->first('subject_trial')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Content bản dùng thử</label>
                        {{Form::textarea('content_trial', (isset($email->content_trial)) ? $email->content_trial : '', ['class' => 'form-control', 'placeholder' => 'Content trial', 'id' => 'editor-full-trial'])}}
                        @if($errors->has('content_trial'))
                            <span class="text-danger">{{$errors->first('content_trial')}}</span>
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
        {{ Form::close() }}
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
@endsection