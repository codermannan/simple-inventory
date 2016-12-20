<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $page_title." # ".$transfer->id; ?></title>
<link rel="shortcut icon" href="<?php echo $this->config->base_url(); ?>assets/img/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo $this->config->base_url(); ?>assets/css/<?php echo THEME; ?>.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<style type="text/css">
html, body { height: 100%; /* font-family: "Segoe UI", Candara, "Bitstream Vera Sans", "DejaVu Sans", "Bitstream Vera Sans", "Trebuchet MS", Verdana, "Verdana Ref", sans-serif; */ }
#wrap { padding: 20px; }
.table th { text-align:center; }
</style>
</head>

<body>
<div id="wrap">
<div style="margin-bottom:20px;"><img src="<?php echo $this->config->base_url(); ?>assets/img/<?php echo LOGO2; ?>" alt="SITE_NAME" /></div>
<div class="row-fluid">    
<div class="span6">
	
	<?php echo $this->lang->line("from"); ?>:<br />
	<h3><?php echo $from_warehouse->name. " ( ". $from_warehouse->code ." )"; ?></h3>
	<?php echo $from_warehouse->address."<br />".$from_warehouse->city."<br />"; 

	?>
    
	</div>
  
    <div class="span6">
    
   <?php echo $this->lang->line("to"); ?>:<br />
	<h3><?php echo $to_warehouse->name. " ( ". $to_warehouse->code ." )"; ?></h3>
	<?php echo $to_warehouse->address."<br />".$to_warehouse->city."<br />"; 

	?>

	</div> 
</div>
<div style="clear: both;"></div>
<p>&nbsp;</p>
<div class="row-fluid"> 
<div class="span6">    	
<h3 class="inv"><?php echo $this->lang->line("transfer_no")." ".$transfer->id; ?></h3>
</div>
<div class="span6">

<p style="font-weight:bold;"><?php echo $this->lang->line("reference_no"); ?>: <?php echo $transfer->transfer_no; ?></p>

<p style="font-weight:bold;"><?php echo $this->lang->line("date"); ?>: <?php echo date(PHP_DATE, strtotime($transfer->date)); ?></p> 
<p>&nbsp;</p>    
</div>
<div style="clear: both;"></div>	
</div>

	<table class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
	<thead> 
	<tr> 
	    <th style="text-align:center; vertical-align:middle;"><?php echo $this->lang->line("no"); ?></th> 
	    <th style="vertical-align:middle;"><?php echo $this->lang->line("description"); ?></th> 
            <th style="text-align:center; vertical-align:middle;"><?php echo $this->lang->line("quantity"); ?></th>
	<th style="padding-right:20px; text-align:center; vertical-align:middle;"><?php echo $this->lang->line("unit_price"); ?></th> 
	<?php if(TAX1) { echo '<th style="padding-right:20px; text-align:center; vertical-align:middle;">'.$this->lang->line("tax").'</th>'; } ?>
	<th style="padding-right:20px; text-align:center; vertical-align:middle;"><?php echo $this->lang->line("subtotal"); ?></th> 
	</tr> 
	</thead> 

	<tbody> 
	
	<?php $r = 1; foreach ($rows as $row):?>
	<tr>
		<td style="text-align:center; width:100px;"><?php echo $r; ?></td>
                <td style="text-align:left;"><?php echo $row->product_name; ?>
                	(<?php echo $row->product_code; ?>)</td>
                <td style="text-align:center; width:80px; "><?php echo $row->quantity; ?></td>
                <td style="width: 80px; text-align:right; padding-right:10px; vertical-align:middle;"><?php echo $this->ion_auth->formatMoney($row->unit_price); ?></td>
                
                <?php if(TAX1) { echo '<td style="width: 80px; text-align:right; vertical-align:middle;"><!--<small>('.$row->tax.')</small>--> '.$this->ion_auth->formatMoney($row->tax_val).'</td>'; } ?>
              
                <td style="width: 100px; text-align:right; padding-right:10px; vertical-align:middle;"><?php echo $this->ion_auth->formatMoney($row->gross_total); ?></td>
	</tr> 
    <?php $r++; endforeach;?>

        <?php $col = 4; if(TAX1) { $col += 1; } ?>
    
<?php if(TAX1) { ?>
<tr><td colspan="<?php echo $col; ?>" style="text-align:right; padding-right:10px;"><?php echo $this->lang->line("total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:10px;"><?php echo $this->ion_auth->formatMoney($transfer->tr_total); ?></td></tr>
<?php echo '<tr><td colspan="'.$col.'" style="text-align:right; padding-right:10px;;">'.$this->lang->line("product_tax").' ('. CURRENCY_PREFIX.')</td><td style="text-align:right; padding-right:10px;">'.$this->ion_auth->formatMoney($transfer->total_tax).'</td></tr>'; } ?>
<tr><td colspan="<?php echo $col; ?>" style="text-align:right; padding-right:10px; font-weight:bold;"><?php echo $this->lang->line("total_amount"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:10px; font-weight:bold;"><?php echo $this->ion_auth->formatMoney($transfer->total); ?></td></tr>

	</tbody> 

	</table> 
<div style="clear: both;"></div>
<div class="row-fluid"> 
<div class="span12">    	
    <?php if($transfer->note && $transfer->note != "") { ?>
	<p>&nbsp;</p>
	<p><span style="font-weight:bold; font-size:14px; margin-bottom:5px;"><?php echo $this->lang->line("note"); ?>:</span></p>
	<p><?php echo html_entity_decode($transfer->note); ?></p>
	
    <?php } ?>
</div>
</div>
<p>&nbsp;</p>
<div style="clear: both;"></div>
<div class="row-fluid">    
<div class="span5">
	
	<?php echo $this->lang->line("issued_by").": ".$transfer->user; ?>
	<p>&nbsp;</p>
    <p>&nbsp;</p>
	<p style="border-bottom: 1px solid #666;">&nbsp;</p>
	<p><?php echo $this->lang->line("signature")." &amp; ".$this->lang->line("stamp"); ?></p>

	</div>
  
    <div class="span5 offset2">
    
    <?php echo $this->lang->line("received_by"); ?>:
	<p>&nbsp;</p>
    <p>&nbsp;</p>
	<p style="border-bottom: 1px solid #666;">&nbsp;</p>
	<p><?php echo $this->lang->line("signature")." &amp; ".$this->lang->line("stamp"); ?></p>

	</div> 
</div>
</div>
</body>
</html>