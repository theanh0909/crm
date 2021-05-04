@extends('admin.layouts.app_new')
@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Docs', 'item2' => 'Vision'])
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
                <h3 class="card-label">Vision - Tầm nhìn</h3>
            </div>
        </div>
        <div class="card-header" style="padding-top: 10px">
            {{-- Viết nội dung ở đây --}}
            <p>Không phải mình thì là ai?</p>
            <p>GXD gánh trên vai sứ mệnh Chuyển đổi số ngành xây dựng Việt Nam. Cung cấp các giải pháp các giải pháp chuyển đổi số cho các doanh nghiệp xây dựng, chủ đầu tư, ban quản lý dự án, tư vấn...</p>
            <p>GXD là công ty hàng đầu Việt Nam cung cấp hệ sinh thái các phần mềm Quản lý xây dựng, Quản lý dự án.</p>
            <p>GXD sẽ là công ty có môi trường làm việc êm đềm, nhẹ nhàng, các nhân viên tự giác, yêu công việc. Phương châm: được làm công việc yêu thích và có thu nhập tốt bạn thấy như là không phải làm việc.</p>
            <p>GXD trở thành công ty giàu có nhất ngành xây dựng Việt Nam.</p>  
        </div>
    </div>
</div>
@endsection
