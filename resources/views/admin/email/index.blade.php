@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Email', 'item2' => 'Mẫu Email cho sản phẩm'])
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
                    Mẫu Email
                </h3>
            </div>
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                <tr>
                    <th>Stt</th>
                    <th width="200">Template cho sản phẩm</th>
                    <th>Chủ đề email bản quyền</th>
                    <th>Chủ đề email dùng thử</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $item)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{ ($item->has_email) ? $item->has_email->subject : '' }}</td>
                        <td>{{ ($item->has_email) ? $item->has_email->subject_trial : '' }}</td>
                        <td>
                            <a class="btn btn-warning" href="{{route('admin.email.edit', ['product_id' => $item->id])}}">
                                <i class="flaticon-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                {!! $products->links() !!}
            </div>        
        </div>
    </div>
</div>
@endsection
