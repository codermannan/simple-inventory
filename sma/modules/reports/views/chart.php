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
    	/*
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
		*/
		
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
				headerFormat: '<span style="font-size:14px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
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
                    ['<?php echo $this->lang->line("stock_value_by_price"); ?>',   <?php echo $stock->stock_by_price; ?>],
                    ['<?php echo $this->lang->line("stock_value_by_cost"); ?>',   <?php echo $stock->stock_by_cost; ?>],
                ],
                center: [80, 42],
                size: 80,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });
    });
</script>
<h3 class="title"><?php echo $page_title; ?></h3>
<p><?php echo $this->lang->line("overview_chart_heading"); ?></p>
<p>&nbsp;</p>
<div id="chart" style="width:100%; height:450px;"></div>
<p class="text-center"><?php echo $this->lang->line("chart_lable_toggle"); ?></p>