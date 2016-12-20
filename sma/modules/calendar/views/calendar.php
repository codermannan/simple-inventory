
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
<style>
.table th { text-align:center; }
.table td { text-align:center; }
.table a:hover { text-decoration: none; }
.cl_wday { text-align: center; font-weight:bold; }
.cl_equal { width: 14%; }
.day { width: 14%; }
.day_num { width: 100%; text-align:left; cursor:pointer; margin: -8px; padding:8px; } 
.day_num:hover { background:#F5F5F5; }
.content { width: 100%;text-align:left; color: #2FA4E7; margin-top:10px; }
.highlight { color: #0088CC; font-weight:bold; }
</style>
<h3 class="title"><?php echo $page_title; ?></h3>
<p><?php echo $this->lang->line("calendar_line"); ?></p>
	<div>
    <?php echo $calender; ?>
    </div>
    
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 id="myModalLabel"><?php echo $this->lang->line("add_event"); ?> - <span id="selected_date"></span></h4>
</div>

<div class="modal-body">
<p><?php echo $this->lang->line("add_modify_event"); ?>:</p>
<p><?php echo form_textarea('event', '', 'class="input-block-level" style="height:100px;" id="event_text"'); ?><input type="hidden" name="dayNum" id="dayNum" value="" /></p>
</div>
<div class="modal-footer">
<span id="delb" class="pull-left" style="min-width:70px; max-width:150px; text-align:left; display:none;"><button class="btn btn-danger" id="del"><?php echo $this->lang->line("delete"); ?></button></span>
<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line("close"); ?></button>
<button type="submit" class="btn btn-primary" id="ok" data-loading-text=""><?php echo $this->lang->line("add_event"); ?></button>
</div>

</div>
    
<script type="text/javascript">
	$('document').ready(function(){
		$('.table .day').click(function() {
			day_num = $(this).find('.day_num').html();
			month_year = $('#month_year').text();
			$('#selected_date').text(day_num+' '+month_year);
			if($(this).find('.content').length) {
				var v = $(this).find('.content').html();
				var v = v.replace(/<br>/g, "|");
				$('#delb').show();
			} else {
				var v = "";
			}
			
			$('#event_text').val(v);
			$('#dayNum').val(day_num);
			$('#myModal').modal();
			
		});
		$('#myModal').on('shown', function () {
			$('#event_text').focus();
			$initialVal = $('#event_text').val();
        	$('#event_text').val('');
        	$('#event_text').val($initialVal);
    			
    	});
		
		$('#ok').click(function() {
			$(this).text('<?php echo $this->lang->line("adding"); ?>');
			day_data = $('#event_text').val();
			day = $('#dayNum').val();
			
			if (day_data != null) {
				
				$.ajax({
					url: window.location,
					type: 'POST',
					data: {
						<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>',
						day: day,
						data: day_data
					},
					success: function(msg) {
						location.reload();
					}						
				});
				
			}
		});
		
		$('#del').click(function() {
			$(this).text('<?php echo $this->lang->line("deleting"); ?>');
			day = $('#dayNum').val();
				$.ajax({
					url: window.location,
					type: 'POST',
					data: {
						<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash() ?>',
						day: day,
						data: ''
					},
					success: function(msg) {
						location.reload();
					}						
				});
		});
		
	});
		
	</script>