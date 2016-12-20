<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
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
					  null,
	
					  { "bSortable": false }
					]
					
                } );
				
            } );
                    
</script>
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>


	<h3 class="title"><?php echo $page_title; ?></h3>
	<p class="introtext"><?php echo $this->lang->line('list_results'); ?></p>
	
	<table id="fileData" class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
		<thead>
        <tr>
			<th style="width:35px;"><?php echo $this->lang->line('no'); ?></th>
			<th><?php echo $this->lang->line('title'); ?></th>
            <th><?php echo $this->lang->line('tax_rate'); ?></th>
            <th><?php echo $this->lang->line('type'); ?></th>
			
            <th style="width:45px;"><?php echo $this->lang->line('actions'); ?></th>
		</tr>
        </thead>
		<tbody>
		<?php 
		$r = 1;
		foreach ($tax_rates as $row):?>
			<tr>
				<td><?php echo $r; ?></td>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->rate; ?></td>
                <td><?php switch ($row->type) {
								case 1:
									echo "Percentage (%)";
									break;
								case 2:
									echo "Fixed ($)";
									break;
						}
					?></td>
                
                <td><?php echo '<center>
                <a href="index.php?module=settings&view=edit_tax_rate&id=' . $row->id . '" title="'. $this->lang->line('update_tax_rate').'" class="tip"><i class="icon-edit"></i></a> 
								<a href="index.php?module=settings&view=delete_tax_rate&id=' . $row->id . '" onClick="return confirm(\''. $this->lang->line('alert_x_tax_rate') .'\')" title="'.$this->lang->line('delete_tax_rate').'" class="tip"><i class="icon-trash"></i></a></center> 
								
							
                '; ?></td>
			</tr>
            
		<?php $r++; endforeach;?>
        </tbody>
	</table>
	
	<p><a href="<?php echo site_url('module=settings&view=add_tax_rate');?>" class="btn btn-primary"><?php echo $this->lang->line('new_tax_rate'); ?></a></p>
