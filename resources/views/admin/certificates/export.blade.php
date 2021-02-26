@extends('admin.layouts.app_new')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('tags/amsify.suggestags.css')}}">
@endsection


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
            <form action="{{route('admin.customer.export-certificate')}}" method="post">
                @csrf
                <div class="tab-content">
                    <fieldset class="mb-3">
                        <!-- <legend class="text-uppercase font-size-sm font-weight-bold"> </legend> -->
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="">Chọn ngày thi để export</label>
                                <input type="date" name="date_exam" class="form-control">
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="">Chọn kiểu xuất</label><br>
                                <div class="radio-inline">
                                    <label class="radio radio-solid">
                                        <input value="1" type="radio" name="type" class="from-control">
                                        <span></span>Trích ngang (tài khoản)
                                    </label>
                                    <label class="radio radio-solid">
                                        <input value="0" type="radio" name="type" class="from-control">
                                        <span></span>Tạo mã (Sheet 1)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div>
                        <button class="btn btn-success" type="submit">Export</button>
                    </div>
                </div>
            </form>
            <!--end::Search Form-->
        </div>
        @if(!empty($transactions))
            <div class="card-header">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Thông tin cá nhân</th>
                            <th>Mã chứng chỉ</th>
                            <th style="width: 20%; text-align:center">Lĩnh vực</th>
                            <th style="width: 10%; text-align:center">Hạng</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $key => $dataItem)
                            <tr>
                                <td>
                                    {{$key+1}}
                                </td>
                                <td>
                                    <p>
                                        Tên: <b>{{$dataItem->customer_name}}</b>
                                    </p>
                                    <p>
                                        SĐT: <b>{{$dataItem->customer_phone}}</b>
                                    </p>
                                    <p>
                                        Địa chỉ: <b>{{$dataItem->customer_address}}</b>
                                    </p>
                                    <p>
                                        CMT: <b>{{$dataItem->id_card}}</b>
                                    </p>
                                    <p>
                                        Trình độ: <b>{{$dataItem->qualification}}</b>
                                    </p>
                                </td>
                                <td>
                                    {{$dataItem->customer_account}}
                                </td>                             
                                <td colspan="2" style="width: 40%">
                                    @php
                                        $typeExam = explode(';', $dataItem->type_exam);
                                        $class = explode(';', $dataItem->class);
                                    @endphp
                                    <table class="type-exam">
                                        @foreach($typeExam as $key => $item)
                                            <tr>
                                                <td style="width: 90%">
                                                    {{$item}}
                                                </td>
                                                <td align="center">
                                                    {{$class[$key]}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td></td>    
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
