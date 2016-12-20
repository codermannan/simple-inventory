<script>
             $(document).ready(function() {
                $('#fileData').dataTable( {
					/*"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
					"sPaginationType": "full_numbers",	*/
                    "aaSorting": [[ 1, "desc" ]],
                    "iDisplayLength": -1,
					"bJQueryUI": true,
					"sDom": '<"H"frT>t',
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
					  null,
					  null,
					  null,
					  <?php $groups = array('salesman', 'viewer');
						if (!$this->ion_auth->in_group($groups))
						{ ?>
					 null,
					<?php } ?>
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
	<center>
    <a class="button" href="products" style="margin: 0px 5px 10px 5px;"><?php echo $this->lang->line("all_warehouses"); ?></a>
	<?php
	foreach($warehouses as $warehouse) {
		echo "<a class='button' href='products/warehouse/".$warehouse->id."' style='margin: 0px 5px 10px 5px;'>".$warehouse->name."</a>";	
	}
	?></center>
	<table id="fileData" cellpadding=0 cellspacing=10 width="100%">
		<thead>
        <tr>
			<th style="width:45px;"><?php echo $this->lang->line("image"); ?></th>
			<th><?php echo $this->lang->line("product_code"); ?></th>
            <th><?php echo $this->lang->line("product_name"); ?></th>
            <th><?php echo $this->lang->line("quantity"); ?></th>
			<th><?php echo $this->lang->line("product_unit"); ?></th>
			<th><?php echo $this->lang->line("product_size"); ?></th>
        
			<?php $groups = array('salesman', 'viewer');
            if (!$this->ion_auth->in_group($groups))
            { ?>
                <th><?php echo $this->lang->line("product_cost"); ?></th>
            <?php } ?>
            
             <th><?php echo $this->lang->line("product_price"); ?></th>
            <!-- <th><?php echo $this->lang->line("alert_quantity"); ?></th> -->
            <th style="width:45px;"><?php echo $this->lang->line("actions"); ?></th>
		</tr>
        </thead>
		<tbody>
		<?php foreach ($rows as $row):?>
			<tr>
            	<td style="text-align:center;">
				<?php echo '<a class="ajax" href="uploads/' . $row['image'] .'"><img src="uploads/' . $row['image'] . '" alt="' . $row['image'] . '" width="24" height="24" /></a>'; ?></td>
				<td><?php echo $row['code']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['unit']; ?></td>
                <td><?php echo $row['size']; ?></td>
                <?php $groups = array('salesman', 'viewer');
				if (!$this->ion_auth->in_group($groups))
				{ ?>
					 <td><?php echo $row['cost']; ?></td>
				<?php } ?>
               
                <td><?php echo $row['price']; ?></td>
                <!-- <td><?php echo $row['alert_quantity']; ?></td> -->
                
                <td style="text-align:center;"><?php echo '
                <a href="products/edit/' . $row['id'] . '">
								<img src="'.$this->config->base_url().'smlib/images/edit.png" width="16" height="16" title="'.$this->lang->line("edit_product").'" style="margin:1px;"/>
								</a>';
								if ($this->ion_auth->in_group('owner')) {
								echo '<a href="products/delete/' .  $row['id'] . '" onClick="return confirm(\''. $this->lang->line('alert_x_product') .'\');">
								<img src="'.$this->config->base_url().'smlib/images/delete.png" width="16" height="16" title="'.$this->lang->line("delete_product").'" style="margin:1px;"/>
								</a>
                '; } ?></td>
			</tr>
		<?php endforeach;?>
        </tbody>
	</table>
	<?php if($links) { echo $links; } else { echo "<div class=\"pagerSC\"></div>"; }?>
	<p><a href="<?php echo site_url('products/add');?>" class="button"><?php echo $this->lang->line("add_product"); ?></a></p>
	
</div>
<div class="clr"></div>
</div>
<div class="clear"></div>
</div>
</div>