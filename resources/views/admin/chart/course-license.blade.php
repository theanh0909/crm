@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Danh sách key tặng kèm khóa học'])
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
                <h3 class="card-label">
                    Danh sách key tặng kèm khóa học
                </h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <table class="table">
                <thead>
                <tr align="center">
                    <th>Stt</th>
                    {{--<th width="50">#</th>--}}
                    <th>Thông tin key</th>
                    <th>Khách hàng</th>
                    <th>Thông tin KH</th>


                    {{--<th width="150">Hành động</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($licenses as $key => $item)
                    <tr id="row-{{$item->id}}">
                        <!-- Đánh số thứ tự -->
                        <td align="center">{{1 + $key++}}</td>
                        <td>
                            <p>
                                <span class="label label-lg label-light-primary label-inline">{{$item->license_key}}</span>
                            </p>
                            <p>Sản phẩm: {{$item->product->name}}</p>
                            <p>Loại Key: Key thương mại - 1 năm</p>
                            <p>Ngày tạo: {{date('d/m/Y', strtotime($item->license_created_date))}}</p>
                            <p>Ngày gửi: {{date('d/m/Y', strtotime($item->transaction->updated_at))}}</p>
                        </td>
                        <td>
                            <p>Khóa học: {{$item->transaction->product->name}}</p>
                            <p><i style="margin-right: 5px" class="flaticon2-user"></i> {{$item->transaction->customer_name}}</p>
                            <p><i style="margin-right: 5px" class="flaticon2-new-email"></i> {{$item->transaction->customer_email}}</p>
                            <p><i style="margin-right: 5px" class="flaticon2-phone"></i> {{$item->transaction->customer_phone}}</p>
                            <p><i class="flaticon2-map" style="margin-right: 5px"></i> {{$item->transaction->customer_address}}</p>
                        </td>
                        <td>
                            <p>
                                @if($item->customer)
                                    <span class="label label-lg label-light-primary label-inline">Đã kích hoạt</span>
                                    
                                @else
                                    <span class="label label-lg label-light-warning label-inline">Chưa kích hoạt</span>
                                @endif
                            </p>
                            @if($item->customer)
                                <p>
                                    <i style="margin-right: 5px" class="flaticon2-user"></i> 
                                    <a href="{{route('admin.customer.edit', ['id' => $item->customer->id])}}">{{$item->customer->customer_name}}</a>
                                </p>
                            @endif
                        </td>

                        <td align="center">
                            {{Form::open(['url' => route('admin.license.destroy', ['id' => $item->id]), 'method' => 'DELETE'])}}

                           @if(can('license-block'))
                            <a class="btn btn-sm btn-info" href="#">
                            <i class="fa fa-key"></i>
                            </a>
                            @endif
                            @if(can('license-delete'))
                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Xác nhận xóa key!')">
                                    <i class="flaticon2-rubbish-bin-delete-button"></i>
                                </button>
                            @endif
                            {{Form::close()}}


                        </td>
                    </tr>

                @endforeach
                </tbody>

            </table>
            <div class="row">
                {!! $licenses->links() !!}
            </div>            
        </div>
    </div>
</div>
@endsection

