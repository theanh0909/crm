@extends('admin.layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="#" class="breadcrumb-item">Import dữ liệu thi chứng chỉ</a>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">   
        @include('admin.layouts.partitals.notify')
        <style>
            .content table tr td * {
                font-size: 10px;
            }
        </style>
        <div class="card">
            <div class="card-body">
            <form action="{{route('admin.customer.import-certificate')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="tab-content">
                    <fieldset class="mb-3">
                        <!-- <legend class="text-uppercase font-size-sm font-weight-bold"> </legend> -->
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label class="col-form-label">Chọn file để import</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <p style="margin-top: 45px">
                                    <a href="example/import-du-thi-cc.xls">Kích để tải file mẫu</a>
                                </p>
                            </div>                            
                        </div>
                    </fieldset>
                    <div>
                        <p>Ghi chú: Dữ liệu phải đúng như file mẫu để import.</p>
                    </div>
                    <div>
                        <button class="btn btn-success" type="submit">Import</button>
                    </div>
                </div>
            </form>
            </div>
    </div>
    
@endsection