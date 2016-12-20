<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/timepicker.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-timepicker.js"></script>
<link href="<?php echo $this->config->base_url(); ?>assets/css/redactor.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/redactor.min.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$( "#date" ).datepicker({
        	format: "<?php echo JS_DATE; ?>",
			autoclose: true
    });
	$('#timepicker').timepicker({
		template: false,
		defaultTime: '<?php echo $delivery->time; ?>', 
		showInputs: false,
		minuteStep: 5
	});
	$('form').form();
	
});
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?> </h3>
	<p><?php echo $this->lang->line("update_info"); ?></p>
    
	<?php $attrib = array('class' => 'form-horizontal', 'id' => 'addSale_form'); echo form_open("module=sales&view=edit_delivery&id=".$id, $attrib); ?>
<div class="control-group">
  <label class="control-label" for="date"><?php echo $this->lang->line("date"); ?></label>
  <div class="controls"> <?php echo form_input('date', date(PHP_DATE, strtotime($delivery->date)), 'class="span4" id="date" required="required" data-error="'.$this->lang->line("date").' '.$this->lang->line("is_required").'"');?></div>
</div>
<div class="control-group">
  <label class="control-label" for="timepicker"><?php echo $this->lang->line("time"); ?></label>
  <div class="controls"> <?php echo form_input('time', $delivery->time, 'class="span4" id="timepicker" required="required" data-error="'.$this->lang->line("time").' '.$this->lang->line("is_required").'"');?></div>
</div>
<div class="control-group">
  <label class="control-label" for="reference_no"><?php echo $this->lang->line("invoice_reference_no"); ?></label>
  <div class="controls"> <?php echo form_input('reference_no', $delivery->reference_no, 'class="span4 tip" id="reference_no" required="required" data-error="'.$this->lang->line("reference_no").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="customer"><?php echo $this->lang->line("customer"); ?></label>
  <div class="controls"> <?php echo form_input('customer', $delivery->customer, 'class="span4" id="customer" required="required" data-error="'.$this->lang->line("customer").' '.$this->lang->line("is_required").'"');?></div>
</div>

<div class="control-group">
  <label class="control-label" for="address"><?php echo $this->lang->line("address"); ?></label>
  <div class="controls"> <?php echo form_textarea('address', $delivery->address, 'class="span4" id="address" style="margin-top: 10px; height: 100px;" required="required" data-error="'.$this->lang->line("address").' '.$this->lang->line("is_required").'"');?></div>
</div>

<label class="control-label" for="note"><?php echo $this->lang->line("note"); ?></label>
  <div class="controls"> <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : html_entity_decode($delivery->note)), 'class="input-block-level" id="note" style="margin-top: 10px; height: 150px;"');?> </div>
</div>
<div class="control-group"><div class="controls"><?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary" style="padding: 6px 15px;"');?></div></div>
<?php echo form_close();?> 
