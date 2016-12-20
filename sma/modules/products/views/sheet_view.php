<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<base href="<?php echo base_url(); ?>" />
<title><?php echo $page_title. " | " . SITE_NAME; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="<?php echo base_url(); ?>images/icon.png" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-<?php echo THEME; ?>.css" type="text/css" charset="utf-8">
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#category').change(function(){
      // window.location.href = "<?php echo base_url(); ?>index.php?module=products&view=sheet&category_id="+$(this).val();
       window.location.replace("<?php echo base_url(); ?>index.php?module=products&view=sheet&category_id="+$(this).val());
       return false;
   }); 
});
</script>
<style>
body { text-align:center; color: #000; }
.table td { text-align: center; }
h4 { margin:5px; padding:0; }
@media print
  {
   .container { width: auto !important; }
   .container h4,
   .pagination { display: none; }
  }
</style>
</head>
<body>
     <div class="container">
		<h4><?php echo SITE_NAME.' - '.$page_title; ?> <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php?module=home"><i class="icon-home icon-white"></i> <?php echo $this->lang->line('home'); ?></a></h4>
  
  <label class="control-label" for="category"><?php echo $this->lang->line("category"); ?></label>
 <?php 
	  $cat[''] = $this->lang->line("select")." ".$this->lang->line("category");
	  	foreach($categories as $category) {
    		$cat[$category->id] = $category->name;
		}
		echo form_dropdown('category', $cat, (isset($_GET['category_id']) ? $_GET['category_id'] : ""), 'class="tip chzn-select span4" id="category" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("category").'" required="required" data-error="'.$this->lang->line("category").' '.$this->lang->line("is_required").'"'); ?> 
         <?php if($r != 1) { ?>       
         <div class="pagination pagination-centered"><?php echo $this->pagination->create_links(); ?></div>
		<?php echo $html?>
		<?php // echo $this->table->generate($records); ?>
        <div class="pagination pagination-centered"><?php echo $this->pagination->create_links(); ?></div>
         <?php } else { echo '<h3>'.$this->lang->line('empty_category').'</h3>'; } ?>
	 </div>
     
</body>
</html>	