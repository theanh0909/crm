@extends('admin.layouts.app')

@section('content')

    <script src="/limitless/global_assets/js/plugins/visualization/echarts/echarts.min.js"></script>
    <script>
        $(document).ready(function() {
            var bars_basic_element = document.getElementById('bars_basic');

            var regions = [];
            var productions = [];

            @foreach($regions as $region)
                regions.push("{{$region->customer_cty}}");
            @endforeach
            @foreach($productions as $production)
                productions.push("{{$production->name}}");
            @endforeach

            if (bars_basic_element) {

                // Initialize chart
                var bars_basic = echarts.init(bars_basic_element);


                // Options
                bars_basic.setOption({

                    // Global text styles
                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 13
                    },

                    // Chart animation duration
                    animationDuration: 750,

                    // Setup grid
                    grid: {
                        left: 0,
                        right: 30,
                        top: 50,
                        bottom: 80,
                        containLabel: true
                    },

                    // Add legend
                    legend: {
                        data: productions,
                        itemHeight: 18,
                        itemGap: 10,
                        top: 100,
                        left: 180,
                        bottom: 1000,
                        textStyle: {
                            padding: [0, 50]
                        }
                    },

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        backgroundColor: 'rgba(0,0,0,0.75)',
                        padding: [10, 15],
                        textStyle: {
                            fontSize: 13,
                            fontFamily: 'Roboto, sans-serif'
                        },
                        axisPointer: {
                            type: 'shadow',
                            shadowStyle: {
                                color: 'rgba(0,0,0,0.025)'
                            }
                        }
                    },

                    // Horizontal axis
                    xAxis: [{
                        type: 'value',
                        boundaryGap: [0, 10],
                        axisLabel: {
                            color: '#333'
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: '#eee',
                                type: 'dashed'
                            }
                        }
                    }],

                    // Vertical axis
                    yAxis: [{
                        type: 'category',
                        data: regions,
                        axisLabel: {
                            color: '#333'
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: ['#eee']
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.015)']
                            }
                        }
                    }],

                    // Add series
                    series: [
                        @foreach($productions as $product)
                        {
                            name: '{{$product->name}}',
                            type: 'bar',
                            itemStyle: {
                                normal: {
                                    color: '#EF5350'
                                }
                            },
                            data: [38203, 73489, 129034, 204970, 331744]
                        },
                        @endforeach
                        <?php
                            $i = 0;
                            foreach($productions as $product) :
                                $dataBind = [];
                                $x = 0;
                                foreach($resultsValue as $k => $v) {
                                    $dataBind[] = $v[$i];
                                }

                        ?>
                        {
                            name: '{{$product->name}}',
                            type: 'bar',
                            itemStyle: {
                            normal: {
                             color: '#EF5350'
                            }
                            },
                            data: <?= json_encode($dataBind) ?>
                        },
                        <?php
                            $i++;
                            endforeach;
                        ?>
                    ]
                });
            }
        });
    </script>
    <script src="/limitless/assets/js/app.js"></script>
    <script src="/limitless/global_assets/js/demo_pages/charts/echarts/bars_tornados.js"></script>
    <!-- Page header -->
    <div class="page-header page-header-light">


        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="#" class="breadcrumb-item">Chart</a>
                    <span class="breadcrumb-item active">Biểu đồ sử dụng theo khu vực</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">
    @include('admin.layouts.partitals.notify')

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Biểu đồ sử dụng theo địa phương</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart" id="bars_basic" style="height: 6300px; width: 1200px; background-color: rgba(0,0,255,.1)"></div>
                </div>
            </div>
        </div>


    </div>
    <!-- /content area -->

@endsection
