@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'User', 'item2' => 'Create'])
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
                <h3 class="card-label">Tạo user mới</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <div class="card card-custom gutter-b" style="width: 100%">
                <div class="card-header card-header-tabs-line" style="padding: 0px">
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_4">
                                    <span class="nav-text">Thông tin cơ bản</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_4">
                                    <span class="nav-text">Quyền truy cập đặc biệt</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem 0px">
                    {{ Form::open(['route' => 'admin.user.store', 'method' => 'POST']) }}
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="kt_tab_pane_1_4" role="tabpanel" aria-labelledby="kt_tab_pane_1_4">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Tên đăng nhập</label>
                                        {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Tên đăng nhập'])}}
                                        @if($errors->has('name'))
                                            <span class="text-danger">{{$errors->first('name')}}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Email</label>
                                        {{Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email đăng nhập'])}}
                                        @if($errors->has('email'))
                                            <span class="text-danger">{{$errors->first('email')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Tên hiển thị</label>
                                        {{Form::text('fullname', '', ['class' => 'form-control', 'placeholder' => 'Tên hiển thị'])}}
                                        @if($errors->has('fullname'))
                                            <span class="text-danger">{{$errors->first('fullname')}}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Nhóm quyền</label>
                                        <select name="roles[]" multiple="multiple" class="form-control select" data-fouc>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{$role->display_name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('roles'))
                                            <span class="text-danger">{{$errors->first('roles')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Mật khẩu</label>
                                        {{Form::password('password', ['class' => 'form-control', 'placeholder' => 'Mật khẩu'])}}
                                        @if($errors->has('password'))
                                            <span class="text-danger">{{$errors->first('password')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Xác nhận lại mật khẩu</label>
                                        {{Form::password('password_confirm', ['class' => 'form-control', 'placeholder' => 'Nhập lại mật khẩu'])}}
                                        @if($errors->has('password_confirm'))
                                            <span class="text-danger">{{$errors->first('password_confirm')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="kt_tab_pane_2_4" role="tabpanel" aria-labelledby="kt_tab_pane_2_4">
                                @foreach($permissionGroup as $group)
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <h4>{{$group->name}}</h4>
                                        </div>
                                        <div class="col-md-12">
                                            <table>
                                                @foreach($group->permissions as $permission)
                                                    <tr>
                                                        <td style="padding: 8px 0px">
                                                            <div class="checkbox-list">
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}"/>
                                                                    <span></span>
                                                                </label>
                                                            </div>             
                                                        </td>
                                                        <td style="padding-left: 20px">
                                                            {{$permission->display_name}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <button type="submit" class="btn btn-primary px-6 font-weight-bold">
                                            Tạo mới
                                        </button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .card.card-custom{
        box-shadow: none;
    }
</style>
@endsection

@section('script')
<script>
    $('.select').select2({
        minimumResultsForSearch: Infinity
    });
</script>
@endsection
