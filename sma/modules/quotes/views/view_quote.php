<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo $page_title." ".$this->lang->line("no")." ".$inv->id; ?></title>
<link href="<?php echo $this->config->base_url(); ?>assets/css/<?php echo THEME; ?>.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<style type="text/css">
body{ margin:0; padding:0;font-family:sun-extA; }
#wrap { padding: 20px; }
.table th { text-align:center; }
.table td { width: 12%; }
.table td:first-child { width: 5%; }
.table td:nth-child(2) { width: 30%; }
.table td:last-child { width: 15%; }
</style>
</head>

<body>
<!--<img src="<?php echo $this->config->base_url(); ?>assets/img/<?php /* echo $inv->status; */ ?>.png" alt="<?php // echo $inv->status; ?>" style="position: absolute; top:0; right: 0;"/>-->
<div id="wrap">
<img src="<?php echo $this->config->base_url(); ?>assets/uploads/logos/<?php echo $biller->logo; ?>" alt="SITE_NAME" />
<div class="row-fluid">    
<div class="span6">
	
	<h3><?php echo $biller->company; ?></h3>
	<?php echo $biller->address."<br />".$biller->city." ".$biller->postal_code." ".$biller->state."<br />".$biller->country;

	echo "
	<br />".$this->lang->line("tel").": ".$biller->phone."<br />".$this->lang->line("email").": ".$biller->email; 
    echo "<p>";
	
	if($biller->cf1 != "-" && $biller->cf1 != "") { echo "<br />".$this->lang->line("bcf1").": ".$biller->cf1; }
	if($biller->cf2 != "-" && $biller->cf2 != "") { echo "<br />".$this->lang->line("bcf2").": ".$biller->cf2; }
	if($biller->cf3 != "-" && $biller->cf3 != "") { echo "<br />".$this->lang->line("bcf3").": ".$biller->cf3; }
	if($biller->cf4 != "-" && $biller->cf4 != "") { echo "<br />".$this->lang->line("bcf4").": ".$biller->cf4; }
	if($biller->cf5 != "-" && $biller->cf5 != "") { echo "<br />".$this->lang->line("bcf5").": ".$biller->cf5; }
	if($biller->cf6 != "-" && $biller->cf6 != "") { echo "<br />".$this->lang->line("bcf6").": ".$biller->cf6; }
	
	echo "</p>";
	?>
    
	</div>
  
    <div class="span6">
    
   <?php echo $this->lang->line("quoted_to"); ?>:
   <h3><?php if($customer->company != "-") { echo $customer->company; } else { echo $customer->name; } ?></h3>
   <?php if($customer->company != "-") { echo "Attn: ".$customer->name; } ?>
   <p>
   <?php if($customer->address != "-") { echo  $this->lang->line("address").": ".$customer->address.", ".$customer->city.", ".$customer->postal_code.", ".$customer->state.", ".$customer->country; } ?>
   <br> <?php echo $this->lang->line("tel").": ".$customer->phone; ?>
 	<br><?php echo $this->lang->line("email").": ".$customer->email; ?></p>
   <?php
    if($customer->cf1 != "-" && $customer->cf1 != "") { echo "<br />".$this->lang->line("ccf1").": ".$customer->cf1; }
	if($customer->cf2 != "-" && $customer->cf2 != "") { echo "<br />".$this->lang->line("ccf2").": ".$customer->cf2; }
	if($customer->cf3 != "-" && $customer->cf3 != "") { echo "<br />".$this->lang->line("ccf3").": ".$customer->cf3; }
	if($customer->cf4 != "-" && $customer->cf4 != "") { echo "<br />".$this->lang->line("ccf4").": ".$customer->cf4; }
	if($customer->cf5 != "-" && $customer->cf5 != "") { echo "<br />".$this->lang->line("ccf5").": ".$customer->cf5; }
	if($customer->cf6 != "-" && $customer->cf6 != "") { echo "<br />".$this->lang->line("ccf6").": ".$customer->cf6; }
   ?>

	</div> 
</div>
<div style="clear: both; height:0;"></div>

<div class="row-fluid"> 
<div class="span6">    	
<h3 class="inv"><?php echo $this->lang->line("quote")." ". $this->lang->line("no") ." ".$inv->id; ?></h3>
</div>
<div class="span6">

<p style="font-weight:bold;"><?php echo $this->lang->line("reference_no"); ?>: <?php echo $inv->reference_no; ?></p>

<p style="font-weight:bold;"><?php echo $this->lang->line("date"); ?>: <?php echo date(PHP_DATE, strtotime($inv->date)); ?></p>   
</div>
</div>
<div style="clear: both; height:0;"></div>

	<table class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

	<thead> 

	<tr> 

	    <th style="text-align:center; vertical-align:middle;"><?php echo $this->lang->line("no"); ?></th> 
	    <th style="vertical-align:middle;"><?php echo $this->lang->line("description"); ?></th> 
        <th style="text-align:center; vertical-align:middle;"><?php echo $this->lang->line("quantity"); ?></th>
	    <th style="padding-right:20px; text-align:center; vertical-align:middle;"><?php echo $this->lang->line("unit_price"); ?></th> 
        <?php if(DISCOUNT_OPTION == 2) { echo '<th style="text-align:center; vertical-align:middle;">'.$this->lang->line("discount").'</th>'; } ?>
        <!--<?php if(TAX1) { echo '<th style="text-align:center; vertical-align:middle;">'.$this->lang->line("tax").'</th>'; } ?>-->
        <?php if(TAX1) { echo '<th style="padding-right:20px; text-align:center; vertical-align:middle;">'.$this->lang->line("tax").'</th>'; } ?>
	    <th style="padding-right:20px; text-align:center; vertical-align:middle;"><?php echo $this->lang->line("subtotal"); ?></th> 
	</tr> 

	</thead> 

	<tbody> 
	
	<?php $r = 1; foreach ($rows as $row):?>
			<tr>
            	<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $r; ?></td>
                <td style="vertical-align:middle;"><?php echo $row->product_name." (".$row->product_code.")"; ?>
                <?php if($row->details) { echo '<div>'.html_entity_decode($row->details).'</div>'; } ?></td>
                
                <td style="text-align:center; vertical-align:middle;"><?php echo $row->quantity; ?></td>
                <td style="text-align:right; vertical-align:middle;"><?php echo $this->ion_auth->formatMoney($row->unit_price); ?></td>
                <?php if(DISCOUNT_OPTION == 2) { echo '<td style="text-align:center; vertical-align:middle;">'.$row->discount_val.'</td>'; } ?>
                <!--<?php if(TAX1) { echo '<td style="text-align:center; vertical-align:middle;">'.$row->tax.'</td>'; } ?>-->
                <?php if(TAX1) { echo '<td style="text-align:right; vertical-align:middle;"><!--<small>('.$row->tax.')</small>--> '.$row->val_tax.'</td>'; } ?>
              
                <td style="text-align:right; vertical-align:middle;"><?php echo $this->ion_auth->formatMoney($row->gross_total); ?></td> 
			</tr> 
    <?php 
		$r++; 
		endforeach;
	?>
    <?php $col = 4;  if(DISCOUNT_OPTION == 2) { $col += 1; } if(TAX1) { $col += 1; } ?>

<?php if(TAX1 || TAX2 || DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { echo '<tr><td colspan="'.$col.'" style="text-align:right;;">'.$this->lang->line("total").' ('. CURRENCY_PREFIX.')</td><td style="text-align:right;">'.$this->ion_auth->formatMoney($inv->inv_total).'</td></tr>'; } ?>
<?php if(DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { echo '<tr><td colspan="'.$col.'" style="text-align:right;;">'.$this->lang->line("discount").' ('. CURRENCY_PREFIX.')</td><td style="text-align:right;">'.$this->ion_auth->formatMoney($inv->inv_discount).'</td></tr>'; } ?>
<?php if(TAX1) { echo '<tr><td colspan="'.$col.'" style="text-align:right;;">'.$this->lang->line("product_tax").' ('. CURRENCY_PREFIX.')</td><td style="text-align:right;">'.$this->ion_auth->formatMoney($inv->total_tax).'</td></tr>'; } ?>
<?php if(TAX2) { echo '<tr><td colspan="'.$col.'" style="text-align:right;;">'.$this->lang->line("invoice_tax").' ('. CURRENCY_PREFIX.')</td><td style="text-align:right;">'.$this->ion_auth->formatMoney($inv->total_tax2).'</td></tr>'; } ?>
<?php if($inv->shipping != 0) { echo '<tr><td colspan="'.$col.'" style="text-align:right;;">'.$this->lang->line("shipping").' ('. CURRENCY_PREFIX.')</td><td style="text-align:right;">'.$this->ion_auth->formatMoney($inv->shipping).'</td></tr>'; } ?>
<tr><td colspan="<?php echo $col; ?>" style="text-align:right; font-weight:bold;"><?php echo $this->lang->line("total_amount"); ?> (<?php echo CURRENCY_PREFIX; ?>)</td><td style="text-align:right; font-weight:bold;"><?php echo $this->ion_auth->formatMoney($inv->total+$inv->shipping); ?></td></tr>

	</tbody> 

	</table> 
<div style="clear: both; height:0;"></div>

<div class="row-fluid"> 
<div class="span12">    	
    <?php if($inv->note || $inv->note != "") { ?>
	<p>&nbsp;</p>
	<p><span style="font-weight:bold; font-size:14px; margin-bottom:5px;"><?php echo $this->lang->line("note"); ?>:</span></p>
	<p><?php echo html_entity_decode($inv->note); ?></p>
	
    <?php } ?>
</div>
</div>
<div style="clear: both; height:0;"></div>
<div class="row-fluid">
<div class="span5"> 
<p>&nbsp;</p>
<p><?php echo $this->lang->line("buyer"); ?>: <?php if($customer->company != "-") { echo $customer->company; } else { echo $customer->name; } ?> </p>
<p>&nbsp;</p>
<p style="border-bottom: 1px solid #666;">&nbsp;</p>
<p><?php echo $this->lang->line("signature")." &amp; ".$this->lang->line("stamp"); ; ?></p>
</div>

<div class="span5 offset2"> 
<p>&nbsp;</p>
<p><?php echo $this->lang->line("issued_by"); ?>: <?php echo $inv->user; ?> </p>
<p>&nbsp;</p>
<p style="border-bottom: 1px solid #666;">&nbsp;</p>
<p><?php echo $this->lang->line("signature")." &amp; ".$this->lang->line("stamp"); ; ?></p>
</div>
</div>
<div style="clear: both; height:0;"></div>
</div>
</body>
</html>