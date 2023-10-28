
<table width="100%" align="center" class="table table-striped table-bordered table-hover" style="background-color: #aacdff;">
  <thead>
	<colgroup>
    	<col width=""/>
    	<col width=""/>
    	<col style=""/>
    	<col width=""/>
    	<col style=""/>
        <col width=""/>
        <col width=""/>
        <col width=""/>
        <col width=""/>
        <col width=""/>
	</colgroup>
  	<tr>
		<th style="text-align: center;">No</th>
		<th style="text-align: center;">Node</th>
		<th style="text-align: center;">NickName</th>
		<th style="text-align: center;">Last Block</th>
		<th style="text-align: center;">Last Resource</th>
		<th style="text-align: center;">Status</th>
 		<th style="text-align: center;">DateTime</th>		
		<th style="text-align: center;">Mining</th>
 		<th style="text-align: center;">Log</th>
		<th style="text-align: center;">Job</th>
	</tr>
  </thead>	
	<tbody >
<?php
$icount = 1;
foreach($this->rs["data"] as $key => $value) {
	//$api_time = date("Y-m-d h:i:s", $value["time"]);
	
	$node = $value["node"].':'.$value["port"];
	
	if($value["mining"] == '1'){
		$mining = '<img width="15" src="'.__ENV_URL__.'assets/img/green.png">';
	}else{
		$mining = '<img width="15" src="'.__ENV_URL__.'assets/img/red.png">';
	}
?>
	<tr>
		<td><?=$icount?></td>
		<td style='font-size: 15px;'><a href="http://<?=$node?>/info" target="_new"><?=$value["node"].'  /  '.$value["port"]?></a></td>
		<td><?=$value["name"]?></td>	
		<td style='font-size: 15px;color:#4d07b1;'><b><?=$value["last_block"];?></b></td>
		<td style='font-size: 15px;'><?=$value["last_resource"];?></td>
		<td><?=$value["status"];?></td>
	 	<td><?=$value["regist_dt"];?>&nbsp;&nbsp;<?=$value["regist_tm"];?></td>
	 	<td><?=$mining;?></td>
	 	<td>
		 	<button type="button" class="btn btn-success btn-sm" onclick="Server.log('<?=$value["node"]?>','<?=$value["port"]?>')" id="id_layout_toggle_flag">Log Check</button>
	 	</td>
	 	<td>
		 	<!--
		 	<button type="button" class="btn btn-default btn-sm" onclick="Server.start('<?=$value["node"]?>','<?=$value["port"]?>')" id="id_layout_toggle_flag">Start</button>
		 	<button type="button" class="btn btn-default btn-sm" onclick="Server.stop('<?=$value["node"]?>','<?=$value["port"]?>')" id="id_layout_toggle_flag">Stop</button>
		 	<button type="button" class="btn btn-default btn-sm" onclick="Server.restart('<?=$value["node"]?>','<?=$value["port"]?>')" id="id_layout_toggle_flag">Restart</button>
		 	-->
		 	<button type="button" class="btn btn-default btn-sm" onclick="Server.edit('<?=$value["node"]?>','<?=$value["port"]?>')" id="id_layout_toggle_flag">Edit</button>
		 	<button type="button" class="btn btn-warning btn-sm" onclick="Server.remove('<?=$value["node"]?>','<?=$value["port"]?>')" id="id_layout_toggle_flag">Remove</button>

	 	</td>
	</tr>
<?php
    $icount++;
}
?>
</tbody>
</table>
<!-- paging -->
<div id="dataTable_paginate" class="dataTables_paginate paging_simple_numbers pull-right">
<?php
$this->mfpaging();
?>
</div>
<!--//paging -->
<script type="text/javascript">
<!--
$("#id_total_count").html("<?=$icount?>");
//-->
</script>		

