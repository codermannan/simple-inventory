<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$( "#date" ).datepicker({
        	format: "<?php echo JS_DATE; ?>",
			autoclose: true
    });
	$('form').form();
	$('#warehouse_l').on('click', function(){ setTimeout(function(){ $('#warehouse_s').trigger('liszt:open'); }, 0); });
});
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("enter_info"); ?></p>
    
	<?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("module=products&view=edit_damage&product_id=".$product_id."&id=".$id, $attrib); ?>
<div class="control-group">
  <label class="control-label" for="date"><?php echo $this->lang->line("date"); ?></label>
  <div class="controls"> <?php echo form_input('date', date(PHP_DATE, strtotime($damage->date)), 'class="span4" id="date" required="required" data-error="'.$this->lang->line("date").' '.$this->lang->line("is_required").'"');?></div>
</div>
<div class="control-group">
  <label class="control-label" for="code"><?php echo $this->lang->line("product_code"); ?></label>
  <div class="controls"> <?php echo form_input('code', $product->code, 'class="span4 tip" id="code"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="name"><?php echo $this->lang->line("product_name"); ?></label>
  <div class="controls"> <?php echo form_input('name', $product->name, 'class="span4 tip" id="name"');?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="quantity"><?php echo $this->lang->line("damage_quantity"); ?></label>
  <div class="controls"> <?php echo form_input('quantity', $damage->quantity, 'class="span4 tip" id="unit" required="required" data-error="'.$this->lang->line("damage_quantity").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" id="warehouse_l"><?php echo $this->lang->line("warehouse"); ?></label>
  <div class="controls">  <?php 
	 $wh[''] = '';
	  foreach($warehouses as $warehouse){
    		$wh[$warehouse->id] = $warehouse->name;
		}
		echo form_dropdown('warehouse', $wh, $damage->warehouse_id, 'id="warehouse_s" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("warehouse").'" required="required" data-error="'.$this->lang->line("warehouse").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
<label class="control-label" for="note"><?php echo $this->lang->line("note"); ?></label>
  <div class="controls"> <?php echo form_textarea('note', html_entity_decode($damage->note), 'class="input-block-level" id="note" style="margin-top: 10px; height: 100px;"');?> </div>
</div>
<div class="control-group"><div class="controls"><?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary" style="padding: 6px 15px;"');?></div></div>
<?php echo form_close();?> 
