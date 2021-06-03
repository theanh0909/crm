@extends('admin.layouts.app_new')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('tags/amsify.suggestags.css')}}">
@endsection

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Phân loại khách hàng'])
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
                <h3 class="card-label">Phân loại khách hàng</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header" style="padding-top: 10px">
            <p>
                Nhóm 1: Khách hàng mục tiêu (những người mong muốn mua hàng, những người có nhu cầu mà chúng ta nhắm tới)
                </p>
                <p>
                Nhóm 2: Khách hàng tiềm năng (đã cho chúng ta một mẩu thông tin nào đó, có thể là email, có thể là điện thoại)
                </p>
                <p>
                Nhóm 3: Mua hàng (ít nhất 1 lần mua hàng), khách hàng này sự trung thành chưa cao, sẵn sàng từ bỏ để mua hàng từ nơi khác
                </p>
                <p>
                Nhóm 4: Khách hàng (ít nhất mua hàng 2 lần trở lên)
                </p>
                <p>
                Nhóm 5: Thành viên (đã mua đi mua lại nhiều lần, được hưởng ưu đãi, có thẻ thành viên, ưu đãi, VIP, được đón tiếp nồng hậu hơn) hãy tập trung chăm sóc nhóm này, tập trung thật nhiều vào xây dựng nhóm thành viên này.
                </p>
                <p>
                Nhóm 6: Những người ủng hộ (những người mua hàng vô cùng nhiều, mỗi khi có ai đó hỏi về món hàng liên quan thì bạn sẽ là người đầu tiên xuất hiện trong tâm trí của họ), nhóm này luôn muốn bạn phát triển kinh doanh, họ sẵn sàng giới thiệu bạn với bạn bè, họ hàng, khách hàng của họ
                </p>
                <p>
                Nhóm 7: Khách hàng cuồng nhiệt (Raving fan): (bạn có thể như 1 ca sỹ, cầu thủ ủng hộ - sẵn sàng bán hàng cho bạn vì bất kì điều kiện nào, chỉ bởi vì thích), nếu xây dựng nhóm này tốt, kinh doanh sẽ ở tầm cao mới.
                </p>  
        </div>
    </div>
</div>
@endsection
