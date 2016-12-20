<script type="text/javascript">
$(function () {
       $(".tip").tooltip();
});
</script>

<style>
.table th { text-align:center; }
.table td { text-align:center; }
.table a:hover { text-decoration: none; }
.cl_wday { text-align: center; font-weight:bold; }
.cl_equal { width: 14%; }
.day { width: 14%; }
.day_num { width: 100%; text-align:left; margin: -8px; padding:8px; } 
.content { width: 100%;text-align:left; color: #2FA4E7; margin-top:10px; }
.highlight { color: #0088CC; font-weight:bold; }
#eann { display:inline-block; }
</style>
<?php   
		foreach($monthly_sales as $month_sale) {
		$months[] = date('M-Y', strtotime($month_sale->month));
		$sales[] = $month_sale->sales;
		$tax1[] = $month_sale->tax1;
		$tax2[] = $month_sale->tax2;
		$purchases[] = $month_sale->purchases;
		$tax3[] = $month_sale->ptax;
		
		} 
		/*
		foreach($monthly_purchases as $month_purchase) {
		$purchases[] = $month_purchase->purchases;
		} */

?>   
<script src="<?php echo base_url(); ?>assets/js/sl/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sl/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
		
		$('#chart').highcharts({
            chart: {
            },
			credits: {
			  	enabled: false
			},
            title: {
                text: '<?php echo $this->lang->line("monthly_sales_purchases"); ?>'
            },
            xAxis: {
                categories: [<?php foreach($months as $month) {
					 echo "'".$month."', ";
				 }
				?>]
            },
			yAxis: {
                min: 0,
                title: ""
            },
			tooltip: {
				shared: true,
				headerFormat: '<span style="font-size:14px">{point.key}</span><table>',
                pointFormat: '<tr style="border-bottom: 1px dotted {series.color};"><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="color:{series.color};padding:0;text-align:right;"><?php echo CURRENCY_PREFIX; ?> <b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                useHTML: true,
				valueDecimals: 2,
				style: {
					fontSize: '13px',
					padding: '10px',
					fontWeight: 'bold',
					color: '#000000'
				}
            },
            series: [{
                type: 'column',
                name: '<?php echo $this->lang->line("sp_tax"); ?>',
                data: [<?php 
				echo implode(', ', $tax1);
				?>]
            },
			{
                type: 'column',
                name: '<?php echo $this->lang->line("tax2"); ?>',
                data: [<?php 
				echo implode(', ', $tax2);
				?>]
            },
			{
                type: 'column',
                name: '<?php echo $this->lang->line("sales"); ?>',
                data: [<?php 
				echo implode(', ', $sales);
				?>]
            },  {
                type: 'spline',
                name: '<?php echo $this->lang->line("purchases"); ?>',
                data: [<?php 
				echo implode(', ', $purchases);
				?>],
                marker: {
                	 lineWidth: 2,
                    states: {
                        hover: {
                            lineWidth: 4
                        }
                    },
                	lineColor: Highcharts.getOptions().colors[3],
                	fillColor: 'white'
                }
            },  {
                type: 'spline',
                name: '<?php echo $this->lang->line("pp_tax"); ?>',
                data: [<?php 
				echo implode(', ', $tax3);
				?>],
                marker: {
                	 lineWidth: 2,
                    states: {
                        hover: {
                            lineWidth: 4
                        }
                    },
                	lineColor: Highcharts.getOptions().colors[3],
                	fillColor: 'white'
                }
            }, {
                type: 'pie',
                name: '<?php echo $this->lang->line("stock_value"); ?>',
                data: [
				['',   0],
				['',   0],
                    ['<?php echo $this->lang->line("by_price"); ?>',   <?php echo $stock->stock_by_price; ?>],
                    ['<?php echo $this->lang->line("by_cost"); ?>',   <?php echo $stock->stock_by_cost; ?>],
                ],
                center: [20, 0],
                size: 80,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });
    });
	
	$(function () {
    $('#tp').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '<?php echo $this->lang->line("best_sellers")." (".date('F Y').")"; ?>'
        },
        credits: {
			  	enabled: false
			},
			tooltip: {
				shared: true,
				headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:4px">{series.name}: </td>' +
                    '<td style="color:{series.color};padding:4px;text-align:right;"> <b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                useHTML: true,
				style: {
					fontSize: '13px',
					padding: '10px',
					fontWeight: 'bold',
					color: '#000000'
				}
            },

			plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                    },
                    showInLegend: false
                }
            },
        series: [{
                type: 'pie',
                name: '<?=$this->lang->line('total_sold')?>',
                data: [
                    <?php 
				foreach($topProducts as $tp) {
				echo "['".$tp->product_name." (".$tp->product_code.")', ".$tp->quantity."],";
				
				} ?>
                ]
            }]
    });
});
</script>
<?php if ($message) { echo "<div class=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>".$message."</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>

<h3 class="title"><?php echo $page_title; ?></h3>

<?php if ($com->comment) { echo "<div class=\"alert alert-info\" style='position:relative;'><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><i class='icon-remove'></i></button>".html_entity_decode($com->comment)."</div>"; } ?>


<div class="row-fluid">

<div class="span8">
<div class="well well-small">
<div id="chart" style="width:100%; height:300px;"></div>
</div>	
</div>


<div class="span4">
<div class="well well-small">
<div id="tp" style="width:100%; height:300px;"></div>
</div>	
</div>

</div>
	
			
						<?php if ($this->ion_auth->in_group(array('owner', 'admin'))) { ?>
                        <ul class="dash">
                         
                        	<li>
								<a class="tip" href="index.php?module=products" title="<?php echo $this->lang->line("products"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/products.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("products"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=products&view=add" title="<?php echo $this->lang->line("new_product"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/product_add.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("new_product"); ?></span></span>
								</a>
							</li>
                            <li style="position:relative;">
								<a class="tip" href="index.php?module=reports&view=products" title="<?php echo $this->lang->line("product_alerts"); ?>">
                                <!--<span style="background:#C00; width: auto; position: absolute; top: -5px; right:5px; color:#FFF; border-radius: 5px; font-weight:bold; padding:2px 5px;"> </span>-->
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/alert.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("product_alerts"); ?></span></span>
								</a>
							</li>
							<li>
								<a class="tip" href="index.php?module=inventories" title="<?php echo $this->lang->line("inventories"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/puchase.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("purchases"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=inventories&view=add" title="<?php echo $this->lang->line("new_purchase"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/puchase_add.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("new_purchase"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=sales" title="<?php echo $this->lang->line("invoices"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/sales.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("sales"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=sales&view=add" title="<?php echo $this->lang->line("new_sale"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/sale_add.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("new_sale"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=reports&view=overview" title="<?php echo $this->lang->line("reports"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/report.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("reports"); ?></span></span>
								</a>
							</li> 
                            <?php if ($this->ion_auth->in_group('owner')) { ?>
                            <li>
								<a class="tip" href="index.php?module=settings&view=system_setting" title="<?php echo $this->lang->line("settings"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/settings.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("settings"); ?></span></span>
								</a>
							</li>
							<li>
								<a class="tip" href="index.php?module=auth&view=users" title="<?php echo $this->lang->line("users"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/users.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("users"); ?></span></span>
								</a>
							</li>
							<li>
								<a class="tip" href="index.php?module=auth&view=create_user" title="<?php echo $this->lang->line("new_user"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/user_add.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("new_user"); ?></span></span>
								</a>
							</li>
                            <?php } ?>
                            <li>
								<a class="tip" href="index.php?module=auth&view=change_password" title="<?php echo $this->lang->line("change_password"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/user_edit.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("change_password"); ?></span></span>
								</a>
							</li>
							<li>
								<a class="tip" href="index.php?module=billers" title="<?php echo $this->lang->line("billers"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/billers.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("billers"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=billers&view=add" title="<?php echo $this->lang->line("new_biller"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/biller_add.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("new_biller"); ?></span></span>
								</a>
							</li>
                            
							<li>
								<a class="tip" href="index.php?module=customers" title="<?php echo $this->lang->line("customers"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/customers.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("customers"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=customers&view=add" title="<?php echo $this->lang->line("new_customer"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/customer_add.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("new_customer"); ?></span></span>
								</a>
							</li>
                            
                            <li>
								<a class="tip" href="index.php?module=suppliers" title="<?php echo $this->lang->line("suppliers"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/suppliers.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("suppliers"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=suppliers&view=add" title="<?php echo $this->lang->line("new_supplier"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/supplier_add.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("new_supplier"); ?></span></span>
								</a>
							</li>
							
							<li>
								<a class="tip" href="index.php?module=auth&view=logout" title="<?php echo $this->lang->line("logout"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/logoff.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("logout"); ?></span></span>
								</a>
							</li>
							
						</ul>
                        <?php } ?>
                       
                        
                         <?php if ($this->ion_auth->in_group('purchaser')) { ?>
                         <ul class="dash">
                         
                        	<li>
								<a class="tip" href="index.php?module=products" title="<?php echo $this->lang->line("products"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/products.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("products"); ?></span></span>
								</a>
							</li>
                            
							<li>
								<a class="tip" href="index.php?module=inventories" title="<?php echo $this->lang->line("inventories"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/puchase.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("purchases"); ?></span></span>
								</a>
							</li>
                         <li>
								<a class="tip" href="index.php?module=inventories&view=add" title="<?php echo $this->lang->line("new_purchase"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/puchase_add.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("new_purchase"); ?></span></span>
								</a>
							</li>
                            <li style="position:relative;">
								<a class="tip" href="index.php?module=reports&view=products" title="<?php echo $this->lang->line("product_alerts"); ?>">
                                <!--<span style="background:#C00; width: auto; position: absolute; top: -5px; right:5px; color:#FFF; border-radius: 5px; font-weight:bold; padding:2px 5px;"> </span>-->
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/alert.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("product_alerts"); ?></span></span>
								</a>
							</li>
							<li>
								<a class="tip" href="index.php?module=reports&view=purchases" title="<?php echo $this->lang->line("reports"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/report.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("reports"); ?></span></span>
								</a>
							</li>
							
                            <li>
								<a class="tip" href="index.php?module=auth&view=change_password" title="<?php echo $this->lang->line("change_password"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/user_edit.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("change_password"); ?></span></span>
								</a>
							</li>
							<li>
								<a class="tip" href="index.php?module=auth&view=logout" title="<?php echo $this->lang->line("logout"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/logoff.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("logout"); ?></span></span>
								</a>
							</li>
							
                            </ul>
                            
                            <div class="clearfix"></div>
                            
                        <?php } ?>
                        
                        <?php if ($this->ion_auth->in_group('salesman')) { ?>
                        <ul class="dash">
                         
                        	<li>
								<a class="tip" href="index.php?module=products" title="<?php echo $this->lang->line("products"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/products.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("products"); ?></span></span>
								</a>
							</li>
                            
							<li>
								<a class="tip" href="index.php?module=sales" title="<?php echo $this->lang->line("invoices"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/sales.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("sales"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=sales&view=add" title="<?php echo $this->lang->line("new_sale"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/sale_add.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("new_sale"); ?></span></span>
								</a>
							</li>
                           <li style="position:relative;">
								<a class="tip" href="index.php?module=reports&view=products" title="<?php echo $this->lang->line("product_alerts"); ?>">
                                <!--<span style="background:#C00; width: auto; position: absolute; top: -5px; right:5px; color:#FFF; border-radius: 5px; font-weight:bold; padding:2px 5px;"> </span>-->
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/alert.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("product_alerts"); ?></span></span>
								</a>
							</li>
							<li>
								<a class="tip" href="index.php?module=reports&view=sales" title="<?php echo $this->lang->line("reports"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/report.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("reports"); ?></span></span>
								</a>
							</li>
							
                            <li>
								<a class="tip" href="index.php?module=auth&view=change_password" title="<?php echo $this->lang->line("change_password"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/user_edit.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("change_password"); ?></span></span>
								</a>
							</li>
							<li>
								<a class="tip" href="index.php?module=auth&view=logout" title="<?php echo $this->lang->line("logout"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/logoff.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("logout"); ?></span></span>
								</a>
							</li>
							
                            </ul>
                            
                            <div class="clearfix"></div>
                           
                        <?php } ?>
                        
                         <?php if ($this->ion_auth->in_group('viewer')) { ?>
                       <ul class="dash">
                         
                        	<li>
								<a class="tip" href="index.php?module=products" title="<?php echo $this->lang->line("products"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/products.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("products"); ?></span></span>
								</a>
							</li>
                            <li>
								<a class="tip" href="index.php?module=inventories" title="<?php echo $this->lang->line("inventories"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/puchase.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("purchases"); ?></span></span>
								</a>
							</li>
                         <li>
							<li>
								<a class="tip" href="index.php?module=sales" title="<?php echo $this->lang->line("invoices"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/sales.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("sales"); ?></span></span>
								</a>
							</li>
                            
                            <li style="position:relative;">
								<a class="tip" href="index.php?module=reports&view=products" title="<?php echo $this->lang->line("product_alerts"); ?>">
                                <!--<span style="background:#C00; width: auto; position: absolute; top: -5px; right:5px; color:#FFF; border-radius: 5px; font-weight:bold; padding:2px 5px;"> </span>-->
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/alert.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("product_alerts"); ?></span></span>
								</a>
							</li>
							
                            <li>
								<a class="tip" href="index.php?module=auth&view=change_password" title="<?php echo $this->lang->line("change_password"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/user_edit.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("change_password"); ?></span></span>
								</a>
							</li>
							<li>
								<a class="tip" href="index.php?module=auth&view=logout" title="<?php echo $this->lang->line("logout"); ?>">
									<i><img src="<?php echo $this->config->base_url(); ?>assets/img/icons/logoff.png" alt="" /></i>
									<span><span><?php echo $this->lang->line("logout"); ?></span></span>
								</a>
							</li>
							
                            </ul>
                            
                            <div class="clearfix"></div>
                           
                        <?php } ?>
                        

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 id="myModalLabel"><?php echo $this->lang->line("update_comment"); ?></h4>
</div>
<?php echo form_open("module=home&view=update_comment", 'style="margin-bottom:0;"'); ?>
<div class="modal-body">
<p><?php echo form_textarea('comment', html_entity_decode($com->comment), 'class="input-block-level" id="note"');?></p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line("close"); ?></button>
<button type="submit" class="btn btn-primary" id="ok" data-loading-text=""><?php echo $this->lang->line("submit"); ?></button>
</div>
<?php echo form_close(); ?> 
</div>