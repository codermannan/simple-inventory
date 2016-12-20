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
			<th style="width:35px; text-align:center;"><?php echo $this->lang->line('no'); ?></th>
            <th><?php echo $this->lang->line('warehouse_code'); ?></th>
			<th><?php echo $this->lang->line('warehouse_name'); ?></th>
            <th><?php echo $this->lang->line('address'); ?></th>
			<th><?php echo $this->lang->line('city'); ?></th>
            <th style="width:45px;"><?php echo $this->lang->line('actions'); ?></th>
		</tr>
        </thead>
		<tbody>
		<?php 
		$r = 1;
		foreach ($warehouses as $row):?>
			<tr>
				<td style="text-align:center;"><?php echo $r; ?></td>
                <td><?php echo $row->code; ?></td>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->address; ?></td>
                <td><?php echo $row->city; ?></td>
                <td><?php echo '<center>
                				<a href="index.php?module=settings&view=edit_warehouse&id=' . $row->id . '" title="'.$this->lang->line('update_warehouse').'" class="tip"><i class="icon-edit"></i></a>
								<a href="index.php?module=settings&view=delete_warehouse&id=' . $row->id . '" onClick="return confirm(\''. $this->lang->line('alert_x_warehouse') .'\')"  title="'.$this->lang->line('delete_warehouse').'" class="tip"><i class="icon-trash"></i></a> 			
								
                </center>'; ?></td>
			</tr>
            
		<?php $r++; endforeach;?>
        </tbody>
	</table>
	
	<p><a href="<?php echo site_url('module=settings&view=add_warehouse');?>" class="btn btn-primary"><?php echo $this->lang->line('add_warehouse'); ?></a></p>
