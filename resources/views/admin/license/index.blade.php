@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'License', 'item2' => $title])
<div class="container">
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title">
                <span class="card-icon">
                    <span class="svg-icon svg-icon-md svg-icon-primary">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5" />
                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5" />
                                <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero" />
                                <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </span>
                <h3 class="card-label">{{$title}}</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Dropdown-->
                <div class="dropdown dropdown-inline mr-2">
                    <button type="button" class="btn btn-light-primary btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal"><i class="la la-download"></i>Export</button>

                    <!-- Modal-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{route('admin.license.exportExcel')}}" method="POST" target="_blank">
                            @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Export Key</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <div class="col-lg-12" style="margin-bottom: 15px">
                                                <label>Phần mềm:</label>
                                                <br>
                                                <select style="width: 100%" class="form-control" id="kt_select2_2" name="product_type">
                                                    @foreach($productTypes as $productType)
                                                        <option @if(isset($inputs['product_type']) && $inputs['product_type'] == $productType->product_type) selected @endif
                                                        value="{{$productType->product_type}}">{{$productType->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-12" style="margin-bottom: 15px">
                                                <label>Loại key:</label>
                                                <select class="form-control" name="status">
                                                    <option value="0">Key thử nghiệm</option>
                                                    <option value="1">Key thương mại</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-12">
                                                <label>Số lượng key cần xuất:</label>
                                                <input type="number" class="form-control" value="100" name="qty">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Thoát</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end::Dropdown-->
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <form method="GET">
                <div class="mt-2 mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-4 my-2 my-md-0">
                                    <div class="input-icon">
                                        <input type="text" value="{{(isset($inputs['query'])) ? $inputs['query'] : ''}}" class="form-control" placeholder="Nhập từ khóa..." name="query" />
                                        <span>
                                            <i class="flaticon2-search-1 text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <label class="mr-3 mb-0 d-none d-md-block">Phần mềm:</label>
                                        <select class="form-control" id="kt_select2_1" name="product_type">
                                            @foreach($productTypes as $productType)
                                                <option @if(isset($inputs['product_type']) && $inputs['product_type'] == $productType->product_type) selected @endif
                                                value="{{$productType->product_type}}">{{$productType->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2 my-md-0">
                                    <div class="d-flex align-items-center">
                                        <label class="mr-3 mb-0 d-none d-md-block">Key:</label>
                                        <select class="form-control" name="status">
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 0 ){{'selected'}}@endif value="0">Key thử nghiệm</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 1 ){{'selected'}}@endif value="1">Key thương mại</option>
                                            <option @if(isset($inputs['status']) && $inputs['status'] == 2 ){{'selected'}}@endif value="2">Key lớp học</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12 mt-5 mt-lg-0">
                            <center>
                                <button type="submit" class="btn btn-light-primary px-6 font-weight-bold">Tìm kiếm</button>
                                <a href="{{url()->current()}}" class="btn btn-light-success px-6 font-weight-bold">Bộ lọc</a>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
        <div class="card-header">
            <div class="row">
                {!! $licenses->appends(['query' => $filters['query'], 'product_type' => $filters['product_type'], 'status' => $filters['status']])->links() !!}
            </div> 
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Mã License  </th>
                        <th scope="col">SP</th>
                        <th scope="col">Loại key</th>
                        @if($pageAlias == 'actived')
                            <th scope="col">Ngày kích hoạt</th>
                        @endif
                        @if($pageAlias == 'actived')
                            <th scope="col">Ngày hết hạn</th>
                        @endif
                        <th scope="col">Số ngày</th>
                        <th scope="col"></th>
                        @if($pageAlias == 'emailsended')
                            <th scope="col">SDT</th>
                        @endif
                        @if($pageAlias == 'emailsended' || $pageAlias == 'notactive')
                            <th scope="col">Email</th>
                        @endif
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($licenses as $item)
                        @php
                            if($pageActive && !$item->customer)
                                continue;
                        @endphp
                        <tr id="row-{{$item->id}}">
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
                                    <span class="label label-lg label-light-primary label-inline">
                                        Key thử nghiệm
                                    </span>
                                    
                                @else
                                <span class="label label-lg label-light-success label-inline">
                                    Key thương mại
                                </span>
                                    
                                @endif
                            </td>
                            @if($pageAlias == 'actived')
                                <td>{{$item->customer->license_activation_date}}</td>
                            @endif
                            @if($pageAlias == 'actived')
                                <td>{{$item->customer->license_expire_date}}</td>
                            @endif

                            <td>{{$item->type_expire_date}}</td>
                            @if($pageAlias == 'emailsended')
                                <td>{{$item->customer_phone}}</td>
                            @endif
                            @if($pageAlias == 'emailsended' || $pageAlias == 'notactive')
                                <td></td>
                                <td>
                                    <input autocomplete="off" data-id="{{$item->id}}" placeholder="Email..." class="inputemail form-control" id="inputemail-{{$item->id}}" type="text" value="{{$item->email_customer}}">
                                </td>
                            @endif
                            <td>
                                @if($pageAlias == 'notactive')
                                    {!! Form::open(['url' => route('admin.license.sendMailCustomer', ['id' => $item->id]), 'method' => 'POST']) !!}
                                    <button type="submit" data-id="{{$item->id}}" class="btn-sendkey btn btn-sm btn-success" data-dismiss="modal">Gửi Key</button>
                                    {!! Form::close() !!}
                                @endif

                                @if($pageAlias == 'emailsended' && $item->email_customer != '')
                                    {!! Form::open(['url' => route('admin.license.sendMailCustomer', ['id' => $item->id]), 'method' => 'POST']) !!}
                                    <button type="submit" class="btn btn-sm btn-success" data-dismiss="modal">Gửi lại</button>
                                    {!! Form::close() !!}
                                @endif
                            </td>
                            <td>
                                {{Form::open(['url' => route('admin.license.destroy', ['id' => $item->id]), 'method' => 'DELETE'])}}
                                @if($pageAlias == 'actived' || $pageAlias == 'notactive')
                                    @if(can('license-edit'))
                                        <a class="btn btn-sm btn-warning" href="{{route('admin.license.edit', ['id' => $item->id])}}">
                                            <i class="flaticon-edit-1"></i>
                                        </a>
                                    @endif
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
                {!! $licenses->appends(['query' => $filters['query'], 'product_type' => $filters['product_type'], 'status' => $filters['status']])->links() !!}
            </div>            
        </div>
    </div>
</div>
    
@endsection

@section('script')
<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
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
            }
        })
    },500));

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    };

    $('.btn-sendkey').click(function(e) {
        var me      = $(this);
        var id      = me.data('id');
        var email   = $('#inputemail-' + id).val();
        if(email == '' || !isValidEmailAddress(email)) {
            alert('Email không đúng định dạng');
            e.preventDefault();
        }
    });
</script>
@endsection