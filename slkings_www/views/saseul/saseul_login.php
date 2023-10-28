<!DOCTYPE html>
<html lang='en' class=''>
<head>
<meta charset='UTF-8'>
<meta name="robots" content="noindex">
<!-- Custom styles for this template-->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title><?=__ENV_ADMIN_TITLE__?></title>
<!-- Custom Fonts -->
<link href="<?=__ENV_INCLUDE_URL__?>static/vendor/font-awesome/css/fontawesome-all.css" rel="stylesheet">
<link href="<?=__ENV_INCLUDE_URL__?>static/css/login.css" rel="stylesheet">
<script src="<?=__ENV_INCLUDE_URL__?>static/vendor/jquery/jquery.min.js"></script>
<script src="/public/jquery-ui-1.12.1/jquery-ui.js"></script>
<script src="/public/js/util.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function(){
	var f = document.frm_login
	f.uid.focus();
}); 

var Auth = {};
Auth.submit =  function (){
	
    var f = document.frm_login;    

    if(Utility.fun.chkEmpty(f.uid.value)){
        alert("<?=$this->util->getLang("999","Please enter your ID.")?>");
        f.uid.focus();
        return;
    }
    if(Utility.fun.chkEmpty(f.pass.value)){
        alert("<?=$this->util->getLang("999","Please enter your password.")?>");
        f.pass.focus();
        return;
    }
    var param = Utility.fun.fromPost(f);    
	var url = "/saseul/auth";	
	var json = $.post(url,param);

	json.done(function(res) {		
		if(res.code == "100" ){
			Auth.goToUrl();
		}else{
			alert(res.msg);
		}
	});
	json.fail( function (xhr, textStatus, errorThrown){
		 console.log(xhr);
		 alert("<?=$this->util->getLang("999","System error. Please try again.")?>");
	});

};

Auth.goToUrl = function(){	
	var f = document.frm_buypass;
	f.method  = "post";
	f.action = "<?=$this->url?>";
	f.submit();
};

Auth.enter = function(){
	if(event.keyCode==13){
		Auth.submit();	
	}
};
//-->
</script>
</head>
<body>

	<div class="login">

		<div class="custom-radios" style='display:none;'>
			<div style="padding: 5px; margin: 10px 0;">
				<input type="radio" id="color-1" name="color" value="color-1" checked> <label for="color-1"> <span> </span>
				</label>
			</div>
			
			<div style="margin-left: 15px;">
				<input type="radio" id="color-2" name="color" value="color-2">
				<label for="color-2"> <span> </span>
				</label>
			</div>

		</div>
	<div>
		<h1>SASEUL My Node</h1>
	</div>
		<form name="frm_login" method="post"  onSubmit="return false">

    		<input type="text" name="uid" placeholder="Username"  class="width100" maxlength="20" /> 
    		<input type="password" name="pass" placeholder="Password"  class="width100" maxlength="20" onKeyPress="Auth.enter();" />
    	</form>	
    	<button type="submit" class="btn btn-primary btn-block btn-large" onclick="Auth.submit();">Login</button>
	</div>
	<form  name="frm_buypass" method="POST" onSubmit="return false" style='display:none;'>
	</form>
</body>
</html>
