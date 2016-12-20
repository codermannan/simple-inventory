<div id="body_section">
<!-- Errors -->
<?php if ($message) { echo "<div class=\"yellow_bar\">".$message."</div>"; } ?>
<div id="body_section_inner">
<div class="contentPageWrapper">

<div class='mainInfo'>
<div id="form">
	<h1><?php echo $page_title; ?></h1>
	<p><?php echo $this->lang->line("enter_info"); ?> <?php echo $this->lang->line("skip"); ?></p>
	
    <?php echo form_open("module=suppliers&view=add");?>
      <p><label><?php echo $this->lang->line("name"); ?>:</label>
      <?php echo form_input($name, '', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("email_address"); ?>:</label>
      <?php echo form_input($email, '', 'class="email"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("company"); ?>:</label>
      <?php echo form_input($company, '', 'class="text"');?>
      </p>
      
            
      <p><label><?php echo $this->lang->line("address"); ?>:</label>
      <?php echo form_input($address, '', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("city"); ?>:</label>
      <?php echo form_input($city, '', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("state"); ?>:</label>
      <?php echo form_input($state, '', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("postal_code"); ?>:</label>
      <?php echo form_input($postal_code , '', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("country"); ?>:</label>
      <?php echo form_input($country, '', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("phone"); ?>:</label>
      <?php echo form_input($phone, '', 'class="text"');?>
      </p>   
      
      
      <p><label><?php echo $this->lang->line("cf1"); ?>:</label>
      <?php echo form_input($cui, '-', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf2"); ?>:</label>
      <?php echo form_input($reg, '-', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf3"); ?>:</label>
      <?php echo form_input($cnp, '-', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf4"); ?>:</label>
      <?php echo form_input($serie, '-', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf5"); ?>:</label>
      <?php echo form_input($account_no, '-', 'class="text"');?>
      </p>
      
      <p><label><?php echo $this->lang->line("cf6"); ?>:</label>
      <?php echo form_input($bank, '-', 'class="text"');?>
      </p>
      
      <p><?php echo form_submit('submit', $this->lang->line("add_supplier"), 'class="submitInput" style="margin-left: 110px;"');?></p>

      
    <?php echo form_close();?>

</div>
</div>
<div class="clr"></div>
</div>
<div class="clear"></div>
</div>
</div>