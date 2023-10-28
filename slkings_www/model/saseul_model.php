<?php
class Saseul_Model extends Model{    
	
	public function __construct(){
		parent::__construct();
		$this->_adminId = $this->util->getCmsLoginId();
		$this->__VAR_LOG_LEVEL__ = 5;
		$this->__VAR_SQL_LOG_LEVEL__ = 5;
		
		$this->today    = $this->util->getToday();
		$this->expday   = $this->util->addDays($this->today,3);
		$this->expdaybf = $this->util->addDays($this->today,-30);
		
		$admin_inofo = $this->getAdminInfo($this->_adminId);
	}
/************************************************
// Admin Information
*************************************************/
	public function getAdminInfo($adminId){
	    
	    $_key  = $adminId;
	    if ( $adminId !== ""){ 
		    $FilterData[":sid"] = $_key;
		    
		    $sql = "SELECT  a.*
					FROM tb_employ a 
	    			WHERE a.emp_id = :sid";
		    $rs = $this->db->select($sql,$FilterData);
	    return $rs[0];
	    }

	}
/************************************************
// Auth
*************************************************/	
	public function auth($req,$type=__ENV_AUTH_TYPE__){
    	$ip = getenv('HTTP_X_FORWARDED_FOR');
    	
	    $sql = " SELECT  a.emp_id, a.status_cd, a.ip_addr
	    	         FROM tb_employ a
	    	         WHERE a.emp_id = :id ";
	    
	    $rs = $this->db->select($sql,array(":id" => $req->uid ));
	    
	    if ( !is_array($rs) || !count($rs) ) {
	        return 1; // Id not fuound
	    }
	    
	    if($rs[0]['status_cd'] != "UM001"){
	        return 3; // access stop
	    }
	    
	    // IP Check.
	    if ( $req->uid == 'master' OR $rs[0]['ip_addr'] == '*' ){
		    $sql = " SELECT  a.emp_id, a.staff_lev
		    	         FROM tb_employ a
		    	         WHERE a.emp_id = :id
		    			 AND a.emp_pwd = :passwd
	                     AND a.status_cd = 'UM001' ";
		    $rs = $this->db->select($sql,array(":id" => $req->uid,":passwd"=> Hash::create(__ENV_SHA__, $req->pass, __ENV_HASH_PWD_KEY__)));
	    }else{
		    $sql = " SELECT  a.emp_id, a.staff_lev
		    	         FROM tb_employ a
		    	         WHERE a.emp_id = :id
		    			 AND a.emp_pwd = :passwd
		    			 AND a.ip_addr = :ip
	                     AND a.status_cd = 'UM001' ";
		    $rs = $this->db->select($sql,array(":id" => $req->uid,":passwd"=> Hash::create(__ENV_SHA__, $req->pass, __ENV_HASH_PWD_KEY__),":ip"=>$ip));
	    }
	    
	    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,Hash::create(__ENV_SHA__, $req->pass, __ENV_HASH_PWD_KEY__),$this->__VAR_LOG_PFIX__);
	    
	    if ( !is_array($rs) || !count($rs) ) {
		    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"접속자 IP : ".is_array($rs),$this->__VAR_LOG_PFIX__);
		    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"접속자 IP : ".count($rs),$this->__VAR_LOG_PFIX__);
	        return 2; // incorrect password
	    }
	    
	    $encrypted_uid = $rs[0]['emp_id'];
	    
	    if($type == __ENV_AUTH_TYPE__){
	        Session::init();
	        Session::set('cmsid', $encrypted_uid);
	    }else{
	        $this->util->setCookie("cmsid", $encrypted_uid);
	    }	    
	    return 0;
	} //end - login
/************************************************
// User List
*************************************************/
	public function findEmployList($param){
	    $_WHERE_VALUE_ = array();
	    $_RESULT_SET_ = array();
	    $_WHERE_STATEMENT_ = "";
	    
	    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"kind=>".$param->_search,$this->__VAR_LOG_PFIX__);
	    
	    if($this->util->getStrlenWithSpace($this->_search)){
	        $_WHERE_STATEMENT_ .= " and ( " ;
	        $_WHERE_STATEMENT_ .= "     a.emp_id LIKE :search ";
	        $_WHERE_STATEMENT_ .= "  OR a.emp_name LIKE :search ";
	        $_WHERE_STATEMENT_ .= " ) ";
	        $_WHERE_VALUE_[":search"] = '%'.$this->_search.'%';
	    }
	    
	    //Query count
	    $sql = " select COUNT(a.emp_id ) as t_count ,CEILING( COUNT(a.emp_id) / $this->_rows ) as p_count
	   	         from  tb_employ a
                 where 1 = 1 ".
                 $_WHERE_STATEMENT_ ;
        $rs = $this->db->select($sql,$_WHERE_VALUE_);
        $_RESULT_SET_["count"]=$rs;
        
        // Query Data
        $s_point = ((int)$this->_page -1 ) * $this->_rows;
                 
        $sql =  "select a.*, c.code_name_sub as status_nam, d.code_name_sub as staff_lev_nm
        from  tb_employ a
        LEFT OUTER JOIN tb_code c on a.status_cd = c.code_no
        LEFT OUTER JOIN tb_code d on a.staff_lev = d.code_no
        where 1 = 1 ".
        $_WHERE_STATEMENT_.
        " order by a.emp_id desc ".
        " limit $s_point , $this->_rows " ;
        
        $rs = $this->db->select($sql,$_WHERE_VALUE_);
        $_RESULT_SET_["data"]=$rs;
        return $_RESULT_SET_;	    
	    
	} // END - findEmployList
/************************************************
// get User
*************************************************/	
	public function getEmploy($param){
	    
	    $FilterData[":key"] = $param->_key;
	    
	    $sql = "SELECT  a.emp_id
                        ,a.emp_nm
                        ,a.staff_lev
                        ,a.tel_no
                        ,a.cmp_no
                        ,a.email_addr
                        ,a.status_cd
				FROM tb_employ a
    			WHERE a.emp_id = :key";
	    
	    $rs = $this->db->select($sql,$FilterData);
	    return $rs;
	}
/************************************************
// Mining shop
*************************************************/
public function getShopInfo($param){
	    
	$_WHERE_VALUE_ = array();
	$_WHERE_VALUE_[":key"] = $param->_userid;
	
	$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,$param->_userid,$this->__VAR_LOG_PFIX__);
	$sql = "SELECT a.*
			FROM tb_employ a
			WHERE a.emp_id = :key ";
	
	$rs = $this->db->select($sql,$_WHERE_VALUE_);
	return $rs;
	
} // END getShopInfo
/************************************************
// Node Info
*************************************************/
public function deleteNode($param){

    $server = $this->util->reqPostParameter("server", "");
    $port   = $this->util->reqPostParameter("port", "");
    
	$_WHERE_VALUE_ = array();
	$_WHERE_VALUE_[":node"] = $server;
	$_WHERE_VALUE_[":port"] = $port;
	
	$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,$server,$this->__VAR_LOG_PFIX__);
	$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,$port,$this->__VAR_LOG_PFIX__);
	
/*
	$sql = "DELETE
			FROM tb_server a
			WHERE a.node = :node and a.port = :port ";
*/
	
	$where = " node ='".$server."' AND port= '".$port."' ";
	$result = $this->db->delete("tb_server",$where,"1");

    $out = array(
        "code"=>"100",
        "msg"=>"Remove Success."
    );
    return $out;
} // END deleteNode
/************************************************
// Node Info
*************************************************/
public function getNode($param){
	    
	$_WHERE_VALUE_ = array();
	$_WHERE_VALUE_[":key"] = $param->_userid;
	
	$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"UserId : ".$param->_userid,$this->__VAR_LOG_PFIX__);
	$sql = "SELECT a.*
			FROM tb_employ a
			WHERE a.emp_id = :key ";
	
	$rs = $this->db->select($sql,$_WHERE_VALUE_);

    $this->db->commit();
    $out = array(
        "code"=>"100",
        "msg"=>"Insert Success."
    );
    return $out;
} // END getNode
/************************************************
// Edit Node Info
*************************************************/
public function getEditNode($param){
	    
    $this->server =  $this->util->reqRequestParameter("server", "");
    $this->port   =  $this->util->reqRequestParameter("port", "");
    
	$_WHERE_VALUE_ = array();
	$_WHERE_VALUE_[":node"] = $this->server;
	$_WHERE_VALUE_[":port"] = $this->port;
	
	$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"UserId : ".$param->_userid,$this->__VAR_LOG_PFIX__);
    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"server ".$this->server,$this->__VAR_LOG_PFIX__);
    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"port ".$this->port,$this->__VAR_LOG_PFIX__);

	$sql = "SELECT a.*
			FROM tb_server a
			WHERE a.node = :node and a.port = :port ";
	
	$rs = $this->db->select($sql,$_WHERE_VALUE_);

    return $rs;
} // END getNode
/************************************************
// get User List
*************************************************/
	//get emp list
	public function getEmpList(){	    
	    $sql = "select a.*
				from tb_employ a
                WHERE a.staff_lev in ( 'EM008','EM007','EM001' )
				order by a.emp_id ";
	    
	    $rs = $this->db->select($sql);	    
	    $out = array();	    
	    foreach($rs as $key => $value) {
	        $out[] =$value['emp_id']."/".$value['emp_nm']."(".$value['emp_id'].")";
	    }
	    return $out;
	}
/************************************************
// Node add & update
*************************************************/
	public function setNode(){
	    
	    $flag      = $this->util->reqPostParameter("flag", "I");
	    //$emp_id    = $this->util->reqPostParameter("emp_id", "");
	    $no        = $this->util->reqPostParameter("no", "");
	    $emp_nm    = $this->util->reqPostParameter("emp_nm", "");
	    $ip_addr   = $this->util->reqPostParameter("ip_addr", "");
	    $port      = $this->util->reqPostParameter("port", "");
	    $cmp_no    = $this->util->reqPostParameter("cmp_no", "");
	    $status_cd = $this->util->reqPostParameter("status_cd", "ST001");
	    
	    if($flag == "U"){
	        
            $sql = " UPDATE tb_server  ".
	   	            " SET node = ? ".
	   	            " ,port = ? ".
	   	            " ,name = ? ".
	   	            " ,regist_dt = ?".
	   	            " ,regist_tm = ?".
	   	            " ,status_cd=? ".
	   	            " WHERE no  = ? ";
            
            $param = array($ip_addr, $port, $emp_nm, __ENV_TODAY__, __ENV_NOW_TIME__, $status_cd, $no);
	        
	        $this->db->beginTransaction();
	        $result = $this->db->updateDml($sql,$param);
	        
	        if(!$result){
	            $this->db->rollBack();
	            $out = array(
	                "code"=>"301",
	                "msg"=>"Update failed"
	            );
	            return $out;
	        }
	        
	        $this->db->commit();
	        $out = array(
	            "code"=>"100",
	            "msg"=>"Update Success"
	        );
	        return $out;
	        
	    }else{
	        
	        $sql = " SELECT a.cmp_no "
	              ." FROM tb_server a "
	              ." WHERE a.node = :node and a.port = :port " ;
	                
            $FilterData = array(":node"=> $ip_addr, ":port"=> $port);
            $rs = $this->db->select($sql,$FilterData);
            
            if(count($rs) >= 1 ){                
                //$this->db->rollBack();
                $out = array(
                    "code"=>"301",
                    "msg"=>"This ip address & port is already in use."
                );
                return $out;
            }
	                    
            $sql = " INSERT INTO tb_server ( cmp_no, node, port, name, regist_dt, regist_tm, regist_id, status_cd) ".
                   " VALUES ( ?,?,?,?,?,?,?,?) ";
            
            $param = array($cmp_no, $ip_addr, $port, $emp_nm, __ENV_TODAY__, __ENV_NOW_TIME__, 'system', $status_cd);
            $this->db->beginTransaction();
            $result = $this->db->execDml($sql,$param);
            if(!$result){
                $this->db->rollBack();
                $out = array(
                    "code"=>"301",
                    "msg"=>"Update failed"
                );
                return $out;
            }
            
            $this->db->commit();
            $out = array(
                "code"=>"100",
                "msg"=>"Insert Success."
            );
            return $out;
	    }
	} // END - setEmploy
/************************************************
// Employ add & update
*************************************************/
	public function setEmploy(){
	    
	    $flag = $this->util->reqPostParameter("flag", "I");
	    $emp_id = $this->util->reqPostParameter("emp_id", "");
	    $emp_nm = $this->util->reqPostParameter("emp_nm", "");
	    $emp_pwd = $this->util->reqPostParameter("emp_pwd", "");
	    $staff_lev = $this->util->reqPostParameter("staff_lev", "EM001");
	    $tel_no = $this->util->reqPostParameter("tel_no", "");
	    $cmp_no = $this->util->reqPostParameter("cmp_no", "");
	    $email_addr = $this->util->reqPostParameter("email_addr", "");
	    $status_cd = $this->util->reqPostParameter("status_cd", "UM001");
	    
	    if($flag == "U"){
	        
	        if( $this->util->getStringLength($emp_pwd) < 6 ){
	            //Don't chage password
	            $sql = " UPDATE tb_employ  ".
	   	            " SET emp_nm = ? ".
	   	            " ,staff_lev = ? ".
	   	            " ,tel_no = ? ".
	   	            " ,cmp_no = ? ".
	   	            " ,email_addr = ? ".
	   	            " ,update_dt ='".__ENV_TODAY__."' ".
	   	            " ,update_tm ='".__ENV_NOW_TIME__."' ".
	   	            " ,update_id=? ".
	   	            " ,status_cd=? ".
	   	            " WHERE emp_id  = ? ";
	            
	            $param = array($emp_nm,$staff_lev,$tel_no,$cmp_no,$email_addr,$this->_adminId,$status_cd,$emp_id);
	            
	        }else{
		        
	            $new_pwd = Hash::create(__ENV_SHA__, $emp_pwd, __ENV_HASH_PWD_KEY__);
	            //change password
	            $sql = " UPDATE tb_employ  ".
	   	            " SET emp_nm = ? ".	   	           
	   	            " ,emp_pwd = ? ".
	   	            " ,staff_lev = ? ".
	   	            " ,tel_no = ? ".
	   	            " ,cmp_no = ? ".
	   	            " ,email_addr = ? ".
	   	            " ,update_dt ='".__ENV_TODAY__."' ".
	   	            " ,update_tm ='".__ENV_NOW_TIME__."' ".
	   	            " ,update_id=? ".
	   	            " ,status_cd=? ".
	   	            " WHERE emp_id  = ? ";
	            
	            $param = array($emp_nm,$new_pwd,$staff_lev,$tel_no,$cmp_no,$email_addr,$this->_adminId,$status_cd,$emp_id);
	        }
	        
	        $this->db->beginTransaction();
	        $result = $this->db->updateDml($sql,$param);
	        
	        if(!$result){
	            $this->db->rollBack();
	            $out = array(
	                "code"=>"301",
	                "msg"=>"Update failed"
	            );
	            return $out;
	        }
	        
	        $this->db->commit();
	        $out = array(
	            "code"=>"100",
	            "msg"=>"Update Success"
	        );
	        return $out;
	        
	    }else{
	        
	        $sql = " SELECT a.emp_id "
	            ." FROM tb_employ a "
	            ." WHERE a.emp_id = :empid " ;
	                
            $FilterData = array(":empid"=> $emp_id);
            $rs = $this->db->select($sql,$FilterData);
            
            if(count($rs) >= 1 ){                
                $this->db->rollBack();
                $out = array(
                    "code"=>"301",
                    "msg"=>"This ID is already in use."
                );
                return $out;
            }
	                
            $new_pwd = Hash::create(__ENV_SHA__, $emp_pwd, __ENV_HASH_PWD_KEY__);
            
            $sql = " INSERT INTO tb_employ ( emp_id,cmp_no,emp_nm,emp_pwd,pw_changedt,staff_lev,tel_no,line_no,mphone,fax_no,email_addr,bank_name,bank_no,bank_owner,token_addr,regist_dt,regist_tm,regist_id,status_cd) ".
                " VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
            
            $param = array($emp_id,$cmp_no,$emp_nm,$new_pwd,__ENV_TODAY__,$staff_lev,$tel_no,$line_no,$mphone,$fax_no,$email_addr,$bank_name,$bank_no,$bank_owner,$token_addr,__ENV_TODAY__,__ENV_NOW_TIME__,$this->_adminId,$status_cd);
            $this->db->beginTransaction();
            $result = $this->db->execDml($sql,$param);
            if(!$result){
                $this->db->rollBack();
                $out = array(
                    "code"=>"301",
                    "msg"=>"Update failed"
                );
                return $out;
            }
            
            $this->db->commit();
            $out = array(
                "code"=>"100",
                "msg"=>"Update Success"
            );
            return $out;
	    }
	} // END - setEmploy
/************************************************
// Server List
*************************************************/
	public function findServerList($param){
		
		$node = $this->util->reqPostParameter("node", "");
		$kind = $this->util->reqPostParameter("kind", "");
		
	    $_WHERE_VALUE_ = array();
	    $_RESULT_SET_ = array();
	    $_WHERE_STATEMENT_ = "";
	    
		$_WHERE_STATEMENT_ .= " and ( " ;
		$_WHERE_STATEMENT_ .= "    a.cmp_no = :cmp_no and node =:node ";
		$_WHERE_STATEMENT_ .= " ) ";
		$_WHERE_VALUE_[":cmp_no"] = $this->_key;
		$_WHERE_VALUE_[":node"] = $node;

	
	    //Query count
	    $sql = " select COUNT(a.no) t_count ,CEILING( COUNT(a.no) / $this->_rows ) as p_count
	   	         from tb_server a
                 where a.status_cd = 'ST001' ".
                 $_WHERE_STATEMENT_
                 ;
                 
        $rs = $this->db->select($sql, $_WHERE_VALUE_);
        $_RESULT_SET_["count"]=$rs;
        
        // Query Data
        $s_point = ((int)$this->_page -1 ) * $this->_rows;
        
        $sql = "SELECT a.node ".
                "FROM tb_server a
                  WHERE 1 = 1 and a.status_cd = 'ST001'".
                  $_WHERE_STATEMENT_.
                  " GROUP BY node order by a.node DESC  ";
            
        $rs = $this->db->select($sql, $_WHERE_VALUE_);
        $_RESULT_SET_["server"]=$rs;
                    
        $sql = "SELECT a.* ".
                "FROM tb_server a
                    WHERE 1 = 1 and a.status_cd = 'ST001' ".$_WHERE_STATEMENT_." order by a.node DESC limit $s_point , $this->_rows ";
            
        $rs = $this->db->select($sql, $_WHERE_VALUE_);
        $_RESULT_SET_["data"]=$rs;
            
            
        /* if check All log check. */
        if ( $kind == 'all' ){
	        
	        $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__," kind :".$kind, $this->__VAR_LOG_PFIX__);
	        foreach($rs as $key => $value ){       
		        //
		        $this->cmp_no    = $value["cmp_no"];
		        $this->node_ip   = $value["node"];
		        $this->node_port = $value["port"];
		        
		        
		        
		        //
		        $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__," cmp_no :".$this->node_ip, $this->__VAR_LOG_PFIX__);
		        //
		        
		        $this->backgroundServerLog($this);
		        
		    }

        }
            
        return $_RESULT_SET_;
	} // END findServerList
/************************************************
// background All Log update 
*************************************************/
    public function backgroundServerLog($param){        
        
	    $cmp_no      = $param->cmp_no;
	    $server      = $param->node_ip;
	    $port        = $param->node_port;
        
        $url = "http://".$server.':'.$port.'/info';
        
	    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $cmp_no,$this->__VAR_LOG_PFIX__);
	    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $url,$this->__VAR_LOG_PFIX__);
        	
		$return = file_get_contents($url);
		
		$object = json_decode($return);
		$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $return, $this->__VAR_LOG_PFIX__);
		
		if ($return){
			
			@$mining        = $object->data->mining;  // true or false -> Error 
			$last_block    = $object->data->last_block->height;
			$last_resource = $object->data->last_resource_block->height;
			$status        = $object->data->status;

			$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $mining, $this->__VAR_LOG_PFIX__);
			$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $last_block, $this->__VAR_LOG_PFIX__);
			$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $last_resource, $this->__VAR_LOG_PFIX__);
			$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $status, $this->__VAR_LOG_PFIX__);
		
			
		    $status_cd   = "ST001";
		    
	        $sql = " UPDATE tb_server  SET mining = ? , last_block = ? , last_resource = ? ".
		           " ,status = ? ,regist_dt = ? , regist_tm=? WHERE node  = ? and port = ?";
	        $data = array($mining,$last_block,$last_resource,$status,__ENV_TODAY__,__ENV_NOW_TIME__, $server, $port);
	        
	        $this->db->beginTransaction();
	        $result = $this->db->updateDml($sql,$data);
	        
	        if($result > 1){
		        $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, "Update Fail.", $this->__VAR_LOG_PFIX__);
	            $this->db->rollBack();
	            $msg = "Node Log update fail.";
		        $out = array(
		            "code"=>"201",
		            "msg"=>$msg
		        );
	            return $out;
	        }
	        
	        $this->db->commit();			
		}

    }// backgroundServerLog
/************************************************
// IP List
*************************************************/
	public function getServerIpList($param){
		
	    $_WHERE_VALUE_ = array();
		$_cmp_no = $param->_cmp_no;
	    
        $this->util->log($this->__VAR_SQL_LOG_LEVEL__,__FUNCTION__,"cmp_no:".$_cmp_no, $this->__VAR_LOG_PFIX__);
        
        $sql = "SELECT a.node ".
                "FROM tb_server a
                  WHERE 1 = 1 and a.status_cd = 'ST001' and cmp_no = '".$_cmp_no."' GROUP BY node order by a.node DESC  ";
            
            $rs = $this->db->select($sql,$_WHERE_VALUE_);
            $_RESULT_SET_["server"]=$rs;
            
            return $_RESULT_SET_;
	} // END getServerIpList
/************************************************
// Log update
*************************************************/
    public function setServerLog($param){        
        
	    $cmp_no      = $this->util->reqPostParameter("cmp_no", "");
	    $server      = $this->util->reqPostParameter("server", "");
	    $port        = $this->util->reqPostParameter("port", "");
        
        $url = "http://".$server.':'.$port.'/info';
        
	    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $url,$this->__VAR_LOG_PFIX__);
        	
		$return = file_get_contents($url);
		
		$object = json_decode($return);
		$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $return, $this->__VAR_LOG_PFIX__);
		
		if ($return){
			
			@$mining        = $object->data->mining;
			@$last_block    = $object->data->last_block->height;
			@$last_resource = $object->data->last_resource_block->height;
			@$status        = $object->data->status;

			$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $mining, $this->__VAR_LOG_PFIX__);
			$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $last_block, $this->__VAR_LOG_PFIX__);
			$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $last_resource, $this->__VAR_LOG_PFIX__);
			$this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, $status, $this->__VAR_LOG_PFIX__);
		
			
		    $status_cd   = "ST001";
		    
	        $sql = " UPDATE tb_server  SET mining = ? , last_block = ? , last_resource = ? ".
		           " ,status = ? ,regist_dt = ? , regist_tm=? WHERE node  = ? and port = ?";
	        $data = array($mining,$last_block,$last_resource,$status,__ENV_TODAY__,__ENV_NOW_TIME__, $server, $port);
	        
	        $this->db->beginTransaction();
	        $result = $this->db->updateDml($sql,$data);
	        
	        if($result > 1){
		        $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__, "Update Fail.", $this->__VAR_LOG_PFIX__);
	            $this->db->rollBack();
	            $msg = "Node Log update fail.";
		        $out = array(
		            "code"=>"201",
		            "msg"=>$msg
		        );
	            return $out;
	        }
	        
	        $this->db->commit();			
		}

		$out = array(
			"code"=>"100",
			"msg"=>$this->util->getLang("999","Get Log."),
			"node_ip"=>$server
		);

		return $out;
    }// setServerLog	

/************************************************
// Document END
*************************************************/

} // __END_CLASS__ 