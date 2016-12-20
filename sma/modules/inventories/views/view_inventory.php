<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $page_title." ".$this->lang->line("no")." ".$inv->id; ?></title>
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
<div class="row-fluid text-center" style="margin-bottom:20px;">
<img src="<?php echo base_url().'assets/img/'.LOGO2; ?>" alt="<?php echo SITE_NAME; ?>">
</div>
<div class="row-fluid">     
<div class="span6">
	
    <h3><?php if($supplier->company != "-") { echo $supplier->company; } else { echo $supplier->name; } ?></h3>
   <?php if($supplier->company != "-") { echo "<p>Attn: ".$supplier->name."</p>"; } ?>
   
	<?php echo $supplier->address.",<br />".$supplier->city.", ".$supplier->postal_code.", ".$supplier->state.",<br />".$supplier->country;  

    echo "<p>";
	
	if($supplier->cf1 != "-" && $supplier->cf1 != "") { echo "<br />".$this->lang->line("scf1").": ".$supplier->cf1; }
	if($supplier->cf2 != "-" && $supplier->cf2 != "") { echo "<br />".$this->lang->line("scf2").": ".$supplier->cf2; }
	if($supplier->cf3 != "-" && $supplier->cf3 != "") { echo "<br />".$this->lang->line("scf3").": ".$supplier->cf3; }
	if($supplier->cf4 != "-" && $supplier->cf4 != "") { echo "<br />".$this->lang->line("scf4").": ".$supplier->cf4; }
	if($supplier->cf5 != "-" && $supplier->cf5 != "") { echo "<br />".$this->lang->line("scf5").": ".$supplier->cf5; }
	if($supplier->cf6 != "-" && $supplier->cf6 != "") { echo "<br />".$this->lang->line("scf6").": ".$supplier->cf6; }
	
	echo "</p>";
	echo $this->lang->line("tel").": ".$supplier->phone."<br />".$this->lang->line("email").": ".$supplier->email; 
	?>
    
	</div>
  
    <div class="span6">
    
   <h3 class="inv"><?php echo $this->lang->line("inventory_no"); ?>. <?php echo $inv->id; ?></h3>
<p style="font-weight:bold;"><?php echo $this->lang->line("reference_no"); ?>: <?php echo $inv->reference_no; ?></p>

<p style="font-weight:bold;"><?php echo $this->lang->line("date"); ?>: <?php echo date(PHP_DATE, strtotime($inv->date)); ?></p>   
</div>
<div style="clear: both;"></div>	
</div>
<p>&nbsp;</p> 
	<table class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

	<thead> 

	<tr> 
    	<th><?php echo $this->lang->line("no"); ?></th> 
	    <th><?php echo $this->lang->line("description"); ?> (<?php echo $this->lang->line("code"); ?>)</th> 
        <th><?php echo $this->lang->line("quantity"); ?></th>
	    <th style="padding-right:20px;"><?php echo $this->lang->line("unit_price"); ?></th> 
        <?php if(TAX1) { echo '<th style="padding-right:20px; text-align:center; vertical-align:middle;">'.$this->lang->line("tax").'</th>'; } ?>
	    <th style="padding-right:20px;"><?php echo $this->lang->line("subtotal"); ?></th> 
	</tr> 

	</thead> 

	<tbody> 
	
	<?php $r = 1; foreach ($rows as $row):?>
			<tr>
            	<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $r; ?></td>
                <td style="vertical-align:middle;"><?php echo $row->product_name." (".$row->product_code.")"; ?></td>
                <td style="width: 100px; text-align:center; vertical-align:middle;"><?php echo $row->quantity; ?></td>
                <td style="text-align:right; width:100px; padding-right:10px;"><?php echo $this->ion_auth->formatMoney($row->unit_price); ?></td>
                <?php if(TAX1) { echo '<td style="width: 80px; text-align:right; vertical-align:middle;"><!--<small>('.$row->tax.')</small>--> '.$row->val_tax.'</td>'; } ?>
                <td style="text-align:right; width:100px; padding-right:10px;"><?php echo $this->ion_auth->formatMoney($row->gross_total); ?></td> 
			</tr> 
    <?php 
		$r++; 
		endforeach;
	?>
    <?php $col = 4; if(TAX1) { $col += 1; } ?>
    
<?php if(TAX1) { ?>
<tr><td colspan="<?php echo $col; ?>" style="text-align:right; padding-right:10px;"><?php echo $this->lang->line("total"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:10px;"><?php echo $this->ion_auth->formatMoney($inv->inv_total); ?></td></tr>
<?php echo '<tr><td colspan="'.$col.'" style="text-align:right; padding-right:10px;;">'.$this->lang->line("product_tax").' ('. CURRENCY_PREFIX.')</td><td style="text-align:right; padding-right:10px;">'.$this->ion_auth->formatMoney($inv->total_tax).'</td></tr>'; } ?>
<tr><td colspan="<?php echo $col; ?>" style="text-align:right; padding-right:10px; font-weight:bold;"><?php echo $this->lang->line("total_amount"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; padding-right:10px; font-weight:bold;"><?php echo $this->ion_auth->formatMoney($inv->total); ?></td></tr>

	</tbody> 

	</table> 
<div style="clear: both;"></div>
<div class="row-fluid"> 
<div class="span12">    	
    <?php if($inv->note || $inv->note != "") { ?>
	<p>&nbsp;</p>
	<p><span style="font-weight:bold; font-size:14px; margin-bottom:5px;"><?php echo $this->lang->line("note"); ?>:</span></p>
	<p><?php echo html_entity_decode($inv->note); ?></p>
	
    <?php } ?>
</div>
</div>
<div style="clear: both;"></div>

<div class="row-fluid">
<div class="span5"> 
<p>&nbsp;</p>
<p><?php echo $this->lang->line("order_by"); ?>: <?php echo $inv->user; ?> </p>
<p>&nbsp;</p>
<p style="border-bottom: 1px solid #666;">&nbsp;</p>
<p><?php echo $this->lang->line("signature")." &amp; ".$this->lang->line("stamp"); ; ?></p>
</div>
</div>

</div>
</body>
</html>