<script src="<?php echo $this->config->base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<style type="text/css">
.text_filter { width: 100% !important; border: 0 !important; box-shadow: none !important;  border-radius: 0 !important;  padding:0 !important; margin:0 !important; }
.select_filter { width: 100% !important; padding:0 !important; height: auto !important; margin:0 !important;}
</style>
<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
                    <?php if(BSTATESAVE) { echo '"bStateSave": true,'; } ?>
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=suppliers&view=getdatatableajax',
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
					  null,
					  null,
					  null,
					  null,
					  null,
					  null, 

					  { "bSortable": false }
					]
					
                } ).columnFilter({ aoColumns: [
                                                            //{ type: "text", bRegex:true },
															//null, null, null, null, null, null, null, null,
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															{ type: "text", bRegex:true },
															null
                                                            
                                                        ]});
				
            } );
                    
</script>

<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>


	<h3 class="title"><?php echo $page_title; ?></h3>
	<p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>
	
	<table id="fileData" cellpadding=0 cellspacing=10 class="table table-bordered table-hover table-striped">
		<thead>
        <tr>
			<th><?php echo $this->lang->line("name"); ?></th>
			<th><?php echo $this->lang->line("company"); ?></th>
            <th><?php echo $this->lang->line("phone"); ?></th>
            <th><?php echo $this->lang->line("email_address"); ?></th>
			<th><?php echo $this->lang->line("city"); ?></th>
            <th><?php echo $this->lang->line("country"); ?></th>
            <th style="width:45px;"><?php echo $this->lang->line("actions"); ?></th>
		</tr>
        </thead>
		<tbody>
			<tr>
            	<td colspan="7" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
        <tfoot>
        <tr>
			<th>[<?php echo $this->lang->line("name"); ?>]</th>
			<th>[<?php echo $this->lang->line("company"); ?>]</th>
            <th>[<?php echo $this->lang->line("phone"); ?>]</th>
            <th>[<?php echo $this->lang->line("email_address"); ?>]</th>
			<th>[<?php echo $this->lang->line("city"); ?>]</th>
            <th>[<?php echo $this->lang->line("country"); ?>]</th>
            <th style="width:45px;"><?php echo $this->lang->line("actions"); ?></th>
		</tr>
        </tfoot>
	</table>
	
	<p><a href="<?php echo site_url('module=suppliers&view=add');?>" class="btn btn-primary"><?php echo $this->lang->line("add_supplier"); ?></a></p>
