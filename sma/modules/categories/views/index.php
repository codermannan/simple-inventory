<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
                    <?php if(BSTATESAVE) { echo '"bStateSave": true,'; } ?>
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=categories&view=getdatatableajax',
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
						"sSwfPath": "smlib/media/swf/copy_csv_xls_pdf.swf",
						"aButtons": [
								{
									"sExtends": "csv",
									"sFileName": "Products.csv",
                   		 			"mColumns": [ 0, 1, 2 ]
								},
								{
									"sExtends": "pdf",
									"sFileName": "<?php echo $this->lang->line("products"); ?>.pdf",
									"sPdfOrientation": "landscape",
                   		 			"mColumns": [ 0, 1, 2 ]
								},
								"print"
						]
					},
					"aoColumns": [ 
					  null,
					  null,
					  null,
					  { "bSortable": false }
					]
					
                } );
				
            } );
       
</script>
        
<!-- Errors -->
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?></h3>
	<p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>
	
	<table id="fileData" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
		<thead>
        <tr>
			<th style="width:45px;"><?php echo $this->lang->line("no"); ?></th>
            <th><?php echo $this->lang->line("category_code"); ?></th>
			<th><?php echo $this->lang->line("category_name"); ?></th>
            <th style="width:65px;"><?php echo $this->lang->line("actions"); ?></th>
		</tr>
        </thead>
		<tbody>
			<tr>
            	<td colspan="4" class="dataTables_empty">Loading data from server</td>
			</tr>

        </tbody>
	</table>
	
	<p><a href="<?php echo site_url('module=categories&view=add');?>" class="btn btn-primary"><?php echo $this->lang->line("add_category"); ?></a></p>
	

