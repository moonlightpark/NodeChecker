
var Utility = {};

Utility.fun = {

   chkEmail: function(data){
	   var reg_email=/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/;
	   
	   if (data.search(reg_email) == -1){
		   return false;
	   }
	   return true;
	   
   },
   delDupArray: function(arr){
		
		var tempArr = [];
	    for (var i = 0; i < arr.length; i++) {
	        if (tempArr.length == 0) {
	            tempArr.push(arr[i]);
	        } else {
	            var duplicatesFlag = true;
	            for (var j = 0; j < tempArr.length; j++) {
	                if (tempArr[j] == arr[i]) {
	                    duplicatesFlag = false;
	                    break;
	                }
	            }
	            if (duplicatesFlag) {
	                tempArr.push(arr[i]);
	            }
	        }
	    }
	    return tempArr;

	},
	printTime: function(){
		var now = new Date(); 
		return now.getFullYear() + "/" + (now.getMonth()+1) + "/" + now.getDate() + "/ " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds() ;
	},	
	clearMsg : function(obj,id_msg) {
	    $(obj).keyup(function(){
	         if(!Utility.fun.chkEmpty($(this).val())){
	        	 $("#"+id_msg).html("");
	        	 $("#"+id_msg).hide();
	         }
	    }); 
	},		
	getExtensionOfFilename :function(filename){
		var _fileLen = filename.length;
		var _lastDot = filename.lastIndexOf('.'); 
		var _fileExt = filename.substring(_lastDot, _fileLen).toLowerCase();
		return _fileExt;
	},	
    nulltoStr : function(text){
    	if(text == null || text == "null") {
    		text = "";
    	}
    	return text;   	
    },
	humanReadable : function (sec) {
		  var pad = function(x) { return (x < 10) ? "0"+x : x; }
		  return pad(parseInt(sec / (60*60))) + ":" +
		         pad(parseInt(sec / 60 % 60)) + ":" +
		         pad(sec % 60)
   },
   pad : function(n,width){
	   n = n + '';
	   return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;  
   },
   initHtmlTextBox : function(f,def){
	   var data={};
	   for (var i = 0; i < f.elements.length; i++) {	  
	   		//console.log(  f.elements[i] );    
	   		if( f.elements[i].type == "text"){
	   			f.elements[i].value = def;
	   		}
	     }
	   return data;
   },		
   isNull : function (input){
	 if(input == null || input == ""){
		 return true;
	 }  
	 return false;
   },		
   chkundefined : function (value) {
	   console.log("chkundefined");
	   console.log(value);
	   if(value === undefined ){
		   return "";
	   }
	   return value;
   },	
   fromPost : function(f){
	   var data={};

	   for (var i = 0; i < f.elements.length; i++) {	  	   		    
	   		if( f.elements[i].type == "radio" || f.elements[i].type == "checkbox" ){
	   			//console.log(  f.elements[i] );
	   			if(f.elements[i].checked ){
	   				data[f.elements[i].name] = f.elements[i].value;
	   			}
	   		}else{
	           	data[f.elements[i].name] = f.elements[i].value;
	   		}
	     }
	   return data;
   },		
   replaceNonwhite : function (value) {
	  return value.replace(/(\s*)/g, '');
   },	
   comma : function (str){
	   str = String(str);
	    return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
   },	
   uncomma : function (str){
	   str = String(str);
	   return str.replace(/[^\d]+/g, '');
   },
   inputNumberFormat : function (obj){
	 //<input type="text" onkeyup="inputNumberFormat(this)" />
	   obj.value = this.comma(this.uncomma(obj.value));
   },  
   setCookie : function( name, value, expirehours ) {

	   if( expirehours == 0 )
	   {
			document.cookie = name + "=" + escape( value ) + ";path=/;";
			return;
	   }
	   var todayDate = new Date(); 
	   todayDate.setHours( todayDate.getHours() + expirehours ); 
	   document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 

   },
   getCookie : function( name ) {
		var nameOfCookie = name + "=";
		var x = 0
		while (x<=document.cookie.length) {
			var y = (x+nameOfCookie.length);
			if (document.cookie.substring(x,y)==nameOfCookie) {
				if ((endOfCookie=document.cookie.indexOf(";",y))==-1)
					endOfCookie = document.cookie.length;
					return unescape(document.cookie.substring(y,endOfCookie));
			}
			x = document.cookie.indexOf(" ",x) + 1;
			if (x==0)
			break;
		}
		return "";
   },		
   chkEmpty : function (str) {
	 	if (str == "") return true;
		for (var i=0; i < str.length; i++)   {
			if (str.charAt(i) != " ")
				return false;
		}
		return true;
    },
    
	onlyNumber : function(obj) {
		//console.log(obj)
	    $(obj).keyup(function(){
	         $(this).val($(this).val().replace(/[^0-9]/g,""));
	    }); 
	},
	
	onlyPrice : function(obj) {
		
	    $(obj).keyup(function(){
	    	if($(this).val().length == 1){
	    		$(this).val($(this).val().replace(/[^0-9]/g,""));	
	    	}else{
	          $(this).val($(this).val().replace(/[^0-9]/g,"").replace(/(^0+)/, ""));
	    	}
	    }); 
	},	
	
	isNumber : function(s) {
		  s += ''; 
		  s = s.replace(/^\s*|\s*$/g, ''); // remove space left right
		  if (s == '' || isNaN(s)) return false;
		  return true;
	},	
	
	onlyFloatNumber : function() {

		flag = false;
		if((event.keyCode >= 48) && (event.keyCode <= 57) || (event.keyCode >= 96) && (event.keyCode <= 105)){
			//숫자
			flag = true;
		}else if((event.keyCode == 46) || (event.keyCode == 8)){
			//delete, backspace
			flag = true;
		}else if((event.keyCode == 9) || (event.keyCode == 37) || (event.keyCode == 39) || (event.keyCode == 35) || (event.keyCode == 36)){
			//tab, <-, -> , home, end
			flag = true;
		}else if((event.keyCode == 110 || event.keyCode == 190 )){
			//.
			flag = true;
		}
		event.returnValue=flag;
	},
	onlyMoney : function() {

		flag = false;
		if((event.keyCode >= 48) && (event.keyCode <= 57) || (event.keyCode >= 96) && (event.keyCode <= 105)){
			//숫자
			flag = true;
		}else if((event.keyCode == 46) || (event.keyCode == 8)){
			//delete, backspace
			flag = true;
		}else if((event.keyCode == 9) || (event.keyCode == 37) || (event.keyCode == 39) || (event.keyCode == 35) || (event.keyCode == 36)){
			//tab, <-, -> , home, end
			flag = true;
		}else if((event.keyCode == 110 || event.keyCode == 190 )){
			//.
			flag = true;
		}
		
		
		event.returnValue=flag;
	},	
	
   loadXML : function(xml) {

		if (window.DOMParser){
			 var parser=new DOMParser();
			 var xmlDoc=parser.parseFromString(xml,"text/xml");
		}else{ // Internet Explorer

			var xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
			xmlDoc.async=false;
			xmlDoc.loadXML(xml); 
		}

		return xmlDoc;
   },	
	
   winclose : function(){
	   window.close();
   },
   
   gotoUrl : function(url){
	   location.href=url;
   },
   
   openwin : function(url,title, xsize,ysize,scroll){
	   
		var cx = window.screen.width;
		var cy = window.screen.height;

		var posx = (cx-xsize)/2;
		var posy = (cy-xsize)/2;
		var width = xsize;
		var height = ysize;

		if (xsize>cx-100) width=cx-100;
		if (ysize>cy-100) height=cy-100;
		
	    var win = window.open(url,title,"top="+posy+",left="+posx+",width="+width+",height="+height+",scrollbars="+scroll);
	    return win;
   }

};

function TableList(){
	this.page=1;  			
	this.row=10;
	this.block=10;
	this.search = "";
	this.key ="";
	this.subkey ="";
	this.module ="";
	this.view = "";
	this.url = "";
	this.target = "";
	this.temprow = "";
	this.kind = "";
	this.status = "";
	this.selectedkey = "";
	this.selectedsubkey = "";
	this.selectedid = "";
	this.used = "N";
	this.mode = 0;
};

TableList.prototype.rowclick = function(id,key){
	this.selectedkey = key;
	this.selectedid = id;	
	if(this.temprow != ""){
		$("#"+this.temprow).css("background-color", "#f9f9f9");
	}
	this.temprow = id;
	$("#"+id).css("background-color", "#ccc");	
	this.rowclickAction();
};

TableList.prototype.rowclickAction = function(){
	$("#"+this.selectedid).css("background-color", "#ccc");
};


TableList.prototype.finishlist = function(){
	$("td[class='colorus ST002']").css({"color":"red","text-align":"center"});
	$("td[class='colorus GS001']").css({"color":"green","text-align":"center"}); 
	$("td[class='colorus GS002']").css({"color":"blue","text-align":"center"}); 
	$("td[class='colorus GS003']").css({"color":"red","text-align":"center"}); 
	$("td[class='colorus GS004']").css({"color":"red","text-align":"center"}); 
	
	$("[class='colorus PAY01']").css({"color":"green","text-align":"center"}); 
	$("[class='colorus PAY02']").css({"color":"blue","text-align":"center"}); 
	$("[class='colorus PAY03']").css({"color":"red","text-align":"center"}); 
	
	$("td[class='colorus PY003']").css({"color":"green","text-align":"center"});
	$("td[class='colorus PY005']").css({"color":"blue","text-align":"center"});
	$("td[class='colorus PY006']").css({"color":"red","text-align":"center"});
	
	$("td[class='colorus BUP01']").css({"color":"green","text-align":"center"});
	$("td[class='colorus BUP02']").css({"color":"blue","text-align":"center"});
	$("td[class='colorus BUP03']").css({"color":"red","text-align":"center"});

};

TableList.prototype.searchfind = function(page){
	
};

TableList.prototype.list = function(page){

	this.page =page;
	var tg_table = this.target;
	var tg_total_page_id = this.idtotalpage;
	var obj = this;
	var param = {};		
	
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
	param.kind = this.kind;
	param.used = this.used;
	param.mode = this.mode;
		
	$.post(this.url,param).done(function(result) {
		$("#"+tg_table).html(result);
		obj.finishlist();
	}).fail(function(xhr, textStatus, errorThrown) {
		console.log("err->"+xhr.responseText);
		alert("System error Try agin!!");
	});			    	
};	

TableList.prototype.enter = function(){	
	if(event.keyCode==13){
		//console.log("ek->"+event.keyCode);
		this.list(1);
	}
};

$(document).ready( function() {
	$('.modal-dialog').draggable({
	    handle: ".modal-header"
	});		
	$('.modal-content').resizable({
	   // alsoResize: ".modal-dialog",
	    minHeight: 300,
	    minWidth: 300
	});	
	$(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
        $(this).val($(this).val().replace(/[^\d].+/, ""));
         if ((event.which < 48 || event.which > 57)) {
             event.preventDefault();
         }
     });
	$(".allow_decimal").on("input", function(evt) {
		   var self = $(this);
		   self.val(self.val().replace(/[^0-9\.]/g, ''));
		   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
		   {
		     evt.preventDefault();
		   }
	});	
	$(".allow_numeric").on("input", function(evt) {
	    var self = $(this);
	    self.val(self.val().replace(/[^\d].+/, ""));
	    if ((evt.which < 48 || evt.which > 57)) 
	     {
		   evt.preventDefault();
	     }
	 });
	$(".cls_font_color_red").on("keypress keyup blur",function (event) {
		if( parseFloat($(this).val()) > 0 ){
			$(this).css({"color":"red","font-size":"14px"});
		}else{
			$(this).css({"color":"black","font-size":"12px"});
		}		
     });
	$(".cls_font_color_blue").on("keypress keyup blur",function (event) {
		if( parseFloat($(this).val()) > 0 ){
			$(this).css({"color":"blue","font-size":"14px"});
		}else{
			$(this).css({"color":"black","font-size":"12px"});
		}		
     });	
	
});

var CommonModule ={};

CommonModule.openDlg = function(id,id_title,title,otherfun){	
	$('#'+id_title).html(title);
	$('#'+id).modal('show');
	otherfun(1);
};

CommonModule.login = function(id,url){	
	if(Utility.fun.chkEmpty(id)){
		location.href = "/cms/loginr?gurl="+url;
		return false;
	}
	return true;
};

CommonModule.logoutmsg= function(msg){
	alert(msg);
	location.href = "/cms/logoff";
};

CommonModule.addropen = function (){
	var url = "https://www.epost.go.kr/search.RetrieveIntegrationNewZipCdList.comm";
	var title = "address";
    Utility.fun.openwin(url,title, "900","600","yes");	
};

CommonModule.weblogout = function(){
	location.href = "/shop/login";
};

CommonModule.banner = function(key,type){
	if(key == "" || key==0){
		return;
	}
	if(type=="G"){
		location.href = "/shop/product?product_no="+key;
	}else if(type=="U"){
		location.href = key;
	}else{
		return;
	}
};

CommonModule.ImageView = function(obj){
	
	var url = obj.src; 
	var ext = Utility.fun.getExtensionOfFilename(url);;
	$("#id_dlg_img_src").hide();
	$("#id_dlg_img_file_src").hide();
	if($.inArray(ext, ['.png','.jpg','.jpeg']) > -1){
		
		$("#id_dlg_img_src").show();
		$("#id_dlg_img_src").attr("src",obj.src);
		$("#id_dlg_img_src_url").html(url);
		
		$('#id_dlg_view_title').html("Image");	
		var width_img = (obj.naturalWidth)/2.2;
		var height_img = (obj.naturalHeight)/2.2;	
		$("#id_dlg_img_src").css("height","50%");
		$("#id_dlg_img_src").css("max-width","700px");
		$("#id_dlg_img_src").css("max-height","700px");
		if(parseInt(width_img) < 200){
			$('#id_dlg_img_view').find(".modal-dialog").removeClass("modal-lg");
			$('#id_dlg_img_view').find(".modal-dialog").addClass("modal-md");
		}else{
			$('#id_dlg_img_view').find(".modal-dialog").removeClass("modal-md")
			$('#id_dlg_img_view').find(".modal-dialog").addClass("modal-lg");
		}
		$('#id_dlg_img_view').modal({backdrop: 'static'});	
		$('#id_dlg_img_view').modal('show');
	}else{
		url = obj.getAttribute("downurl");
		$("#id_dlg_img_file_src").show();
		$("#id_dlg_img_src_url").html(url);
		$('#id_dlg_view_title').html("File");	
		$("#id_dlg_img_file_src").attr("href",url);
		$('#id_dlg_img_view').find(".modal-dialog").removeClass("modal-lg");
		$('#id_dlg_img_view').find(".modal-dialog").addClass("modal-md");
		$('#id_dlg_img_view').modal({backdrop: 'static'});	
		$('#id_dlg_img_view').modal('show');
	}

};

// BSP
