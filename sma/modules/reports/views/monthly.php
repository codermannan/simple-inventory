<style>
.table th, .table td { width: 8.333%; text-align:center; vertical-align: middle; }
.data tr:nth-child(odd) td { color: #2FA4E7; text-align: left; border-bottom: 0 !important; }
.data tr:nth-child(even) td { text-align: right; font-weight:bold; }
@media (max-width: 767px) {
.tabel thead, .year_roller { display: none !important; visibility:hidden; }	
.table tr:first-child td { padding: 10px; }
}
</style>
<h3 class="title"><?php echo "Monthly Sales"; ?></h3>
<p>&nbsp;</p>
	
    <table id="fileData" class="table table-bordered">
    <thead>
    <tr class="year_roller">
    <th><div class="text-center"> <a href="index.php?module=reports&view=monthly_sales&year=<?php echo $year-1; ?>">&lt;&lt;</a> </div></th>
    <th colspan="10"><div class="text-center"> <?php echo $year; ?> </div></td>
    <th><div class="text-center"> <a href="index.php?module=reports&view=monthly_sales&year=<?php echo $year+1; ?>">&gt;&gt;</a> </div></th>
    </th>
    </tr> 
    </thead> 
    <tr>
    <td><?php echo $this->lang->line("january"); ?></td>
    <td><?php echo $this->lang->line("february"); ?></td>
    <td><?php echo $this->lang->line("march"); ?></td>
    <td><?php echo $this->lang->line("april"); ?></td>
    <td><?php echo $this->lang->line("may"); ?></td>
    <td><?php echo $this->lang->line("june"); ?></td>
    <td><?php echo $this->lang->line("july"); ?></td>
    <td><?php echo $this->lang->line("august"); ?></td>
    <td><?php echo $this->lang->line("september"); ?></td>
    <td><?php echo $this->lang->line("october"); ?></td>
    <td><?php echo $this->lang->line("november"); ?></td>
    <td><?php echo $this->lang->line("december"); ?></td>
    </tr>
    <tr>
     
	<?php
	if(!empty($sales)) {
		
		foreach($sales as $value) {
			$array[$value->date] ="<table class='table table-bordered table-hover table-striped table-condensed data' style='margin:0;'><tr><td>".$this->lang->line("tax1")."</td></tr><tr><td>". $this->ion_auth->formatMoney($value->tax1)."</td></tr><tr><td>".$this->lang->line("tax2")."</td></tr><tr><td>".$this->ion_auth->formatMoney($value->tax2)."</td></tr><tr><td>".$this->lang->line("total")."</td></tr><tr><td>".$this->ion_auth->formatMoney($value->total)."</td></tr></table>";
		}

		for ($i = 1; $i <= 12; $i++){
       		echo "<td>";
       			if(isset($array[$i])) {
        			echo $array[$i]; 
				} else { echo '<strong>0</strong>'; }
        	echo "</td>";
    	}
		
	} else {
		for($i=1; $i<=12; $i++) {
			echo "<td><strong>0</strong></td>";
		}
	}
	?>
    </tr>
    </table>
   