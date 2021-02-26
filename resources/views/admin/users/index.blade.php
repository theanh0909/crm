@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'User', 'item2' => 'Danh sách người dùng'])
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
                <h3 class="card-label">Danh sách người dùng</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-body">
            <form action="" method="GET">
                <div class="row">
                    @csrf
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" placeholder="Nhập từ khóa" value="{{(isset($filters['query'])) ? $filters['query'] : ''}}">
                            <span class="input-group-append">
                                <button class="btn btn-light" type="submit">Tìm kiếm</button>
                            </span>
                        </div>
                    </div>
                    <div class="list-icons">
                    <a class="btn btn-info" href="{{route('admin.user.create')}}"><i class="fa fa-plus"></i> Tạo mới</a>
                    </div>
                </div>
                
            </form>
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                <tr align="center">
                    <th>Stt</th>
                    <th>Tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th width="250">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr align="center">
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$user->fullname}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if($user->avatar != '')
                                    <img src="{{Storage::url($user->avatar)}}" width="70" />
                                @else
                                    <img src="/limitless/global_assets/images/placeholders/placeholder.jpg" width="70" />
                                @endif
                            </td>
                            <td>
                                {{Form::open(['url' => route('admin.user.destroy', ['user' => $user->id]), 'method' => 'DELETE'])}}
                                <a class="btn btn-warning" href="{{route('admin.user.edit', ['user' => $user->id])}}" title="">
                                    <i class="flaticon-edit"></i></a>

                                @if(can('user-cpassword'))
                                <button type="button" title="Đổi mật khẩu"
                                        class="btn btn-secondary" data-toggle="modal" data-target="#changePassword{{$user->id}}">
                                    <i class="fa fa-key"></i>
                                </button>
                                @endif

                                <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this item?')">
                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                </button>
                                {{Form::close()}}
                            </td>
                        </tr>

                        <div class="modal fade" id="changePassword{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    {!! Form::open(['url' => route('admin.user.postEditPassword', ['id' => $user->id]), 'method' => 'POST']) !!}
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Đổi mật khẩu user: {{$user->email}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12">Mật khẩu mới</label>
                                            <div class="col-lg-12">
                                                {{Form::password('password', ['class' => 'form-control', 'placeholder' => 'Mật khẩu'])}}
                                                @if($errors->has('password'))
                                                    <span class="text-danger">{{$errors->first('password')}}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                {{$users->links()}}
            </div>            
        </div>
    </div>
</div>
@endsection
