<div id="body_section">
<!-- Errors -->
<?php if ($message) { echo "<div class=\"yellow_bar\">".$message."</div>"; } ?>
<div id="body_section_inner">
<div class="contentPageWrapper">
<h1><?php echo $page_title; ?></h1>
<!-- Big buttons -->
						
						
                           <ul class="dash">
                            <li>
								<a href="index.php?module=reports&view=products" title="<?php echo $this->lang->line("product_reports"); ?>" class="tooltip">
									<img src="<?php echo $this->config->base_url(); ?>smlib/images/icons/product_report.png" alt="" />
									<span><?php echo $this->lang->line("product_reports"); ?></span>
								</a>
							</li>
                             
                            <?php $group1 = array('owner', 'admin', 'viewer', 'purchaser'); if ($this->ion_auth->in_group($group1)) { ?>
							<li>
								<a href="index.php?module=reports&view=purchases" title="<?php echo $this->lang->line("purchase_reports"); ?>" class="tooltip">
									<img src="<?php echo $this->config->base_url(); ?>smlib/images/icons/purchase_report.png" alt="" />
									<span><?php echo $this->lang->line("purchase_reports"); ?></span>
								</a>
							</li>
                            <?php } ?>
                            <?php $group2 = array('owner', 'admin', 'viewer', 'salesman'); if ($this->ion_auth->in_group($group2)) { ?>
                            <li>
								<a href="index.php?module=reports&view=sales" title="<?php echo $this->lang->line("sale_reports"); ?>" class="tooltip">
									<img src="<?php echo $this->config->base_url(); ?>smlib/images/icons/sale_report.png" alt="" />
									<span><?php echo $this->lang->line("sale_reports"); ?></span>
								</a>
							</li>
                            <?php } ?>
                            </ul>
                            <div class="clr"></div>
                            
                        
                        
<!-- End of Big buttons -->
					
    
   

<div class="clr"></div>
</div>
<div class="clear"></div>
</div>
</div>