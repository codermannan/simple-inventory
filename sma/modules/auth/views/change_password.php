<!-- Errors -->
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>


<h3 class="title"><?php echo $page_title; ?></h3>

<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=auth&view=change_password", $attrib);?>
<div class="control-group">
  <label class="control-label" for="old_password"><?php echo $this->lang->line("old_pw"); ?></label>
  <div class="controls"> <?php echo form_input($old_password , '', 'class="span4" id="old_password"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="new_password"><?php echo $this->lang->line("new_pw"); ?></label>
  <div class="controls"> <?php echo form_input($new_password , '', 'class="span4" id="new_password"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="new_password_confirm"><?php echo $this->lang->line("confirm_pw"); ?></label>
  <div class="controls"> <?php echo form_input($new_password_confirm , '', 'class="span4" id="new_password_confirm"');?> </div>
</div>
<?php echo form_input($user_id);?>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("change_password"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 