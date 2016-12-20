<link href="<?php echo $this->config->base_url(); ?>assets/css/redactor.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/redactor.min.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(function() {
	$('form').form();
	$('.bcc').hide();
    $(".toggle_form").slideDown('hide');
	$('.toggle_form').click(function(){
		$("#bcc").slideToggle();
		return false;
	});
});
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

<h3 class="title"><?php echo $page_title." ".$this->lang->line("no")." ".$id; ?> <a href="#" class="btn btn-mini toggle_form"><?php echo $this->lang->line("show_bcc"); ?></a></h3>
<p><?php echo $this->lang->line('email_details'); ?></p>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=sales&view=email_invoice&id=".$id, $attrib); ?>
<div class="control-group">
  <label class="control-label" for="site_name"><?php echo $this->lang->line("from"); ?></label>
  <div class="controls" style="padding-top:5px;"> <strong><?php echo $from_name; echo " &lt;".$from_email."&gt;"; ?></strong> </div>
</div>
<div class="control-group">
  <label class="control-label" for="to"><?php echo $this->lang->line("to")." (". $this->lang->line("email"). ")" ; ?></label>
  <div class="controls"> <input type="email" name="to" id="to" value="<?php echo $cus->email; ?>" class="span4" required="required" data-error="<?php echo $this->lang->line("email_address").' '.$this->lang->line("is_required"); ?>" /> </div>
</div>
<div id="bcc" style="display:none;">
<div class="control-group">
  <label class="control-label" for="cc"><?php echo $this->lang->line("cc")." (". $this->lang->line("optional"). ")" ; ?></label>
  <div class="controls"> <input type="email" name="cc" id="cc" class="span4" /> </div>
</div>
<div class="control-group">
  <label class="control-label" for="bcc"><?php echo $this->lang->line("bcc")." (". $this->lang->line("optional"). ")" ; ?></label>
  <div class="controls"> <input type="email" name="bcc" id="bcc" class="span4" /> </div>
</div>
</div>
<div class="control-group">
  <label class="control-label" for="subject"><?php echo $this->lang->line("subject"); ?></label>
  <div class="controls"> <?php echo form_input('subject', $this->lang->line("invoice")." ".$this->lang->line("no")." ".$id." ".$this->lang->line("from")." ".SITE_NAME, 'class="span4" id="subject" pattern=".{2,255}" required="required" data-error="'.$this->lang->line("subject").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
<label class="control-label" for="note"><?php echo $this->lang->line("message"); ?> (<?php echo $this->lang->line("optional"); ?>):</label>
  <div class="controls"> <?php echo form_textarea($note, (isset($_POST['note']) ? $_POST['note'] : ""), 'class="input-block-level" id="note" style="margin-top: 10px; height: 100px;"');?> </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("email_invoice"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
