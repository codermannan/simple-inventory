<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
					"sPaginationType": "full_numbers",	
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
					"bJQueryUI": true,
					"sDom": '<"H"frlT><"clear">t<"clear"><"F"ip>',
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=suppliers&view=getdatatableajax',
					'fnServerData': function(sSource, aoData, fnCallback)
					{
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
					
                } );
				
            } );
                    
</script>
        
<div id="body_section">
<!-- Errors -->
<?php if ($message) { echo "<div class=\"yellow_bar\">".$message."</div>"; } ?>
<div id="body_section_inner">
<div class="contentPageWrapper">

<div class='mainInfo'>

	<h1><?php echo $page_title; ?></h1>
	<p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>
	
	<table id="fileData" cellpadding=0 cellspacing=10 width="100%">
		<thead>
        <tr>
			<th><?php echo $this->lang->line("name"); ?></th>
			<th><?php echo $this->lang->line("company"); ?></th>
            <th><?php echo $this->lang->line("phone"); ?></th>
            <th><?php echo $this->lang->line("email_address"); ?></th>
			<!-- <th>Address</th> -->
			<th><?php echo $this->lang->line("city"); ?></th>
            <th><?php echo $this->lang->line("country"); ?></th>
            <th style="width:45px;"><?php echo $this->lang->line("actions"); ?></th>
		</tr>
        </thead>
		<tbody>
			<tr>
            	<td colspan="4" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
	</table>
	
	<p><a href="<?php echo site_url('module=suppliers&view=add');?>" class="button"><?php echo $this->lang->line("add_supplier"); ?></a></p>
	
</div>
<div class="clr"></div>
</div>
<div class="clear"></div>
</div>
</div>
