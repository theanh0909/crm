<!-- Main navbar -->
{{--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">--}}
<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="{{route('admin.index')}}" class="d-inline-block">
            <img src="/img/DutoanGXD.ico" alt="">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>

        </ul>

        <ul class="navbar-nav">
            <!-- <li class="nav-item dropdown">
                <a href="{{route('admin.customer.hashKeyCustomer')}}" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="fa fa-plus"></i> Khóa cứng
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="{{route('admin.request.create')}}" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="fa fa-plus"></i> Khóa mềm
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="{{route('admin.course.create')}}" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="fa fa-plus"></i> Học viên
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="{{route('admin.certificate')}}" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="fa fa-plus"></i> Chứng chỉ
                </a>
            </li> -->
            <li class="nav-item dropdown">
                <a href="{{route('admin.input')}}" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="fa fa-plus"></i> Thêm đơn hàng
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="{{route('admin.customer.import-certicate-form')}}" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="fa fa-plus"></i> Import dữ liệu
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="{{route('admin.customer.export-certificate-view')}}" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="fa fa-plus"></i> Export dữ liệu
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="{{route('admin.sendy.index')}}" class="navbar-nav-link dropdown-toggle caret-0">
                    <i class="fa fa-plus"></i> Sendy
                </a>
            </li>
        </ul>

        <span class="navbar-text ml-md-5 ml-md-auto">
            <form style="margin: -8px;margin-right: 40px;" method="post" action="{{route('admin.search')}}">
                @csrf
              <div class="input-group" style="width: 450px;">
                <input name="query" type="text" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
                {{-- <select name="product" id="">
                    <option value="4">Tất cả</option>
                    <option value="0">Key mềm</option>
                    <option value="3">Chứng chỉ</option>
                    <option value="2">Khóa học</option>
                    <option value="1">Khóa cứng</option>
                </select> --}}
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit">
                        <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
        </span>

        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                    <i class="icon-people"></i>
                    <span class="d-md-none ml-2">Users</span>
                </a>

                {{--<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-300">--}}
                    {{--<div class="dropdown-content-header">--}}
                        {{--<span class="font-weight-semibold">Users online</span>--}}
                        {{--<a href="#" class="text-default"><i class="icon-search4 font-size-base"></i></a>--}}
                    {{--</div>--}}

                    {{--<div class="dropdown-content-body dropdown-scrollable">--}}
                        {{--<ul class="media-list">--}}
                            {{--<li class="media">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--<a href="#" class="media-title font-weight-semibold">Jordana Ansley</a>--}}
                                    {{--<span class="d-block text-muted font-size-sm">Lead web developer</span>--}}
                                {{--</div>--}}
                                {{--<div class="ml-3 align-self-center"><span class="badge badge-mark border-success"></span></div>--}}
                            {{--</li>--}}

                            {{--<li class="media">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--<a href="#" class="media-title font-weight-semibold">Will Brason</a>--}}
                                    {{--<span class="d-block text-muted font-size-sm">Marketing manager</span>--}}
                                {{--</div>--}}
                                {{--<div class="ml-3 align-self-center"><span class="badge badge-mark border-danger"></span></div>--}}
                            {{--</li>--}}

                            {{--<li class="media">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--<a href="#" class="media-title font-weight-semibold">Hanna Walden</a>--}}
                                    {{--<span class="d-block text-muted font-size-sm">Project manager</span>--}}
                                {{--</div>--}}
                                {{--<div class="ml-3 align-self-center"><span class="badge badge-mark border-success"></span></div>--}}
                            {{--</li>--}}

                            {{--<li class="media">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--<a href="#" class="media-title font-weight-semibold">Dori Laperriere</a>--}}
                                    {{--<span class="d-block text-muted font-size-sm">Business developer</span>--}}
                                {{--</div>--}}
                                {{--<div class="ml-3 align-self-center"><span class="badge badge-mark border-warning-300"></span></div>--}}
                            {{--</li>--}}

                            {{--<li class="media">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--<a href="#" class="media-title font-weight-semibold">Vanessa Aurelius</a>--}}
                                    {{--<span class="d-block text-muted font-size-sm">UX expert</span>--}}
                                {{--</div>--}}
                                {{--<div class="ml-3 align-self-center"><span class="badge badge-mark border-grey-400"></span></div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}

                    {{--<div class="dropdown-content-footer bg-light">--}}
                        {{--<a href="#" class="text-grey mr-auto">All users</a>--}}
                        {{--<a href="#" class="text-grey"><i class="icon-gear"></i></a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </li>

            {{--<li class="nav-item dropdown">--}}
                {{--<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">--}}
                    {{--<i class="icon-bubbles4"></i>--}}
                    {{--<span class="d-md-none ml-2">Messages</span>--}}
                    {{--<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">2</span>--}}
                {{--</a>--}}

                {{--<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">--}}
                    {{--<div class="dropdown-content-header">--}}
                        {{--<span class="font-weight-semibold">Messages</span>--}}
                        {{--<a href="#" class="text-default"><i class="icon-compose"></i></a>--}}
                    {{--</div>--}}

                    {{--<div class="dropdown-content-body dropdown-scrollable">--}}
                        {{--<ul class="media-list">--}}
                            {{--<li class="media">--}}
                                {{--<div class="mr-3 position-relative">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}

                                {{--<div class="media-body">--}}
                                    {{--<div class="media-title">--}}
                                        {{--<a href="#">--}}
                                            {{--<span class="font-weight-semibold">James Alexander</span>--}}
                                            {{--<span class="text-muted float-right font-size-sm">04:58</span>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}

                                    {{--<span class="text-muted">who knows, maybe that would be the best thing for me...</span>--}}
                                {{--</div>--}}
                            {{--</li>--}}

                            {{--<li class="media">--}}
                                {{--<div class="mr-3 position-relative">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}

                                {{--<div class="media-body">--}}
                                    {{--<div class="media-title">--}}
                                        {{--<a href="#">--}}
                                            {{--<span class="font-weight-semibold">Margo Baker</span>--}}
                                            {{--<span class="text-muted float-right font-size-sm">12:16</span>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}

                                    {{--<span class="text-muted">That was something he was unable to do because...</span>--}}
                                {{--</div>--}}
                            {{--</li>--}}

                            {{--<li class="media">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--<div class="media-title">--}}
                                        {{--<a href="#">--}}
                                            {{--<span class="font-weight-semibold">Jeremy Victorino</span>--}}
                                            {{--<span class="text-muted float-right font-size-sm">22:48</span>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}

                                    {{--<span class="text-muted">But that would be extremely strained and suspicious...</span>--}}
                                {{--</div>--}}
                            {{--</li>--}}

                            {{--<li class="media">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--<div class="media-title">--}}
                                        {{--<a href="#">--}}
                                            {{--<span class="font-weight-semibold">Beatrix Diaz</span>--}}
                                            {{--<span class="text-muted float-right font-size-sm">Tue</span>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}

                                    {{--<span class="text-muted">What a strenuous career it is that I've chosen...</span>--}}
                                {{--</div>--}}
                            {{--</li>--}}

                            {{--<li class="media">--}}
                                {{--<div class="mr-3">--}}
                                    {{--<img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--<div class="media-title">--}}
                                        {{--<a href="#">--}}
                                            {{--<span class="font-weight-semibold">Richard Vango</span>--}}
                                            {{--<span class="text-muted float-right font-size-sm">Mon</span>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}

                                    {{--<span class="text-muted">Other travelling salesmen live a life of luxury...</span>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}

                    {{--<div class="dropdown-content-footer justify-content-center p-0">--}}
                        {{--<a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Load more"><i class="icon-menu7 d-block top-0"></i></a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</li>--}}

            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    @if(auth()->user()->avatar != '')

                        <img src="{{Storage::url(auth()->user()->avatar)}}" class="rounded-circle" alt="">
                    @else
                        <img src="/limitless/global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="">
                    @endif
                    <span>{{auth()->user()->name}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <form method="POST" action="{{route('logout')}}" id="logout-form">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </form>
                    <script>
                        function logout() {
                            $('#logout-form').submit();
                        }
                    </script>
                    <a href="{{route('admin.user.edit-profile')}}" class="dropdown-item" ><i class="icon-user-plus"></i> My Profile</a>
                    <a href="admin/logout" class="dropdown-item" onclick="logout();" ><i class="icon-switch2"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
