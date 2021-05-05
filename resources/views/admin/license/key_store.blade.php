@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'License', 'item2' => 'Kho key'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Số lượng key còn trong kho</h3>
        </div>
        @include('admin.layouts.partitals.notify')
    </div>
    <div class="card-header">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Sản phẩm</th>
                    <th scope="col">Key thương mại</th>
                    <th scope="col">Key dùng thử</th>
                    <th scope="col">Key lớp học</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productTypes as $key => $productTypeItem)
                    <tr>
                        <td scope="row">
                            {{1 + $key++}}
                        </td>
                        <td scope="row">
                            {{$productTypeItem->name}}
                        </td>
                        <td scope="row">
                            {{number_format(\App\Helpers\Helper::countKey($productTypeItem->product_type, 1))}}
                        </td>
                        <td scope="row">
                            {{number_format(\App\Helpers\Helper::countKey($productTypeItem->product_type, 0))}}
                        </td>
                        <td>
                            {{number_format(\App\Helpers\Helper::countKey($productTypeItem->product_type, 2))}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>           
    </div>
</div>
@endsection