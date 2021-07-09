@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Tìm kiếm', 'item2' => 'Kết quả'])
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
                <h3 class="card-label">Đơn hàng đã duyệt</h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        @if(count($customers) > 0)
        <!-- Modal Chuyển cho NV -->
            <div class="modal fade" id="changeUser" tabindex="-1" role="dialog" aria-labelledby="changeUser" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        {!! Form::open(['url' => route('admin.customer.changeUser'), 'method' => 'POST']) !!}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chuyển cho NV</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">NV Nhận</label>
                                <div class="col-lg-10">
                                    <select class="form-control" name="user_id">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->fullname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" id="input_customer_id" name="customer_id" value="" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Chuyển</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="card-header">
                <table class="table">
                        <thead>
                            <tr align="center">
                                <th>Đơn hàng</th>
                                <th>Thông tin thêm</th>
                                <th>Khách hàng</th>
                                <th>Quản lý</th>
                                <th>Ghi chú</th>
                                <th>HĐ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $item)
                                <tr>
                                    <td>
                                        <p class="text-success">
                                            <b> 
                                            @if(!empty($item->license_original))
                                            Key:
                                                {{$item->license_original}}
                                            @endif
                                            </b>
                                        </p>    
                                        <p>
                                            <b>
                                                <li>{{($item->product) ? $item->product->name: ''}}
                                                    @if(!empty($item->license->status))
                                                            :
                                                        @if($item->license->status == 0)
                                                            0 đ
                                                        @else
                                                            {{($item->product) ? number_format($item->product->price, 0, '.', '.'): ''}} đ
                                                        @endif
                                                    @endif
                                                </li>
                                            </b>
                                            <li>Tạo đơn: {{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}</li>
                                            <li>Duyệt đơn: {{(!empty($item->transaction) ? date('d/m/Y', strtotime($item->transaction->time_approve)) : '...')}}</li>  {{-- Nếu không có thì là dữ liệu cũ --}}                                  
                                            <li>Kích hoạt: {{\Carbon\Carbon::parse($item->license_activation_date)->format('d-m-Y')}}</li>                                  
                                        </p>
                                    </td>
                                    <td> 
                                        @if(!empty($item->license))
                                            <p>
                                                Loại Key:
                                                @if($item->license)
                                                    @if($item->license->status == 0)
                                                    Key dùng thử
                                                    @else
                                                    Key thương mại
                                                    @endif
                                                @endif
                                            </p>
                                            <p>
                                                <b class="text-success">Số tiền:</b>
                                                {{number_format($item->price * $item->qty)}}
                                            </p>
                                            <p>
                                                Trạng thái:
                                                @if(!empty($item->hardware_id))
                                                    Kích hoạt
                                                @else
                                                    Chưa kích hoạt
                                                @endif                                
                                            </p>
                                            <p>Đổi máy: {{$item->number_has_change_key-1}} lần</p>
                                        @else
                                            <p>
                                                Giá tiền: <b>{{number_format($item->price)}}<b>
                                            </p>
                                        @endif
                                        @if(!empty($item->license_expire_date))
                                            <p>
                                                Hết hạn: {{\Carbon\Carbon::parse($item->license_expire_date)->format('d-m-Y')}}
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-success"><b><a href="{{route('admin.customer.edit', ['id' => $item->id])}}">{{$item->customer_name}}</a></b></p>
                                        <p>{{$item->customer_phone}} / <span class="text-secondary">{{$item->customer_email}}</span></p>
                                        @if(!empty($item->last_runing_date))
                                            HĐ cuối: {{\Carbon\Carbon::parse($item->last_runing_date)->format('d-m-Y')}}
                                        @endif
                                        <p>Địa chỉ: {{$item->customer_address}}</p>
                                        <p>Địa phương: {{$item->customer_cty}}</p>
                                        <p>
                                            <button data-background="info" data-id="{{$item->id}}" class="status_action btn btn-sm
                                                    @if($item->background == 'info') btn-info @else btn-light @endif">Xong</button>
                                            <button data-background="warning" data-id="{{$item->id}}" class="status_action btn btn-sm
                                                    @if($item->background == 'warning') btn-warning @else btn-light @endif">Chờ</button>
                                            <button data-background="danger" data-id="{{$item->id}}" class="status_action btn btn-sm
                                                    @if($item->background == 'danger') btn-danger @else btn-light @endif">Hủy</button>
                                            <button data-id="{{$item->id}}" data-toggle="modal"
                                                    data-target="#changeUser" class="btn btn-light btn-sm btn-changeuser">Chuyển</button>
                                        </p>
                                    </td>
                                    <td>
                                        <span class="text-success">
                                            @if($item->user) {{$item->user->fullname}} @endif
                                        </span>
                                    </td>
                                    <td>
                                        <textarea cols="20" rows="4" class="form-control noteaction" data-table="registered" data-id="{{$item->id}}">{{($item->transaction) ? $item->transaction->note : ''}}</textarea>
                                    </td>
                                    <td>
                                        {{Form::open(['url' => route('admin.customer.delete',['id' => $item->id]), 'method' => 'POST', 'id' => 'deleteCM' . $item->id])}}
                                        {{Form::close()}}
                                        {{Form::open(['url' => route('admin.customer.reset-key', ['id' => $item->id]), 'method' => 'POST', 'id' => 'reset-key' . $item->id])}}
                                        {{Form::close()}}

                                        {{Form::open(['url' => route('admin.customer.resendEmail', ['id' => $item->id]), 'method' => 'POST', 'id' => 'resendEmail' . $item->id])}}
                                        {{Form::close()}}

                                        {{Form::open(['url' => route('admin.customer.blockKey', ['id' => $item->id]), 'method' => 'POST', 'id' => 'blockKey' . $item->id])}}
                                        {{Form::close()}}
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown">
                                                <i class="flaticon2-gear text-primary"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-sm">
                                                <ul class="navi">
                                                    <li class="navi-item">
                                                        <a class="navi-link" target="_blank" href="{{route('admin.customer.print', ['id' => $item->id])}}">
                                                            <span class="navi-icon"><i class="flaticon2-printer"></i></span>
                                                            <span class="navi-text">In hóa đơn</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a class="navi-link" onclick="submitformx('#resendEmail{{$item->id}}', 'Xác nhận gửi lại Email?')">
                                                            <span class="navi-icon"><i class="flaticon2-send-1"></i></span>
                                                            <span class="navi-text">Gửi lại Email</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="{{route('admin.customer.edit', ['id' => $item->id])}}" class="navi-link" title="Edit">
                                                            <span class="navi-icon"><i class="flaticon-edit"></i></span>
                                                            <span class="navi-text">Sửa</span>
                                                        </a>
                                                    </li>
                                                    @if(can('customer-reset'))
                                                        <li class="navi-item">
                                                            <a class="navi-link" onclick="submitformx('#reset-key{{$item->id}}', 'Xác nhận đặt lại key?')">
                                                                <span class="navi-icon"><i class="flaticon2-refresh-1"></i></span>
                                                                <span class="navi-text">Đặt lại key</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(can('customer-block'))
                                                        <li class="navi-item">
                                                            <a class="navi-link" onclick="submitformx('#blockKey{{$item->id}}', 'Xác nhận khóa Key này?')">
                                                                <span class="navi-icon"><i class="flaticon-exclamation-1"></i></span>
                                                                <span class="navi-text">Khóa key</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(can('customer-renew'))
                                                        <li class="navi-item">
                                                            <a href="{{route('admin.customer.getRenewed', ['id' => $item->id])}}" class="navi-link" title="Gia hạn Key">
                                                                <span class="navi-icon"><i class="flaticon-time"></i></span>
                                                                <span class="navi-text">Gia hạn key</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(can('customer-block'))
                                                        <li class="navi-item">
                                                            <a class="navi-link" onclick="submitformx('#deleteCM{{$item->id}}', 'Xác nhận xóa?')">
                                                                <span class="navi-icon"><i class="flaticon2-rubbish-bin-delete-button"></i></span>
                                                                <span class="navi-text">Xóa</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                <div class="row">
                    {{$customers->appends(['query' => $query])->links()}}
                </div>            
            </div>
        @endif
    </div>
    <br>
    @if(count($transactions) > 0)
        <!-- Modal Chuyển cho NV -->
        <div class="modal fade" id="changeUser" tabindex="-1" role="dialog" aria-labelledby="changeUser" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['url' => route('admin.customer.changeUser'), 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chuyển cho NV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">NV Nhận</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="user_id">
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="input_customer_id" name="customer_id" value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Chuyển</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
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
                    <h3 class="card-label">
                        Đơn hàng đã duyệt và chờ giao dịch
                    </h3>
                </div>
            </div>
            <div class="card-header">
                <table class="table">
                    <thead>
                        <tr align="center">
                            <th>Đơn hàng</th>
                            <th>Thông tin thêm</th>
                            <th>Khách hàng</th>
                            <th>Quản lý</th>
                            <th>Ghi chú</th>
                            <th>HĐ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $item)
                            <tr>
                                <td>
                                    <p>
                                        <b><li>{{($item->product) ? $item->product->name: ''}}
                                        @if(!empty($item->license->status))
                                                :
                                            @if($item->license->status == 0)
                                                0 đ
                                            @else
                                                {{($item->product) ? number_format($item->product->price, 0, '.', '.'): ''}} đ
                                            @endif
                                        @endif
                                        </li></b>
                                        <li>Tạo đơn: {{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}</li>
                                        <li>Duyệt đơn: {{$item->time_approve != '' ? date('d/m/Y', strtotime($item->time_approve)) : 'Chưa duyệt'}}</li>                        
                                    </p>
                                </td>
                                <td> 
                                    <p>
                                        Sản phẩm
                                        @if($item->customer_type == 0)
                                            <b>Khóa mềm - {{$item->type == 1 ? 'Key thương mại' : 'Key dùng thử'}}</b>
                                        @elseif($item->customer_type == 1)
                                            <b>Khóa cứng</b>
                                        @elseif($item->customer_type == 2)
                                            <b>Khóa học</b>
                                        @elseif($item->customer_type == 3)
                                            <b>Chứng chỉ</b>
                                        @endif
                                    </p>
                                    <p>
                                        <b class="text-success">Số tiền:</b>
                                        {{number_format($item->price * $item->qty)}}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-success"><b><a href="{{route('admin.customer.edit', ['id' => $item->id])}}">{{!empty($item->customer) ? $item->customer->name : ''}}</a></b></p>
                                    <p>{{!empty($item->customer) ? $item->customer->phone : ''}} / <span class="text-secondary">{{!empty($item->customer) ? $item->customer->email : ''}}</span></p>
                                    @if(!empty($item->last_runing_date))
                                        HĐ cuối: {{\Carbon\Carbon::parse($item->last_runing_date)->format('d-m-Y')}}
                                    @endif
                                    <p>Địa chỉ: {{!empty($item->customer) ? $item->customer->address : ''}}</p>
                                    <p>Địa phương: {{$item->customer_cty}}</p>
                                    <p>
                                        <button data-background="info" data-id="{{$item->id}}" class="status_action btn btn-sm
                                                @if($item->background == 'info') btn-info @else btn-light @endif">Xong</button>
                                        <button data-background="warning" data-id="{{$item->id}}" class="status_action btn btn-sm
                                                @if($item->background == 'warning') btn-warning @else btn-light @endif">Chờ</button>
                                        <button data-background="danger" data-id="{{$item->id}}" class="status_action btn btn-sm
                                                @if($item->background == 'danger') btn-danger @else btn-light @endif">Hủy</button>
                                        <button data-id="{{$item->id}}" data-toggle="modal"
                                                data-target="#changeUser" class="btn btn-light btn-sm btn-changeuser">Chuyển</button>
                                    </p>
                                </td>
                                <td>
                                    <span class="text-success">
                                        @if($item->user) {{$item->user->fullname}} @endif
                                    </span>
                                </td>
                                <td>
                                    <textarea cols="20" rows="4" class="form-control noteaction" data-table="transactions" data-id="{{$item->id}}">{{$item->note}}</textarea>
                                </td>
                                <td>
                                    {{Form::open(['url' => route('admin.request.destroy',['id' => $item->id]), 'method' => 'DELETE', 'id' => 'deleteCM' . $item->id])}}
                                    {{Form::close()}}
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown">
                                            <i class="flaticon2-gear text-primary"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-sm">
                                            <ul class="navi">
                                                <li class="navi-item">
                                                    <a target="_blank" class="navi-link" href="{{route('admin.customer.print', ['id' => $item->id])}}">
                                                        <span class="navi-icon"><i class="fa fa-print"></i></span>
                                                        <span class="navi-text">In hóa đơn</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a class="navi-link" href="{{route('admin.input-edit-form', ['id' => $item->id])}}" title="Edit">
                                                        <span class="navi-icon"><i class="flaticon-edit"></i></span>
                                                        <span class="navi-text">Sửa</span>
                                                    </a>
                                                </li>
                                                @if(can('customer-block'))
                                                <li class="navi-item">
                                                    <a class="navi-link" onclick="submitformx('#deleteCM{{$item->id}}', 'Xác nhận xóa?')">
                                                        <span class="navi-icon"><i class="flaticon2-rubbish-bin-delete-button"></i></span>
                                                        <span class="navi-text">Xóa</span>
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>        
            </div>
        </div>
        <div class="row">
            {!! $transactions->appends(['query' => $query])->links() !!}
        </div>
    @endif
    <br>
    @if(count($licenses) > 0)
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
                    <h3 class="card-label">
                        Key đã gửi chờ kích hoạt
                    </h3>
                </div>
            </div>
            <div class="card-header">
                <table class="table">
                    <thead>
                    <tr align="center">
                        <th width="250">Mã License</th>
                        <th>SP</th>
                        <th>Loại Key</th>
                        <th>Số ngày</th>
                        <th>Email</th>
                        <th width="150">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($licenses as $item)
                        <tr id="row-{{$item->id}}">
                            {{--<td>{{$loop->index + 1}}</td>--}}
                            <td>
                                @if($item->customer)
                                    <a href="{{route('admin.customer.edit', ['id' => $item->customer->id])}}">{{$item->license_key}}</a>
                                @else
                                    {{$item->license_key}}
                                @endif
                            </td>
                            <td>{{($item->product) ? $item->product->name : ''}}</td>
                            <td>
                                @if($item->status == 0)
                                    Key thử nghiệm
                                @else
                                    Key thương mại
                                @endif
                            </td>
                            <td>{{$item->type_expire_date}}</td>
                            
                            @if($pageAlias == 'emailsended' || $pageAlias == 'notactive')
                                <td>
                                    <input autocomplete="off" data-id="{{$item->id}}" class="inputemail form-control" id="inputemail-{{$item->id}}" type="text" value="{{$item->email_customer}}">
                                </td>
                            @endif
                            <td>

                                @if($pageAlias == 'emailsended' && $item->email_customer != '')
                                    {!! Form::open(['url' => route('admin.license.sendMailCustomer', ['id' => $item->id]), 'method' => 'POST']) !!}
                                    <button type="submit" class="btn btn-sm btn-success" data-dismiss="modal">Gửi lại</button>
                                    {!! Form::close() !!}
                                @endif
                            </td>
                            <td>
                                {{Form::open(['url' => route('admin.license.destroy', ['id' => $item->id]), 'method' => 'DELETE'])}}
                                    @if(can('license-edit'))
                                        <a class="btn btn-sm btn-warning" href="{{route('admin.license.edit', ['id' => $item->id])}}">
                                            <i class="flaticon-edit-1"></i>
                                        </a>
                                    @endif
                                
                                    <input type="hidden" name="license_id" value="{{$item->id}}"/>
                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Xác nhận xóa key!')">
                                        <i class="flaticon2-rubbish-bin-delete-button"></i>
                                    </button>
                                {{Form::close()}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="text-right" style="padding: 10px;">
                {!! $licenses->appends(['query' => $query])->links() !!}
            </div>
        </div>
    @endif
</div>
@endsection

@section('script')
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
            }
        })
    });
    
    $('.noteaction').keyup(debounce(function(e){
        var me = $(this);
        var dataPost = {
          id:   me.data('id'),
          note: me.val(),
          table: me.data('table'),
          _token: "{{csrf_token()}}"
        };
       $.ajax({
           url: "{{route('admin.customer.editComment')}}",
           method: 'POST',
           data: dataPost,
           success: function(e) {
               if (e == false) {
                   alert('Bạn không có quyền');
               }
           }
       })
    },1000));
</script>
@endsection