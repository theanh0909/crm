@extends('admin.layouts.app_new')
@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Docs', 'item2' => 'Corporate Culture'])
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
                <h3 class="card-label">Corporate Culture - Văn hóa doanh nghiệp</h3>
            </div>
        </div>
        <div class="card-header" style="padding-top: 10px">
            {{-- Viết nội dung ở đây --}}
            <p>Môi trường tri thức cao, mọi người cư xử với nhau nhẹ nhàng, cao thượng xứng với tầm tri thức.</p>
            <p>Trung thực, các thành viên bình đẳng, tôn trọng lẫn nhau. Mỗi người ý thức rằng: anh/em ruột ở xa nhau có khi lâu lâu mới thăm được nhau. Nhưng các đồng nghiệp trong công ty thì ngày nào cũng cùng nhau hơn 8h đồng hồ, còn quý hơn cả anh/em ruột thịt.</p>
            <p>Hãy nhường nhịn nhau, "chuyền bóng để tạo điều kiện cho nhau ghi bàn", tạo điều kiện cho nhau cùng tỏa sáng. </p>
            <p>Mình mệt hơn 1 chút, nhưng điều đó làm cho các đồng đội đỡ nhiều "xương máu" thì phải cố gắng.</p>
            <p>Lấy chế độ chính sách của Nhà nước, lấy quy định của pháp luật làm chuẩn. Chúng ta phải thực hiện tốt hơn, lớn hơn hoặc bằng chế độ, chính sách của Nhà nước, pháp luật chỉ là min, mình phải tốt nhiều hơn thế.</p>

        </div>
    </div>
</div>
@endsection
