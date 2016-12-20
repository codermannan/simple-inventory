<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-fileupload.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/redactor.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/redactor.min.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<script type="text/javascript">
$(function() {
	$( "#date" ).datepicker({
        format: "<?php echo JS_DATE; ?>",
		autoclose: true
    });
	$( "#date" ).datepicker("setDate", new Date());
	$('form').form();
	
});
function checkfile(sender) {
    var validExts = new Array(".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("<?php echo $this->lang->line("x_csv"); ?>");
      return false;
    }
    else return true;
}
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("enter_info"); ?></p>
  
  <div class="well well-small">
    <a href="<?php echo $this->config->base_url(); ?>assets/uploads/csv_lib/sample_inventory_products.csv" class="btn btn-info pull-right"><i class="icon-download icon-white"></i> Download Sample File</a>
    <span class="text-warning"><?php echo $this->lang->line("csv1"); ?></span><br /><?php echo $this->lang->line("csv2"); ?> <span class="text-info">(<?php echo $this->lang->line("quantity"); ?>, <?php echo $this->lang->line("product_code"); ?>, <?php echo $this->lang->line("unit_price"); ?>)</span> <?php echo $this->lang->line("csv3"); ?>
   </div>
      
	<?php $attrib = array('class' => 'form-horizontal', 'id' => 'addSale_form'); echo form_open_multipart("module=inventories&view=csv_inventory", $attrib); ?>
<div class="control-group">
  <label class="control-label" for="date"><?php echo $this->lang->line("date"); ?></label>
  <div class="controls"> <?php echo form_input($date, (isset($_POST['date']) ? $_POST['date'] : ""), 'class="span4" id="date" required="required" data-error="'.$this->lang->line("date").' '.$this->lang->line("is_required").'"');?></div>
</div>
<div class="control-group">
  <label class="control-label" for="reference_no"><?php echo $this->lang->line("reference_no"); ?></label>
  <div class="controls"> <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $rnumber), 'class="span4 tip" id="reference_no" required="required" data-error="'.$this->lang->line("reference_no").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" id="warehouse_l"><?php echo $this->lang->line("warehouse"); ?></label>
  <div class="controls">  <?php 
	 $wh[''] = '';
	  foreach($warehouses as $warehouse){
    		$wh[$warehouse->id] = $warehouse->name;
		}
		echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : DEFAULT_WAREHOUSE), 'id="warehouse_s" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("warehouse").'" required="required" data-error="'.$this->lang->line("warehouse").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" id="supplier_l"><?php echo $this->lang->line("supplier"); ?></label>
  <div class="controls">  <?php 
	 $sp[""] = "";
	   		foreach($suppliers as $supplier){
				if($supplier->company == "-" || !$supplier->company) {
					$sp[$supplier->id] = $supplier->name." (P)";
				} else {
					$sp[$supplier->id] = $supplier->company." (C)";
				}
			}
		echo form_dropdown('supplier', $sp, (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'id="supplier_s" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("supplier").'" required="required" data-error="'.$this->lang->line("supplier").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label"><?php echo $this->lang->line("upload_file"); ?></label>
  <div class="controls">
<div class="fileupload fileupload-new" data-provides="fileupload">
<span class="btn btn-file"><span class="fileupload-new"><?php echo $this->lang->line("select_file"); ?></span><span class="fileupload-exists"><?php echo $this->lang->line("change"); ?></span><input type="file" name="userfile" id="product_image" onchange="checkfile(this);" required="required" data-error="<?php echo $this->lang->line("select_file")." ".$this->lang->line("is_required"); ?>" /></span>
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
