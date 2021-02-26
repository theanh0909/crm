@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Chứng chỉ', 'item2' => 'Export dữ liệu thi chứng chỉ'])
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
                <h3 class="card-label">Export dữ liệu thi chứng chỉ</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <div class="card-body">
                @if(count($errors->all()) > 0)
                    <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                        <div class="alert-icon"><i class="flaticon-success"></i></div>
                        <div class="alert-text">
                            @foreach($errors->all() as $errorItem)
                                {{$errorItem}}<br>
                            @endforeach
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                @endif
                @if(session('errorCustom') && count(session('errorCustom')) > 0)
                    <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                        <div class="alert-icon"><i class="flaticon-success"></i></div>
                        <div class="alert-text">
                            @foreach(session('errorCustom') as $errorItem)
                                {{$errorItem}}<br>
                            @endforeach
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                @endif
                <form method="POST" action="{{route('admin.sendy.store')}}">
                    @csrf
                    <div class="tab-content">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="">Chọn phầm mềm</label>
                                    <select class="form-control" name="product" id="kt_select2_1">
                                        @foreach($products as $item)
                                            <option value="{{$item->id}}">
                                                {{$item->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>                     
                            </div>
                        </fieldset>
                        <div>
                            <button class="btn btn-success" type="submit">Gửi Sendy</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
@endsection