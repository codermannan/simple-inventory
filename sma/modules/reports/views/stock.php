  
<script src="<?php echo base_url(); ?>/assets/js/sl/highcharts.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/sl/modules/exporting.js"></script>
<script type="text/javascript">

				
$(function () {
    	
		function currencyFormate(x) {
					var parts = x.toString().split(".");
				   return  parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",")+(parts[1] ? "." + ((parts[1].length == 1) ? parts[1]+'0' : parts[1]) : ".00");
					 
				}
				
		$('#chart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: ''
        },
		credits: {
			  	enabled: false
			},
		tooltip: {
				shared: true,
				backgroundColor: '#FFF',
				headerFormat: '<span style="font-size:15px background-color: #FFF;">{point.key}</span><br>',
                pointFormat: '<span style="color:{series.color};padding:0;text-align:right;"><?php echo CURRENCY_PREFIX; ?> <b>{point.y}</b> ({point.percentage:.2f}%)</span>',
                footerFormat: '',
                useHTML: true,
				valueDecimals: 2,
				style: {
					fontSize: '13px',
					padding: '10px',
					color: '#000000'
				}
            },
			plotOptions: {
            	pie: {
                dataLabels: {
                    enabled: true,
                    //format: '<h4 style="margin:-15px 0 0 0;"><b>{point.name}</b>:<br><?php echo CURRENCY_PREFIX; ?> <b> {point.y} </b></h4>',
					formatter: function() {
                        return '<h3 style="margin:-15px 0 0 0;"><b>'+this.point.name+'</b>:<br><?php echo CURRENCY_PREFIX; ?> <b> ' + currencyFormate(this.y) +'</b></h3>';
                    },
					useHTML: true
                }
            }
        },
        series: [{
            type: 'pie',
            name: '<?php echo $this->lang->line("stock_value"); ?>',
            data: [
                    ['<?php echo $this->lang->line("stock_value_by_price"); ?>',   <?php echo $stock->stock_by_price; ?>],
                    ['<?php echo $this->lang->line("stock_value_by_cost"); ?>',   <?php echo $stock->stock_by_cost; ?>],
					['<?php echo $this->lang->line("profit_estimate"); ?>',   <?php echo ($stock->stock_by_price - $stock->stock_by_cost); ?>],
                ]
		
        }]
    });
	
    });
</script>
<div class="btn-group pull-right" style="margin-left: 25px;">
<a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
<?php $links = '';
	foreach($warehouses as $warehouse) {
		if($warehouse->id == $warehouse_id) {
			$wh_name = $warehouse->name;
			echo $wh_name;
		} else {
			$links .= "<li><a href='index.php?module=reports&view=warehouse_stock&warehouse=".$warehouse->id."'>".$warehouse->name."</a></li>";
		}
	} 
	?>
<span class="caret"></span>
</a>
<ul class="dropdown-menu">
    <?php echo $links; ?>
    </ul>
    </div>
<h3 class="title"><?php echo $page_title." (".$wh_name.")"; ?></h3>
<p><?php echo $this->lang->line("warehouse_stock_heading"); ?></p>
<p>&nbsp;</p>
<div id="chart" style="width:100%; height:450px;"></div>
