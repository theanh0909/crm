@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Khách chưa kích hoạt'])
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
                <h3 class="card-label">Khách chưa kích hoạt</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th width="20%">Sản phẩm</th>
                            <th width="15%">Loại key</th>
                            <th>Quản lý</th>
                            <th>Ngày tạo</th>
                            <th>Khách hàng</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th width="10%">HĐ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($licenses as $key => $item)
                        <tr>
                            <td>
                                {{$key + 1}}
                            </td>
                            <td>
                                <p>{{($item->product) ? $item->product->name : ''}}</p>
                                {{$item->license_key}}
                            </td>
                            <td>
                                <p>
                                    @if($item->status == 0)
                                        <span class="label label-lg label-light-warning label-inline">Key thử nghiệm</span>
                                    @else
                                        <span class="label label-lg label-light-success label-inline">Key thương mại</span>
                                    @endif 
                                </p>
                                <p>Thời hạn: <b>{{$item->type_expire_date}} ngày</b></p>
                            </td>
                            <td>
                                <span>
                                    @if($item->user) {{$item->user->fullname}} @endif
                                </span>
                            </td>
                            <td>
                                {{date('d/m/Y',strtotime($item->created_at))}}
                            </td>
                            <td>
                                <input autocomplete="off" data-id="{{$item->id}}" class="form-control inputname" id="inputname-{{$item->id}}" type="text" value="{{$item->customer_name}}">
                            </td>
                            <td>
                                <input autocomplete="off" data-id="{{$item->id}}" class="form-control inputphone" id="inputphone-{{$item->id}}" type="text" value="{{$item->customer_phone}}">
                            </td>
                            <td>
                                <input autocomplete="off" data-id="{{$item->id}}" class="form-control inputemail" id="inputemail-{{$item->id}}" type="text" value="{{$item->email_customer}}">
                            </td>
                            <td class="action">
                                {!! Form::open(['url' => route('admin.license.sendMailCustomer', ['id' => $item->id]), 'method' => 'POST']) !!}
                                <button type="submit" class="btn btn-sm btn-success" data-dismiss="modal" title="Gửi lại key vào email">
                                    <i class="flaticon2-reply"></i></button>
                                {!! Form::close() !!}
                                {{Form::open(['url' => route('admin.license.destroy', ['id' => $item->id]), 'method' => 'DELETE'])}}
                                
                                @if(can('license-delete'))
                                    <button class="btn btn-sm btn-danger" type="submit" title="Xóa thông tin này" onclick="return confirm('Xác nhận xóa!')">
                                        <i class="flaticon-delete-1"></i>
                                    </button>
                                @endif
                                {{Form::close()}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            <div class="row">
                {{$licenses->links()}}
            </div>
        </div>
    </div>
</div>
                    <style>
                        .action form{
                            display: inline-block;
                        }
                    </style>
@endsection

@section('script')
<script src="{{asset('js/sweetalert2@10.js')}}"></script>
<script>
    $('.inputemail').keyup(debounce(function(e){
        var me = $(this);
        var dataPost = {
            id                  :   me.data('id'),
            email_customer      :   me.val(),
            _token              : "{{csrf_token()}}"
        };
        $.ajax({
            url: "{{route('admin.license.editEmail')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật thành công',
                    timer: 800
                })
            }
        })
    },500));
    $('.inputname').keyup(debounce(function(e){
        var me = $(this);
        var dataPost = {
            id                  :   me.data('id'),
            customer_name      :   me.val(),
            _token              : "{{csrf_token()}}"
        };
        $.ajax({
            url: "{{route('admin.license.editName')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật thành công',
                    timer: 800
                })
            }
        })
    },500));
    $('.inputphone').keyup(debounce(function(e){
        var me = $(this);
        var dataPost = {
            id                  :   me.data('id'),
            customer_phone      :   me.val(),
            _token              : "{{csrf_token()}}"
        };
        $.ajax({
            url: "{{route('admin.license.editPhone')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật thành công',
                    timer: 800
                })
            }
        })
    },500));
    function submitformx(idform, text) {
        var conf = window.confirm(text);
        if(conf) {
            $(idform).submit();
        }
    }
    $('.btn-changeuser').click(function (e) {
        var id = $(this).data('id');
        $('#input_customer_id').val(id);
    });

    $('.status_action').click(function (e) {
        var me = $(this);
        var dataPost = {
            id:   me.data('id'),
            background: me.data('background'),
            _token: "{{csrf_token()}}"
        };

        me.closest('p').find('.status_action').attr('class', 'status_action btn btn-sm btn-light');
        me.attr('class', 'status_action btn btn-sm btn-' + me.data('background'));

        $.ajax({
            url: "{{route('admin.customer.editBackground')}}",
            method: 'POST',
            data: dataPost,
            success: function(e) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật thành công',
                    timer: 800
                })
            }
        })

    });

    $('.noteaction').keyup(debounce(function(e){
        var me = $(this);
        var dataPost = {
        id:   me.data('id'),
        note: me.val(),
        _token: "{{csrf_token()}}"
        };
    $.ajax({
        url: "{{route('admin.customer.editComment')}}",
        method: 'POST',
        data: dataPost,
        success: function(e) {
            Swal.fire({
                icon: 'success',
                title: 'Cập nhật thành công',
                timer: 800
            })
        }
    })
    },1000));
</script>
@endsection