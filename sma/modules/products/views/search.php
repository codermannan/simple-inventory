<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
					"sPaginationType": "full_numbers",	
                    "aaSorting": [[ 1, "asc" ]],
                    "iDisplayLength": 10,
					"bJQueryUI": true,
					"sDom": '<"H"frlT><"clear">t<"clear"><"F"p>',
						//<"H"T><"clear">
						//"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo site_url('module=products&view=getseatchresults&srq='.$sr_name.'\''); ?>,
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
<?php /* print_r($rows); */ ?>
<div class='mainInfo'>

	<h1><?php echo $page_title; ?></h1>
	<p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>
	
	<table id="fileData" cellpadding=0 cellspacing=10 width="100%">
		<thead>
        <tr>
			<th><?php echo $this->lang->line("product_code"); ?></th>
            <th><?php echo $this->lang->line("product_name"); ?></th>
            
			<th><?php echo $this->lang->line("product_unit"); ?></th>
			<th><?php echo $this->lang->line("product_cost"); ?></th>
            <th><?php echo $this->lang->line("product_price"); ?></th>
            <th><?php echo $this->lang->line("quantity"); ?></th>
            <th><?php echo $this->lang->line("alert_quantity"); ?></th>
            <th style="width:105px;"><?php echo $this->lang->line("actions"); ?></th>
		</tr>
        </thead>
		<tbody>
			<tr>
            	<td colspan="8" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
	</table>
	
	
</div>
<div class="clr"></div>
</div>
<div class="clear"></div>
</div>
</div>