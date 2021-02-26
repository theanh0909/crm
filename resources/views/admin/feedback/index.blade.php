@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Feedback', 'item2' => 'List'])
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
                    Các ý kiến phản hồi của khách
                </h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr align="center">
                        <th width="300">Khách hàng</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($models as $item)
                        <tr>
                            <td>
                                <p>{{$item->customer->license_original}}</p>
                                <p><span>{{$item->customer->customer_name}}</span></p>
                                <p><span>{{$item->customer->customer_email}}</span>/ <span>{{$item->customer->customer_phone}}</span></p>
                            </td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->content}}</td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
            <div class="row">
                {{$models->links()}}
            </div>            
        </div>
    </div>
</div>
@endsection
