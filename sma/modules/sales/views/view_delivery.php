<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $page_title; ?></title>
<link rel="shortcut icon" href="<?php echo $this->config->base_url(); ?>assets/img/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo $this->config->base_url(); ?>assets/css/<?php echo THEME; ?>.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<style type="text/css">
html, body { height: 100%; /* font-family: "Segoe UI", Candara, "Bitstream Vera Sans", "DejaVu Sans", "Bitstream Vera Sans", "Trebuchet MS", Verdana, "Verdana Ref", sans-serif; */ }
#wrap { padding: 20px; }
</style>
</head>

<body>
<!--<img src="<?php echo $this->config->base_url(); ?>assets/img/<?php echo $inv->status; ?>.png" alt="<?php echo $inv->status; ?>" style="float: right; position: absolute; top:0; right: 0;"/>-->
<div id="wrap">
<div class="text-center">
<img src="<?php echo $this->config->base_url(); ?>assets/img/<?php echo LOGO2; ?>" alt="SITE_NAME" />
</div>
<h3 class="title"><?php echo $page_title; ?></h3>

	<table class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

	<tbody> 
	<tr>
    <td width="30%"><?php echo $this->lang->line("date"); ?></td>
    <td width="70%"><?php echo date(PHP_DATE, strtotime($delivery->date)); ?></td>
    </tr>
    <tr>
    <td><?php echo $this->lang->line("time"); ?></td>
    <td><?php echo $delivery->time; ?></td>
    </tr>
    <tr>
    <td><?php echo $this->lang->line("invoice_reference_no"); ?></td>
    <td><?php echo $delivery->reference_no; ?></td>
    </tr>
    <tr>
    <td><?php echo $this->lang->line("customer"); ?></td>
    <td><?php echo $delivery->customer; ?></td>
    </tr>
    <tr>
    <td><?php echo $this->lang->line("address"); ?></td>
    <td><?php echo $delivery->address; ?></td>
    </tr>
    <tr>
    <td><?php echo $this->lang->line("note"); ?></td>
    <td><?php echo html_entity_decode($delivery->note); ?></td>
    </tr>
	</tbody> 

	</table> 
        
    
<div class="row-fluid">
<div class="span5"> 
<p>&nbsp;</p>
<p><?php echo $this->lang->line("prepared_by"); ?>: <?php echo $delivery->user; ?> </p>
<p>&nbsp;</p>
<p style="border-bottom: 1px solid #666;">&nbsp;</p>
<p><?php echo $this->lang->line("signature")." &amp; ".$this->lang->line("stamp"); ; ?></p>
</div>
</div>
<p>&nbsp;</p>
<div class="row-fluid">
<div class="span5"> 
<p>&nbsp;</p>
<p><?php echo $this->lang->line("delivery_by"); ?>: </p>
<p>&nbsp;</p>
<p style="border-bottom: 1px solid #666;">&nbsp;</p>
<p><?php echo $this->lang->line("name")." &amp; ".$this->lang->line("signature"); ; ?></p>
</div>

<div class="span5 offset2"> 
<p>&nbsp;</p>
<p><?php echo $this->lang->line("received_by"); ?>:  </p>
<p>&nbsp;</p>
<p style="border-bottom: 1px solid #666;">&nbsp;</p>
<p><?php echo $this->lang->line("name")." &amp; ".$this->lang->line("signature"); ; ?></p>
</div>
</div>

</div>
</body>
</html>