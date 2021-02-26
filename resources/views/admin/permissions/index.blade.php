@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Permission', 'item2' => 'Create'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Thêm quyền truy cập</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        <form action="{{route('admin.permission.create')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Tên:</label>
                        <input type="text" name="name" class="form-control" placeholder="vd: product-view-all">
                    </div>
                    <div class="col-lg-4">
                        <label>Tên hiển thị:</label>
                        <input type="text" class="form-control" name="display_name" placeholder="Tên hiển thị, vd: Xem sản phẩm đang phát triển">
                    </div>
                    <div class="col-lg-4">
                        <label>Nhóm quyền:</label>
                        <select class="form-control" name="group_id" id="">
                            @foreach($permissionGroup as $permissionItem)
                                <option value="{{$permissionItem->id}}">
                                    {{$permissionItem->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Mô tả:</label>
                        <textarea class="form-control" name="description" id="" cols="30" placeholder="Quyền truy cập này có tác dụng gì...." rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary mr-2">Thêm</button>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
@endsection
