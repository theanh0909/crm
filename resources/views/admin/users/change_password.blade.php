@extends('admin.layouts.app')

@section('content')

    <!-- Theme JS files -->
    <script src="/limitless/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script src="/limitless/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script src="/limitless/global_assets/js/plugins/forms/styling/switch.min.js"></script>
    <script src="/limitless/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>

    <script src="/limitless/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <!-- Page header -->
    <div class="page-header page-header-light">


        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="#" class="breadcrumb-item">User</a>
                    <span class="breadcrumb-item active">Create</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Đổi mật khẩu user: {{ $user->email }}</h6>
            </div>

            <div class="card-body">
                {{ Form::open(['route' => 'admin.user.store', 'method' => 'POST']) }}

                    <div class="tab-pane fade active show" id="basic-tab1">


                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">Đổi mật khẩu</legend>


                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Mật khẩu</label>
                                <div class="col-lg-10">
                                    {{Form::password('password', ['class' => 'form-control', 'placeholder' => 'Mật khẩu'])}}
                                    @if($errors->has('password'))
                                        <span class="text-danger">{{$errors->first('password')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Xác nhận lại mật khẩu</label>
                                <div class="col-lg-10">
                                    {{Form::password('password_confirm', ['class' => 'form-control', 'placeholder' => 'Nhập lại mật khẩu'])}}
                                    @if($errors->has('password_confirm'))
                                        <span class="text-danger">{{$errors->first('password_confirm')}}</span>
                                    @endif
                                </div>
                            </div>


                        </fieldset>

                    </div>



                    <div>
                        <button class="btn btn-success" type="submit">Create</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>


    </div>
    <!-- /content area -->

@endsection
