@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Product', 'item2' => 'List'])
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
                <h3 class="card-label">Sản phẩm</h3>
            </div>
            <div class="card-title">
                <a href="{{route('admin.product.create')}}">
                    <button class="btn btn-primary">
                        <i class="flaticon-plus"></i> Thêm mới
                    </button>
                </a>
            </div>
            
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-header">
            <table class="table">
                <thead>
                <tr align="center">
                    <th width="100">Stt</th>
                    <th>SP</th>
                    <th>Ảnh</th>
                    <th>Giá</th>
                    <th>CK</th>
                    <th>Product Type</th>
                    <th>Danh mục</th>
                    <th>Mô tả</th>
                    <th width="150">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($models as $item)
                    <tr>
                        <td align="center">{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>
                            @if(Storage::has($item->icon))
                                <img src="{{Storage::url($item->icon)}}" width="70">
                            @else
                                <img src="/img/no-image.jpg" width="70">
                            @endif
                        </td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->discount}}%</td>
                        <td>{{$item->product_type}}</td>
                        <td>{{\App\Models\Product::$typeLabel[$item->type]}}</td>
                        <td>{{$item->description}}</td>
                        <td align="center">
                            {{Form::open(['url' => route('admin.product.destroy', ['product' => $item->id]), 'method' => 'DELETE'])}}
                            <a class="btn btn btn-warning" href="{{route('admin.product.edit', ['product' => $item->id])}}">
                                <i class="flaticon-edit"></i>
                            </a>
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this item?')">
                                <i class="flaticon2-rubbish-bin-delete-button"></i>
                            </button>
                            {{Form::close()}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                {!! $models->links() !!}
            </div>            
        </div>
    </div>
</div>
@endsection
