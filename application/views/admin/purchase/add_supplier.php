<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title ">Add New Supplier</h3>
                    </div>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <form role="form" enctype="multipart/form-data" id="addSupplierForm"
                      action="<?php echo base_url(); ?>admin/purchase/save_supplier/<?php if (!empty($supplier->supplier_id)) {
                          echo $supplier->supplier_id;
                      } ?>"
                      method="post">

                    <div class="row">

                        <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                            <div class="box-body">

                                <!-- /.Company Name -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Company Name <span class="required">*</span></label>
                                    <input type="text" name="company_name" placeholder="Company Name"
                                           value="<?php
                                           if (!empty($supplier->company_name)) {
                                               echo $supplier->company_name;
                                           }
                                           ?>"
                                           class="form-control">
                                </div>

                                <!-- /.Company Name -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Supplier Name <span class="required">*</span></label>
                                    <input type="text" name="supplier_name" placeholder="Supplier Name"
                                           value="<?php
                                           if (!empty($supplier->supplier_name)) {
                                               echo $supplier->supplier_name;
                                           }
                                           ?>"
                                           class="form-control">
                                </div>

                                <!-- /.Company Email -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email <span
                                            class="required">*</span></label>
                                    <input type="text" placeholder="Email" name="email"
                                           value="<?php
                                           if (!empty($supplier->email)) {
                                               echo $supplier->email;
                                           }
                                           ?>"
                                           class="form-control">
                                </div>

                                <!-- /.Phone -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phone<span class="required"> *</span></label>
                                    <input type="text" placeholder="Phone" name="phone"
                                           value="<?php
                                           if (!empty($supplier->phone)) {
                                               echo $supplier->phone;
                                           }
                                           ?>"
                                           class="form-control">
                                </div>

                                <!-- /.Address -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address <span class="required">*</span></label>
                                    <textarea name="address" class="form-control autogrow" rows="10" id="ck_editor"
                                              placeholder="Business Address" required><?php
                                        if (!empty($supplier->address)) {
                                            echo $supplier->address;
                                        }
                                        ?></textarea>
                                    <?php echo display_ckeditor($editor['ckeditor']); ?>
                                </div>



                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn bg-navy col-md-offset-3" type="submit">Add Supplier
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>
