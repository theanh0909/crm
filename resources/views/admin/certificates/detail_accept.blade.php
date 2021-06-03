@extends('admin.layouts.app_new')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('tags/amsify.suggestags.css')}}">
@endsection

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Chứng chỉ', 'item2' => 'Import dữ liệu thi chứng chỉ'])
<div class="container">
    <div class="card card-custom overflow-x">
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
                <h3 class="card-label">Import dữ liệu thi chứng chỉ</h3>
            </div>
        </div>
        @if(session('errorCustom') && count(session('errorCustom')) > 0)
            <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-success"></i></div>
                <div class="alert-text">
                    @foreach(session('errorCustom') as $errorItem)
                        <p>{{$errorItem}}</p>
                    @endforeach
                </div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>
        @endif       
        @include('admin.layouts.partitals.notify')
        <div class="card-body">
            <center>
                <form enctype="multipart/form-data" method="post" action="{{route('admin.certificate.update-import-certificate', ['name' => $nameUpload])}}">
                @csrf
                <table>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input type="file" name="file">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </td>
                    </tr>
                </table>
            </form>
            </center>
            
        </div>
        <hr>
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th width="20%">Thông tin</th>
                        <th>Nghị định</th>
                        <th style="width: 20%; text-align:center">Lĩnh vực</th>
                        <th style="width: 5%; text-align:center">Hạng</th>
                        <th>Lượt thi</th>
                        <th style="width: 5%">Ngày thi</th>
                        <th>HĐ</th>
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
                                @php
                                    $typeExam = explode(';', $dataItem->type_exam);
                                    $class = explode(';', $dataItem->class);
                                    $decree = explode(';', $dataItem->decree);
                                @endphp
                                @if($dataItem->decree != '')
                                    <input data-id="{{$dataItem->id}}" type="text" value="{{str_replace(';', ',', $dataItem->decree)}}" class="decree{{$dataItem->id}} update-decree form-control" name="anything"/>
                                @else
                                    <input data-id="{{$dataItem->id}}" type="text" class="decree{{$dataItem->id}} update-decree form-control" name="anything"/>
                                @endif
                                <br>
                                <button class="btn btn-primary" onclick="updateDecree({{$dataItem->id}})">Cập nhật</button>
                            </td>
                            <td colspan="2" style="width: 20%">
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
                                <input style="width: 70px" type="number" data-id="{{$dataItem->id}}" class="form-control edit-retest" value="{{$dataItem->retest}}">
                            </td>
                            <td>
                                <input type="date" class="form-control update-date-exam" data-id="{{$dataItem->id}}" value="{{$dataItem->date_exam}}">
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown">
                                        <i class="flaticon2-gear text-primary"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm">
                                        <ul class="navi">
                                            <li class="navi-item">
                                                <a href="{{route('admin.customer.edit-certificate', ['id' => $dataItem->id])}}" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon-edit-1"></i></span>
                                                    <span class="navi-text">Sửa</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a onclick="return confirm('Delete this item?')" href="{{route('admin.certificate.delete-certificate', ['id' => $dataItem->id])}}" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon2-rubbish-bin-delete-button"></i></span>
                                                    <span class="navi-text">Xóa</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                {{$transactions->links()}}
            </div>
        </div>
    </div>
    <br>
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
                <h3 class="card-label">Danh sách trùng thông tin (tên, số điện thoại, email)</h3>
            </div>
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>Tên</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Nhân viên</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactionDuplicate as $dataItem)
                        @if (count($dataItem) > 1)
                            @foreach ($dataItem as $key => $item)
                                <tr>
                                    <td>
                                        {{$key+1}}
                                    </td>
                                    <td>
                                        {{$item->customer_name}}
                                    </td>
                                    <td>
                                        {{$item->customer_phone}}
                                    </td>
                                    <td>
                                        {{$item->customer_email}}
                                    </td>
                                    <td>
                                        {{$item->user->fullname}}
                                    </td>
                                    <td>
                                        <a href="{{route('admin.customer.edit-certificate', ['id' => $item->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a href="{{route('admin.certificate.delete-certificate', ['id' => $item->id])}}">
                                            <button class="btn btn-outline-danger" type="submit" onclick="return confirm('Delete this item?')">
                                                <i class="fa fa-remove mr-1"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('tags/jquery.amsify.suggestags.js')}}"></script>

<script src="{{asset('js/sweetalert2@10.js')}}"></script>
<script>
    $('input[name="anything"]').amsifySuggestags({
        type : 'amsify',
        suggestions: ['Khảo sát xây dựng',
                        'Thiết kế quy hoạch xây dựng',
                        'Thiết kế xây dựng công trình',
                        'Quản lý dự án đầu tư xây dựng',
                        'Định giá xây dựng',
                        'Giám sát thi công xây dựng công trình',
                        'Giám sát lắp đặt thiết bị công trình']
    });
    function updateDecree(id)
    {
        decree  = $('.decree' + id).val();
        var dataPost = {
            type: 'accept',
            id:   id,
            decree: decree,
            _token: "{{csrf_token()}}"
        };
        $.ajax({
            url: "{{route('admin.certificate.update-decree')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật thành công',
                    timer: 500
                })
            }
        });
    }
    $('.update-date-exam').change(debounce(function(e){
        var me = $(this);
        var dataPost = {
            id:   me.data('id'),
            date: me.val(),
            _token: "{{csrf_token()}}"
        };
        $.ajax({
            url: "{{route('admin.certificate.update-date-exam-item')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                if (e == "true") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cập nhật thành công',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Đơn này đã được thanh toán cho bạn rồi',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        })
        },1000));

    $('.edit-retest').change(debounce(function(e){
        var me = $(this);
        var dataPost = {
            id:   me.data('id'),
            num: me.val(),
            _token: "{{csrf_token()}}"
        };
        $.ajax({
            url: "{{route('admin.certificate.update-retest-item')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                alert('Update thành công');
            }
        })
        },1000));
</script>
@endsection