<?php   
		foreach($monthly_sales as $month_sale) {
		$months[] = $month_sale->month; 
		$sales[] = $month_sale->sales;
		$tax1[] = $month_sale->tax1;
		$tax2[] = $month_sale->tax2;
		} 
		
		foreach($monthly_purchases as $month_purchase) {
		$purchases[] = $month_purchase->purchases;
		} 

?>   
<script src="<?php echo base_url(); ?>/assets/js/sl/highcharts.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/sl/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
    	
    	// Radialize the colors
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
		
		$('#chart').highcharts({
            chart: {
            },
			credits: {
			  	enabled: false
			},
            title: {
                text: ''
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
                valuePrefix: '<?php echo CURRENCY_PREFIX; ?> ',
				style: {
					fontSize: '13px',
					padding: '10px'
				}
            },
            labels: {
                items: [{
                    html: 'Stock Manager Overview Chart',
                    style: {
                        left: '40px',
                        top: '8px',
                        color: 'black'
                    }
                }]
            },
            series: [{
                type: 'column',
                name: 'tax1',
                data: [<?php 
				echo implode(', ', $tax1);
				?>]
            },
			{
                type: 'column',
                name: 'tax2',
                data: [<?php 
				echo implode(', ', $tax2);
				?>]
            },
			{
                type: 'column',
                name: 'Sales',
                data: [<?php 
				echo implode(', ', $sales);
				?>]
            },  {
                type: 'spline',
                name: 'Purchases',
                data: [<?php 
				echo implode(', ', $purchases);
				?>],
                marker: {
                	lineWidth: 2,
                	lineColor: Highcharts.getOptions().colors[3],
                	fillColor: 'white'
                }
            }, {
                type: 'pie',
                name: 'Current Stock Value',
                data: [
                    ['Stock Value By Price',   <?php echo $stock->stock_by_price; ?>],
                    ['Stock Value By Cost',   <?php echo $stock->stock_by_cost; ?>],
                ],
                center: [100, 80],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });
    });
</script>
<h3 class="title"><?php echo $page_title; ?></h3>
<div id="chart" style="width:100%; height:450px;"></div>