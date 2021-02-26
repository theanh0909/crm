@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Chứng chỉ', 'item2' => 'Import dữ liệu thi chứng chỉ'])
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
                <h3 class="card-label">Danh sách học viên dự thi</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <form action="{{route('admin.certificate.merge')}}" method="post" style="width: 100%">
                @csrf
                <input type="hidden" name="table" value="transaction_wait">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="7">
                                <button type="submit" class="btn btn-primary">Gộp danh sách</button>
                            </th>
                        </tr>
                        <tr>
                            <th>Chọn</th>
                            <th>Stt</th>
                            <th>Tên đợt upload</th>
                            <th>Ngày upload</th>
                            <th>Tình trạng</th>
                            <th>Số lượng</th>
                            <th style="text-align:center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $stt = 1 @endphp
                        @foreach($transactions as $key => $dataItem)
                            <tr>
                                <td>
                                    <div class="radio-inline">
                                        <label class="radio radio-solid">
                                            <input value="{{$key}}" name="nameUpload[]" class="name-upload-item" type="checkbox">
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    {{$stt++}}
                                </td>
                                <td>
                                    @if(count($dataItem) == 1)
                                        <a href="{{route('admin.certificate.edit-certificate-form', ['id' => $dataItem[0]->id])}}">
                                    @else
                                        <a href="{{route('admin.customer.certificate-detail', ['name' => $key])}}">
                                    @endif
                                        {{$key}}
                                    </a>
                                </td>
                                <td>
                                    @if($dataItem[0])
                                        {{date('d/m/Y', strtotime($dataItem[0]->created_at))}}
                                    @endif
                                </td>
                                <td>
                                    Chưa phê duyệt
                                </td>
                                <td>
                                    {{count($dataItem)}}
                                </td>
                                <td style="text-align: center !important">
                                    <a href="{{route('admin.customer.accept-certificate', ['name' => $dataItem[0]->slug])}}" class="approve-request btn btn-outline-success" onclick="return confirm('Có chắc chắn duyệt không?')">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{route('admin.customer.certificate-delete', ['name' => $dataItem[0]->slug])}}" title="Xóa toàn bộ" onclick="return confirm('Có chắc chắn muốn xóa không')">
                                        <button class="btn btn-danger btn-sm" type="button">
                                            <i class="flaticon2-rubbish-bin-delete-button"></i>
                                        </button>
                                    </a>
                                    @if(count($dataItem) == 1)
                                        <a href="{{route('admin.certificate.edit-certificate-form', ['id' => $dataItem[0]->id])}}" class="btn btn-warning btn-sm"><i class="flaticon-edit-1"></i></a>
                                    @else
                                        <a href="{{route('admin.customer.certificate-detail', ['name' => $key])}}" class="btn btn-warning btn-sm"><i class="flaticon-edit-1"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>           
        </div>
    </div>
</div>
@endsection
