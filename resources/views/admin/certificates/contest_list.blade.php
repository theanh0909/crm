@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Chứng chỉ', 'item2' => 'Danh sách dự thi'])
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
        <div class="card-body">
            <form method="GET">
                <div class="mt-2 mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <input class="form-control" type="text" placeholder="Tên nhân viên" name="customer_name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class='input-group' id='kt_daterangepicker_6'>
                                        <input type='text' value="{{$date_exam}}" name="date_exam" class="form-control" readonly  placeholder="Chọn thời gian"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                        </div>
                                   </div>
                                </div>
                                <div class="col-md-2 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <select class="form-control" id="kt_select2_2" name="status_exam">
                                            <option @if($statusExam == 2){{'selected'}}@endif value="2">Tất cả trạng thái</option>
                                            <option @if($statusExam == 0){{'selected'}}@endif value="0">Chưa thi</option>
                                            <option @if($statusExam == 1){{'selected'}}@endif value="1">Đã thi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" name="submit" value="thongke" class="btn btn-light-primary px-6 font-weight-bold">Thống kê</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                   
                </div>
            </form>
            <!--end::Search Form-->
        </div>
        <div class="card-header">
            <table class="table">
                    <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Thông tin cá nhân</th>                            
                            <th style="width: 20%; text-align:center">Lĩnh vực</th>
                            <th style="width: 10%; text-align:center">Hạng</th>
                            <th>Lượt thi</th>
                            <th>Ngày thi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contestList as $key => $dataItem)
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
                                <td>
                                    <input type="number" data-id="{{$dataItem->id}}" class="form-control edit-retest" value="{{$dataItem->retest}}">
                                </td>
                                <td>
                                    <input type="date" class="form-control update-date-exam" data-id="{{$dataItem->id}}" value="{{$dataItem->date_exam}}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            <div class="row">
                {{$contestList->appends(['date_exam' => $date_exam, 'status_exam' => $statusExam, 'submit' => 'thongke'])->links()}}
            </div>            
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
@endsection