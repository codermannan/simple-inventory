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
<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary ">
                <div class="box-header box-header-background with-border">
                        <h3 class="box-title ">Pending Order</h3>
                </div>


                <div class="box-body">

                        <!-- Table -->
                        <table class="table table-bordered table-hover" id="dataTables-example">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active">Sl</th>
                                <th class="active">Order No</th>
                                <th class="active">Order Date</th>
                                <th class="active">Order Status</th>
                                <th class="active">Order Total</th>
                                <th class="active">Sales By</th>
                                <th class="active">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->
                            <?php $counter =1 ; ?>
                            <?php
                            $pending_order = $_SESSION["pending_order"];
                            if (!empty($pending_order)): foreach ($pending_order as $v_order) : ?>
                                <tr class="custom-tr">
                                    <td class="vertical-td">
                                        <?php echo  $counter ?>
                                    </td>
                                    <td class="vertical-td">OR<?php echo $v_order->order_no ?></td>
                                    <td class="vertical-td"><?php echo date('Y-m-d', strtotime($v_order->order_date ))?></td>
                                    <td class="vertical-td">
                                        <?php
                                          if($v_order->order_status == 0){
                                              echo 'Pending Order';
                                          }elseif($v_order->order_status == 1){
                                              echo 'Cancel Order';
                                        }else{
                                            echo 'Confirm Order';
                                        }
                                        ?>
                                    </td>
                                    <td class="vertical-td"><?php echo $currency .' '. number_format($v_order->grand_total,2)  ?></td>
                                    <td class="vertical-td"><?php echo $v_order->sales_person ?></td>

                                    <td class="vertical-td">
                                        <?php echo btn_edit('admin/order/view_order/' . $v_order->order_no); ?>

                                    </td>

                                </tr>
                            <?php
                                $counter++;
                            endforeach;
                            ?><!--get all sub category if not this empty-->
                            <?php else : ?> <!--get error message if this empty-->
                                <td colspan="6">
                                    <strong>There is no record for display</strong>
                                </td><!--/ get error message if this empty-->
                            <?php endif; ?>
                            </tbody><!-- / Table body -->
                        </table> <!-- / Table -->

                </div><!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>




