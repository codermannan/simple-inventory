<script>
             $(document).ready(function() {

                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 1, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
                    <?php if(BSTATESAVE) { echo '"bStateSave": true,'; } ?>
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=quotes&view=getquotes',
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
								// "copy",
								"csv",
								"xls",
								{
									"sExtends": "pdf",
									"sPdfOrientation": "landscape",
									"sPdfMessage": ""
								},
								"print"
						]
					},
					"oLanguage": {
					  "sSearch": "Filter: "
					},
					"aoColumns": [ 
					  { "mRender": format_date }, null, null, null, { "mRender": currencyFormate },
					  { "bSortable": false }
					]
					
                } );
				
            } );
                    
</script>
<style>
.table th { text-align: center; }
.table td { width:16.666%; }
.table td:nth-child(5), .table tfoot th:nth-child(5) {	text-align:right; }
</style>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?></h3>
	<p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>
	
	<table id="fileData" class="table table-bordered table-hover table-striped table-condensed" style="margin-bottom: 5px;">
		<thead>
        <tr>
            <th><?php echo $this->lang->line("date"); ?></th>
			<th><?php echo $this->lang->line("reference_no"); ?></th>
            <th><?php echo $this->lang->line("biller"); ?></th>
            <th><?php echo $this->lang->line("customer"); ?></th>
            <th><?php echo $this->lang->line("total"); ?></th>
			<!--<th>note</th>-->
            <th style="width:135px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
		</tr>
        </thead>
		<tbody>
			<tr>
            	<td colspan="6" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
	</table>

	<a href="<?php echo site_url('module=quotes&view=add');?>" class="btn btn-primary"><?php echo $this->lang->line("add_quote"); ?></a>