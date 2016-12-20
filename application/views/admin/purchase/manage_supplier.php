<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary ">
                <div class="box-header box-header-background with-border">
                        <h3 class="box-title ">Manage Supplier</h3>
                </div>


                <div class="box-body">

                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="dataTables-example">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active ">Sl</th>
                                <th class="active">Company Name</th>
                                <th class="active">Supplier Name</th>
                                <th class="active">Email</th>
                                <th class="active">Phone</th>

                                <th class="active">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->
                            <?php $counter =1 ; ?>
                            <?php if (!empty($supplier)): foreach ($supplier as $v_supplier) : ?>
                                <tr class="custom-tr">
                                    <td class="vertical-td">
                                        <?php echo  $counter ?>
                                    </td>
                                    <td class="vertical-td"><?php echo $v_supplier->company_name ?></td>
                                    <td class="vertical-td"><?php echo $v_supplier->supplier_name ?></td>
                                    <td class="vertical-td"><?php echo $v_supplier->email ?></td>
                                    <td class="vertical-td"><?php echo $v_supplier->phone ?></td>


                                    <td class="vertical-td">
                                        <?php echo btn_view('admin/purchase/supplier_history/' . $v_supplier->supplier_id); ?>
                                        <?php echo btn_edit('admin/purchase/add_supplier/' . $v_supplier->supplier_id); ?>
                                        <?php echo btn_delete('admin/purchase/delete_supplier/' . $v_supplier->supplier_id); ?>
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




