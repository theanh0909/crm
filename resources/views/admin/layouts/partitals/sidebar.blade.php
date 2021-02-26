<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

            {{--<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item">
                    <a href="{{route('admin.index')}}" class="nav-link ">
                        <i class="icon-home4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>--}}
                <li class="nav-item"><a href="{{route('admin.request.create')}}" class="nav-link"><i class="icon-key"></i>Yêu cầu gửi key</a></li>
                @if(can('license-sendkey'))
                    <li class="nav-item">
                        <!-- <a href="{{route('admin.license.send-key')}}" class="nav-link"><i class="icon-lock"></i> Gửi key</a> -->
                        <a href="{{route('admin.license.not-actived', ['product_type' => 'DutoanGXD2020'])}}" class="nav-link"><i class="fa fa-envelope"></i>Nhập email gửi key</a>
                    </li>
                @endif
                @if(can('license-approved'))
                {{--<li class="nav-item">
                    <a href="{{route('admin.input')}}" class="nav-link">
                        <i class="fa fa-plus"></i> Thêm đơn hàng
                    </a>
                </li>--}}
                <li class="nav-item">
                    <a href="{{route('admin.request.index')}}" class="nav-link"><i class="fa fa-check"></i>Duyệt đơn hàng</a>
                </li>
                @endif
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-table2"></i> <span>Thi chứng chỉ</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="User pages">
                        <li class="nav-item"><a href="{{route('admin.customer.certificate-list-approve')}}" class="nav-link"><i class="fa fa-money"></i>Danh sách đợi duyệt</a></li>
                        <li class="nav-item"><a href="{{route('admin.certificate.list-certificate')}}" class="nav-link"><i class="fa fa-money"></i>Danh sách đã duyệt</a></li>
                        <li class="nav-item"><a href="{{route('admin.certificate.contest-list')}}" class="nav-link"><i class="fa fa-money"></i>Danh sách dự thi</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="{{route('admin.request.myRequest')}}" class="nav-link"><i class="fa fa-users"></i>Theo dõi yêu cầu</a></li>

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="fa fa-tasks"></i> <span>Chăm sóc khách hàng</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="User pages">
                        <li class="nav-item"><a href="{{route('admin.customer.not-actived')}}" class="nav-link">Khách chưa kích hoạt</a></li>
                        <li class="nav-item"><a href="{{route('admin.chart.expiredBeforeCustomer')}}" class="nav-link">Khách sắp hết hạn</a></li>
                        <li class="nav-item"><a href="{{route('admin.chart.expiredCustomer')}}" class="nav-link">Khách đã hết hạn</a></li>
                        <li class="nav-item"><a href="{{route('admin.customer.classify')}}" class="nav-link">Phân loại khách hàng</a></li>
                        <li class="nav-item"><a href="{{route('admin.customer.today')}}" class="nav-link">Sử dụng trong ngày</a></li>
                        @if(can('statistic-region'))
                            <li class="nav-item"><a href="{{route('admin.chart.region')}}" class="nav-link">Biểu đồ khu vực</a></li>
                        @endif
                        @can(can('statistic-user'))
                            <li class="nav-item"><a href="{{route('admin.chart.user')}}" class="nav-link">Thống kê tổng NV</a></li>
                        @endif
                        <li class="nav-item"><a href="{{route('admin.chart.courseLicense')}}" class="nav-link">Key tặng kèm</a></li>

                    </ul>
                </li>

                {{--<li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="fa fa-thumbs-up"></i> <span>Yêu cầu</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="User pages">
                        
                        <li class="nav-item"><a href="{{route('admin.request.create')}}" class="nav-link">Gửi key mềm</a></li>
                        <li class="nav-item"><a href="{{route('admin.course.create')}}" class="nav-link">Đăng ký học</a></li>
                        <li class="nav-item"><a href="{{route('admin.customer.hashKeyCustomer')}}" class="nav-link">Xuất khóa cứng</a></li>
                        <li class="nav-item"><a href="{{route('admin.certificate')}}" class="nav-link">Thi chứng chỉ</a></li>
                        <li clas="nav-tiem"></li>
                    </ul>
                </li>--}}

                @if(can(['license-create', 'license-view'], true))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="fa fa-info-circle"></i> <span>Thông tin Key</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="User pages">
                        @if(can('license-view'))
                        <li class="nav-item"><a href="{{route('admin.license.not-actived', ['product_type' => 'DutoanGXD2020'])}}" class="nav-link">Key chờ gửi đi</a></li>
                        <li class="nav-item"><a href="{{route('admin.license.emailSendedToday')}}" class="nav-link">Key gửi đi trong ngày</a></li>
                        <li class="nav-item"><a href="{{route('admin.license.emailSended')}}" class="nav-link">Key đã gửi qua Email</a></li>
                        <li class="nav-item"><a href="{{route('admin.customer.index')}}" class="nav-link">Key đã kích hoạt</a></li>
                        <li class="nav-item"><a href="{{route('admin.license.exported')}}" class="nav-link">Key đã xuất Excel</a></li>
                        <li class="nav-item"><a href="{{route('admin.license.exportApi')}}" class="nav-link">Key đã xuất ra API</a></li>
                        @endif
                        @if(can('license-create'))
                            <li class="nav-item"><a href="{{route('admin.license.create')}}" class="nav-link">Tạo mới</a></li>
                            <li class="nav-item"><a href="{{route('admin.license.key-store')}}" class="nav-link">Kho key</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-table2"></i> <span>Danh sách khách hàng</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="User pages">
                        <li class="nav-item"><a href="{{route('admin.customer.listHashKeyCustomer')}}" class="nav-link">Sử dụng khóa cứng</a></li>
                        <li class="nav-item"><a href="{{route('admin.customer.index')}}" class="nav-link">Sử dụng khóa mềm</a></li>
                        <li class="nav-item"><a href="{{route('admin.course.index')}}" class="nav-link">Tham gia khóa học</a></li>
                        <li class="nav-item"><a href="{{route('admin.certification')}}" class="nav-link">Dự thi chứng chỉ</a></li>
                        <li class="nav-item"><a href="{{route('admin.customer.trial')}}" class="nav-link">Khách dùng thử</a></li>
                        @if(can('customer-feedback'))
                        <li class="nav-item"><a href="{{route('admin.feedback.index')}}" class="nav-link">Khách góp ý</a></li>
                        @endif
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="fa fa-file"></i> <span>Số liệu kinh doanh</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="User pages">
                        <li class="nav-item"><a href="{{route('admin.customer.no-paid')}}" class="nav-link">Chưa thanh toán</a></li>
                        <li class="nav-item"><a href="{{route('admin.statistic.usersDetail')}}" class="nav-link">Chi tiết nhân viên</a></li>
                        @if(can('statistic'))
                            <li class="nav-item"><a href="{{route('admin.statistic.consolidated')}}" class="nav-link">Tổng hợp nhân viên</a></li>
                            <li class="nav-item"><a href="{{route('admin.statistic.vacc')}}" class="nav-link">Phải trả cho VACC</a></li>
                            <li class="nav-item"><a href="{{route('admin.statistic.vace')}}" class="nav-link">Phải trả cho VACE</a></li>
                            <li class="nav-item"><a href="{{route('admin.statistic.product')}}" class="nav-link">Theo sản phẩm</a></li>
                            <li class="nav-item"><a href="{{route('admin.statistic.time')}}" class="nav-link">Theo thời gian</a></li>
                            <li class="nav-item"><a href="{{route('admin.statistic.local')}}" class="nav-link">Theo địa phương</a></li>
                            <li class="nav-item"><a href="{{route('admin.chart.kpi')}}" class="nav-link">Số liệu KPI</a></li>
                        @endif
                    </ul>
                </li>

                <!-- Page kits -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Quản trị</div> <i class="icon-menu" title="Page kits"></i></li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-people"></i> <span>Người dùng và quyền</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="User pages">
                        @if(can('system-user'))
                        <li class="nav-item"><a href="{{route('admin.user.index')}}" class="nav-link">Danh sách người dùng</a></li>
                        <li class="nav-item"><a href="{{route('admin.roles.index')}}" class="nav-link">Nhóm phân quyền</a></li>
                        @endif
                        <li class="nav-item"><a href="{{route('admin.user.reset-password')}}" class="nav-link">Đổi password</a></li>
                        @if(can('create-permission'))
                            <li class="nav-item">
                                <a href="{{route('admin.permission.index')}}" class="nav-link">
                                    Quyền truy cập
                                </a>
                            </li>
                        @endif  
                    </ul>
                </li>

                @if(can(['system-emailtemplate', 'system-email'], true))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-inbox"></i> <span>Email</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="User pages">
                        @if(can('system-emailtemplate'))
                            <li class="nav-item "><a href="{{route('admin.email.index')}}" class="nav-link ">Sản phẩm</a></li>
                            <li class="nav-item"><a href="{{route('admin.mailcontent.list')}}" class="nav-link">Cài đặt email hệ thống</a></li>
                        @endif
                        @if(can('system-email'))
                            <li class="nav-item"><a href="{{route('admin.settings.email')}}" class="nav-link">Cấu hình Email</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                @if(can(['system-system', 'system-product'], true))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-wrench3"></i> <span>Hệ thống</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="User pages">
                        @if(can('system-product'))
                            <li class="nav-item"><a href="{{route('admin.product.index')}}" class="nav-link ">Sản phẩm</a></li>
                        @endif

                        @if(can('system-system'))
                        <li class="nav-item"><a href="{{route('admin.settings.system')}}" class="nav-link">Cấu hình hệ thống</a></li>
                        <li class="nav-item"><a href="{{route('admin.settings.api')}}" class="nav-link">Cấu hình API</a></li>
                        <li class="nav-item"><a href="{{route('admin.backup.index')}}" class="nav-link">Sao lưu dữ liệu</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                <!-- /page kits -->

                <!-- /page kits -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<script>
    $(document).ready(function() {
        var url = window.location;
        var element = $('ul.nav.nav-group-sub a').filter(function() {
            return this.href === url.href }).addClass('active')
            .closest('ul.nav-group-sub').show()
            .closest('li.nav-item-submenu').addClass('nav-item-open');

    });
</script>
<!-- /main sidebar -->