<div id="body_section">
<!-- Errors -->
<?php if ($message) { echo "<div class=\"yellow_bar\">".$message."</div>"; } ?>
<div id="body_section_inner">
<div class="contentPageWrapper">
<h1><?php echo $page_title; ?></h1>
<!-- Big buttons -->
						
						
                           <ul class="dash">
                           <li>
								<a href="index.php?module=settings&view=system_setting" title="<?php echo $this->lang->line("system_setting"); ?>" class="tooltip">
									<img src="<?php echo $this->config->base_url(); ?>smlib/images/icons/settings.png" alt="" />
									<span><?php echo $this->lang->line("system_setting"); ?></span>
								</a>
							</li>
                            <li>
								<a href="index.php?module=settings&view=change_logo" title="<?php echo $this->lang->line("change_logo"); ?>" class="tooltip">
									<img src="<?php echo $this->config->base_url(); ?>smlib/images/icons/upload.png" alt="" />
									<span><?php echo $this->lang->line("change_logo"); ?></span>
								</a>
							</li>
							<li>
								<a href="index.php?module=settings&view=upload_biller_logo" title="<?php echo $this->lang->line("upload_biller_logo"); ?>" class="tooltip">
									<img src="<?php echo $this->config->base_url(); ?>smlib/images/icons/upload_folder.png" alt="" />
									<span><?php echo $this->lang->line("upload_biller_logo"); ?></span>
								</a>
							</li>
                            
                            <li>
								<a href="index.php?module=settings&view=warehouses" title="<?php echo $this->lang->line("warehouses"); ?>" class="tooltip">
									<img src="<?php echo $this->config->base_url(); ?>smlib/images/icons/warehouse.png" alt="" />
									<span><?php echo $this->lang->line("warehouses"); ?></span>
								</a>
							</li><li>
								<a href="index.php?module=settings&view=add_warehouse" title="<?php echo $this->lang->line("new_warehouse"); ?>" class="tooltip">
									<img src="<?php echo $this->config->base_url(); ?>smlib/images/icons/add_warehouse.png" alt="" />
									<span><?php echo $this->lang->line("new_warehouse"); ?></span>
								</a>
							</li>
                            
                            <li>
								<a href="index.php?module=settings&view=backup_database" title="<?php echo $this->lang->line("backup_database"); ?>" class="tooltip">
									<img src="<?php echo $this->config->base_url(); ?>smlib/images/icons/db-backup.png" alt="" />
									<span><?php echo $this->lang->line("backup_database"); ?></span>
								</a>
							</li>
                            </ul>
                            <div class="clr"></div>
                            
                        
                        
<!-- End of Big buttons -->
					
    
   

<div class="clr"></div>
</div>
<div class="clear"></div>
</div>
</div>