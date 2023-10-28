<script type="text/javascript">
<!--
$(document).ready(function(){

});

var UserInfo = {};


UserInfo.save = function(){
	
	var f = document.frm_userinfo;
	
    if(Utility.fun.chkEmpty(f.emp_id.value)){
	   	return; 
    }
    
    if(Utility.fun.chkEmpty(f.emp_nm.value)){	
	  	alert("Please enter your Nick Name.");
	  	f.emp_nm.focus();
	   	return; 
    }
	
    if(Utility.fun.chkEmpty(f.emp_pwd.value)){	
	  	alert("Please enter your password.");
	   	return; 
    }
    
 	if (f.emp_pwd.value.length < 6 ){
	 	alert("Please enter at least 6 characters.");
	   	f.emp_pwd.focus();
	   	return;
 	}   
    
    if ( f.re_emp_pwd.value !== f.emp_pwd.value){
	    alert("Password does not match.");
	   	f.emp_pwd.focus();
	   	return;
    }
    
    if(Utility.fun.chkEmpty(f.tel_no.value)){	
	  	alert("Please enter your Phone.");
	   	f.tel_no.focus();
	   	return;
    }
    
    if(Utility.fun.chkEmpty(f.email_addr.value)){	
	  	alert("Please enter your E-mail.");
	   	f.email_addr.focus();
	   	return; 
    }
    
    if(Utility.fun.chkEmpty(f.ip_addr.value)){	
	  	alert("Please enter your ip address.");
	   	f.ip_addr.focus();
	   	return; 
    }


	var param = Utility.fun.fromPost(f);
	var url = "/saseul/save";
	var json = $.post(url,param);
	
	json.done(function(result) {
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
	
<form role="form" name="frm_userinfo" method="POST" onSubmit="return false">
	<input type="hidden" name="flag"   value="U" readonly />
	<input type="hidden" name="module" value="Employ" readonly />
	<input type="hidden" name="cmp_no" value="<?=$this->ShopInfoRs[0]['cmp_no']?>" readonly />

	
	<div class="row padding-top20">
		<!-- customer_info -->
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					User Information
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">					
					<!-- Search -->
					<div class="row">
						<div class="col-lg-12">

							<div class="col-md-6">
								<div class="form-group">
									<label>UserID</label>
									<input type="text" name="emp_id" class="form-control" value="<?=$this->ShopInfoRs[0]['emp_id']?>" disabled />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Nick Name</label>
									<input type="text" name="emp_nm" class="form-control" value="<?=$this->ShopInfoRs[0]['emp_nm']?>" maxlength="200" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="emp_pwd" class="form-control" value="" maxlength="50" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>RePassword</label>
									<input type="password" name="re_emp_pwd" class="form-control" value="" maxlength="50" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Phone</label>
									<input type="text" name="tel_no" class="form-control" value="<?=$this->ShopInfoRs[0]['tel_no']?>" maxlength="50" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>E-mail</label>
									<input type="text" name="email_addr" class="form-control" value="<?=$this->ShopInfoRs[0]['email_addr']?>" maxlength="200" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Connect IpAddress ( To access from anywhere, enter *  )</label>
									<input type="text" name="ip_addr" class="form-control" value="<?=$this->ShopInfoRs[0]['ip_addr']?>" maxlength="50" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label></label>
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






