<div class="table-responsive">
	<table width="100%" class="table table-striped table-bordered table-hover" style="margin-bottom:0;">
    	<colgroup>
        	<col width="5%"/>
        	<col width="10%"/>
        	<col width="15%"/>
        	<col width=""/>
        	<col width=""/>
        	<col width=""/>
        	<col width=""/>
        	<col width="10%"/>
        	<col width="10%"/>
    	</colgroup>
    	<thead>
        	<tr>
        		<th>ID</th>
         		<th>권한</th>
        		<th>사용자닉네임</th>
        		<th>대리점<br>추천인코드</th>
         		<th>지갑주소</th>
        		<th>접속IP</th>
         		<th>은행명</th>
         		<th>계좌번호</th>
         		<th>예금주</th>
        		<th>전화</th>
        		<th>상태</th>
        		<th></th>
        	</tr>
    	</thead>
    	<tbody>
<?php 
foreach($this->rs["data"] as $key => $value) {
?>	    	
    	<tr>
    		<td>
    			<?=$value["emp_id"]?>
    		</td>
    		<td>
    			<?=$value["staff_lev_nm"]?>
    		</td>
    		<td>
    			<?=$value["emp_nm"]?>
    		</td>
    		<td>
    			<?=$value["cmp_no"]?>
    		</td>

    		<td>
	    		<?php
		    		
		    		if( $value["token_addr"] !== 'undefined' ){
    			?>
    			<a href="<?=__ENV_BEP20_NETWORK_ADDRESS__?><?=$value["token_addr"]?>" target="_blank"><?=substr($value["token_addr"],0,9)?>...<?=substr($value["token_addr"],-5)?></a>
    			<?php
	    			}else{
    			?>
    			미설정
    			<?php
	    			}
    			?>
    		</td>
    		<td>
    			<?
        			if ($value["ip_addr"] == "*"){
                        echo "<font color='red'>어디서든 접속가능</font>";
        			}else{
            			echo $value["ip_addr"];
        			}
        			
    			?>
    		</td>
    		<td>
    			<?=$value["bank_name"]?>
    		</td> 
    		<td>
    			<?=$value["bank_no"]?>
    		</td> 
    		<td>
    			<?=$value["bank_owner"]?>
    		</td> 
    		
   

    		<td>
    			<?=$value["mphone"]?>
    		</td>
    		<td style="text-align:center;">
    			<?=$value["status_nam"]?>
    		</td>
    		<td style="text-align:center;">
    			<button type="button" class="btn btn-success btn-xs" onclick="EmployDlg.info('<?=$value["emp_id"]?>')" >수정 </button>
    		</td>
    	</tr>
<?php
}
?>        	
    	</tbody>
	</table>
</div>
<!-- /.table-responsive -->
<!-- paging -->
<div id="dataTable_paginate" class="dataTables_paginate paging_simple_numbers pull-right">
<?php
$this->mfpaging();
?>
</div>
<!--//paging -->