<script type="text/javascript">
<!--
$(document).ready(function(){

});

var UserInfo = {};


UserInfo.save = function(){
	
	var f = document.frm_node;
    
    if(Utility.fun.chkEmpty(f.ip_addr.value)){	
	  	alert("Please enter your ip address.");
	   	f.email_addr.focus();
	   	return; 
    }
    
    if(Utility.fun.chkEmpty(f.port.value)){	
	  	alert("Please enter your ip port.");
	   	f.ip_addr.focus();
	   	return; 
    }


	var param = Utility.fun.fromPost(f);
	var url = "/saseul/save";
	var json = $.post(url,param);
	
	json.done(function(result) {
		console.log(result);
		if(result.code == "100"){
			alert(result.msg);
			
		}else{
			alert(result.msg);
		}		
	});

	json.fail( function (xhr, textStatus, errorThrown){
		console.log(xhr);
		alert("System error");
	});
	
	
};




//-->
</script>
<div id="page-wrapper">
	
<form role="form" name="frm_node" method="POST" onSubmit="return false">
	<input type="hidden" name="flag"   value="I" readonly />
	<input type="hidden" name="module" value="Node" readonly />
	<input type="hidden" name="cmp_no" value="<?=$this->ShopInfoRs[0]['cmp_no']?>" readonly />
	<input type="hidden" name="emp_nm" value="<?=$this->ShopInfoRs[0]['emp_nm']?>" readonly />

	
	<div class="row padding-top20">
		<!-- customer_info -->
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Add Node
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">					
					<!-- Search -->
					<div class="row">
						<div class="col-lg-12">

							<div class="col-md-6">
								<div class="form-group">
									<label>IP Address</label>
									<input type="text" name="ip_addr" class="form-control" value="" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Port</label>
									<input type="number" name="port" class="form-control" value="" maxlength="200" />
								</div>
							</div>

						</div>


						<div class="modal-footer">
							<button type="button" class="btn btn-primary" onclick="UserInfo.save()">Save</button>
						</div>







					</div>
					<!-- /.table-responsive -->
					  
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
	<!-- /.row -->
</div>
<!-- /.col-lg-10 -->
</div>
<!-- /.row -->
</form>
</div>
<!-- /#page-wrapper -->






