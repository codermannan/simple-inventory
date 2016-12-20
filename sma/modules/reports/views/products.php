<?php
$v = "";
if($this->input->post('submit')) {
		  
		    if($this->input->post('product')){
			   $v .= "&product=".$this->input->post('product');
		   } 
		   if($this->input->post('start_date')){
			   $v .= "&start_date=".$this->input->post('start_date');
		   }
		   if($this->input->post('end_date')) {
			    $v .= "&end_date=".$this->input->post('end_date');
		   }
	  
}
?>
<style type="text/css">
.text_filter { width: 100% !important; font-weight: normal !important; border: 0 !important; box-shadow: none !important;  border-radius: 0 !important;  padding:0 !important; margin:0 !important; font-size: 1em !important;}
.select_filter { width: 100% !important; padding:0 !important; height: auto !important; margin:0 !important;}
.table td { width: 12%; display: table-cell; }
.table td:first-child, .table td:nth-child(2) { width: 21%; }
.table th, .table td:nth-child(3), .table tfoot th:nth-child(3),.table td:nth-child(4), .table tfoot th:nth-child(4) { text-align: center; }
.table td:nth-child(5), .table tfoot th:nth-child(5), .table td:nth-child(6), .table tfoot th:nth-child(6) { text-align:right; }
span.date { display: none; }
@media print { span.date { display: inline-block; } }
</style>

<script src="<?php echo base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>

<script>
             $(document).ready(function() {
				 function profit(x) {
					var pr = x.split('-');
					var val = parseFloat(pr[0]) - parseFloat(pr[1]) - parseFloat(pr[2]);
					return parseFloat(val).toFixed(2);
				}
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 3, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=reports&view=getCP<?php echo $v; ?>',
					'fnServerData': function(sSource, aoData, fnCallback)
					{
						aoData.push( { "name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash(); ?>" } );
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

					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
						var income = 0; profit = 0;
						for ( var i=0 ; i<aaData.length ; i++ )
						{
							income += parseFloat(aaData[ aiDisplay[i] ][4]);
							profit += parseFloat(aaData[ aiDisplay[i] ][5]);

						}
						
						var nCells = nRow.getElementsByTagName('th');
						nCells[4].innerHTML = parseFloat(income).toFixed(2);
						nCells[5].innerHTML = parseFloat(profit).toFixed(2);
					}
					
                } ).columnFilter({ aoColumns: [

						{ type: "text", bRegex:true },{ type: "text", bRegex:true },  
						null, null, null, null
                     ]});
				
            } );
                    
</script>

<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">

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
		<?php if($this->input->post('submit')) { echo "$('#form').hide();"; } ?>
       
	    $(".toggle_form").slideDown('slow');
 
		$('.toggle_form').click(function(){
			$("#form").slideToggle();
			return false;
		});
		
	});
</script>

<h3><?php echo $page_title; ?> <?php if($this->input->post('start_date')){ echo "From ".$this->input->post('start_date')." to ".$this->input->post('end_date'); } else { echo "Till ".$this->input->post('end_date'); } ?> <a href="#" class="btn btn-default btn-sm toggle_form"><?php echo $this->lang->line("show_hide"); ?></a></h3>

<div id="form">
<p>Please customise the report below.</p>
	
    <?php echo form_open("module=reports&view=custom_products", "class='form-horizontal'"); ?>
    
<div class="control-group">
  <label class="control-label" for="product"><?php echo $this->lang->line("product"); ?></label>
  <div class="controls"> <?php 
		$pr[0] = $this->lang->line("select")." ".$this->lang->line("product");
	  	foreach($products as $product){
    		$pr[$product->id] = $product->name;
		}

		echo form_dropdown('product', $pr, (isset($_POST['product']) ? $_POST['product'] : ""), 'class="form-control input-sm" id="product"'); ?> </div>
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
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
</div>
<?php echo form_close(); ?>

</div>

<div class="clearfix"></div>

	<?php if($this->input->post('submit')) { ?>
	<table id="fileData" class="table table-striped table-bordered table-condensed table-hover" style="margin-bottom:5px;">
		<thead>
        <tr class="active">
            <th><?php echo $this->lang->line("product_name"); ?></th>
            <th><?php echo $this->lang->line("product_code"); ?></th>
            <th><?php echo $this->lang->line("purchased"); ?></th>
            <th><?php echo $this->lang->line("sold"); ?></th>
            <th><?php echo $this->lang->line("total"); ?></th>
            <th><?php echo $this->lang->line("profit"); ?></th>
		</tr>
        </thead>
		<tbody>
			<tr>
            	<td colspan="6" class="dataTables_empty">Loading data from server</td>
			</tr>
        </tbody>
        <tfoot>
        <tr>
            <th><?php echo $this->lang->line("product_name"); ?></th>
            <th><?php echo $this->lang->line("product_code"); ?></th>
            <th><?php echo $this->lang->line("purchased"); ?></th>
            <th><?php echo $this->lang->line("sold"); ?></th>
            <th><?php echo $this->lang->line("total"); ?></th>
            <th><?php echo $this->lang->line("profit"); ?></th>
		</tr>
        </tfoot>
	</table>
    <?php } ?>

