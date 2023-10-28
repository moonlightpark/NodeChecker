<script type="text/javascript">
<!--
$(document).ready(function(){
	ServerList        = new TableList();
	ServerList.page   = "1";
	ServerList.search = "id_search";
	ServerList.url    = "/saseul/datalist";
	ServerList.module = "ServerList";
	ServerList.view   = "saseul/saseul_node_list";
	ServerList.target = "id_list";
	ServerList.row    = 20;
	ServerList.block  = 5;
	ServerList.mode   = 2;
	ServerList.kind   = "";
	ServerList.key    = "<?=$this->_cmp_no?>";

	ServerList.list = function(page,log){		
		
		this.page = page;
		this.log  = log;
		
		var tg_table = this.target;
		var tg_total_page_id = this.idtotalpage;
		var obj = this;
		var param = {};		
		
		if(log == 'all'){

	    	$('#id_dlg_node_info_title').html("<?=$this->util->getLang("999","All Node Log Check.")?>");	
	    	$('#id_dlg_node_info').find(".modal-dialog").addClass("modal-md");
	    	$('#id_dlg_node_info').modal({backdrop: 'static'});
	    	$('#id_dlg_node_info').modal('show');
	    	
		}
			
		param.page   = page;
		param.row = this.row;
		param.block = this.block;
		param.search = "";
		if(this.search != "" ){
			param.search = $("#"+this.search).val();
		}
		
		param.key = this.key;
		param.subkey = this.subkey;
		param.module = this.module;
		param.funlist = this.funlist;
		param.view = this.view;
		param.kind = this.log;
		param.used = this.used;
		param.mode = this.mode;		
		param.node =  $("#node").val();
		console.log('node :'+param.node);
		
		$.post(this.url,param).done(function(result) {
			$("#"+tg_table).html(result);
			obj.finishlist();
			console.log('page:'+page);
		}).fail(function(xhr, textStatus, errorThrown) {
			console.log("err->"+xhr.responseText);
			
		});
		
		
	};	
	ServerList.list(1);
	
});

var Server = {};

Server.refresh = function(){
	location.reload();
};

Server.Explorer = function(){
	window.open("https://explorer.saseul.com", "_blank");
};

Server.Peers = function(){
	window.open("http://main.saseul.net/peer", "_blank");
};


Server.log = function(server, port){
	
	var f = document.frm_ServerLog;
	
	f.server.value  = server;
	f.port.value    = port;
	
    var url = "/saseul/save";
	var param = Utility.fun.fromPost(f);

	param.module   = "ServerLog";
	param.server   =  f.server.value;
	param.port     =  f.port.value;
	param.cmp_no   =  f.cmp_no.value;
	
	var json = $.post(url,param);
	
	json.done(function(result) {
		if(result.code == "100" ){
			
			console.log(result.code);
			ServerList.list(ServerList.page);
		}
	});

	json.fail( function (xhr, textStatus, errorThrown){
		console.log("err->"+xhr.textStatus);
		console.log(xhr);
	});	

};

Server.edit = function(server, port){
		
	var url = "/saseul/info";
	var param = {};
	param.server = server;
	param.port   = port;
	param.module = "EditNode";
	
	$.post(url,param).done(function(result){
		if(result.length != 1){
			alert("<?=$this->util->getLang("999","Please select a node.")?>");
			return;		
		}	
		
		var f = document.frm_node;
		f.flag.value = "U";
        f.ip_addr.value = result[0].node;
        f.port.value = result[0].port;
        f.emp_nm.value = result[0].name;
        f.no.value = result[0].no;
        
    	$('#id_dlg_node_title').html("<?=$this->util->getLang("999","Edit Node")?>");	
    	$('#id_dlg_node').find(".modal-dialog").addClass("modal-md");
    	$('#id_dlg_node').modal({backdrop: 'static'});
    	$('#id_dlg_node').modal('show');     
	
	}).fail(function(error) {
		alert("System Error.");
	});	
};

Server.remove = function(server, port){
	
	if(!confirm("Are want to delete the node?")){
		return;	
	} 
    
	var url = "/saseul/delete";	
	var param = {};
	param.server = server;
	param.port = port;
	param.module = "Node";

	var json = $.post(url,param);
	json.done(function(result) {
		if(result.code == "100"){
			alert(result.msg);
			location.reload();
		}else{
			alert(result.msg);
		}	
	});
	json.fail( function (xhr, textStatus, errorThrown){		
		console.log(xhr);
		alert(msg_system_error);
	});      	
};

Server.save = function(){
	
	var f = document.frm_node;
	
    if(Utility.fun.chkEmpty(f.ip_addr.value)){
        alert("<?=$this->util->getLang("999","Enter the IP address.")?>");
        f.ip_addr.focus();
        return;
    }
    
	if(Utility.fun.chkEmpty(f.port.value)){
        alert("<?=$this->util->getLang("999","Enter the port number.")?>");	        
        f.port.focus();
        return;
	}
	
	if(Utility.fun.chkEmpty(f.emp_nm.value)){
        alert("<?=$this->util->getLang("999","Enter a node nickname.")?>");
        f.emp_nm.focus();
        return;
	}		
    
	var param = Utility.fun.fromPost(f);
	var url = "/saseul/save";
	var json = $.post(url,param);
	
	json.done(function(result) {
		console.log(result);
		$('#id_dlg_node').modal('hide');
		ServerList.list(1);
	});

	json.fail( function (xhr, textStatus, errorThrown){
		console.log("err->"+xhr.textStatus);
		console.log(xhr);
		alert("처리중 오류가 발생하였습니다.");
	});
};

Server.start = function(server, port){
	
	alert("Only available in local version.");
};

Server.stop = function(server, port){
	
	alert("Only available in local version.");
};

Server.restart = function(server, port){
	
	alert("Only available in local version.");
};


//-->
</script>
<div style="display:none;">
    <form name="frm_ServerLog" method="POST" onSubmit="return false">
    	<input type="hidden" name="key" value="" />
    	<input type="hidden" name="server" value="" />
    	<input type="hidden" name="port" value="" />
    	<input type="hidden" name="cmp_no" value="<?=$this->_cmp_no?>" />	
    </form>
</div>
<div id="page-wrapper">
	<div class="row padding-top20">
		<!-- customer_info -->
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Nodes
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">					
					<!-- Search -->
					<div class="row">
						<div class="col-lg-12">
							<div class="form-inline pull-left" >
								<label> Node IP Address : 
								  <div class="form-group input-group">
                                      <select class="form-control" id="node" >
	                                    	<?php
	                                    	foreach($this->ipRs["server"] as $key => $value) {
		                                    ?>
                                    	    <option value="<?=$value['node']?>"><?=$value['node']?></option>		                                    
		                                    <?php
			                                }  
			                                ?>
                                    	</select>
								  </div>							  
								</label>
								<label>
								  <div class="form-group input-group">
									<span class="input-group-btn">
										<button class="btn btn-default btn-sm" type="button" onclick="ServerList.list(1,'1');">Search</button>&nbsp;&nbsp;
									</span>
									
								  </div>
								</label>
								
								<label>
								  <div class="form-group input-group">

									<span class="input-group-btn">
									    <button type="button" class="btn btn-default btn-sm"  title="button" onclick="ServerList.list(1,'all');">All Log Check</button>
									</span>
									
								  </div>
								</label>
								
								<label>
								  <div class="form-group input-group">

									<span class="input-group-btn">
									    <button type="button" class="btn btn-danger btn-sm"  title="" onclick="Server.Explorer();">Explorer</button>
									</span>
									
								  </div>
								</label>
								
								
								<label>
								  <div class="form-group input-group">

									<span class="input-group-btn">
									    <button type="button" class="btn btn-default btn-sm"  title="" onclick="Server.Peers();">Peers</button>
									</span>
									
								  </div>
								</label>
								
								
															
							</div>
							<div class="pull-right" style="line-height:30px;margin-left:10px;margin-right:10px;">
							</div>
							<div class="form-inline pull-right" >
								<label>
								  <div class="form-group input-group">
									<input type="text" id="id_search" class="form-control" onkeypress="ServerList.enter();">
									<span class="input-group-btn">
										<button class="btn btn-default btn-sm" type="button" onclick="ServerList.list(1);"><i class="fa fa-search"></i></button>
									</span>
								  </div>
								</label>
							</div>							
						</div>
					</div>
					<!--// Search -->					
					<div class="table-responsive" id="id_list"></div>
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
</div>
<!-- /#page-wrapper -->

<?php 
$this->dialogForEditor("id_dlg_node","id_dlg_node_title","dlg/dlg_node_input");
$this->dialogForEditor("id_dlg_node_info","id_dlg_node_info_title","dlg/dlg_node_info");
?>
