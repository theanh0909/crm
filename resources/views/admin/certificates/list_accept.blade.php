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
                <h3 class="card-label">Import dữ liệu chứng chỉ</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <form action="{{route('admin.certificate.merge')}}" method="post" style="width: 100%">
                @csrf
                <input type="hidden" name="table" value="transactions">
                <table class="table">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <button class="btn btn-primary" type="submit">Gộp danh sách</button>
                            </td>
                        </tr>
                        <tr>
                            <th>Chọn</th>
                            <th>Stt</th>
                            <th>Tên đợt upload</th>
                            <th>Số lượng</th>
                            <th>Ngày upload</th>
                            <th>Ngày thi</th>
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
                                    <a href="{{route('admin.certificate.detail-certificate-upload', ['name' => $key])}}">
                                        {{$key}}
                                    </a>
                                </td>
                               
                                <td>
                                    @if($dataItem[0])
                                        {{date('d/m/Y', strtotime($dataItem[0]->created_at))}}
                                    @endif
                                </td>
                                <td>
                                    {{count($dataItem)}}
                                </td>
                                <td>
                                    <input value="@if($dataItem[0]->date_exam != ''){{$dataItem[0]->date_exam}}@endif" class="form-control update-date-exam" id="{{$key}}" type="date">
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

@section('script')
<script src="{{asset('js/sweetalert2@10.js')}}"></script>
<script>
    $('.update-date-exam').change(debounce(function(e){
        var name_upload = $(this).attr('id');
        var date = $(this).val();
        var dataPost = {
            name_upload:   name_upload,
            date: date,
            _token: "{{csrf_token()}}"
        };
        $.ajax({
            url: "{{route('admin.certificate.update-date-exam')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                if (e == "true") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cập nhật thành công',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Bạn không có quyền',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
            ,
            error: function(xhr, status, error){
                Swal.fire({
                    icon: 'error',
                    title: 'Bạn không có quyền',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })
        },1000));
</script>
@endsection