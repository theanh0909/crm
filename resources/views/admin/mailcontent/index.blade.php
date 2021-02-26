@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Email', 'item2' => 'Edit'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">
                Sửa template email cho - <i>{{$arrayTypes[$type]}}</i>
            </h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        {{ Form::model($content, ['url' => route('admin.mailcontent.update', ['type' => $type]), 'method' => 'POST', 'files' => true]) }}
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Tiêu đề:</label>
                        {{Form::text('subject', (isset($content->value->subject)) ? $content->value->subject : '', ['class' => 'form-control', 'placeholder' => 'Subject'])}}
                        @if($errors->has('subject'))
                            <span class="text-danger">{{$errors->first('subject')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Content:</label>
                        {{Form::textarea('content', (isset($content->value->content)) ? $content->value->content : '', ['class' => 'form-control', 'placeholder' => 'Content', 'id' => 'editor-full'])}}
                        @if($errors->has('content'))
                            <span class="text-danger">{{$errors->first('content')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Cập nhật</button>
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
@endsection