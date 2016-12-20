<script type="text/javascript">
$(function() {
	$(".user-role .btn").click(function() {
    // whenever a button is clicked, set the hidden helper
    $("#role").val($(this).val());
}); 
});
</script>
<!-- Errors -->
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<h3 class="title"><?php echo $page_title ?></h3>
<p><?php echo $this->lang->line("update_user_info"); ?></p>
<?php $first_name = array(
              'name'        => 'first_name',
              'id'          => 'first_name',
			  'placeholder' => "First Name",
              'value'       => $user->first_name,
              'class'       => 'span4'
            );
			$last_name = array(
              'name'        => 'last_name',
              'id'          => 'last_name',
              'value'       => $user->last_name,
              'class'       => 'span4'
            );
			$company = array(
              'name'     => 'company',
              'id'          => 'company',
              'value'       => $user->company,
              'class'       => 'span4',
            );
			$phone = array(
              'name'        => 'phone',
              'id'          => 'phone',
              'value'       => $user->phone,
              'class'       => 'span4',
            );
			$email = array(
              'name'        => 'email',
              'id'          => 'email',
              'value'       => $user->email,
              'class'       => 'span4',
            );
			
	?>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=auth&view=edit_user&id=".$id, $attrib);?>
<div class="control-group">
  <label class="control-label" for="first_name"><?php echo $this->lang->line("first_name"); ?></label>
  <div class="controls"> <?php echo form_input($first_name);?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="last_name"><?php echo $this->lang->line("last_name"); ?></label>
  <div class="controls"> <?php echo form_input($last_name);?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="company"><?php echo $this->lang->line("company"); ?></label>
  <div class="controls"> <?php echo form_input($company);?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="phone"><?php echo $this->lang->line("phone"); ?></label>
  <div class="controls"> <?php echo form_input($phone);?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="email"><?php echo $this->lang->line("email_address"); ?></label>
  <div class="controls"> <?php echo form_input($email);?> </div>
</div>
<!--<div class="control-group">
  <label class="control-label" for="phone"><?php echo $this->lang->line("user_role"); ?></label>
  <div class="controls"> 

<label class="radio">
        <input type="radio" name="role" id="optionsRadios1" value="1" <?php if($group->group_id == '1') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '1')) { echo "checked=\"yes\""; } ?>>
        <?php echo $this->lang->line("owner_role"); ?> </label>
      <label class="radio">
        <input type="radio" name="role" id="optionsRadios2" value="2" <?php if($group->group_id == '2') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '2')) { echo "checked=\"yes\""; } ?>>
        <?php echo $this->lang->line("admin_role"); ?> </label>
      <label class="radio">
        <input type="radio" name="role" id="optionsRadios3" value="3" <?php if($group->group_id == '3') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '3')) { echo "checked=\"yes\""; } ?>>
        <?php echo $this->lang->line("purchaser_role"); ?> </label>
        <label class="radio">
        <input type="radio" name="role" id="optionsRadios4" value="4" <?php if($group->group_id == '4') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '4')) { echo "checked=\"yes\""; } ?>>
        <?php echo $this->lang->line("salesman_role"); ?> </label>
      <label class="radio">
        <input type="radio" name="role" id="optionsRadios5" value="5" <?php if($group->group_id == '5') { echo "checked=\"yes\""; } if(isset($_POST['submit']) && ($_POST['role'] == '5')) { echo "checked=\"yes\""; } ?>>
        <?php echo $this->lang->line("view_role"); ?> </label>
  </div>
</div>     -->
<div class="control-group">
  <label class="control-label" for="phone"><?php echo $this->lang->line("user_role"); ?></label>
  <div class="controls">
      <div class="btn-group user-role" data-toggle="buttons-radio">
    <button type="button" value="1" class="btn <?php if($group->group_id == '1') { echo "active"; } if(isset($_POST['submit']) && ($_POST['role'] == '1')) { echo "active"; } ?>"><?php echo $this->lang->line("owner"); ?></button>
    <button type="button" value="2" class="btn <?php if($group->group_id == '2') { echo "active"; } if(isset($_POST['submit']) && ($_POST['role'] == '2')) { echo "active"; } ?>"><?php echo $this->lang->line("admin"); ?></button>
    <button type="button" value="3" class="btn <?php if($group->group_id == '3') { echo "active"; } if(isset($_POST['submit']) && ($_POST['role'] == '3')) { echo "active"; } ?>"><?php echo $this->lang->line("purchaser"); ?></button>
    <button type="button" value="4" class="btn <?php if($group->group_id == '4') { echo "active"; } if(isset($_POST['submit']) && ($_POST['role'] == '4')) { echo "active"; } ?>"><?php echo $this->lang->line("salesman"); ?></button>
    <button type="button" value="5" class="btn <?php if($group->group_id == '5') { echo "active"; } if(isset($_POST['submit']) && ($_POST['role'] == '5')) { echo "active"; } ?>"><?php echo $this->lang->line("user"); ?></button>
    </div>
    <input type="hidden" name="role" id="role" value="<?php echo $group->group_id; ?>">
 </div>
</div>       
<div class="control-group">
  <label class="control-label" for="password"><?php echo $this->lang->line("pw"); ?></label>
  <div class="controls"> <?php echo form_input($password , '', 'class="password span4" id="password"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="confirm_pw"><?php echo $this->lang->line("confirm_pw"); ?></label>
  <div class="controls"> <?php echo form_input($password_confirm , '', 'class="password span4" id="confirm_pw"');?> </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_user"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?>

