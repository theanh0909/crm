@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Roles', 'item2' => 'Danh sách quyền'])
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
                <h3 class="card-label">Danh sách quyền</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-body">
            <form method="GET">
                <div class="mt-2 mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-3 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <input type="text" name="query" class="form-control" placeholder="Tìm kiếm" value="{{(isset($filters['query'])) ? $filters['query'] : ''}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" name="submit" value="thongke" class="btn btn-primary px-6 font-weight-bold">Tìm kiếm</button>
                                    <a class="btn btn-info" href="{{route('admin.roles.create')}}"><i class="fa fa-plus"></i> Tạo mới</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr align="center">
                        <th>Stt</th>
                        <th width="200px">Tên quyền</th>
                        <th>Mã</th>
                        <th>Mô tả</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$role->display_name}}</td>
                            <td>{{$role->name}}</td>
                            <td>{{$role->description}}</td>
                            <td align="center">
                                {{Form::open(['url' => route('admin.roles.destroy', ['roles' => $role->id]), 'method' => 'DELETE'])}}
                                    <a class="btn btn-warning" href="{{route('admin.roles.edit', ['roles' => $role->id])}}">
                                        <i class="flaticon-edit"></i></a>

                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this item?')">
                                        <i class="flaticon2-rubbish-bin-delete-button"></i>
                                    </button>
                                {{Form::close()}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    {{$roles->links()}}
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
