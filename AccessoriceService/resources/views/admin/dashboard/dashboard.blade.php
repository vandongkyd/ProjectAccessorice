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
                    <h2>3,000,000.00</h2>
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
                            <h5 class="title">Total Sale</h5>
                            <h3 class="value text-secondary">$5000,000</h3>
                        </div>
                        <div class="chart-legend-1 col-12 col-sm-4">
                            <h5 class="title">Total View</h5>
                            <h3 class="value text-primary">10000,000</h3>
                        </div>
                        <div class="chart-legend-1 col-12 col-sm-4">
                            <h5 class="title">Total Support</h5>
                            <h3 class="value text-warning">100,000</h3>
                        </div>
                    </div>
                    <div class="chartjs-revenue-statistics-chart">
                        <canvas id="chartjs-revenue-statistics-chart"></canvas>
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
                        <canvas id="chartjs-market-trends-chart"></canvas>
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
                                <th class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i class="icon"></i></label></th>
                                <!--<th class="selector h5"><button class="button-check"></button></th>-->
                                <th><span>Image</span></th>
                                <th><span>Product Name</span></th>
                                <th><span>ID</span></th>
                                <th><span>Quantity</span></th>
                                <th><span>Price</span></th>
                                <th><span>Status</span></th>
                                <th></th>
                            </tr>
                            </thead><!-- Table Head End -->

                            <!-- Table Body Start -->
                            <tbody>
                            <tr>
                                <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i class="icon"></i></label></td>
                                <td><img src="assets/images/product/list-product-1.jpg" alt="" class="table-product-image rounded-circle"></td>
                                <td><a href="#">Microsoft surface pro 4</a></td>
                                <td>#MSP40022</td>
                                <td>05 - Products</td>
                                <td>$60000000.00</td>
                                <td><span class="badge badge-success">Paid</span></td>
                                <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                            </tr>
                            <tr class="selected">
                                <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i class="icon"></i></label></td>
                                <td><img src="assets/images/product/list-product-2.jpg" alt="" class="table-product-image rounded-circle"></td>
                                <td><a href="#">Microsoft surface pro 4</a></td>
                                <td>#MSP40022</td>
                                <td>05 - Products</td>
                                <td>$60000000.00</td>
                                <td><span class="badge badge-success">Paid</span></td>
                                <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                            </tr>
                            <tr>
                                <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i class="icon"></i></label></td>
                                <td><img src="assets/images/product/list-product-3.jpg" alt="" class="table-product-image rounded-circle"></td>
                                <td><a href="#">Microsoft surface pro 4</a></td>
                                <td>#MSP40022</td>
                                <td>05 - Products</td>
                                <td>$60000000.00</td>
                                <td><span class="badge badge-warning">Due</span></td>
                                <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                            </tr>
                            <tr>
                                <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i class="icon"></i></label></td>
                                <td><img src="assets/images/product/list-product-4.jpg" alt="" class="table-product-image rounded-circle"></td>
                                <td><a href="#">Microsoft surface pro 4</a></td>
                                <td>#MSP40022</td>
                                <td>05 - Products</td>
                                <td>$60000000.00</td>
                                <td><span class="badge badge-danger">Reject</span></td>
                                <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                            </tr>
                            </tbody><!-- Table Body End -->

                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Recent Transaction End -->

    </div>
@stop