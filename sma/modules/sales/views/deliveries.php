<script src="<?php echo base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<style type="text/css">
.text_filter {
	width: 100% !important;
	font-weight: normal !important;
	border: 0 !important;
	box-shadow: none !important;
	border-radius: 0 !important;
	padding:0 !important;
	margin:0 !important;
	font-size: 1em !important;
}
.select_filter {
	width: 100% !important;
	padding:0 !important;
	height: auto !important;
	margin:0 !important;
}
.table td {
	width: 12%;
	display: table-cell;
}
.table th {
	text-align: center;
}
.table td:nth-child(5) {
	width: 40%;
}
</style>
<script>
             $(document).ready(function() {
				function format_date(oObj) {
					//var sValue = oObj.aData[oObj.iDataColumn]; 
					var aDate = oObj.split('-');
					<?php if(JS_DATE == 'dd-mm-yyyy') { ?>
					return aDate[2] + "-" + aDate[1] + "-" + aDate[0];
					<?php } elseif(JS_DATE == 'dd/mm/yyyy') { ?>
					return aDate[2] + "/" + aDate[1] + "/" + aDate[0];
					<?php } elseif(JS_DATE == 'mm/dd/yyyy') { ?>
					return aDate[1] + "/" + aDate[2] + "/" + aDate[0];
					<?php } elseif(JS_DATE == 'mm-dd-yyyy') { ?>
					return aDate[1] + "-" + aDate[2] + "-" + aDate[0];
					<?php } else { ?>
					return sValue;
					<?php } ?>
				}
				function currencyFormate(x) {
					var parts = x.toString().split(".");
				   return  parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",")+(parts[1] ? "." + parts[1] : ".00");
					 
				}
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=sales&view=getdeliveries',
					'fnServerData': function(sSource, aoData, fnCallback, fnFooterCallback)
					{
						aoData.push( { "name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash() ?>" } );
					  $.ajax
					  ({
						'dataType': 'json',
						'type'    : 'POST',
						'url'     : sSource,
						'data'    : aoData,
						'success' : fnCallback
					  });
					},
					"oTableTools": {
						"sSwfPath": "assets/media/swf/copy_csv_xls_pdf.swf",
						"aButtons": [
								{
									"sExtends": "csv",
									"sFileName": "<?php echo $this->lang->line("deliveries"); ?>.csv",
                   		 			"mColumns": [ 0, 1, 2, 3, 4, 5 ]
								},
								{
									"sExtends": "pdf",
									"sFileName": "<?php echo $this->lang->line("deliveries"); ?>.pdf",
									"sPdfOrientation": "landscape",
                   		 			"mColumns": [ 0, 1, 2, 3, 4, 5 ]
								},
								"print"
						]
					},
					"aoColumns": [ 
					  { "mRender": format_date },  null,  null, null, null,
					  { "bSortable": false }
					]
					
                } ).columnFilter({ aoColumns: [

						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						null
                     ]});
				
            } );
                    
</script>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>

<div class="btn-group pull-right" style="margin-left: 25px;"> <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("all_warehouses"); ?> <span class="caret"></span> </a>
  <ul class="dropdown-menu">
    <?php
	foreach($warehouses as $warehouse) {
		echo "<li><a href='index.php?module=sales&view=warehouse&warehouse_id=".$warehouse->id."'>".$warehouse->name."</a></li>";	
	}
	?>
  </ul>
</div>
<h3 class="title"><?php echo $page_title; ?></h3>
<p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>
<table id="fileData" class="table table-bordered table-hover table-striped table-condensed" style="margin-bottom: 5px;">
  <thead>
    <tr>
      <th><?php echo $this->lang->line("date"); ?></th>
      <th><?php echo $this->lang->line("time"); ?></th>
      <th><?php echo $this->lang->line("reference_no"); ?></th>
      <th><?php echo $this->lang->line("customer"); ?></th>
      <th><?php echo $this->lang->line("address"); ?></th>
      <th style="width:115px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="6" class="dataTables_empty"><?php echo $this->lang->line("loading_data"); ?></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <th>[<?php echo $this->lang->line("date"); ?> (yyyy-mm-dd)]</th>
      <th><?php echo $this->lang->line("time"); ?></th>
      <th><?php echo $this->lang->line("reference_no"); ?></th>
      <th><?php echo $this->lang->line("customer"); ?></th>
      <th><?php echo $this->lang->line("address"); ?></th>
      <th style="width:115px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
    </tr>
  </tfoot>
</table>
<a href="<?php echo site_url('module=sales');?>" class="btn btn-primary"><?php echo $this->lang->line("back_to_sales"); ?></a>

  </ul>
</div>
