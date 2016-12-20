<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(function() {
	$('form').form();
});
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>


	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("enter_info"); ?></p>

   	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=billers&view=add", $attrib);?>

<div class="control-group">
  <label class="control-label" for="name"><?php echo $this->lang->line("name"); ?></label>
  <div class="controls"> <?php echo form_input($name, '', 'class="span4" id="name" pattern=".{2,55}" required="required" data-error="'.$this->lang->line("name").' '.$this->lang->line("is_required").'"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="email_address"><?php echo $this->lang->line("email_address"); ?></label>
  <div class="controls"> <input type="email" name="email" class="span4" required="required" data-error="<?php echo $this->lang->line("email_address").' '.$this->lang->line("is_required"); ?>" />
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="phone"><?php echo $this->lang->line("phone"); ?></label>
  <div class="controls"> <input type="tel" name="phone" class="span4" pattern="[0-9]{7,15}" required="required" data-error="<?php echo $this->lang->line("phone").' '.$this->lang->line("is_required"); ?>" />
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="company"><?php echo $this->lang->line("company"); ?></label>
  <div class="controls"> <?php echo form_input($company, '', 'class="span4 tip" title="'.$this->lang->line("bypass").'" id="company" pattern=".{1,55}" required="required" data-error="'.$this->lang->line("company").' '.$this->lang->line("is_required").'"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="address"><?php echo $this->lang->line("address"); ?></label>
  <div class="controls"> <?php echo form_input($address, '', 'class="span4" id="address" pattern=".{2,255}" required="required" data-error="'.$this->lang->line("address").' '.$this->lang->line("is_required").'"');?>
  </div>
</div>  
<div class="control-group">
  <label class="control-label" for="city"><?php echo $this->lang->line("city"); ?></label>
  <div class="controls"> <?php echo form_input($city, '', 'class="span4" id="city" pattern=".{2,55}" required="required" data-error="'.$this->lang->line("city").' '.$this->lang->line("is_required").'"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="state"><?php echo $this->lang->line("state"); ?></label>
  <div class="controls"> <?php echo form_input($state, '', 'class="span4" id="state" pattern=".{2,55}" required="required" data-error="'.$this->lang->line("state").' '.$this->lang->line("is_required").'"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="postal_code"><?php echo $this->lang->line("postal_code"); ?></label>
  <div class="controls"> <?php echo form_input($postal_code, '', 'class="span4" id="postal_code"pattern=".{4,8}" required="required" data-error="'.$this->lang->line("postal_code").' '.$this->lang->line("is_required").'"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="country"><?php echo $this->lang->line("country"); ?></label>
  <div class="controls"> <?php echo form_input($country, '', 'class="span4" id="country" pattern=".{2,55}" required="required" data-error="'.$this->lang->line("country").' '.$this->lang->line("is_required").'"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label"><?php echo $this->lang->line("logo"); ?></label>
  <div class="controls">  
	  <?php 
	  $biller_logos[''] = ''; 
	  	foreach($logos as $key=>$value){
    		$biller_logos[$value] = $value;
		}
		echo form_dropdown('logo', $biller_logos, '', 'data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("biller_logo").'" required="required" data-error="'.$this->lang->line("biller_logo").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="cf1"><?php echo $this->lang->line("bcf1"); ?></label>
  <div class="controls"> <?php echo form_input('cf1', '', 'class="span4" id="cf1"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf2"><?php echo $this->lang->line("bcf2"); ?></label>
  <div class="controls"> <?php echo form_input('cf2', '', 'class="span4" id="cf2"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf3"><?php echo $this->lang->line("bcf3"); ?></label>
  <div class="controls"> <?php echo form_input('cf3', '', 'class="span4" id="cf3"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf4"><?php echo $this->lang->line("bcf4"); ?></label>
  <div class="controls"> <?php echo form_input('cf4', '', 'class="span4" id="cf4"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf5"><?php echo $this->lang->line("bcf5"); ?></label>
  <div class="controls"> <?php echo form_input('cf5', '', 'class="span4" id="cf5"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf6"><?php echo $this->lang->line("bcf6"); ?></label>
  <div class="controls"> <?php echo form_input('cf6', '', 'class="span4" id="cf6"');?>
  </div>
</div> 
<div class="control-group">
<label class="control-label" for="note"><?php echo $this->lang->line("invoice_footer"); ?></label>
  <div class="controls"> <?php echo form_textarea('invoice_footer', (isset($_POST['invoice_footer']) ? $_POST['invoice_footer'] : ""), 'class="input-block-level" id="note"');?> </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("add_biller"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
   