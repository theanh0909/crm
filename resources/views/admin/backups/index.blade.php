@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Sao lưu', 'item2' => 'Danh sách'])
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
                    Sao lưu dữ liệu
                </h3>
            </div>
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Kích thước</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($backups as $key => $file)
                        <tr>
                            <td>
                                {{$key+1}}
                            </td>
                            <td>
                                <a href="{{route('admin.backup.download', ['filename' => $file->getfilename()])}}">
                                    {{$file->getfilename()}}
                                </a>
                            </td>
                            <td>
                                {{number_format((int)$file->getsize()/1024)}} Mb
                                {{-- {{dd($file)}} --}}
                            </td>
                            <td>
                                {{date('d/m/Y', $file->getmtime())}}
                            </td>
                            <td>
                                <a href="{{route('admin.backup.download', ['filename' => $file->getfilename()])}}">
                                    <button class="btn-sm btn btn-success" type="button">
                                        <i class="fa fa-download"></i>
                                    </button>
                                </a>
                                <a href="{{route('admin.backup.destroy', ['filename' => $file->getfilename()])}}">
                                    <button class="btn btn-danger btn-sm" type="button" onclick="return confirm('Delete this item?')">
                                        <i class="flaticon2-rubbish-bin-delete-button"></i>
                                    </button>
                                </a>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>            
        </div>
    </div>
</div>
@endsection
