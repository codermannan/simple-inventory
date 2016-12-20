<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $page_title ." &middot; ". SITE_NAME; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo $this->config->base_url(); ?>assets/css/<?php echo THEME; ?>.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/sma.css" rel="stylesheet">
<!--[if lt IE 9]>
      <script src="<?php echo $this->config->base_url(); ?>assets/js/html5shiv.js"></script>
<![endif]-->

<style type="text/css">
#one-column-emphasis {
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 12px;
	margin: 45px;
	width: 480px;
	text-align: left;
	border-collapse: collapse;
}
#one-column-emphasis th {
	font-size: 14px;
	font-weight: normal;
	padding: 12px 15px;
	color: #039;
}
#one-column-emphasis td {
	padding: 10px 15px;
	color: #454545;
	border-bottom: 1px solid #DDD;
}
.oce-first {
	background: #F6F6F6;
	border-right: 10px solid transparent;
	border-left: 10px solid transparent;
	font-weight:bold;
}
#one-column-emphasis tr:hover td {
	color: #333;
	background: #EEE;
}
</style>
</head>
<body>
<div class="row-fluid text-center" style="margin:20px; auto;"> <img src="<?php echo base_url().'assets/img/'.LOGO2; ?>" alt="<?php echo SITE_NAME; ?>"> </div>
<h3 class="title" style="text-align:center;"><?php echo $product->name; ?></h3>
<div style="text-align:center; margin-bottom:15px;"><?php echo $barcode; ?></div>
<table class="table table-bordered table-hover table-striped table-condensed">
  <tbody>
    <tr>
      <td><?php echo $this->lang->line("product_code"); ?></td>
      <td><?php echo $product->code; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_name"); ?></td>
      <td><?php echo $product->name; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("category"); ?></td>
      <td><?php echo $category->name; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_unit"); ?></td>
      <td><?php echo $product->unit; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_size"); ?></td>
      <td><?php echo $product->size; ?></td>
    </tr>
    <?php $no_cost = array('salesman', 'viewer'); if (!$this->ion_auth->in_group($no_cost)) { ?>
    <tr>
      <td><?php echo $this->lang->line("product_cost"); ?></td>
      <td><?php echo $product->cost; ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td><?php echo $this->lang->line("product_price"); ?></td>
      <td><?php echo $product->price; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("alert_quantity"); ?></td>
      <td><?php echo $product->alert_quantity; ?></td>
    </tr>
  </tbody>
</table>
</body>
</html>