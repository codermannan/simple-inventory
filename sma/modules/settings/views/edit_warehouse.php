<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('form').form();
});
</script>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("update_info"); ?></p>
    
	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=settings&view=edit_warehouse&id=".$id, $attrib); ?>

<div class="control-group">
  <label class="control-label" for="code"><?php echo $this->lang->line("warehouse_code"); ?></label>
  <div class="controls"> <?php echo form_input('code', $warehouse->code, 'class="span4 tip" id="code" title="'.$this->lang->line("warehouse_code_tip").'" required="required" data-error="'.$this->lang->line("warehouse_code").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="name"><?php echo $this->lang->line("warehouse_name"); ?></label>
  <div class="controls"> <?php echo form_input('name', $warehouse->name, 'class="span4 tip" id="name" title="'.$this->lang->line("warehouse_name_tip").'" required="required" data-error="'.$this->lang->line("warehouse_name").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="address"><?php echo $this->lang->line("address"); ?></label>
  <div class="controls"> <?php echo form_textarea('address', $warehouse->address, 'class="span4 tip" id="address" style="height:100px;" title="'.$this->lang->line("warehouse_address_tip").'" required="required" data-error="'.$this->lang->line("address").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="city"><?php echo $this->lang->line("city"); ?></label>
  <div class="controls"> <?php echo form_input('city', $warehouse->city, 'class="span4 tip" id="city" title="'.$this->lang->line("warehouse_city_tip").'" required="required" data-error="'.$this->lang->line("city").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_warehouse"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 

