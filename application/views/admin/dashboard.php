<?php
$info = $this->session->userdata('business_info');
if(!empty($info->currency))
{
    $currency = $info->currency ;
}else
{
    $currency = '$';
}
?>

<section class="content">

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <div class="col-md-9">
        <!-- MAP & BOX PANE -->
        <div class="box">
            <div class="box-header box-header-background with-border">
                <h3 class="box-title">Sales Report</h3>

            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-sm-8">
                        <p class="text-center">
                            <strong>Sales: 1 Jan, <?php echo date("Y") ?> - 31 Dec, <?php echo date("Y") ?></strong>
                        </p>
                        <div class="chart-responsive">
                            <!-- Sales Chart Canvas -->
                            <canvas width="860" style="width: 860px; height: 190px;" id="salesChart" height="300"></canvas>
                        </div><!-- /.chart-responsive -->
                    </div><!-- /.col -->
                    <div class="col-md-2 col-sm-4">
                        <div class="pad box-pane-right bg-green" style="min-height: 280px">
                            <div class="description-block margin-bottom">
                                <div class="sparkbar pad" data-color="#fff"><canvas height="30" width="34" style="display: inline-block; width: 34px; height: 30px; vertical-align: top;"></canvas></div>
                                <h5 class="description-header"><?php echo $currency .' '. number_format($total->selling_price - $total->buying_price - $discount->discount_amount ,2)  ?></h5>
                                <span class="description-text">TOTAL REVENUE</span>
                            </div><!-- /.description-block -->
                            <div class="description-block margin-bottom">
                                <div class="sparkbar pad" data-color="#fff"><canvas height="30" width="34" style="display: inline-block; width: 34px; height: 30px; vertical-align: top;"></canvas></div>
                                <h5 class="description-header"><?php echo $currency .' '. number_format($total->buying_price , 2)  ?></h5>
                                <span class="description-text">TOTAL COST</span>
                            </div><!-- /.description-block -->
                            <div class="description-block">
                                <div class="sparkbar pad" data-color="#fff"><canvas height="30" width="34" style="display: inline-block; width: 34px; height: 30px; vertical-align: top;"></canvas></div>
                                <h5 class="description-header"><?php echo $currency .' '. number_format($total->product_tax , 2)  ?></h5>
                                <span class="description-text">TOTAL TAX</span>
                            </div><!-- /.description-block -->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div><!-- /.col -->

    <div class="col-md-3">
        <!-- Info Boxes Style 2 -->
        <div class="info-box bg-yellow">


                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-qrcode"></i></span>
                    <div class="info-box-content box-color">
                        <span class="info-box-text">TOTAL PRODUCT</span>
                        <span class="info-box-number"><?php echo $total_product ?></span>
                        <a href="<?php echo base_url() ?>admin/product/manage_product" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->


        </div><!-- /.info-box -->
        <div class="info-box bg-green">
            <div class="info-box">
                <span class="info-box-icon bg-purple"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                <div class="info-box-content box-color">
                    <span class="info-box-text">TOTAL ORDER</span>
                    <span class="info-box-number"><?php echo $total_order ?></span>
                    <a href="<?php echo base_url() ?>admin/order/manage_order" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.info-box -->
        <div class="info-box bg-red">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-list-alt"></i></span>
                <div class="info-box-content box-color">
                    <span class="info-box-text">TOTAL INVOICE</span>
                    <span class="info-box-number"><?php echo $total_invoice ?></span>
                    <a href="<?php echo base_url() ?>admin/order/manage_invoice" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.info-box -->
        <div class="info-box bg-aqua">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-user"></i></span>
                <div class="info-box-content box-color">
                    <span class="info-box-text">TOTAL CUSTOMER</span>
                    <span class="info-box-number"><?php echo $total_customer?></span>
                    <a href="<?php echo base_url() ?>admin/customer/manage_customer" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
</div><!-- /.row -->



<div class="row">
    <div class="col-md-8">
        <!-- TABLE: LATEST ORDERS -->
        <div class="box">
            <div class="box-header box-header-background with-border">
                <h3 class="box-title">Latest Orders</h3>

            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Order Total</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if($order_info): foreach($order_info as $v_order): ?>
                            <tr>
                                <td><a href="<?php echo base_url()?>admin/order/view_order/<?php echo $v_order->order_no ?>">OR<?php echo $v_order->order_no ?></a></td>
                                <td><?php echo $v_order->customer_name ?></td>
                                <td><?php echo $v_order->order_date ?></td>
                                <td>
                                    <?php if($v_order->order_status == 0){ ?>
                                    <span class="label label-warning">PENDING</span>
                                <?php }elseif($v_order->order_status == 1){ ?>
                                    <span class="label label-danger">CANCEL</span>
                                <?php }else { ?>
                                    <span class="label label-info">CONFIRM</span>
                                <?php }?>

                                </td>
                                <td><?php echo $currency .' '. number_format($v_order->grand_total , 2)  ?></td>
                            </tr>
                        <?php endforeach;
                        else:?>
                            <tr style="column-span: 5">
                                <td><strong>Currently there is no order for display </strong></td>
                            </tr>

                        <?php endif ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <a href="<?php echo base_url() ?>admin/order/new_order" class="btn btn-sm bg-navy btn-flat pull-left">Place New Order</a>
                <a href="<?php echo base_url() ?>admin/order/manage_order" class="btn btn-sm bg-purple btn-flat pull-right">View All Orders</a>
            </div><!-- /.box-footer -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-4">
        <!-- PRODUCT LIST -->
        <div class="box box-primary">
            <div class="box-header box-header-background with-border">
                <h3 class="box-title">Recently Added Products</h3>
                          </div><!-- /.box-header -->
            <div class="box-body">
                <ul class="products-list product-list-in-box">

                    <?php
                    if(!empty($product_info)){
                   foreach($product_info as $v_product) {
                       ?>
                       <li class="item">
                           <div class="product-img">
                               <?php if(!empty($v_product->filename)){?>
                                   <img src="<?php echo base_url() . $v_product->filename ?>" alt="Product Image">
                               <?php }else{?>
                                   <img src="<?php echo base_url(); ?>img/product.png" class="img-circle" alt="Product Image"/>
                               <?php } ?>

                           </div>
                           <div class="product-info">
                               <a href="<?php echo base_url() ?>admin/product/manage_product"
                                  class="product-title">Barcode:<?php echo $v_product->product_code ?><span
                                       class="label label-warning pull-right"><?php echo $currency. $v_product->selling_price ?></span></a>
                        <span class="product-description">
                          <?php echo $v_product->product_name ?>
                        </span>
                           </div>
                       </li><!-- /.item -->
                   <?php
                   }}else{

                    ?>
                        <strong>Currently there is no recently added product </strong>
                    <?php }?>

                </ul>
            </div><!-- /.box-body -->
            <div class="box-footer text-center">
                <a href="<?php echo base_url() ?>admin/product/manage_product" class="uppercase">View All Products</a>
            </div><!-- /.box-footer -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->


</section>

<script>


    $(function () {

        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //-----------------------
        //- MONTHLY SALES CHART -
        //-----------------------

        // Get context with jQuery - using jQuery's .get() method.
        var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var salesChart = new Chart(salesChartCanvas);

        var salesChartData = {
            labels: [
                <?php foreach ($yearly_sales_report as $name => $v_result):
                    $month_name = date('F', strtotime($year . '-' . $name)); // get full name of month by date query
                    ?>
                "<?php echo $month_name; ?>", // echo the whole month of the year
                <?php endforeach; ?>
            ],
            datasets: [



                {
                    label: "My Second dataset",
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: [

                        <?php
                        foreach ($yearly_sales_report as $v_result):
                        ?>
                            "<?php
                                if (!empty($v_result)) {

                                    foreach($v_result as $result){

                                        echo round($result->grand_total);
                                    }
                                }
                                ?>",
                        <?php endforeach; ?>

                    ]
                }
            ]
            };

        var options = {
            animation: false,



            scaleLabel:
                function(label){return  ' $' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");}

        };

        var salesChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.4,
            //Boolean - Whether to show a dot for each point
            pointDot: true,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,

            // String - Template string for single tooltips
            tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= addCommas(value) %>",

            maintainAspectRatio: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,

            scaleLabel:
                function(label){return  ' <?php echo $currency ?>' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");}
        };

        //Create the line chart
        salesChart.Line(salesChartData, salesChartOptions);

        //---------------------------
        //- END MONTHLY SALES CHART -
        //---------------------------


    });

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }


</script>


