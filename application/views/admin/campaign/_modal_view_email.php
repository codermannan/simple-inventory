<?php
//company logo
if(!empty($info->logo)){
    $logo = $info->logo;
}else{
    $logo = 'img/logo.png';
}

//company details
if(!empty($info->company_name)){
    $company_name = $info->company_name;
}else{
    $company_name = 'Your Company Name';
}
//company phone
if(!empty($info->phone)){
    $company_phone = $info->phone;
}else{
    $company_phone = 'Company Phone';
}
//company email
if(!empty($info->email)){
    $company_email = $info->email;
}else{
    $company_email = 'Company Email';
}
//company address
if(!empty($info->address)){
    $address = $info->address;
}else{
    $address = 'Company Address';
}



?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $campaign->campaign_name ?></h4>
</div>
<div class="modal-body wrap-modal wrap" style="max-height: 900px;">





    <div class="row">

        <div class="col-sm-12">
            <?php $info = $this->session->userdata('business_info');?>
            <table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="100" style="background-color:#eeeeee; border-top:solid 10px #333333">
                        <img width="196" height="60" src="<?php  echo base_url(). $logo ?>" alt="logo" style="padding-top: 5px; padding-bottom: 5px; padding-left:10px">
                    </td>
                </tr>
                <tr>
                    <td height="31" valign="top" style="padding:20px">
                        <?php if(!empty($campaign->email_body)) echo $campaign->email_body  ?>
                    </td>
                </tr>
                <tr>
                    <td height="50" style="background-color:#eeeeee; border-bottom:solid 5px #333333; text-align:center; font-size:12px; color:#666">
                        <strong><?php echo $company_name?></strong>&nbsp;&nbsp;&nbsp;<?php echo $address ?>
                    </td>
                </tr>
            </table>

        </div>
    </div>




    <div class="modal-footer" >

            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <a href="<?php echo base_url(); ?>admin/campaign/new_campaign/<?php echo $campaign_id ?>" type="button" class="btn btn-primary">Edit Email</a>

        </div>

</div>


