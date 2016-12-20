<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
					"sPaginationType": "full_numbers",	
                    "aaSorting": [[ 1, "desc" ]],
                    "iDisplayLength": 10,
					"bJQueryUI": true,
					"sDom": '<"H"frlT>t<"F"ip>',
						//<"H"T><"clear">
						//"sDom": '<"top"i>rt<"bottom"flp><"clear">',
						
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
					  { "bSortable": false },
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
			<th style="width:35px; text-align:center;"><?php echo $this->lang->line("no"); ?></th>
			<th><?php echo $this->lang->line("title"); ?></th>
            <th><?php echo $this->lang->line("type"); ?></th>
			
            <th style="width:45px;"><?php echo $this->lang->line("actions"); ?></th>
		</tr>
        </thead>
		<tbody>
		<?php 
		$r = 1;
		foreach ($invoice_types as $row):?>
			<tr>
				<td style="text-align:center;"><?php echo $r; ?></td>
                <td><?php echo $row->name; ?></td>
                <td style="text-transform:capitalize;"><?php echo $row->type; ?></td>
                
                <td><?php echo '<center>
                <a href="index.php?module=settings&view=edit_invoice_type&id=' . $row->id . '">
								<img src="'.$this->config->base_url().'smlib/images/edit.png" width="16" height="16" title="'.$this->lang->line("update_invoice_type").'" style="margin:1px;"/>
								</a> 
								<a href="index.php?module=settings&view=delete_invoice_type&id=' . $row->id . '" onClick="return confirm(\''. $this->lang->line('alert_x_invoice_type') .'\')">
								<img src="'.$this->config->base_url().'smlib/images/delete.png" width="16" height="16" title="'.$this->lang->line('delete_invoice_type').'" style="margin:1px;"/>
								</a> </center>
								
			
                '; ?></td>
			</tr>
            
		<?php $r++; endforeach;?>
        </tbody>
	</table>
	
	<p><a href="<?php echo site_url('module=settings&view=add_invoice_type');?>" class="button"><?php echo $this->lang->line("new_invoice_type"); ?></a></p>
	
</div>
<div class="clr"></div>
</div>
<div class="clear"></div>
</div>
</div>
