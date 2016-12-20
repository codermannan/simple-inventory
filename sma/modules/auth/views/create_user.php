<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(function() {
	$('form').form();
	$(".user-role .btn").click(function() {
    	$("#role").val($(this).val()); 
	});
	$("form").submit(function () { 
			if($("#role").val() == "") {
				alert("<?php echo $this->lang->line('select_user_role'); ?>");
				return false;
			}
			if ($("#password").val() != $("#password_confirm").val()) { 
				alert ('The passwords do not match!');
				return false; 
			} 
	}); 
});
</script>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<h3 class="title"><?php echo $this->lang->line("create_user"); ?></h3>
<p><?php echo $this->lang->line("enter_user_info"); ?></p>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=auth&view=create_user", $attrib);?>
<div class="control-group">
  <label class="control-label" for="first_name"><?php echo $this->lang->line("first_name"); ?></label>
  <div class="controls"> <?php echo form_input($first_name, '', 'class="span4" pattern=".{2,55}" required="required" data-error="'.$this->lang->line("first_name").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="last_name"><?php echo $this->lang->line("last_name"); ?></label>
  <div class="controls"> <?php echo form_input($last_name, '', 'class="span4" pattern=".{2,55}" required="required" data-error="'.$this->lang->line("last_name").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="company"><?php echo $this->lang->line("company"); ?></label>
  <div class="controls"> <?php echo form_input($company, '', 'class="span4" required="required" data-error="'.$this->lang->line("company").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="phone"><?php echo $this->lang->line("phone"); ?></label>
  <div class="controls"> <?php /* echo form_input($phone, '', 'class="span4" required="required" data-error="'.$this->lang->line("phone").' '.$this->lang->line("is_required").'"'); */?> 
  <input type="tel" name="phone" class="span4" pattern="[0-9]{7,15}" required="required" data-error="<?php echo $this->lang->line("phone").' '.$this->lang->line("is_required"); ?>" /></div>
</div>
<div class="control-group">
  <label class="control-label" for="email"><?php echo $this->lang->line("email_address"); ?></label>
  <div class="controls"> <?php /* echo form_input($email, '', 'class="span4" required="required" data-error="'.$this->lang->line("date").' '.$this->lang->line("is_required").'"'); */?> 
  <input type="email" name="email" class="span4" required="required" data-error="<?php echo $this->lang->line("email_address").' '.$this->lang->line("is_required"); ?>" /></div>
</div>
<div class="control-group">
  <label class="control-label" for="role"><?php echo $this->lang->line("user_role"); ?></label>
  <div class="controls">
      <div class="btn-group user-role" data-toggle="buttons-radio">
    <button type="button" value="1" class="btn"><?php echo $this->lang->line("owner"); ?></button>
    <button type="button" value="2" class="btn"><?php echo $this->lang->line("admin"); ?></button>
    <button type="button" value="3" class="btn"><?php echo $this->lang->line("purchaser"); ?></button>
    <button type="button" value="4" class="btn"><?php echo $this->lang->line("salesman"); ?></button>
    <button type="button" value="5" class="btn"><?php echo $this->lang->line("user"); ?></button>
    </div>
    <input type="hidden" name="role" id="role" value="<?php /* echo $group->group_id; */ ?>">
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="password"><?php echo $this->lang->line("pw"); ?></label>
  <div class="controls"> <?php echo form_input($password , '', 'class="password span4" id="password" pattern=".{8,55}" required="required" data-error="'.$this->lang->line("pw").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="confirm_pw"><?php echo $this->lang->line("confirm_pw"); ?></label>
  <div class="controls"> <?php echo form_input($password_confirm , '', 'class="password span4" id="confirm_pw" pattern=".{8,55}" required="required" data-error="'.$this->lang->line("confirm_pw").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("add_user"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 