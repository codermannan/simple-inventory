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
        <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo"><b>Easy</b>Inventory</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->


            <div class="navbar-custom-menu pull-right">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <?php
                    if(!empty($_SESSION["notify_product"]))
                    {
                        $notify_product = $_SESSION["notify_product"];
                        $notify_product_count = count($notify_product);
                    }
                    ?>



                    <!-- Notifications: style can be found in dropdown.less -->

                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger"><?php if(!empty($notify_product_count)){
                                    echo $notify_product_count;
                                }else{
                                    echo '0';
                                }
                                ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">
                                <?php if(!empty($notify_product_count)){
                                    echo $notify_product_count;
                                }else{
                                    echo '0';
                                }
                                ?>
                                Product are running out of stock</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">

                                    <?php
                                    if(!empty($notify_product)){
                                    foreach($notify_product as $v_notify_product){
                                        ?>

                                        <li><!-- start message -->
                                            <a href="<?php echo base_url()?>admin/product/add_product/<?php echo $v_notify_product->product_id ?>">
                                                <div class="pull-left">
                                                    <?php if(!empty($v_notify_product->filename)){?>
                                                        <img src="<?php echo base_url() . $v_notify_product->filename; ?>" class="img-circle" alt="Product Image"/>
                                                    <?php }else{?>
                                                        <img src="<?php echo base_url(); ?>img/product.png" class="img-circle" alt="Product Image"/>
                                                    <?php } ?>
                                                </div>
                                                <h4 style="padding-bottom:6px">
                                                    <?php echo 'Barcode:'.$v_notify_product->product_code  ?>
                                                    <span class="label label-danger">Qty:<?php echo $v_notify_product->product_quantity  ?></span>
                                                </h4>
                                                <p><?php echo $v_notify_product->product_name  ?></p>
                                            </a>
                                        </li><!-- end message -->

                                    <?php }; } ?>


                                </ul>
                            </li>
                            <li class="footer"><a href="<?php echo base_url() ?>admin/product/notification_product">See All Notification</a></li>
                        </ul>
                    </li>

                    <?php
                    $pending_order = $_SESSION["pending_order"];
                    $pending_order_count = count($pending_order);
                    ?>

                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning"><?php echo $pending_order_count ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo $pending_order_count ?> Pending Order</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">

                                    <?php
                                    foreach($pending_order as $v_pending_order){
                                        ?>

                                        <li><!-- start message -->
                                            <a href="<?php echo base_url()?>admin/order/view_order/<?php echo $v_pending_order->order_no ?>">
                                                <h4 style="padding-bottom:6px">
                                                    <?php echo $v_pending_order->order_no ?> <small>Order Date:  <?php echo date('Y-m-d', strtotime($v_pending_order->order_date ))?></small>
                                                </h4>
                                                <p><?php echo $currency .' '. number_format($v_pending_order->grand_total,2)  ?></p>
                                            </a>
                                        </li><!-- end message -->

                                    <?php } ?>


                                </ul>
                            </li>
                            <li class="footer"><a href="<?php echo base_url() ?>admin/order/pending_order">See All Pending Order</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?php echo base_url()?>login/logout" >
                            <span class="glyphicon glyphicon-off"></span> Logout
                        </a>

                    </li>


                </ul>
            </div>


        </nav>
      </header>