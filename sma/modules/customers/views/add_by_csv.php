<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){
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
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-fileupload.css" rel="stylesheet">
<h3  class="title"><?php echo $page_title; ?></h3>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
    
	<div class="well well-small">
    <a href="<?php echo $this->config->base_url(); ?>assets/uploads/csv_lib/sample.csv" class="btn btn-info pull-right"><i class="icon-download icon-white"></i> Download Sample File</a>
    <span class="text-warning"><?php echo $this->lang->line("csv1"); ?></span><br /><?php echo $this->lang->line("csv2"); ?> <span class="text-info">(<?php echo $this->lang->line("name"); ?>, <?php echo $this->lang->line("email"); ?>, <?php echo $this->lang->line("phone"); ?>, <?php echo $this->lang->line("company"); ?>, <?php echo $this->lang->line("address"); ?>, <?php echo $this->lang->line("city"); ?>,  <?php echo $this->lang->line("state"); ?>, <?php echo $this->lang->line("postal_code"); ?>, <?php echo $this->lang->line("country"); ?>)</span> <?php echo $this->lang->line("csv3"); ?>
    
    </div>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("module=customers&view=add_by_csv", $attrib); ?>
<div class="control-group">
  <label class="control-label" for="csv_file"><?php echo $this->lang->line("upload_file"); ?></label>
  <div class="controls">
<div class="fileupload fileupload-new" data-provides="fileupload">
<span class="btn btn-file"><span class="fileupload-new"><?php echo $this->lang->line("select_file"); ?></span><span class="fileupload-exists"><?php echo $this->lang->line("change"); ?></span><input type="file" name="userfile" id="csv_file" onchange="checkfile(this);" required="required" data-error="<?php echo $this->lang->line("select_file")." ".$this->lang->line("is_required"); ?>" /></span>
<span class="fileupload-preview"></span>
<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
</div>
  </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
