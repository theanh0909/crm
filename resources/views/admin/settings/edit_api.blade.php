@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'KEY', 'item2' => 'Edit'])
<div class="container">
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title">
                <span class="card-icon">
                    <span class="svg-icon svg-icon-md svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5" />
                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5" />
                                <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero" />
                                <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5" />
                            </g>
                        </svg>
                    </span>
                </span>
                <h3 class="card-label">
                    Thông tin sản phẩm
                </h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <div class="card card-custom gutter-b" style="width: 100%">
                <div class="card-body" style="padding: 2rem 0px">
                    {{ Form::model($key, ['url' => route('admin.settings.updateApi', ['id' => $key->id]), 'method' => 'PUT', 'files' => true]) }}
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>Domain</label>
                                {{Form::text('domain', $key->domain, ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>Key</label>
                                {{Form::text('key', $key->key, ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary px-6 font-weight-bold">
                                    Cập nhật
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

