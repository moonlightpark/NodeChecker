<?php
class Util {
	function __construct() {
		//echo 'this is the view';
	}	
	public function getOrderNoFormat($key){	    
	    if($this->getStringLength($key) != 11){
	        return '';
	    }
	    return substr($key, 0, 7)."-".substr($key,7);
	}
	public function utf2euc($str) { return iconv("UTF-8","cp949//IGNORE", $str); }
	public function is_ie() {
	    if(!isset($_SERVER['HTTP_USER_AGENT']))return false;
	    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) return true; // IE8
	    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 6.1') !== false) return true; // IE11
	    return false;
	}
	
	public function getMemoToWeb($memo){
	    return str_replace("\n","<br>", $memo);
	}
	
	public function makeInternationalNumber($nation, $number){
		$nation_ = str_replace('+', '',$nation);
		$number_ = (Int)$number;
		return trim($nation_) .'-'. trim($number_);
	}
	
	public function getLang($key,$msg="",$lang=__ENV_DEFALUT_REGION__){
	    if($key = "999"){
	        return $msg;
	    }
	    if( !isset($GLOBALS['__GVAL_LANG__'][$key]) ){
	        return $msg;
	    }
	    if( !isset($GLOBALS['__GVAL_LANG__'][$key][$lang]) ){
	        return $msg;
	    }
	    return $GLOBALS['__GVAL_LANG__'][$key][$lang];
	}
	
	public function getCommaMoney($value){
	    return number_format($value);
	}
	
	public function getIntMax(){
	    return PHP_INT_MAX;
	}
	
	public function getSetToTime($sec){
		$result = "";
		switch ($sec){
			case 60 :
				$result = "60 sec";
				break;
			case 300 :
				$result = "5 min";
				break;
			case 600 :
				$result = "10 min";
				break;
			case 900 :
				$result = "15 min";
				break;
			case 1800 :
				$result = "30 min";
				break;
			case 3600 :
				$result = "1 hour";
				break;
			case 10800 :
				$result = "3 hour";
				break;
			case 21600 :
				$result = "6 hour";
				break;
			case 43200 :
				$result = "12 hour";
				break;
			case 86400 :
				$result = "1 day";
				break;
			case 259200 :
				$result = "3 day";
				break;
			case 432000 :
				$result = "5 day";
				break;
			default :
				$result = $sec." sec";
				break;
		}
		return $result;
	}

	//Obtain the http header value.
	public function findHttpheaderValue($key, $default = ""){
	
		$key = "HTTP_".strtoupper($key);
	
		if( !isset($_SERVER[$key]) ){
			return $default;
		}
		if($this->getStringLength($_SERVER[$key]) < 1){
			return $default;
		}
		return $_SERVER[$key];
	}

	public function numberWithCommas($value){
		return number_format($value);
	}
	
	public function nullToString($value,$default=""){
		
		if($value == null){
			return $default;
		}
		return $value;
	}
    public function getStafflevel($level){
    	$result = 0;
    	switch ($level){
    		case "EMP00" :
    			$result = 9;
    			break;
    		case "EMP01" : //ceo
    			$result = 7;
    			break;
   			case "EMP02" : //manager
   				$result = 3;
   				break;
   			case "EMP02" : // staff
   				$result = 2;
   				break;
    	}
    	return $result;
    }
	/**
	 * The string is truncated to the requested length.
	 */
	public function cutString($src,$len=3,$charset = "UTF-8"){
		$tail = "";
		$strlen =  mb_strlen($src,$charset);
		if($strlen > $len ){
			$tail = "...";
		}		
		return mb_substr($src,0,$len,$charset ).$tail;
	}
	public function cutString2($src,$len=3,$charset = "UTF-8"){
	    $tail = "";
	    $strlen =  mb_strlen($src,$charset);
	    if($strlen > $len ){
	        $tail = "";
	    }
	    return mb_substr($src,0,$len,$charset ).$tail;
	}
	public function resJsonMessage($code,$msg,$data){
		
		$header = array(									
			"status" => (int)$code,
			"message" => (string)$msg,
			"hostname"=>gethostname()
		);
		
		$json = array_replace_recursive($header,$data);
		header("Cache-Control: no-cache, must-revalidate");
		header("Content-type: text/json; charset=UTF-8");
		return json_encode($json);
	}
	public function resJson($data) {
	
		header("Cache-Control: no-cache, must-revalidate");
		header("Content-type: text/json; charset=UTF-8");
		echo json_encode($data);
	}
	/**
	 * Replace a string with a special character below a certain position.
	 */
	function replaceSpecialChar($src,$dp_len,$charset = "UTF-8") {	
		$strlen =  mb_strlen($src,$charset);
		if($strlen < 1 ){
			return "";
		}
		$out = mb_substr($src,0,$dp_len,$charset ).str_repeat('*',$strlen-$dp_len);
		return $out;
	}
	/**
	 * The length of the string with spaces removed
	 */
	public function getStringLength($val,$charset = "UTF-8"){
		return mb_strlen($this->removeSpace($val),$charset);
	}
	/** 
	  Returns the length of the string.
	 */
	function getStrlenWithSpace($val, $charset = "UTF-8"){
		return mb_strlen($val,$charset);
	}
	//
	function stripQuoteString($value){
		// Stripslashes
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		return $value;
	}
	/**
	 * Retrieves the Json value.
	 */
	public function reqPostParameterJson($array,$key, $default = ""){
	
		if(!is_array($array)){
			return $default;
		}
		if( !isset($array[$key]) ){
			return $default;
		}
		if($this->getStringLength($array[$key]) < 1){
			return $default;
		}	
		return $array[$key];
	}	
    /**
     * Retrieves the POST value.
     */
	public function reqPostParameter($val, $default = ""){
		
		if( !isset($_POST[$val]) ){
			return $default;
		}
		
		if($this->getStringLength($_POST[$val]) < 1){
			return $default;
		}
		
		return $_POST[$val];
	}
	
    /**
     *  Retrieves the GET value.
     */
	public function reqGetParameter($val, $default = ""){
	
		if( !isset($_GET[$val]) ){
			return $default;
		}
		
		if($this->getStringLength($_GET[$val]) < 1){
			return $default;
		}		
		return $_GET[$val];
	}	
	/**
	 *  Retrieves the REQUEST value.
	 */
	public function reqRequestParameter($val, $default = ""){
	
		if( !isset($_REQUEST[$val]) ){
			return $default;
		}
		
		if($this->getStringLength($_REQUEST[$val]) < 1){
			return $default;
		}		
		return $_REQUEST[$val];
	}
	/**
	 * Remove the space from the strin.
	 */
    public function removeSpace($val, $default = "")
    {
		$out = preg_replace("/\s+/", "", $val);
	
		if($out == "" ){
	
			$out = $default;
		}
	
		return $out;  
    }

    /**
     * Generate GUID
     */
    public function makeGuid(){
    	
    	if( function_exists('com_create_guid')) {
    		return com_create_guid();
    	
    	}else {
    		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    		$charid = strtoupper(md5(uniqid(rand(), true)));
    		$hyphen = chr(45);// "-"
    		$uuid = chr(123)// "{"
    		.substr($charid, 0, 8).$hyphen
    		.substr($charid, 8, 4).$hyphen
    		.substr($charid,12, 4).$hyphen
    		.substr($charid,16, 4).$hyphen
    		.substr($charid,20,12)
    		.chr(125);// "}"
    		return $uuid;
    	
    	}    	
    }
    /**
	  Output only 32 characters excluding GUID special characters
     */
    public function  getTextOfGuid() {
    
    	$tmp = $this->makeGuid();
    	$tmp = preg_replace( '/{/', '', $tmp);
    	$tmp = preg_replace( '/-/', '', $tmp );
    	$tmp = preg_replace( '/}/', '', $tmp );
    	return $tmp;
    }
    /** 
	  Remove the HTML tag from the input variable.
     */
    public function removeHtml($copy){
    
    	$copy = trim($copy);
    	$copy = htmlspecialchars($copy, ENT_QUOTES);
    	$copy = preg_replace( '/%/', '&#37;', $copy);
    	$copy = preg_replace( '/</', '&lt;', $copy);
    	$copy = preg_replace( '/>/', '&gt;', $copy);
    	$copy = preg_replace( '/&amp/', '&', $copy);
    	$copy = nl2br($copy);
    	$copy = StripSlashes($copy);
    	return($copy);
    }

    public function log($type,$title,$msg,$pfix=__ENV_LOG_PFIX__){
    
    	if($type >= __ENV_ERROR_LEVEL__) {
    	
    		$txt = $title."=>".$msg;
    		//error_log($txt);
    		$this->logging($txt,$pfix);
    	}
    }  
    public function getUrlPath(){
    
    	if( !isset($_GET['url']) ){
    		return "";
    	}
    	return $_GET['url'];
    }
    public function logging($msg,$fhname) {
	
    	$message = date("H:i:s")."|".__ENV_REMOTE_IP__."|".$_SERVER['REQUEST_URI']."|"." MSG: ".$msg.chr(13).chr(10);
       /*
        * 로그디렉토리가 존재하지 않으면 생성한다.
        */	
		if(!is_dir(__ENV_LOG_DIR__)){
			@mkdir(__ENV_LOG_DIR__);
		}		
		/*
		 * sql을 제외한 전체로그를 sys에 기록한다.
		 */
		if(__ENV_DEVELOP__ == 1){
			$newfilename = __ENV_LOG_DIR__.DIRECTORY_SEPARATOR."dev_log.log";
		}else{
			$newfilename = __ENV_LOG_DIR__.DIRECTORY_SEPARATOR.$fhname."_".date("Ymd").".log";
		}
		
		
		$fpall = fopen($newfilename, "a");
		
		if(!$fpall) {
			//die("Can not open the file == > check setting log dir");
			return;
		}
		
		fwrite($fpall, $message);
		fclose($fpall);
	
	}
    /**
     * Obtain the mega byte value.
     */
    public function getMegaOfBytes($mega){
    	return $mega * 1048576;
    }
    /**
     * today's date.  YYYY/mm/dd
     */
    public function getToday(){
    	return date("Y-m-d");
    }
    /**
     * Gets the current time. HH:mm:dd
     */
    public function getCurrentTime($flag=1){
    	if($flag){
    		return date("H:i:s");
    	}else{
    		return date("Y-m-d_H:i:s");
    	}
    }   
    public function addTimes($data){
        return time()+(60*60*(int)$data); // 현재시간 - 3시간
    }
    /**
     * Add the date.
     */
    public function addDays($givendate,$day=0,$mth=0,$yr=0) {
    
    	$cd = strtotime($givendate);    
    
    	$newdate = date('Y-m-d', mktime(date('h',$cd)
    			, date('i',$cd), date('s',$cd), date('m',$cd)+$mth
    			, date('d',$cd)+$day, date('Y',$cd)+$yr));
    
    	return $newdate;
    }  
    /**
     Retrieves the last day of the month.
     */
    public function monthEndday($y,$m) {
    	for ($i=28;; $i++) {
    		if (!checkdate($m,$i,$y))
    			break;
    	}
    	return $i-1;
    }
    
    /**
     //인증결과 데이터 추출 함수 (나이스 안심본인 인증)
     */
    public function GetValue($plaindata , $key) {

        $value = "";
        $keyIndex = -1;
        $valLen = 0;
 
        // 복호화 데이터 분할 (php 버전에 따라 split 함수나 explode 함수 적용)
        // $arrData = split(":", $plaindata);
        $arrData = explode(":", $plaindata);
        $cnt = count($arrData);

        for($i = 0; $i < $cnt; $i++){
            $item = $arrData[$i];
            $itemKey = preg_replace("/[0-9]+$/", "", $item);

            // 길이정보 제거한 값이 키값과 일치하는 데이터 검색
            if ($itemKey == $key){

                $keyIndex = $i;

                // 데이터 길이값 추출
                $valLen = (int) str_replace($key, "", $item);

                if($key != "NAME"){
                    // 실제 데이터 추출
                    $value = substr($arrData[$keyIndex + 1], 0, $valLen);
                }else{
                    // 이름 데이터 추출 (한글 깨짐 대응)
                    $value =  preg_replace("/[0-9]/", "", $arrData[$keyIndex + 1]);  
                }
                break;
            }
        }
        return $value;
    }
    
    
    /**
    	Retrieves the login ID.
     */
    public function getLoginId($type=__ENV_AUTH_TYPE__){
        
        $userid = "";
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            if (isset($_SESSION['acid'])) {
                //$crypt = new ApiCrypter();
                //$userid = $crypt->decrypt($_SESSION['acid']); // php bug
                $userid = $_SESSION['acid'];
            }
        }else{
            
            if($this->existsCookie("acid")){
                $userid =$this->getCookie("acid");
            }
        }
        return $userid;
    }
    
    public function getCmsLoginId($type=__ENV_AUTH_TYPE__){
        
        $userid = "";
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            if (isset($_SESSION['cmsid'])) {
                //$crypt = new ApiCrypter();
                //$userid = $crypt->decrypt($_SESSION['acid']); // php bug
                $userid = $_SESSION['cmsid'];
            }
        }else{
            
            if($this->existsCookie("cmsid")){
                $userid =$this->getCookie("cmsid");
            }
        }
        return $userid;
    }
    
    public function getPlayLoginId($type=__ENV_AUTH_TYPE__){
        
        $userid = "";
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            if (isset($_SESSION['playid'])) {
                //$crypt = new ApiCrypter();
                //$userid = $crypt->decrypt($_SESSION['acid']); // php bug
                $userid = $_SESSION['playid'];
            }
        }else{
            
            if($this->existsCookie("playid")){
                $userid =$this->getCookie("playid");
            }
        }
        return $userid;
    }
    
    public function getPlayLoginAgency($type=__ENV_AUTH_TYPE__){
        
        $agencyName = "";
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            if (isset($_SESSION['agency_name'])) {
                //$crypt = new ApiCrypter();
                //$userid = $crypt->decrypt($_SESSION['acid']); // php bug
                $agencyName = $_SESSION['agency_name'];
            }
        }else{
            
            if($this->existsCookie("agency_name")){
                $agencyName =$this->getCookie("agency_name");
            }
        }
        return $agencyName;
    }
    
    public function getPartnersLoginId($type=__ENV_AUTH_TYPE__){
        
        $userid = "";
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            if (isset($_SESSION['partnersid'])) {
                //$crypt = new ApiCrypter();
                //$userid = $crypt->decrypt($_SESSION['acid']); // php bug
                $userid = $_SESSION['partnersid'];
            }
        }else{
            
            if($this->existsCookie("partnersid")){
                $userid =$this->getCookie("partnersid");
            }
        }
        return $userid;
    }
    
    public function getPartnersLoginName($type=__ENV_AUTH_TYPE__){
        
        $agencyName = "";
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            if (isset($_SESSION['partners_name'])) {
                //$crypt = new ApiCrypter();
                //$userid = $crypt->decrypt($_SESSION['acid']); // php bug
                $agencyName = $_SESSION['partners_name'];
            }
        }else{
            
            if($this->existsCookie("partners_name")){
                $agencyName =$this->getCookie("partners_name");
            }
        }
        return $agencyName;
    }
    
    public function getBankerLoginId($type=__ENV_AUTH_TYPE__){
        
        $userid = "";
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            if (isset($_SESSION['bankid'])) {
                //$crypt = new ApiCrypter();
                //$userid = $crypt->decrypt($_SESSION['acid']); // php bug
                $userid = $_SESSION['bankid'];
            }
        }else{
            
            if($this->existsCookie("bankid")){
                $userid =$this->getCookie("bankid");
            }
        }
        return $userid;
    }
    
    public function getBankerLoginName($type=__ENV_AUTH_TYPE__){
        
        $bankerName = "";
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            if (isset($_SESSION['banker_name'])) {
                //$crypt = new ApiCrypter();
                //$userid = $crypt->decrypt($_SESSION['acid']); // php bug
                $bankerName = $_SESSION['banker_name'];
            }
        }else{
            
            if($this->existsCookie("banker_name")){
                $bankerName =$this->getCookie("banker_name");
            }
        }
        return $bankerName;
    }
    
    
    
    public function getCmsStaffLevel($type=__ENV_AUTH_TYPE__){
        
        $staff_lev = "";
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            if (isset($_SESSION['staff_lev'])) {
                $staff_lev = $_SESSION['staff_lev'];
            }
        }else{            
            if($this->existsCookie("staff_lev")){
                $staff_lev =$this->getCookie("staff_lev");
            }
        }
        return $staff_lev;
    }
    
    public function setSessionValue ( $name,$value,$type=__ENV_AUTH_TYPE__ ){
        if($type == __ENV_AUTH_TYPE__){
            Session::init();
            Session::set($name, $value);
        }else{
            $this->util->setCookie($name,$value);
        }
    }
    
    
    public function getRegion($type=__ENV_AUTH_TYPE__){
    	 
    	$region = __ENV_DEFALUT_REGION__;
    	 
    	if($type == __ENV_AUTH_TYPE__){
    	    @session_start();
    		if (isset($_SESSION['region'])) {
    			$region = $_SESSION['region'];
    		}
    	}else{
    
    		if($this->existsCookie("region")){
    			$region =$this->getCookie("region");
    		}
    	}
    	return $region;
    }
    
	/**
		Returns the connection browser.
	*/
	public function isBrowser() {		
		 $agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"None";     
		 $browser = array(
		  "MSIE5.0" => "/msie 5.0[0-9]*/",
		  "MSIE5.5" => "/msie 5.5[0-9]*/",
		  "MSIE6.0" => "/msie 6.0[0-9]*/",
		  "MSIE7.0" => "/msie 7.0[0-9]*/",
		  "MSIE8.0" => "/msie 8.0[0-9]*/",
		  "MSIE9.0" => "/msie 9.0[0-9]*/",
		  "Chrome" => "/chrome\/*/",
		  "FireFox" => "/firefox\/*/",
		  "Netscape" => "/x11/",
		  "Opera" => "/opera*/",
		  "Safari" => "/safari\/*/",
		  "Android" => "/android/",
		  "Iphone" => "/mobile\/[0-9a-z]* safari/",
		  "Robot-yahoo" => "/yahoo/",
		  "Robot" => "/bot/"
		 );	
		 $code = "none";	
		 $agent = strtolower($agent);
		 
		 foreach($browser as $name=>$exp){	
			  if(preg_match($exp, $agent)){
				  $code = $name;
			  }
		 }	
		 return strtolower($code);
	}
	
	function isIPhone($agent='') {
		if (empty($agent))
			 $agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:0;
		if (!empty($agent) and preg_match("~Mozilla/[^ ]+ \((iPhone|iPod); U; CPU [^;]+ Mac OS X; [^)]+\) AppleWebKit/[^ ]+ \(KHTML, like Gecko\) Version/[^ ]+ Mobile/[^ ]+ Safari/[^ ]+~", $agent, $match)) {
			//return "YES";
			return 1;
		} elseif (stristr($agent, 'iphone') or stristr($agent, 'ipod')){
			//return "MAYBE";
			return 1;
		} else {
			//return "NO";
			return 0;
		}
	}

	function alertJs($msg,$fnc){	
		$exec = "<script language='javascript'>
				      alert('".$msg."');
				      ".$fnc."
			     </script>";
		return $exec;
	}	
	function mboxpage($title,$msg){
	    
	    $from = "<div style='display:none;'>
                	<form  name=\"frm_message\" method=\"POST\" onSubmit=\"return false\" style='display:none;'>
                		<input type=\"text\" name=\"title\"  value=\"\"  >
                		<input type=\"text\" name=\"msg\"  value=\"\" >
                	</form>
                </div> ";
	    
	    $exec = "<script language='javascript'>
				      //location.href='/shop/mbox';
                      var f = document.frm_message;                      
                      f.title.value = \"".$title."\";
                      f.msg.value = \"".$msg."\";                      
                      f.method  = 'post';
	                  f.action = '/shop/mbox';
					  f.submit();   
			     </script>";
	    return $from.$exec;
	}
	/**
	 * Creates a cooki
	 * param : name , value , expire =0  Until the browser quits. , path Server path
	 * $expire = time() + 86400*365; // 1 year
	 * $expire=time()+86400; 		 // 1 day
	 */
	function setCookie($name,$value,$expire=0,$path="/",$hostname=__ENV_HTTP_HOST__){	    
		setcookie($name,$value,$expire,$path,$hostname);
	}
	function getCookie($name){
		if(!isset($_COOKIE[$name])) {
    		return "";
		} 
   		return $_COOKIE[$name];
	}
	
	function existsCookie($name){
		
		if(!isset($_COOKIE[$name])) {
			return false;
		}
		 
		if( $this->getStringLength($_COOKIE[$name]) < 1){
			return false;
		}
		return true;
	}
	/**
	 *  html -> db
	 */
	function htmlTodb($str){
		
		$str = addslashes( $str);
		if ( get_magic_quotes_gpc() ) {
			$str = htmlspecialchars( stripslashes( $str) ) ;
		}else{
			$str = htmlspecialchars( $str) ;
		}
		
		return $str;	
	}
	/**
	 *  db -> html
	 */	
	function dbtohtml($str){
		$str = stripcslashes($str);
		return htmlspecialchars_decode($str);
	}
	/**
	 * Create Token
	 */	
	function  getSecureToken($org_str) {
		$org_str = $org_str.__ENV_HASH_TOKEN_KEY__;
		$hash_str = hash(__ENV_SHA__, $org_str);
		$rand_str = "";
		$rand_char = array('a' ,'b' ,'c' ,'d' ,'e' ,'f' ,'A' ,'B' ,'C' ,'D' ,'E' ,'F' ,'0' ,'1' ,'2' ,'3' ,'4' ,'5' ,'6' ,'7' ,'8' ,'9' );
		for($i=0; ($i<20 && rand(1,10) != 10); $i++){
			$rand_str .= $rand_char[rand(0, count($rand_char)-1)];
		}
		return $hash_str.$rand_str;
	}	

    function rsa_encrypt($plaintext)
    {

        $public_key = __ENV_BITHUMB_PUBLIC_KEY__;
        //$plaintext = gzcompress($plaintext);
        
        // 공개키를 사용하여 암호화한다.
        $pubkey_decoded = @openssl_pkey_get_public($public_key);
        if ($pubkey_decoded === false) return false;
        
        $ciphertext = false;
        $status = @openssl_public_encrypt($plaintext, $ciphertext, $pubkey_decoded);
        if (!$status || $ciphertext === false) return false;
        
        // 암호문을 base64로 인코딩하여 반환한다.
        
        return base64_encode($ciphertext);
    }
    
    function rsa_decrypt($ciphertext)
    {
        $private_key = __ENV_BITCASH_PRIVATE_KEY__;
        $password = '';
        // 암호문을 base64로 디코딩한다.
        $ciphertext = @base64_decode($ciphertext, true);
        if ($ciphertext === false) return false;
        
        // 개인키를 사용하여 복호화한다.
        $privkey_decoded = @openssl_pkey_get_private($private_key, $password);
        if ($privkey_decoded === false) return false;
        
        $plaintext = false;
        $status = @openssl_private_decrypt($ciphertext, $plaintext, $privkey_decoded);
        @openssl_pkey_free($privkey_decoded);
        if (!$status || $plaintext === false) return false;
        
        // 압축을 해제하여 평문을 얻는다.
        //$plaintext = @gzuncompress($plaintext);
        if ($plaintext === false) return false;
        
        // 이상이 없는 경우 평문을 반환한다.
        
        return $plaintext;
    }
    

} //end Class