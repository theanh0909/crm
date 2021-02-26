@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'License', 'item2' => 'Danh sách vừa tạo'])
<div class="container">
    @include('admin.layouts.partitals.notify')
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">DANH SACH KEY VỪA TẠO</h3><br>
        </div>
        <div class="card-header" style="align-content: center; justify-content: left">
            <form action="{{route('admin.license.export-excel-selected')}}" method="POST" target="_blank">
                @csrf
                @foreach($datas as $item)
                    <input type="hidden" name="id[]" value="{{$item['id']}}">
                @endforeach
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group">
                            <button type="submit" class="btn btn-success">Xuất ra excel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                <tr align="center">
                    <th>License Key</th>
                    <th>Số máy</th>
                    <th>Ngày tạo</th>
                    <th>Loại Key</th>
                    <th>Loại phần mềm</th>
                    <th>Ngày hết hạn</th>
                    <th width="200">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td align="center">{{$item['license_key']}}</td>
                        <td align="center">{{$item['license_no_computers']}}</td>
                        <td align="center">{{$item['license_created_date']}}</td>
                        <td align="center">
                            @if($item['status'] == 0)
                                Key thử nghiệm
                            @else
                                Key thương mại
                            @endif
                        </td>
                        <td align="center">{{$item['product']->name}}</td>
                        <td align="center">{{$item['type_expire_date']}}</td>
                        <td align="center">
                            {{Form::open(['url' => route('admin.license.destroy', ['id' => $item['id']]), 'method' => 'DELETE'])}}
                            <a class="btn btn-outline-secondary" href="{{route('admin.license.edit', ['id' => $item['id']])}}">
                                <i class="flaticon-edit-1"></i>
                            </a>

                            <button class="btn btn-outline-danger" type="submit" onclick="return confirm('Delete this item?')">
                                <i class="flaticon2-rubbish-bin-delete-button"></i>
                            </button>
                            {{Form::close()}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

