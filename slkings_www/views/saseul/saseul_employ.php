<script type="text/javascript">
<!--
$(document).ready(function(){
	EmployList        = new TableList();
	EmployList.page   = "1";
	EmployList.search = "";
	EmployList.url    = "/saseul/datalist";
	EmployList.module = "EmployList";
	EmployList.view   = "saseul/saseul_employ_list";
	EmployList.target = "id_list";
	EmployList.row    = 10;
	EmployList.block  = 5;
	EmployList.mode   = 2;
	EmployList.kind   = "999";
	EmployList.key    = "";
	EmployList.list(1);	
}); 


var EmployDlg = {};

EmployDlg.regist = function(){
	EmployDlg.reset();
	$('#id_dlg_employ_title').html("계정등록");	
	$('#id_dlg_employ').modal('show');
};

EmployDlg.reset = function(){
	
	var f = document.frm_employ;
	
	f.flag.value = "I";
	f.emp_id.value = "";
	f.emp_id.readOnly = false;
	f.emp_nm.value = "";	
	f.emp_pwd.value = "";	
	f.staff_lev.value = "EM001";
	f.tel_no.value = "";
	f.line_no.value = "";
	f.cmp_no.value = "";
	f.bank_name.value = "";
	f.bank_no.value = "";
	f.bank_owner.value = "";
	f.mphone.value = "";
	f.email_addr.value = "";
	f.token_addr.value = "";
	f.status_cd.value = "UM001";	
};

EmployDlg.info = function(key){

	var url = "/saseul/info";
	var param = {};
	param.key = key;  
	param.module = "Employ";
	
	$.post(url,param).done(function(result){
		if(result.length != 1){
			alert("<?=$this->util->getLang("999","게시물을 선택하여 주십시오.")?>");
			return;		
		}	
		
		var f = document.frm_employ;
		f.flag.value = "U";
        f.emp_id.value = result[0].emp_id;
        f.emp_id.readOnly = true;
        f.emp_nm.value = result[0].emp_nm;
        f.staff_lev.value = result[0].staff_lev;
        f.tel_no.value = result[0].tel_no;
        f.cmp_no.value = result[0].cmp_no;
        f.bank_name.value = result[0].bank_name;
        f.bank_no.value = result[0].bank_no;
        f.bank_owner.value = result[0].bank_owner;
        f.line_no.value = result[0].line_no;
        f.mphone.value = result[0].mphone;
        f.email_addr.value = result[0].email_addr;
        f.token_addr.value = result[0].token_addr;
        f.status_cd.value = result[0].status_cd;
        
    	$('#id_dlg_employ_title').html("<?=$this->util->getLang("999","계정정보 수정")?>");	
    	$('#id_dlg_employ').find(".modal-dialog").addClass("modal-md");
    	$('#id_dlg_employ').modal({backdrop: 'static'});
    	$('#id_dlg_employ').modal('show');        
	
	}).fail(function(error) {
		alert("처리중 오류가 발생하였습니다.");
	});	
};

EmployDlg.save = function(){	
	
	var f = document.frm_employ;
 
    if(Utility.fun.chkEmpty(f.emp_id.value)){
        alert("아이디를 입력하여 주십시오.");
        f.emp_id.focus();
        return;
    }
	
    if(Utility.fun.chkEmpty(f.emp_nm.value)){
        alert("이름을 입력하여 주십시오.");
        f.emp_nm.focus();
        return;
    }

    var id = f.emp_id.value;
    id = id.replace(/ /gi,"");  

    if(id.length < 4){
        alert("아이디는 4 ~ 20 이내로 입력하여 주십시오.");
        f.emp_id.focus();
        return;
    }

    
    if(f.flag.value == "I"){
    	
        if(Utility.fun.chkEmpty(f.emp_pwd.value)){
            alert("패스워드를 입력하여 주십시오.");
            f.emp_pwd1.focus();
            return;
        }
        
        var pw = f.emp_pwd.value;
        pw = pw.replace(/ /gi,"");
        
        if(pw.length < 6){
            alert("패스워드는 6자이상 입력하여 주십시오.");
            f.emp_pwd.focus();
            return;
        }       
        
    }
       
	var param = Utility.fun.fromPost(f);
	var url = "/saseul/save";
	var json = $.post(url,param);
	
	json.done(function(result) {
		alert(result.msg);
		if(result.code == "100" ){
			EmployList.list(EmployList.page);
			$('#id_dlg_employ').modal('hide'); 	
		}	
	});

	json.fail( function (xhr, textStatus, errorThrown){
		console.log("err->"+xhr.textStatus);
		console.log(xhr);
		alert("처리중 오류가 발생하였습니다.");
	});	
};	
//-->
</script>
<div id="page-wrapper">
	<div class="row padding-top20">
		<!-- customer_info -->
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fas fa-user"></i> 관리계정 관리 &nbsp;
					<div class="pull-right">
						<div class="btn-group">
							<button type="button" class="btn btn-success btn-xs" onclick="EmployDlg.regist()" >관리자 등록</button>
						</div>
					</div>					
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body" id="id_list"></div>
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
</div>
<!-- /#page-wrapper -->
<?php 
$this->dialog("id_dlg_employ","id_dlg_employ_title","dlg/dlg_employ_input");
?>