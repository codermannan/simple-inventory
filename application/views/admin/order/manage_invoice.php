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
                        <h3 class="box-title ">Manage Invoice</h3>
                    <div class="box-tools">
                            <a onclick="print_invoice('printableArea')" class="btn btn-default">Print</a>

                    </div>
                </div>



                <div class="box-body">


                    <div id="printableArea">
                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="dataTables-example">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active">Sl</th>
                                <th class="active">Invoice No.</th>
                                <th class="active">Order No.</th>
                                <th class="active">Invoice Date</th>
                                <th class="active">Customer</th>
                                <th class="active">Payment Method</th>
                                <th class="active">Order Total</th>
                                <th class="active">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->
                            <?php $counter =1 ; ?>
                            <?php if (!empty($invoice)): foreach ($invoice as $v_invoice) : ?>
                                <tr class="custom-tr">
                                    <td class="vertical-td">
                                        <?php echo  $counter ?>
                                    </td>
                                    <td class="vertical-td">INV-<?php echo $v_invoice->invoice_no ?></td>
                                    <td class="vertical-td">ORD-<?php echo $v_invoice->order_no ?></td>
                                    <td class="vertical-td"><?php echo date('Y-m-d', strtotime($v_invoice->invoice_date)) ?></td>
                                    <td class="vertical-td"><?php echo $v_invoice->customer_name ?></td>
                                    <td class="vertical-td"><?php echo $v_invoice->payment_method ?></td>
                                    <td class="vertical-td"><?php echo $currency .' '. number_format($v_invoice->grand_total,2)  ?></td>

                                    <td class="vertical-td">
                                        <?php echo btn_view('admin/order/order_invoice/' . $v_invoice->invoice_no); ?>
                                    </td>

                                </tr>
                            <?php
                                $counter++;
                            endforeach;
                            ?><!--get all sub category if not this empty-->
                            <?php else : ?> <!--get error message if this empty-->
                                <td colspan="8">
                                    <strong>There is no record for display</strong>
                                </td><!--/ get error message if this empty-->
                            <?php endif; ?>
                            </tbody><!-- / Table body -->
                        </table> <!-- / Table -->
                        </div>

                </div><!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>



