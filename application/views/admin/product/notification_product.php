<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <form action="<?php echo base_url() ?>admin/product/product_action" method="post">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">

                        <h3 class="box-title ">Notification Product</h3>

                </div>


                <div class="box-body">

                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="dataTables-example">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active">Image</th>
                                <th class="active">Code</th>
                                <th class="active">Product Name</th>
                                <th class="active">Stock Available</th>
                                <th class="active">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->

                            <?php
                            $notify_product = $_SESSION["notify_product"];
                            if (!empty($notify_product)): foreach ($notify_product as $v_product) : ?>
                                <tr class="custom-tr">
                                    <td class="product-img">
                                        <?php if (!empty($v_product->filename)):  ?>
                                            <img src="<?php echo base_url() . $v_product->filename ?>" />
                                        <?php else:?>
                                            <img src="<?php echo base_url() ?>img/product.png" alt="Product Image">
                                        <?php endif; ?>
                                    </td>
                                    <td class="vertical-td"><?php echo $v_product->product_code ?></td>
                                    <td class="vertical-td"><?php echo $v_product->product_name ?></td>
                                    <td class="vertical-td">
                                        <?php
                                            if($v_product->notify_quantity >= $v_product->product_quantity)
                                            { ?>
                                                <span class="label label-warning"><?php echo $v_product->product_quantity ?></span>
                                        <?php } else { ?>
                                                <?php echo $v_product->product_quantity ?>
                                                <?php } ?>

                                    </td>

                                    <td class="vertical-td">
                                        <?php echo btn_view_modal('admin/product/view_product/' . $v_product->product_id); ?>
                                        <?php echo btn_edit('admin/product/add_product/' . $v_product->product_id); ?>
                                    </td>

                                </tr>
                            <?php

                            endforeach;
                            ?><!--get all sub category if not this empty-->
                            <?php else : ?> <!--get error message if this empty-->
                                <td colspan="8">
                                    <strong>There is no data to display</strong>
                                </td><!--/ get error message if this empty-->
                            <?php endif; ?>
                            </tbody><!-- / Table body -->
                        </table> <!-- / Table -->

                </div><!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
        </form>
    </div>
    <!-- /.row -->
</section>

<script>
    $('body').on('hidden.bs.modal', '.modal', function() {
        $(this).removeData('bs.modal');
    });

</script>



