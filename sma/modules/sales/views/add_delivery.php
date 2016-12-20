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
	$( "#date" ).datepicker("setDate", new Date());
	$('#timepicker').timepicker({
		template: false,
		showInputs: false,
		minuteStep: 5
	});
	$('form').form();
	
});
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?> </h3>
	<p><?php echo $this->lang->line("enter_info"); ?></p>
    
	<?php $attrib = array('class' => 'form-horizontal', 'id' => 'addSale_form'); echo form_open("module=sales&view=add_delivery", $attrib); ?>
<div class="control-group">
  <label class="control-label" for="date"><?php echo $this->lang->line("date"); ?></label>
  <div class="controls"> <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="span4" id="date" required="required" data-error="'.$this->lang->line("date").' '.$this->lang->line("is_required").'"');?></div>
</div>
<div class="control-group">
  <label class="control-label" for="timepicker"><?php echo $this->lang->line("time"); ?></label>
  <div class="controls"> <?php echo form_input('time', (isset($_POST['time']) ? $_POST['time'] : ""), 'class="span4" id="timepicker" required="required" data-error="'.$this->lang->line("time").' '.$this->lang->line("is_required").'"');?></div>
</div>
<div class="control-group">
  <label class="control-label" for="reference_no"><?php echo $this->lang->line("invoice_reference_no"); ?></label>
  <div class="controls"> <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $inv->reference_no), 'class="span4 tip" id="reference_no" required="required" data-error="'.$this->lang->line("reference_no").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="customer"><?php echo $this->lang->line("customer"); ?></label>
  <div class="controls"> <?php echo form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : $customer->name), 'class="span4" id="customer" required="required" data-error="'.$this->lang->line("customer").' '.$this->lang->line("is_required").'"');?></div>
</div>

<div class="control-group">
  <label class="control-label" for="address"><?php echo $this->lang->line("address"); ?></label>
  <div class="controls"> <?php echo form_textarea('address', (isset($_POST['address']) ? $_POST['address'] : $customer->address." ".$customer->city. " ".$customer->state." ".$customer->postal_code." ".$customer->country.". 
Tel: ".$customer->phone), 'class="span4" id="address" style="margin-top: 10px; height: 100px;" required="required" data-error="'.$this->lang->line("address").' '.$this->lang->line("is_required").'"');?></div>
</div>

<div class="control-group">
<label class="control-label" for="note"><?php echo $this->lang->line("note"); ?></label>
  <div class="controls"> <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="input-block-level" id="note" style="margin-top: 10px; height: 100px;"');?> </div>
</div>
<div class="control-group"><div class="controls"><?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary" style="padding: 6px 15px;"');?></div></div>
<?php echo form_close();?> 
