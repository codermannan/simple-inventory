<div id="body_section">
<!-- Errors -->
<?php if ($message) { echo "<div class=\"yellow_bar\">".$message."</div>"; } ?>
<div id="body_section_inner">
<div class="contentPageWrapper">

<div class='mainInfo'>
<div id="form">
	<h1><?php echo $page_title; ?></h1>
	<p><?php echo $this->lang->line("update_info"); ?> <?php echo $this->lang->line("skip"); ?></p>
	<?php $name = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => $supplier->name,
              'class'       => 'text',
            );
			$email = array(
              'name'        => 'email',
              'id'          => 'email',
              'value'       => $supplier->email,
              'class'       => 'email',
            );
			$company = array(
              'name'     => 'company',
              'id'          => 'company',
              'value'       => $supplier->company,
              'class'       => 'text',
            );
			$cui = array(
              'name'        => 'cui',
              'id'          => 'cui',
              'value'       => $supplier->cui,
              'class'       => 'text',
            );
			$reg = array(
              'name'        => 'reg',
              'id'          => 'reg',
              'value'       => $supplier->reg,
              'class'       => 'text',
            );
			$cnp = array(
              'name'        => 'cnp',
              'id'          => 'cnp',
              'value'       => $supplier->cnp,
              'class'       => 'text',
            );
			$serie = array(
              'name'        => 'serie',
              'id'          => 'serie',
              'value'       => $supplier->serie,
              'class'       => 'text',
            );
			$account_no = array(
              'name'        => 'account_no',
              'id'          => 'account_no',
              'value'       => $supplier->account_no,
              'class'       => 'text',
            );
			$bank = array(
              'name'        => 'bank',
              'id'          => 'bank',
              'value'       => $supplier->bank,
              'class'       => 'text',
            );
			$address = array(
              'name'        => 'address',
              'id'          => 'address',
              'value'       => $supplier->address,
              'class'       => 'text',
            );
			$city = array(
              'name'        => 'city',
              'id'          => 'city',
              'value'       => $supplier->city,
              'class'       => 'text',
            );
			$state = array(
              'name'     => 'state',
              'id'          => 'state',
              'value'       => $supplier->state,
              'class'       => 'text',
            );
			$postal_code = array(
              'name'        => 'postal_code',
              'id'          => 'postal_code',
              'value'       => $supplier->postal_code,
              'class'       => 'text',
            );
			$country = array(
              'name'        => 'country',
              'id'          => 'country',
              'value'       => $supplier->country,
              'class'       => 'text',
            );
			$phone = array(
              'name'        => 'phone',
              'id'          => 'phone',
              'value'       => $supplier->phone,
              'class'       => 'text',
            );
			
		?>
    <?php echo form_open("module=suppliers&view=edit&id=".$id);?>
      <p><label><?php echo $this->lang->line("name"); ?>:</label>
      <?php echo form_input($name);?>
      </p>
      
      <p><label><?php echo $this->lang->line("email_address"); ?>:</label>
      <?php echo form_input($email);?>
      </p>
      
      <p><label><?php echo $this->lang->line("company"); ?>:</label>
      <?php echo form_input($company);?>
      </p>
      
      
            
      <p><label><?php echo $this->lang->line("address"); ?>:</label>
      <?php echo form_input($address);?>
      </p>
      
      <p><label><?php echo $this->lang->line("city") ?>:</label>
      <?php echo form_input($city);?>
      </p>
      
      <p><label><?php echo $this->lang->line("state"); ?>:</label>
      <?php echo form_input($state);?>
      </p>
      
      <p><label><?php echo $this->lang->line("postal_code"); ?>:</label>
      <?php echo form_input($postal_code);?>
      </p>
      
      <p><label><?php echo $this->lang->line("country"); ?>:</label>
      <?php echo form_input($country);?>
      </p>
      
      <p><label><?php echo $this->lang->line("phone"); ?>:</label>
      <?php echo form_input($phone);?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf1"); ?>:</label>
      <?php echo form_input($cui);?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf2"); ?>:</label>
      <?php echo form_input($reg);?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf3"); ?>:</label>
      <?php echo form_input($cnp);?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf4"); ?>:</label>
      <?php echo form_input($serie);?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf5"); ?>:</label>
      <?php echo form_input($account_no);?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf6") ?>:</label>
      <?php echo form_input($bank);?>
      </p>
      
            
      
      <p><?php echo form_submit('submit', $this->lang->line("update_supplier"), 'class="submitInput" style="margin-left: 110px;"');?></p>

      
    <?php echo form_close();?>

</div>
</div>
<div class="clr"></div>
</div>
<div class="clear"></div>
</div>
</div>