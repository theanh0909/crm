@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Thống kê', 'item2' => 'KPI nhân viên'])
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
                    Tổng hợp số liệu KPI
                </h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-body" style="padding-bottom: 0px">
            <form method="GET">
                <div class="mt-2 mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <select class="form-control" name="month">
                                        <?php
                                            $monthSelected = (request()->get('month')) ? request()->get('month') : date('m');
                                            for($i = 1; $i <= 12; $i++) :
                                            $label = ($i < 10) ? '0' . $i : $i;
                                        ?>
                                        <option @if($label == $monthSelected) selected @endif value="{{$label}}">Tháng {{$label}}</option>
                                        <?php endfor; ?>
                                        <option @if($type == 0) selected @endif value="100">Cả năm</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="year">
                                        <?php
                                        $ySelected = (request()->get('year')) ? request()->get('year') : date('Y');
                                        $maxYear = date('Y');
                                        for($i = $maxYear; $i >= ($maxYear - 20); $i--) :
                                        ?>
                                        <option @if($i == $ySelected) selected @endif value="{{$i}}">Năm {{$i}}</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary px-6 font-weight-bold"><i class="flaticon-search-magnifier-interface-symbol"></i> Thống kê</button>
                                    <button style="margin-left: 10px" type="submit" class="btn btn-success" name="submit" value="export">
                                        <i class="fa fa-file-excel-o"></i> Xuất Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </form>
            <!--end::Search Form-->
        </div>
        <div class="card-header">
            <table class="table">
                <thead>
                    <tr align="center">
                        <th>Stt</th>
                        <th>Nhân viên</th>
                        <th>Doanh số</th>
                        <th>Trả Vacc</th>
                        <th>Trả Vace</th>
                        <th>Thưởng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $userItem)
                        <tr align="center">
                            <td>
                                {{$key+1}}
                            </td>
                            <td>
                                {{$userItem->fullname}}
                            </td>
                            <td>
                                @php 
                                    $data = \App\Helpers\Helper::getKpi($date, $userItem->id, $type, $year);
                                    $total = $data['total'];
                                @endphp
                                {{number_format($data['total'])}}
                            </td>
                                                
                            <td>
                                {{number_format($data['vacc'])}}
                            </td>
                            <td>
                                {{number_format($data['vace'])}}
                            </td>
                            <td>
                                @if($type == 0)
                                    @if($total >= 300000000 && $total < 600000000)
                                        {{number_format(1000000)}}
                                    @elseif($total >= 600000000 && $total <= 1200000000)
                                        {{number_format(1500000)}}
                                    @elseif($total > 1200000000)
                                        {{number_format(2000000)}}
                                    @endif
                                @elseif($type == 1)
                                    @if($total >= 10000000 && $total <= 24000000)
                                        {{number_format(500000)}}
                                    @elseif($total >= 25000000 && $total <= 49000000)
                                        {{number_format(1000000)}}
                                    @elseif($total >= 50000000 && $total <= 100000000)
                                        {{number_format(2000000)}}
                                    @elseif($total >= 100000000)
                                        {{number_format(3000000)}}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection