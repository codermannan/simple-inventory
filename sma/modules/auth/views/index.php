<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 4, "asc" ]],
                    "iDisplayLength": 10,
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
					  { "bSortable": false }
					]
					
                } );
				
            } );
                    
</script>
        

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>


	<h3 class="title"><?php echo $this->lang->line("users") ?></h3>
	<p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>
	
	<table id="fileData" class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
		<thead>
        <tr>
			<th><?php echo $this->lang->line("first_name"); ?></th>
			<th><?php echo $this->lang->line("last_name"); ?></th>
			<th><?php echo $this->lang->line("email_address") ?></th>
            <th><?php echo $this->lang->line("phone"); ?></th>
			<th><?php echo $this->lang->line("user_role"); ?></th>
			<th style="width:45px;"><?php echo $this->lang->line("actions"); ?></th>
		</tr>
        </thead>
		<tbody>
		<?php foreach ($users as $user):?>
			<tr>
				<td><?php echo $user->first_name;?></td>
				<td><?php echo $user->last_name;?></td>
				<td><?php echo $user->email;?></td>
                <td><?php echo $user->phone;?></td>
				<td>
					<?php foreach ($user->groups as $group):?>
						<?php echo $group->description;?>
	                <?php endforeach?>
				</td>
				<td style="text-align:center;"><?php /* echo ($user->active) ? anchor("auth/deactivate/".$user->id, 'Active') : anchor("auth/activate/". $user->id, 'Inactive'); */ ?>
                <?php echo '
                <a class="tip" title="'.$this->lang->line("edit_user").'" href="index.php?module=auth&view=edit_user&id=' . $user->id . '"><i class="icon-edit"></i></a> ';
								if ($this->ion_auth->in_group('owner')) {
								echo '<a class="tip" title="'.$this->lang->line("delete_user").'" href="index.php?module=auth&view=delete_user&id=' . $user->id . '" onClick="return confirm(\''. $this->lang->line('alert_x_user') .'\');"><i class="icon-trash"></i></a>
                '; }  ?></td>
			</tr>
		<?php endforeach;?>
        </tbody>
	</table>
	
	<p><a href="<?php echo site_url('module=auth&view=create_user');?>" class="btn btn-primary"><?php echo $this->lang->line("add_user"); ?></a></p>
	
