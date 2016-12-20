<script src="<?php echo base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<style type="text/css">
.text_filter { width: 100% !important; font-weight: normal !important; border: 0 !important; box-shadow: none !important;  border-radius: 0 !important;  padding:0 !important; margin:0 !important; font-size: 1em !important;}
.select_filter { width: 100% !important; padding:0 !important; height: auto !important; margin:0 !important;}
.table td { width: 14.285%; }
</style>
<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=reports&view=getProductAlerts',
					'fnServerData': function(sSource, aoData, fnCallback)
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
									"sFileName": "Products.csv",
                   		 			"mColumns": [ 0, 1, 2, 3, 4, 5 ]
								},
								{
									"sExtends": "pdf",
									"sFileName": "<?php echo $this->lang->line("products"); ?>.pdf",
									"sPdfOrientation": "landscape",
                   		 			"mColumns": [ 0, 1, 2, 3, 4, 5 ]
								},
								"print"
						]
					},
					"oLanguage": {
					  "sSearch": "Filter: "
					},
					"aoColumns": [ 
					  null, null, null, null, null, null,
					  { "bSortable": false }
					]
					
                } ).columnFilter({ aoColumns: [
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						null
                     ]});
			$('#fileData').on('click', '.image', function() {
				var a_href = $(this).attr('href');
				var code = $(this).attr('id');
				$('#myModalLabel').text(code);
				$('#product_image').attr('src',a_href);
				$('#picModal').modal();
				return false;
			});
			
			$('#fileData').on('click', '.barcode', function() {
				var a_href = $(this).attr('href');
				var code = $(this).attr('id');
				$('#myModalLabel').text(code);
				$('#product_image').attr('src',a_href);
				$('#picModal').modal();
				return false;
			});
			
            } );
                    
</script>

    <h3 class="title"><?php echo $this->lang->line("product_alerts")."' ".$this->lang->line("reports"); //. " ( <span style='color: #F00;'>".$n."</span> )"; 
	?> <!--(<span style="color: #F00"><?php /* echo $n; */ ?></span>)--></h3>
    <p><?php echo $this->lang->line("list_results"); ?></p>
	<br />
	<table id="fileData" class="table table-bordered table-hover table-striped table-condensed" style="margin-bottom: 5px;">
		<thead>
        <tr>
			<th><?php echo $this->lang->line("product_code"); ?></th>
            <th><?php echo $this->lang->line("product_name"); ?></th>
            <th><?php echo $this->lang->line("product_unit"); ?></th>
            <th><?php echo $this->lang->line("product_price"); ?></th>
            <th><?php echo $this->lang->line("quantity"); ?></th>
            <th><?php echo $this->lang->line("alert_quantity"); ?></th>
            <th style="width:85px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th> 
		</tr>
        </thead>
		<tbody>
			<tr>
            	<td colspan="7" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
        <tfoot>
        <tr>
			<th>[<?php echo $this->lang->line("product_code"); ?>]</th>
            <th>[<?php echo $this->lang->line("product_name"); ?>]</th>
            <th>[<?php echo $this->lang->line("product_unit"); ?>]</th>
            <th>[<?php echo $this->lang->line("product_price"); ?>]</th>
            <th>[<?php echo $this->lang->line("quantity"); ?>]</th>
            <th>[<?php echo $this->lang->line("alert_quantity"); ?>]</th>
            <th style="width:85px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th> 
		</tr>
        </tfoot>
	</table>

<div id="picModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="picModalLabel" aria-hidden="true">
 <div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel"></h3>
</div>
<div class="modal-body" style="text-align:center; height:200px;">
<img id="product_image" src="" style="height:100%;" />
</div>
<div class="modal-footer">
<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>