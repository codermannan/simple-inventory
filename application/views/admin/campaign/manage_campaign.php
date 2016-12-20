<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary ">
                <div class="box-header box-header-background with-border">
                        <h3 class="box-title ">Manage Campaign</h3>
                </div>


                <div class="box-body">

                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="dataTables-example">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active">Sl</th>
                                <th class="active">Campaign Name</th>
                                <th class="active">Email Subject</th>
                                <th class="active">Create Date</th>
                                <th class="active">Created by</th>
                                <th class="active ">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->
                            <?php $counter =1 ; ?>
                            <?php if (!empty($campaign)): foreach ($campaign as $v_campaign) : ?>
                                <tr class="custom-tr">
                                    <td class="vertical-td">
                                        <?php echo  $counter ?>
                                    </td>
                                    <td class="vertical-td"><?php echo $v_campaign->campaign_name ?></td>
                                    <td class="vertical-td"><?php echo $v_campaign->subject ?></td>
                                    <td class="vertical-td"><?php echo date('Y-m-d', strtotime($v_campaign->date )) ?></td>
                                    <td class="vertical-td"><?php echo $v_campaign->created_by ?></td>


                                    <td class="vertical-td" id="sendEmail">
                                        <form method="post" action="<?php echo base_url() ?>admin/campaign/send_email" >
                                        <?php echo btn_view_modal('admin/campaign/view_email/' . $v_campaign->campaign_id); ?>
                                        <?php echo btn_edit('admin/campaign/new_campaign/' . $v_campaign->campaign_id); ?>
                                            <button type="submit" data-original-title="Send Email"   class="btn bg-purple btn-xs" onclick="return confirm('Are you sure you want to Send this email all of your customer ?');" data-toggle="tooltip" data-placement="top"><i class="glyphicon glyphicon-envelope"></i></button>
                                        <?php echo btn_delete('admin/campaign/delete_campaign/' . $v_campaign->campaign_id); ?>
                                            <input type="hidden" name="campaign_id" value="<?php echo $v_campaign->campaign_id ?>">
                                        </form>
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

<!--<script src="--><?php //echo base_url(); ?><!--asset/js/ajax.js" type="text/javascript" charset="utf-8"></script>-->


