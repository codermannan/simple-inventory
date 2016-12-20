<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-fileupload.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$( "#date" ).datepicker({
        	format: "<?php echo JS_DATE; ?>",
			autoclose: true
    });
	$( "#date" ).datepicker("setDate", new Date());
	$('form').form();
		$("form").submit(function () { 
			if(an <= 1) {
				alert("<?php echo $this->lang->line('no_transfer_item'); ?>");
				return false;
			}
			if ($("#fwarehouse_s").val() == $("#twarehouse_s").val()) { 
				alert ('<?php echo $this->lang->line('same_warehouse'); ?>');
				return false; 
			} 
		});
		$('#fwarehouse_l').on('click', function(){ setTimeout(function(){ $('#fwarehouse_s').trigger('liszt:open'); }, 0); });
		$('#twarehouse_l').on('click', function(){ setTimeout(function(){ $('#twarehouse_s').trigger('liszt:open'); }, 0); });
});
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("enter_info"); ?></p>
    
<div class="well well-small">
    <a href="<?php echo $this->config->base_url(); ?>assets/uploads/csv_lib/sample_transfer_products.csv" class="btn btn-info pull-right"><i class="icon-download icon-white"></i> Download Sample File</a>
    <span class="text-warning"><?php echo $this->lang->line("csv1"); ?></span><br /><?php echo $this->lang->line("csv2"); ?> <span class="text-info">(<?php echo $this->lang->line("product_code"); ?>, <?php echo $this->lang->line("quantity"); ?>)</span> <?php echo $this->lang->line("csv3"); ?>
    
    </div>
    
	<?php $attrib = array('class' => 'form-horizontal', 'id' => 'addSale_form'); echo form_open_multipart("module=transfers&view=transfer_csv", $attrib); ?>
<div class="control-group">
  <label class="control-label" for="date"><?php echo $this->lang->line("date"); ?></label>
  <div class="controls"> <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="span4" id="date" required="required" data-error="'.$this->lang->line("date").' '.$this->lang->line("is_required").'"');?></div>
</div>
<div class="control-group">
  <label class="control-label" for="reference_no"><?php echo $this->lang->line("reference_no"); ?></label>
  <div class="controls"> <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $rnumber), 'class="span4 tip" id="reference_no" required="required" data-error="'.$this->lang->line("reference_no").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" id="fwarehouse_l"><?php echo $this->lang->line("from"); ?></label>
  <div class="controls">  <?php 
	 $wh[''] = '';
	  foreach($warehouses as $warehouse){
    		$wh[$warehouse->id] = $warehouse->name;
		}
		echo form_dropdown('from_warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ''), 'id="fwarehouse_s" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("warehouse").' ('.$this->lang->line("from").')" required="required" data-error="'.$this->lang->line("warehouse").' ('.$this->lang->line("from").') '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" id="twarehouse_l"><?php echo $this->lang->line("to"); ?></label>
  <div class="controls">  <?php 
		echo form_dropdown('to_warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ''), 'id="twarehouse_s" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("warehouse").' ('.$this->lang->line("to").')" required="required" data-error="'.$this->lang->line("warehouse").' ('.$this->lang->line("to").') '.$this->lang->line("is_required").'"'); ?> </div>
</div>


<div class="control-group">
  <label class="control-label"><?php echo $this->lang->line("upload_file"); ?></label>
  <div class="controls">
<!--<div class="fileupload fileupload-new" data-provides="fileupload">
<div class="input-append">
<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="userfile" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
</div>
</div>-->
<div class="fileupload fileupload-new" data-provides="fileupload">
<span class="btn btn-file"><span class="fileupload-new"><?php echo $this->lang->line("select_file"); ?></span><span class="fileupload-exists"><?php echo $this->lang->line("change"); ?></span><input type="file" name="userfile" id="product_image" /></span>
<span class="fileupload-preview"></span>
<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
</div>
  </div>
</div>


<div class="control-group">
<label class="control-label" for="note"><?php echo $this->lang->line("note"); ?></label>
  <div class="controls"> <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'id="note" class="input-block-level" style="margin-top: 10px; height: 100px;"');?> </div>
</div>
<div class="control-group"><div class="controls"><?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary" style="padding: 6px 15px;"');?></div></div>
<?php echo form_close();?> 