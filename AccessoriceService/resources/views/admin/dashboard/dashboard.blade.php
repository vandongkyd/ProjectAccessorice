@extends('admin.layout.layout_manage_default')


@section('title', 'Accessories | '.__('messages.lbl_screen_menu.dashboard'))


@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.dashboard')}}</h3>
@stop

@section('content-body')
    <div class="row">
        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Total Invoice</h4>
                    <a href="#" class="view"><i class="fa fa-file-text fontsize76"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h2>{{ count($invoices) }}</h2>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <p>
                        <span>New:</span> <span>12</span> <span> - </span>
                        <span>In Progress:</span> <span>12</span> <span> - </span>
                        <span>Shipping:</span> <span>12</span> <span> - </span>
                        <span>Done:</span> <span>12</span>
                    </p>
                </div>
            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Total Product</h4>
                    <a href="#" class="view"><i class="fa fa-cube fontsize76"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h2>{{ count($products) }}</h2>
                </div>

                <div class="footer">
                    <p>
                        <span>New:</span> <span>12</span> <span> - </span>
                        <span>In Progress:</span> <span>12</span> <span> - </span>
                        <span>Shipping:</span> <span>12</span> <span> - </span>
                        <span>Done:</span> <span>12</span>
                    </p>
                </div>
            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Customer</h4>
                    <a href="#" class="view"><i class="fa fa-users fontsize76"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h2>{{ count($customers) }}</h2>
                </div>
            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Total Revenue</h4>
                    <a href="#" class="view"><i class="fa fa-money fontsize76"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h2>{{number_format($totalReport['subtotal'])}}</h2>
                </div>

            </div>
        </div>
    </div>

    <div class="row mbn-30">

        <!-- Revenue Statistics Chart Start -->
        <div class="col-md-8 mb-30">
            <div class="box">
                <div class="box-head">
                    <h4 class="title">Revenue Statistics</h4>
                </div>
                <div class="box-body">
                    <div class="chart-legends-1 row">
                        <div class="chart-legend-1 col-12 col-sm-4">
                            <h5 class="title">Total Revenue</h5>
                            <h5 class="value text-secondary">{{number_format($totalReport['subtotal'])}}</h5>
                        </div>
                        <div class="chart-legend-1 col-12 col-sm-4">
                            <h5 class="title">Revenue Order New</h5>
                            <h5 class="value text-primary">{{number_format($totalReport['new'])}}</h5>
                        </div>
                        <div class="chart-legend-1 col-12 col-sm-4">
                            <h5 class="title">Revenue Order In Progress</h5>
                            <h5 class="value text-success">{{number_format($totalReport['inprogress'])}}</h5>
                        </div>
                        <div class="chart-legend-1 col-12 col-sm-4">
                            <h5 class="title">Revenue Order Shipping</h5>
                            <h5 class="value text-info">{{number_format($totalReport['shipping'])}}</h5>
                        </div>
                        <div class="chart-legend-1 col-12 col-sm-4">
                            <h5 class="title">Revenue Order Done</h5>
                            <h5 class="value text-warning">{{number_format($totalReport['done'])}}</h5>
                        </div>
                    </div>
                    <div class="chartjs-revenue-statistics-chart">
                        <canvas id="chart-revenue"></canvas>
                    </div>
                </div>
            </div>
        </div><!-- Revenue Statistics Chart End -->

        <!-- Market Trends Chart Start -->
        <div class="col-md-4 mb-30">
            <div class="box">
                <div class="box-head">
                    <h4 class="title">Market Trends</h4>
                </div>
                <div class="box-body">
                    <div class="chartjs-market-trends-chart">
                        <canvas id="chart-market"></canvas>
                    </div>
                </div>
            </div>
        </div><!-- Market Trends Chart End -->

        <!-- Recent Transaction Start -->
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h4 class="title">Recent Transaction</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-vertical-middle table-selectable">

                            <!-- Table Head Start -->
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>{{__('messages.lbl_table_invoice.no')}}</th>
                                <th>{{__('messages.lbl_table_invoice.recipient_name')}}</th>
                                <th>{{__('messages.lbl_table_invoice.phone')}}</th>
                                <th class="no-sort">{{__('messages.lbl_table_invoice.invoice_status')}}</th>
                                <th class="no-sort">{{__('messages.lbl_table_invoice.payment_status')}}</th>
                                <th>{{__('messages.lbl_table_invoice.purchase_date')}}</th>
                            </tr>
                            </thead><!-- Table Head End -->

                            <!-- Table Body Start -->
                            <tbody>
                            @foreach($recentTran as $invoice)
                                <tr>
                                    <td>{{$invoice->id}}</td>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->recipient_name }}</td>
                                    <td>{{$invoice->phone}}</td>
                                    {{--<td>{{$invoice->address}}</td>--}}
                                    <td>
                                        @foreach(__('messages.lbl_invoice_active') as $key => $value)
                                            @if($key == $invoice->invoice_status)
                                                <p class="pt-2 pb-2 badge badge-outline {{$key == 0 ? 'badge-primary' : 'badge-success'}} w-75">{{$value}}</p>
                                            @endif
                                        @endforeach</td>
                                    <td>
                                        @foreach(__('messages.lbl_payment_active') as $key => $value)
                                            @if($key == $invoice->payment_status)
                                                <p class="pt-2 pb-2 badge badge-outline {{$key == 0 ? 'badge-danger' : 'badge-success'}} w-50">{{$value}}</p>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{date('d/m/Y', $invoice->purchase_date)}}</td>
                                </tr>
                            @endforeach
                            </tbody><!-- Table Body End -->

                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Recent Transaction End -->
    </div>
@stop

@section('after_script')
    <script>
        var list = {!! $totalRe !!}
        var renew = {!! $totalReNew !!}
        var reinpro = {!! $totalReIn !!}
        var reship = {!! $totalReShip !!}
        var redone = {!! $totalReDone !!}
        var labels = [];
        var datanew = [];
        var datain = [];
        var dataship = [];
        var datadone = [];

        list.forEach(function (abc) {
            labels.push(abc.total_amount);
        });
        renew.forEach(function (abc) {
            datanew.push(abc.total_amount);
        });
        reinpro.forEach(function (abc) {
            datain.push(abc.total_amount);
        });
        reship.forEach(function (abc) {
            dataship.push(abc.total_amount);
        });
        redone.forEach(function (abc) {
            datadone.push(abc.total_amount);
        });
        if( $('#chart-revenue').length ) {
            var ECBV = document.getElementById('chart-revenue').getContext('2d');
            var ECBVconfig = {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Revenue Order New',
                            data: datanew,
                            backgroundColor: '#428bfa',
                            fill: false,
                        }
                        ,{
                            label: 'Revenue Order In Progress',
                            data: datain,
                            backgroundColor: '#29db2d',
                            fill: false,
                        },
                        {
                            label: 'Revenue Order Shipping',
                            data: dataship,
                            backgroundColor: '#17a2b8',
                            fill: false,
                        },
                        {
                            label: 'Revenue Order Done',
                            data: datadone,
                            backgroundColor: '#ff9666',
                            fill: false,
                        }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        labels: {
                            fontColor: '#aaaaaa',
                        }
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                color: 'rgba(136,136,136,0.1)',
                                lineWidth: 1,
                                drawBorder: false,
                                zeroLineWidth: 1,
                                zeroLineColor: 'rgba(136,136,136,0.1)',
                            },
                            ticks: {
                                fontColor: '#aaaaaa',
                            },
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                color: 'rgba(136,136,136,0.1)',
                                lineWidth: 1,
                                drawBorder: false,
                                zeroLineWidth: 1,
                                zeroLineColor: 'rgba(136,136,136,0.1)',
                            },
                            ticks: {
                                fontColor: '#aaaaaa',
                            },
                        }]
                    }
                }
            };
            var ECBVchartjs = new Chart(ECBV, ECBVconfig);
        }

        if( $('#chart-market').length ) {
            var customer = {!! count($customers) !!};
            var products = {!! count($products) !!};
            var totals = {!! count($invoices) !!};
            var MTC = document.getElementById('chart-market').getContext('2d');
            var MTCconfig = {
                type: 'doughnut',
                data: {
                    labels: ['Customer', 'Invoice', 'Product'],
                    datasets: [{
                        data: [customer, totals,products],
                        backgroundColor: [
                            '#fb7da4',
                            '#7dfb9b',
                            '#ff9666',
                        ],
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        labels: {
                            boxWidth: 30,
                            padding: 20,
                            fontColor: '#aaaaaa',
                        }
                    },
                    tooltips: {
                        mode: 'point',
                        intersect: false,
                        xPadding: 10,
                        yPadding: 10,
                        caretPadding: 10,
                        cornerRadius: 4,
                        titleFontSize: 0,
                        titleMarginBottom: 2,
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    },
                }
            };
            var MTCchartjs = new Chart(MTC, MTCconfig);
        }
    </script>
@endsection