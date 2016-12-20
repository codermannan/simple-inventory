<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('form').form();
});
</script>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("enter_info"); ?></p>
    
	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=settings&view=add_discount", $attrib); ?>

<div class="control-group">
  <label class="control-label" for="name"><?php echo $this->lang->line("title"); ?></label>
  <div class="controls"> <?php echo form_input('name', '', 'class="span4 tip" id="name" title="'.$this->lang->line("tax_rate_title_tip").'" required="required" data-error="'.$this->lang->line("title").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="discount"><?php echo $this->lang->line("discount"); ?></label>
  <div class="controls"> <?php echo form_input('discount', '', 'class="span4" id="discount" required="required" data-error="'.$this->lang->line("discount").' '.$this->lang->line("is_required").'"'); ?>
        </div>
</div>
<div class="control-group">
  <label class="control-label" for="type"><?php echo $this->lang->line("type"); ?></label>
  <div class="controls"> <?php 
  $type = array ('' => '', '1' => $this->lang->line("percentage"), '2' => $this->lang->line("fixed"));
		echo form_dropdown('type', $type, '', 'class="span4" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("type").'" required="required" data-error="'.$this->lang->line("type").' '.$this->lang->line("is_required").'"');
		?> 
        </div>
</div>

<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("add_discount"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
