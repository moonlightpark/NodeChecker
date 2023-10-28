<?php
/**
 * File Class
 *
 */
class File {
	
	private $up_url; // from url
	private $up_dir; // from disk
	private $arr_tail = Array("gif","jpg","png","hwp","doc","docx","xls","txt","pptx","ppt","xlsx","mp4","htm","html","ai","eps","tiff","pdf","jpeg","zip"); //Upload File Ext	private $util;
	private $key = 0;
	private $pix = "R";
	
	public $model;
	
	function __construct($up_url,$up_dir,$key,$pix="R") {
		//echo 'Main controller<br />';
		$this->up_url = $up_url;
		$this->up_dir = $up_dir;
		$this->key    = $key;
		$this->pix    = $pix;
		$this->util   = new Util();
	}

	private function filesave($filename,$tmp_name,&$msg,&$filehash=""){
		
		$msg .= "[".$filename."]";
		$ext = strtolower(substr($filename,(strrpos($filename,'.')+1)));
		/*
		 * 유효성을 체크한다.
		 */
		if ( preg_match("/\.(php|phtm|cgi|pl|exe|jsp|asp|inc)$/i", $filename) ) {
			$msg .= "Scripts cannot be uploaded.";
			$this->util->log(2,__FUNCTION__,$msg,"cms");
			return 0;
		}
		
		if ( !in_array($ext,$this->arr_tail) ){
			$msg .= "This extension cannot be uploaded.";
			$this->util->log(2,__FUNCTION__,$msg,"cms");
			return 0;
		}
		/*
		 * getFileName
		 */
		$newfilename = $this->pix."_".$this->util->getTextOfGuid().".".$ext;
		$save_dir = sprintf('%s/%s', $this->up_dir, $newfilename);
		$save_url = sprintf('%s/%s', $this->up_url, $newfilename);
		
		if(move_uploaded_file($tmp_name, $save_dir)){
			$msg .= "[$newfilename] Upload successful.";			
			$this->util->log(2,__FUNCTION__,$msg,"cms");
			$filehash = md5_file($save_dir);
			$this->util->log(2,__FUNCTION__."filehash",$filehash,"cms");
			return $newfilename;
		}else{
			$msg .="System Error.";
			$this->util->log(2,__FUNCTION__,$msg,"cms");
			return 0;
		}
		
	}
	
	/**
	 * File upload call, multi-upload possible.
	 */
	public function upload(&$msg="none",&$size=0,&$hash=""){
		
		foreach ($_FILES["attachment"]["error"] as $key => $error){
			
			if($error == UPLOAD_ERR_OK){
				
				$name = $_FILES["attachment"]["name"][$key];
				$tmp_name = $_FILES["attachment"]["tmp_name"][$key];
				$size = $_FILES["attachment"]["size"][$key];
				return  $this->filesave($name,$tmp_name,$msg,$hash);
				
			}else{
				
				$this->util->log(1, "File->upload" , "raise error");
				
				switch ($_FILES['attachment']['error']) {
					case 1:
						$msg .= 'Exceeded the upload_max_filesize setting in the php.ini file (exceeding upload maximum)';
						break;
					case 2:
						$msg .= 'Exceeded MAX_FILE_SIZE setting on Form (upload max. Capacity exceeded)';
						break;
					case 3:
						$msg .= 'Only part of file uploaded';
						break;
					case 4:
						$msg .= 'No uploaded file';
						break;
					case 6:
						$msg .= 'No Temporary Folders Available';
						break;
					case 7:
						$msg .= 'Can not save to disk';
						break;
					case 8:
						$msg .= 'File upload stopped';
						break;
					default:
						$msg .=  'System error occurred ';
						break;
				} // switch
				
			}
		}
		$this->util->log(1, "File->upload" , $msg);
		return 0;
	}	//end - upload
	
	public function uploadp(&$msg="none",&$size=0,&$hash=""){
	
		foreach ($_FILES["myfile"]["error"] as $key => $error){
				
			if($error == UPLOAD_ERR_OK){
	
				$name = $_FILES["myfile"]["name"][$key];
				$tmp_name = $_FILES["myfile"]["tmp_name"][$key];
				$size = $_FILES["myfile"]["size"][$key];
				$this->util->log(1, "File->uploadp" , $name);
				return  $this->filesave($name,$tmp_name,$msg,$hash);
	
			}else{
	
				$this->util->log(1, "File->uploadp" , "raise error");
	
				switch ($_FILES['myfile']['error']) {
					case 1:
						$msg .= 'Exceeded the upload_max_filesize setting in the php.ini file (exceeding upload maximum)';
						break;
					case 2:
						$msg .= 'Exceeded MAX_FILE_SIZE setting on Form (upload max. Capacity exceeded)';
						break;
					case 3:
						$msg .= 'Only part of file uploaded';
						break;
					case 4:
						$msg .= 'No uploaded file';
						break;
					case 6:
						$msg .= 'No Temporary Folders Available';
						break;
					case 7:
						$msg .= 'Can not save to disk';
						break;
					case 8:
						$msg .= 'File upload stopped';
						break;
					default:
						$msg .=  'System error occurred ';
						break;
				} // switch
	
			}
		}
		$this->util->log(1, "File->uploadp" , $msg);
		return 0;
	}	//end - uploadp
	

	
	public function upload_dir(&$msg="none",&$size=0,&$hash="",&$orgfilename=""){
	    
	    foreach ($_FILES["myfile"]["error"] as $key => $error){
	        
	        if($error == UPLOAD_ERR_OK){
	            
	            $name = $_FILES["myfile"]["name"][$key];
	            $orgfilename = $name;
	            $tmp_name = $_FILES["myfile"]["tmp_name"][$key];
	            $size = $_FILES["myfile"]["size"][$key];
	            $this->util->log(1, "File->upload_dir" , $name);
	            return  $this->filesave($name,$tmp_name,$msg,$hash);
	            
	        }else{
	            
	            $this->util->log(1, "File->uploadp" , "raise error");
	            
	            switch ($_FILES['myfile']['error']) {
	                case 1:
	                    $msg .= 'Exceeded the upload_max_filesize setting in the php.ini file (exceeding upload maximum)';
	                    break;
	                case 2:
	                    $msg .= 'Exceeded MAX_FILE_SIZE setting on Form (upload max. Capacity exceeded)';
	                    break;
	                case 3:
	                    $msg .= 'Only part of file uploaded';
	                    break;
	                case 4:
	                    $msg .= 'No uploaded file';
	                    break;
	                case 6:
	                    $msg .= 'No Temporary Folders Available';
	                    break;
	                case 7:
	                    $msg .= 'Can not save to disk';
	                    break;
	                case 8:
	                    $msg .= 'File upload stopped';
	                    break;
	                default:
	                    $msg .=  'System error occurred ';
	                    break;
	            } // switch
	            
	        }
	    }
	    $this->util->log(1, "File->uploadp" , $msg);
	    return 0;
	}	//end - upload_dir
	
	
	public function uploadjson(){
		
		$code = "100";
		$msg = "Upload successful.";
		
		foreach($_FILES["uploadedfile"]["error"] as $key => $error){
			
			if($error == UPLOAD_ERR_OK){
				$uploadfile = $_FILES['uploadedfile']['name'][$key]; //업로드한파일의 이름
				$this->util->log(2,"uploadmulti -> ",$uploadfile);
				$newfilepath = __PLY_DIR__.$uploadfile;
				if( !move_uploaded_file($_FILES['uploadedfile']['tmp_name'][$key], $newfilepath ) ){
					$code = "200";
					$msg = "Upload error";
					$body = array(
							"code"=>(string)$code,
							"msg"=>(string)$msg,
							"sever"=>gethostname(),
							"date"=>(string)date("YmdHis")
					);
					$this->util->resJson($body);
					return;
				}
			}else{
				switch ($_FILES['uploadedfile']['error']) {
					case 1:
						$msg = 'Exceeded the upload_max_filesize setting in the php.ini file (exceeding upload maximum)';
						break;
					case 2:
						$msg = 'Exceeded MAX_FILE_SIZE setting on Form (upload max. Capacity exceeded)';
						break;
					case 3:
						$msg = 'Only part of file uploaded';
						break;
					case 4:
						$msg = 'No uploaded file';
						break;
					case 6:
						$msg .= 'No Temporary Folders Available';
						break;
					case 7:
						$msg = 'Can not save to disk';
						break;
					case 8:
						$msg= 'File upload stopped';
						break;
					default:
						$msg =  'System error occurred';
						break;
				} // switch
				
				$code = "201";
				$body = array(
						"code"=>(string)$code,
						"msg"=>(string)$msg,
						"sever"=>gethostname(),
						"date"=>(string)date("YmdHis")
				);
				$this->util->resJson($body);
				return;
			}
		}
		$body = array(
				"code"=>(string)$code,
				"msg"=>(string)$msg,
				"sever"=>gethostname(),
				"date"=>(string)date("YmdHis")
		);
		$this->util->resJson($body);
		return;
	}
	
	/*
	 * user file upload
	 */
	public function upload_dump_dir(&$msg="none",&$size=0,&$hash="",&$orgfilename=""){
	    
	    foreach ($_FILES["myfile"]["error"] as $key => $error){
	        
	        if($error == UPLOAD_ERR_OK){
	            
	            $name = $_FILES["myfile"]["name"][$key];
	            $orgfilename = $name;
	            $tmp_name = $_FILES["myfile"]["tmp_name"][$key];
	            $size = $_FILES["myfile"]["size"][$key];
	            $this->util->log(1, "File->uploadp" , $name);
	            return  $this->filesavedump($name,$tmp_name,$msg,$hash);
	            
	        }else{
	            
	            $this->util->log(1, "File->uploadp" , "raise error");
	            
	            switch ($_FILES['myfile']['error']) {
	                case 1:
	                    $msg .= 'Exceeded the upload_max_filesize setting in the php.ini file (exceeding upload maximum)';
	                    break;
	                case 2:
	                    $msg .= 'Exceeded MAX_FILE_SIZE setting on Form (upload max. Capacity exceeded)';
	                    break;
	                case 3:
	                    $msg .= 'Only part of file uploaded';
	                    break;
	                case 4:
	                    $msg .= 'No uploaded file';
	                    break;
	                case 6:
	                    $msg .= 'No Temporary Folders Available';
	                    break;
	                case 7:
	                    $msg .= 'Can not save to disk';
	                    break;
	                case 8:
	                    $msg .= 'File upload stopped';
	                    break;
	                default:
	                    $msg .=  'System error occurred ';
	                    break;
	            } // switch
	            
	        }
	    }
	    $this->util->log(1, "File->uploadp" , $msg);
	    return 0;
	}	//end - upload_dir
	private function filesavedump($filename,$tmp_name,&$msg,&$filehash=""){
	    
	    $msg .= "[".$filename."]";
	    $ext = strtolower(substr($filename,(strrpos($filename,'.')+1)));
	    /*
	     * check file validity
	     */
	    if ( preg_match("/\.(php|phtm|cgi|pl|exe|jsp|asp|inc)$/i", $filename) ) {
	        $msg .= "Scripts cannot be uploaded.";
	        $this->util->log(2,__FUNCTION__,$msg,"cms");
	        return 0;
	    }
	    
	    if ( !in_array($ext,$this->arr_tail) ){
	        $msg .= "This file extension cannot be uploaded.";
	        $this->util->log(2,__FUNCTION__,$msg,"cms");
	        return 0;
	    }
	    /*
	     * getFileName
	     */
	    $newfilename = $this->pix."_".$this->util->getTextOfGuid().".".$ext;
	    $save_dir = sprintf('%s/%s', $this->up_dir, $newfilename);
	    $save_url = sprintf('%s/%s', $this->up_url, $newfilename);
	    
	    if(move_uploaded_file($tmp_name, $save_dir)){
	        $msg .= "[$newfilename] Upload successful.";
	        $this->util->log(2,__FUNCTION__,$msg,"cms");
	        $filehash = md5_file($save_dir);
	        $this->util->log(2,__FUNCTION__."filehash",$filehash,"cms");
	        return $newfilename;
	    }else{
	        $msg .="System Error.";
	        $this->util->log(2,__FUNCTION__,$msg,"cms");
	        return 0;
	    }	    
	}
	
	/**
	 * File upload call, multi-upload possible
	 */
	public function uploadm(&$upfile = array()){
	    $i = 0;	    
	    foreach ($_FILES["myfile"]["error"] as $key => $error){
	        
	        $msg = "";	        
	        if($error == UPLOAD_ERR_OK){	            
	            $name = $_FILES["myfile"]["name"][$key];
	            $tmp_name = $_FILES["myfile"]["tmp_name"][$key];
	            $size = $_FILES["myfile"]["size"][$key];
	            $hash = "";
	            $message = "";
	            $newfilename = $this->filesave($name,$tmp_name,$message,$hash);	            
	            $upfile[$i]["org_file_name"] = $name;
	            $upfile[$i]["file_size"] = $size;
	            $upfile[$i]["new_file_name"] = $newfilename;
	            $upfile[$i]["file_url"] = $this->up_url."/".$newfilename;;
	            $upfile[$i]["file_dir"] = $this->up_dir;
	            $upfile[$i]["hash"] = $hash;
	            $upfile[$i]["msg"] = $message;	     
	            $i++;
	        }else{
	            $this->util->log(1, "File->uploadm" , "raise error=>");
	          //  print_r($_FILES["myfile"]["error"]);
	            switch ($_FILES['myfile']['error']) {
	                case 1:
	                    $msg .= 'Exceeded the upload_max_filesize setting in the php.ini file (exceeding upload maximum)';
	                    break;
	                case 2:
	                    $msg .= 'Exceeded MAX_FILE_SIZE setting on Form (upload max. Capacity exceeded)';
	                    break;
	                case 3:
	                    $msg .= 'Only part of file uploaded';
	                    break;
	                case 4:
	                    $msg .= 'No uploaded file';
	                    break;
	                case 6:
	                    $msg .= 'No Temporary Folders Available';
	                    break;
	                case 7:
	                    $msg .= 'Can not save to disk';
	                    break;
	                case 8:
	                    $msg .= 'File upload stopped';
	                    break;
	                default:
	                    $msg .=  'System error occurred ';
	                    break;
	            } // switch
	            
	        }
	        
	    }
	    $this->util->log(1, "File->upload" , $msg);
	    return 0;
	}	//end - uploadm
	
} //Edn Class