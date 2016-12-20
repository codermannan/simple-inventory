<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('form').form();
});
</script>
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-fileupload.css" rel="stylesheet">
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
<h3 class="title"><?php echo $page_title; ?></h3>
<p><?php echo $this->lang->line("enter_info"); ?></p>
<div class="row-fluid">
<div class="span6">
<?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("module=settings&view=change_logo", $attrib); ?>
<div class="control-group">
  <label class="control-label" for="header_image"><?php echo $this->lang->line("header_logo"); ?></label>
  <div class="controls">
    <div class="fileupload fileupload-new" data-provides="fileupload"> 
    <span class="btn btn-file"><span class="fileupload-new"><?php echo $this->lang->line("select_image"); ?></span><span class="fileupload-exists"><?php echo $this->lang->line("chnage"); ?></span>
      <input type="file" name="userfile" id="header_image" required="required" data-error="<?php echo $this->lang->line("header_logo")." ".$this->lang->line("is_required"); ?>" />
      </span> <span class="fileupload-preview"></span> <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a> </div>
    <span class="help-block"><?php echo $this->lang->line('new_logo_tip'); ?></span> </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("upload_logo"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
</div>
<div class="span6">
<?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("module=settings&view=change_login_logo", $attrib); ?>
<div class="control-group">
  <label class="control-label" for="login_image"><?php echo $this->lang->line("login_logo"); ?></label>
  <div class="controls">
    <div class="fileupload fileupload-new" data-provides="fileupload"> 
    <span class="btn btn-file"><span class="fileupload-new"><?php echo $this->lang->line("select_image"); ?></span><span class="fileupload-exists"><?php echo $this->lang->line("chnage"); ?></span>
      <input type="file" name="userfile" id="login_image" required="required" data-error="<?php echo $this->lang->line("login_logo")." ".$this->lang->line("is_required"); ?>" />
      </span> <span class="fileupload-preview"></span> <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a> </div>
    <span class="help-block"><?php echo $this->lang->line('biller_logo_tip'); ?></span> </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("upload_logo"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?>
</div>
</div>