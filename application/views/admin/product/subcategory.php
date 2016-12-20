<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title ">Product Sub Category</h3>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-background">
                <!-- form start -->
                <form role="form" enctype="multipart/form-data"

                      action="<?php echo base_url(); ?>admin/product/save_subcategory/<?php
                      if (!empty($sub_category_info->subcategory_id)) {
                          echo $sub_category_info->subcategory_id;
                      }
                      ?>" method="post">

                    <div class="row">

                        <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                            <div class="box-body" >
                                <!-- /.category -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Category <span class="required">*</span></label>
                                    <select name="category_id" class="form-control col-sm-5" required>
                                        <option value="">Select Product Category</option>
                                        <?php if (!empty($all_category)): ?>
                                            <?php foreach ($all_category as $v_categogy) : ?>
                                                <option value="<?php echo $v_categogy->category_id; ?>"
                                                    <?php
                                                    if (!empty($sub_category_info->category_id)) {
                                                        echo $v_categogy->category_id == $sub_category_info->category_id ? 'selected' : '';
                                                    }
                                                    ?> >
                                                    <?php echo $v_categogy->category_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>

                                 </div>

                                <!-- /.category -->

                                <!-- /.subcategory -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Subcategory <span class="required">*</span></label>
                                    <input type="text" required name="subcategory_name" placeholder="Subcategory"
                                           value="<?php
                                           if (!empty($sub_category_info->subcategory_name)) {
                                               echo $sub_category_info->subcategory_name;
                                           }
                                           ?>"
                                           class="form-control">
                                </div>
                                <!-- /.subcategory -->

                                <button type="submit" class="btn bg-navy" type="submit">Save Subcategory
                                </button><br/><br/>
                            </div>
                            <!-- /.box-body -->

                        </div>
                    </div>

                </form>
                </div>
                <div class="box-footer">

                </div>

                <div class="row">

                    <div class="col-md-10 col-md-offset-1">

                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="dataTables-example">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="col-sm-1 active">SL</th>
                                <th class="active">Category</th>
                                <th class="active">Sub Category</th>
                                <th class="col-sm-1 active">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->
                            <?php $key = 1 ?>
                            <?php if (!empty($all_sub_category)): foreach ($all_sub_category as $v_sub_category) : ?><!--get all sub category if not this empty-->
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $v_sub_category->category_name ?></td>
                                    <td><?php echo $v_sub_category->subcategory_name ?></td>
                                    <td>
                                        <?php echo btn_edit('admin/product/subcategory/' . $v_sub_category->subcategory_id); ?>
                                        <?php echo btn_delete('admin/product/delete_subcategory/' . $v_sub_category->subcategory_id); ?>
                                    </td>

                                </tr>
                            <?php
                            $key++;
                            endforeach;
                            ?><!--get all sub category if not this empty-->
                            <?php else : ?> <!--get error message if this empty-->
                                <td colspan="4">
                                    <strong>There is no data to display</strong>
                                </td><!--/ get error message if this empty-->
                            <?php endif; ?>
                            </tbody><!-- / Table body -->
                        </table> <!-- / Table -->
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>



