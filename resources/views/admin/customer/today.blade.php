@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Khách sử dụng trong ngày'])
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
                <h3 class="card-label">Khách sử dụng trong ngày</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr align="center">
                        <th>Sản phẩm</th>
                        <th>Khách hàng</th>
                        <th>Quản lý</th>
                        <th>Ghi chú</th>
                        {{--<th>Tên khách hàng</th>--}}
                        {{--<th>Địa chỉ</th>--}}
                        {{--<th>Email</th>--}}
                        {{--<th>Điện thoại</th>--}}
                        {{--<th>Phần mềm</th>--}}
                        {{--<th>License Key</th>--}}
                        {{--<th>Loại Key</th>--}}
                        {{--<th>Ngày HĐ cuối</th>--}}
                        {{--<th>Ngày hết hạn</th>--}}
                        <th width="300">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($customers as $item)
                    <tr>
                        <td>
                            <p>
                                <b class="text-success">{{($item->product) ? $item->product->name : ''}}</b> :
                                {{($item->product) ? number_format($item->product->price, 0, '.', '.') : ''}} VND
                            </p>
                            <p>
                                <b class="text-success">Key:</b>
                                {{$item->license_original}}
                            </p>
                            <p>
                                <b class="text-success">Loại Key:</b>
                                @if($item->license)
                                    @if($item->license->status == 0)
                                        Key dùng thử
                                    @else
                                        Key thương mại
                                    @endif
                                @endif
                            </p>
                            <p><b class="text-success">Ngày hết hạn:</b> {{$item->license_expire_date}}</p>
                        </td>
                        <td>
                            <p class="text-success"><b><a href="{{route('admin.customer.edit', ['id' => $item->id])}}">{{$item->customer_name}}</a></b></p>
                            <p><b class="text-info">{{$item->customer_phone}}</b> / <span class="text-secondary">{{$item->customer_email}}</span></p>
                            <p><b class="text-success">Ngày HĐ cuối:</b> {{$item->last_runing_date}}</p>
                            <p>
                                <button data-background="info" data-id="{{$item->id}}" class="status_action btn btn-sm
                                        @if($item->background == 'info') btn-info @else btn-light @endif">Xong</button>
                                <button data-background="warning" data-id="{{$item->id}}" class="status_action btn btn-sm
                                        @if($item->background == 'warning') btn-warning @else btn-light @endif">Chờ</button>
                                <button data-background="danger" data-id="{{$item->id}}" class="status_action btn btn-sm
                                        @if($item->background == 'danger') btn-danger @else btn-light @endif">Hủy</button>
                                {{--<button data-id="{{$item->id}}" data-toggle="modal"--}}
                                        {{--data-target="#changeUser" class="btn btn-light btn-sm btn-changeuser">Chuyển</button>--}}
                            </p>
                        </td>
                        <td>
                            <span class="text-success">
                                @if($item->user) {{$item->user->fullname}} @endif
                            </span>
                        </td>
                        <td>
                            <textarea cols="30" rows="4" data-table='registered' class="form-control noteaction" data-id="{{$item->id}}">{{$item->note}}</textarea>
                        </td>
                        <td class="action" align="center">
                            {{Form::open(['url' => route('admin.customer.delete',['id' => $item->id]), 'method' => 'POST', 'id' => 'deleteCM' . $item->id])}}
                            {{Form::close()}}
                            {{Form::open(['url' => route('admin.customer.reset-key', ['id' => $item->id]), 'method' => 'POST', 'id' => 'reset-key' . $item->id])}}
                            {{Form::close()}}

                            {{Form::open(['url' => route('admin.customer.resendEmail', ['id' => $item->id]), 'method' => 'POST', 'id' => 'resendEmail' . $item->id])}}
                            {{Form::close()}}

                            {{Form::open(['url' => route('admin.customer.blockKey', ['id' => $item->id]), 'method' => 'POST', 'id' => 'blockKey' . $item->id])}}
                            {{Form::close()}}

                            <a data-toggle="tooltip" data-theme="dark"  title="Sửa" href="{{route('admin.customer.edit', ['id' => $item->id])}}" class="btn-sm btn btn-warning" title="Edit">
                                <i class="flaticon-edit-1"></i>
                            </a>

                            <button class="btn-sm btn btn-info" data-toggle="tooltip" data-theme="dark" title="Đặt lại Key" for="reset-key{{$item->id}}"
                                    type="button" onclick="submitformx('#reset-key{{$item->id}}', 'Xác nhận đặt lại key?')">
                                    <i class="fa fa-key"></i>
                            </button>

                            <button class="btn-sm btn btn-danger" data-toggle="tooltip" data-theme="dark" title="Block Key"
                                    type="button" onclick="submitformx('#blockKey{{$item->id}}', 'Xác nhận khóa Key này?')">
                                    <i class="flaticon2-information"></i>
                            </button>


                            <a href="{{route('admin.customer.getRenewed', ['id' => $item->id])}}" class="btn-sm btn btn-success" data-toggle="tooltip" data-theme="dark" title="Gia hạn Key">
                                <i class="flaticon-calendar-with-a-clock-time-tools"></i>
                            </a>


                            {{--<button class="btn-sm btn btn-danger" title="xóa" for="deleteCM{{$item->id}}"--}}
                                    {{--type="button" onclick="submitformx('#deleteCM{{$item->id}}', 'Xác nhận xóa?')"><i class="fa fa-remove"></i>--}}
                            {{--</button>--}}

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                {!! $customers->links() !!}
            </div>            
        </div>
    </div>
</div>
<style type="text/css">
    .action i{
        font-size: 13px !important;
    }
</style>
@endsection

@section('script')
<script src="{{asset('js/sweetalert2@10.js')}}"></script>
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
<script src="assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
<script>
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