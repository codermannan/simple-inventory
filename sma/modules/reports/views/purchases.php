<?php
if($this->input->post('submit')) {
		   
		  $v = "";
		  /*if($this->input->post('name')){
			   $v .= "&name=".$this->input->post('name');
		   }*/ 
		   if($this->input->post('reference_no')){
			   $v .= "&reference_no=".$this->input->post('reference_no');
		   }
		   if($this->input->post('supplier')){
			   $v .= "&supplier=".$this->input->post('supplier');
		   } 
		   if($this->input->post('warehouse')){
			   $v .= "&warehouse=".$this->input->post('warehouse');
		   } 
		   if($this->input->post('user')){
			   $v .= "&user=".$this->input->post('user');
		   }
		   if($this->input->post('start_date')){
			   $v .= "&start_date=".$this->input->post('start_date');
		   }
		   if($this->input->post('end_date')) {
			    $v .= "&end_date=".$this->input->post('end_date');
		   }
	  
}
?>
<script src="<?php echo base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<style type="text/css">
.text_filter { width: 100% !important; font-weight: normal !important; border: 0 !important; box-shadow: none !important;  border-radius: 0 !important;  padding:0 !important; margin:0 !important; font-size: 1em !important;}
.select_filter { width: 100% !important; padding:0 !important; height: auto !important; margin:0 !important;}
.table td { width: 12.5%; display: table-cell; }
.table th { text-align: center; }
.table td:nth-child(6), .table tfoot th:nth-child(6), .table td:nth-child(7), .table tfoot th:nth-child(7), .table td:nth-child(8), .table tfoot th:nth-child(8) { text-align:right; }
</style>
<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/query-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$( "#start_date" ).datepicker({
        	format: "<?php echo JS_DATE; ?>",
			autoclose: true
    	});

		$( "#end_date" ).datepicker({
        	format: "<?php echo JS_DATE; ?>",
			autoclose: true
    	});
		<?php if(!isset($_POST['submit'])) { echo '$( "#end_date" ).datepicker("setDate", new Date());'; } ?>
		<?php if($this->input->post('submit')) { echo "$('.form').hide();"; } ?>
        $(".toggle_form").slideDown('slow');
 
		$('.toggle_form').click(function(){
			$(".form").slideToggle();
			return false;
		});
		
	});
</script>
<script>
             $(document).ready(function() {

                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 1, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=reports&view=getPurchases<?php 
					if($this->input->post('submit')) { echo $v; } ?>',
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
								{
									"sExtends": "csv",
									"sFileName": "<?php echo $this->lang->line("purchases"); ?>.csv",
                   		 			"mColumns": [ 0, 1, 2, 3, 4, 5 ]
								},
								{
									"sExtends": "pdf",
									"sFileName": "<?php echo $this->lang->line("purchases"); ?>.pdf",
									"sPdfOrientation": "landscape",
                   		 			"mColumns": [ 0, 1, 2, 3, 4, 5 ]
								},
								"print"
						]
					},
					"aoColumns": [ 
					  { "mRender": format_date },
					  null,
					  null,
					  null,
					  { "bSearchable": false },
					  { "mRender": currencyFormate },
					  { "mRender": currencyFormate },
                                          { "mRender": currencyFormate }
					],
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
						var total = 0; tax_total =0; gtotal = 0;
						for ( var i=0 ; i<aaData.length ; i++ )
						{
							total += parseFloat(aaData[ aiDisplay[i] ][5]);
                                                        tax_total += parseFloat(aaData[ aiDisplay[i] ][6]);
                                                        gtotal += parseFloat(aaData[ aiDisplay[i] ][7]);
						}
						
						var nCells = nRow.getElementsByTagName('th');
						nCells[5].innerHTML = currencyFormate(parseFloat(total).toFixed(2));
                                                nCells[6].innerHTML = currencyFormate(parseFloat(tax_total).toFixed(2));
                                                nCells[7].innerHTML = currencyFormate(parseFloat(gtotal).toFixed(2));
					}
                    }).columnFilter({ aoColumns: [
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						null, null, null, null
                     ]});
				
            });
                    
</script>

<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">

<h3 class="title"><?php echo $page_title; ?> <a href="#" class="btn btn-mini toggle_form"><?php echo $this->lang->line("show_hide"); ?></a></h3>

<div class="form">
<p>Please customise the report below.</p>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=reports&view=purchases", $attrib); ?>
<div class="control-group">
  <label class="control-label" for="reference_no"><?php echo $this->lang->line("reference_no"); ?></label>
  <div class="controls"> <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ""), 'class="span4" id="reference_no"');?>
  </div>
</div> 
<!--<div class="control-group">
  <label class="control-label" for="name"><?php echo $this->lang->line("product_name"); ?></label>
  <div class="controls"> <?php echo form_input('name', (isset($_POST['name']) ? $_POST['name'] : ""), 'class="span4" id="name"');?>
  </div>
</div>--> 
<div class="control-group">
  <label class="control-label" for="user"><?php echo $this->lang->line("created_by"); ?></label>
  <div class="controls"> <?php 
	   		$us[""] = "";
	   		foreach($users as $user){
				$us[$user->id] = $user->first_name." ".$user->last_name;
			}
			echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="span4" id="user" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("user").'"');  ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="supplier"><?php echo $this->lang->line("supplier"); ?></label>
  <div class="controls"> <?php 
	   		$sp[""] = "";
	   		foreach($suppliers as $supplier){
				$sp[$supplier->id] = $supplier->name;
			}
			echo form_dropdown('supplier', $sp, (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'class="span4" id="supplier" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("supplier").'"');  ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="warehouse"><?php echo $this->lang->line("warehouse"); ?></label>
  <div class="controls"> <?php 
	   		$wh[""] = "";
	   		foreach($warehouses as $warehouse){
				$wh[$warehouse->id] = $warehouse->name;
			}
			echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ""), 'class="span4" id="warehouse" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("warehouse").'"');  ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="start_date"><?php echo $this->lang->line("start_date"); ?></label>
  <div class="controls"> <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="span4" id="start_date"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="end_date"><?php echo $this->lang->line("end_date"); ?></label>
  <div class="controls"> <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="span4" id="end_date"');?> </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?>

</div>
<div class="clearfix"></div>

<?php if($this->input->post('submit')) { ?>

	<table id="fileData" class="table table-bordered table-hover table-striped table-condensed" style="margin-bottom: 5px;">
 
	<thead>
        <tr>
            <th><?php echo $this->lang->line("date"); ?></th>
            <th><?php echo $this->lang->line("ref_no"); ?></th>
            <th><?php echo $this->lang->line("warehouse"); ?></th>
            <th><?php echo $this->lang->line("supplier"); ?></th>
            <th><?php echo $this->lang->line("product_qty"); ?></th>
            <th><?php echo $this->lang->line("total"); ?></th>
            <th><?php echo $this->lang->line("product_tax"); ?></th>
            <th><?php echo $this->lang->line("grand_total"); ?></th>
	</tr>
        </thead>
		<tbody>
			<tr>
            	<td colspan="8" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
        <tfoot>
        <tr>
            <th>[<?php echo $this->lang->line("date"); ?>]</th>
            <th>[<?php echo $this->lang->line("ref_no"); ?>]</th>
            <th>[<?php echo $this->lang->line("warehouse"); ?>]</th>
            <th>[<?php echo $this->lang->line("supplier"); ?>]</th>
            <th><?php echo $this->lang->line("product_qty"); ?></th>
            <th><?php echo $this->lang->line("total"); ?></th>
            <th><?php echo $this->lang->line("product_tax"); ?></th>
            <th><?php echo $this->lang->line("grand_total"); ?></th>
	</tr>
        </tfoot>
	</table>

<?php } ?>
<p>&nbsp;</p>
