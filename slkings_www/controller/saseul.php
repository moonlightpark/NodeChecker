<?php
class Saseul extends Controller {
	
    private $__VAR_LOG_PFIX__  = __ENV_LOG_PFIX__;
    private $__VAR_LOG_LEVEL__ = 5;
    private $__VAR_NAV__       = "saseul_nav";
    private $__STAFF_LEVEL__   = "";
    private $__STAFF_STATUS    = "";
    
    public function __construct() { 
        parent::__construct();

        $this->_userid = $this->util->getCmsLoginId();
        $this->template->staff_lev = $this->util->getCmsStaffLevel(); //리스트용
        
        $this->template->today    = $this->util->getToday();
        $this->template->expday   = $this->util->addDays($this->template->today,3);
        $this->template->expdaybf = $this->util->addDays($this->template->today,-7);
        
        $this->template->gourl = "/";
    }
/**************************
// setup
***************************/  
    public function setup(){       
        
        $obj = (object)array("_key"=> $this->_userid);
        
        $rsemp = $this->model->getEmploy($obj);
        
        if(count($rsemp) != 1){
            $this->procExit();
            $this->template->gourl = "/saseul/login";
            $this->mbox("오류","No information exists.");
            exit;
        }
        $this->template->_userid = $this->_userid;
        
        $admin_inofo = $this->model->getAdminInfo($this->_userid);
        $this->_cmp_no  = $admin_inofo['cmp_no'];
        $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"cmp_no : ".$admin_inofo['cmp_no'],$this->__VAR_LOG_PFIX__);
        
        $this->template->total_banker_fee   = 0;
        $this->template->total_playsite_fee = 0;
        
        $this->__STAFF_LEVEL__ = $rsemp[0]["staff_lev"];
        $this->__USER_PHONE__  = $rsemp[0]["tel_no"];
        
        $this->template->staff_lev =  $this->__STAFF_LEVEL__;      
        $this->util->setSessionValue('staff_lev',$this->__STAFF_LEVEL__);
        $this->__STAFF_STATUS = $rsemp[0]["status_cd"];
        
        $this->__CMP_NO__ = $rsemp[0]["cmp_no"];
		$this->template->cmp_no = $this->__CMP_NO__;  
                
        if($this->__STAFF_STATUS != "UM001" ){
            $this->procExit();
            $this->template->gourl = "/saseul/login";
            $this->mbox("알림","You do not have access rights.");
            exit;
        }

    }
/**************************
// index page
***************************/  
    public function index(){
	    
        $obj = (object)array("_key"=> $this->_userid);
        $rsemp = $this->model->getEmploy($obj);
        
        if($this->_userid == ""){
            header('location: ' .__ENV_URL__."saseul/login");
        }
        
        if(count($rsemp) != 1){
            $this->procExit();
            $this->template->gourl = "/saseul/login";
            $this->mbox("Error","Administrator information does not exist.");
            exit;
        }
        
        $this->__STAFF_LEVEL__ = $rsemp[0]["staff_lev"];
        $this->template->staff_lev =  $this->__STAFF_LEVEL__;
        $this->util->setSessionValue('staff_lev',$this->__STAFF_LEVEL__);
        $this->__STAFF_STATUS = $rsemp[0]["status_cd"];
        
        if($this->__STAFF_STATUS != "UM001" ){
            $this->procExit();
            $this->template->gourl = "/saseul/login";
            $this->mbox("Warning","You do not have access rights.");
            exit;
        } 
        
        //
        header('location: ' .__ENV_URL__."saseul/node");
        
    }
/**************************
//  관리자 암호를 만들기위해서...
// 관리자 암호 만들고 function 삭제
***************************/  
    public function makeAdminPw(){
	    
		$emp_pwd = "12345678";        // your password
		$new_pwd = Hash::create(__ENV_SHA__, $emp_pwd, __ENV_HASH_PWD_KEY__);
		
		echo "emp_pwd  : ".$new_pwd;  // insert db tb_bmploy table -> emp_pwd field.

    }   
/**************************
// datalistc
***************************/  
    public function datalistc($page=1){
        
        $this->_page   = $this->util->reqRequestParameter("page", $page);
        $this->_rows   = $this->util->reqPostParameter("row", "10");
        $this->_search = $this->util->reqPostParameter("search", "");
        $this->_block  = $this->util->reqPostParameter("block", "10");
        $this->_key    = $this->util->reqPostParameter('key',"0");
        $this->_subkey = $this->util->reqPostParameter('subkey',"0");
        $this->_module = $this->util->reqPostParameter('module',"");
        $this->_funlist= $this->util->reqPostParameter('funlist',$this->_module);
        $this->_kind   = $this->util->reqPostParameter('kind',"");
        $this->_status = $this->util->reqPostParameter('status',"");
        $this->_view   = $this->util->reqPostParameter('view',"");
        $this->_used   = $this->util->reqPostParameter('used',"N");
        
        $this->template->_total_page_id  = $this->util->reqPostParameter('idtotalpage',"id_total_page");
        
        $this->model->setPage($this->_page);
        $this->model->setRows($this->_rows);
        $this->model->setSearch($this->_search);
        $this->model->setKey($this->_key);
        $this->model->setSubKey($this->_subkey);
        
        $this->template->rs = $this->model->{ "find".$this->_module}($this);
        $this->template->codelist = $this->model->getCodeList();
        $this->template->page($this->_page, $this->template->rs["count"][0]['p_count'], $this->template->rs["count"][0]['t_count'], $this->_block);
        
        $this->template->module = $this->_module;
        $this->template->list   = $this->_funlist.".list";
        $this->template->_kind  = $this->_kind;
        $this->template->view($this->_view);
    }   
    
/**************************
// Login
***************************/  
    public function login($type="nor",$url=__ENV_HOME_URL__){
        $this->template->type = $type;
        $this->template->url  = $url;
        $this->template->view("saseul/saseul_login");
    }
/**************************
// Logout
***************************/    
    public function logout($type=__ENV_AUTH_TYPE__){
        $this->procExit($type);
        if($type == __ENV_AUTH_TYPE__){
            header('location: '.__ENV_URL__);
            exit;            
        }else{
            header('location: '.__ENV_URL__);
            exit;
        }
    }
/**************************
// processExit
***************************/
    private function procExit($type=__ENV_AUTH_TYPE__){
        if($type == __ENV_AUTH_TYPE__){
            @session_start();
            $cmsid = isset($_SESSION['cmsid']);
            if ($cmsid) {
                @session_destroy();
            }
        }else{
            $this->util->setCookie("cmsid", "",time()-3600);
            $this->util->setCookie("staff_lev", "",time()-3600);
        }
    }
/**************************
// auth
***************************/
    public function auth($ptype=__ENV_AUTH_TYPE__){        
        $this->uid   = $this->util->removeSpace($this->util->reqPostParameter("uid", ""));
        $this->pass  = $this->util->removeSpace($this->util->reqPostParameter("pass", ""));
        /*------------------------------------------
         * Login
         * 0 -> ok
         * 1 -> id not exists.
         * 2 -> password not exists .
         -------------------------------------------*/
        $result = 0;
        $result = $this->model->auth($this,$ptype);
        
        $code = "2000";
        $msg = "An error has occurred.";
        
        switch ($result){
            case 0 :
                $code = "100";
                $msg = $this->util->getLang("999","log-in succeed");
                break;
            case 1 :
                $code = "201";
                $msg = $this->util->getLang("999","ID does not exist.");
                break;
            case 2 :
                $code = "202";
                $msg = $this->util->getLang("999","The connection IP address or password is different.");
                break;
            case 3 :
                $code = "203";
                $msg = $this->util->getLang("999","It is in a suspended state.");
                break;
            default :
                $code = "204";
                $msg = $this->util->getLang("999","An error has occurred.");
                break;
        }
        
        $body = array(
            "code"=> $code,
            "msg"=>$msg
        );
        $this->util->resJson($body);
    }
/**************************
// Add node
***************************/
	public function addNode(){
		    
	    if($this->_userid == ""){
	        header('location: ' .__ENV_URL__."saseul/login");
	    }
	    $this->_page =  $this->util->reqRequestParameter("page", "1");
	
	    $this->template->ShopInfoRs  = $this->model->getShopInfo($this);   
	    $this->template->_page   = $this->_page;        
	    $this->template->_title = "";
	                    
	    $this->setup();
	    $this->template->view('inc/saseul_header');
	    $this->template->view('inc/'.$this->__VAR_NAV__);
	    $this->template->view('saseul/saseul_addNode');
	    $this->template->view("inc/saseul_footer");
	}
/**************************
// get login user information
***************************/
	public function Myinfo(){
		    
	    if($this->_userid == ""){
	        header('location: ' .__ENV_URL__."saseul/login");
	    }
	    $this->_page =  $this->util->reqRequestParameter("page", "1");
	    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"info check ",$this->__VAR_LOG_PFIX__);
	
	    $this->template->ShopInfoRs  = $this->model->getShopInfo($this);   
	    $this->template->_page   = $this->_page;
	        
	    $this->template->_title = "";
	                    
	    $this->setup();
	    $this->template->view('inc/saseul_header');
	    $this->template->view('inc/'.$this->__VAR_NAV__);
	    $this->template->view('saseul/saseul_changepw');
	    $this->template->view("inc/saseul_footer");
	}
/**************************
// get login user information
***************************/
	public function editNode(){
		    
	    if($this->_userid == ""){
	        header('location: ' .__ENV_URL__."saseul/login");
	    }
	    
/*
	    $this->server =  $this->util->reqRequestParameter("server", "");
	    $this->port   =  $this->util->reqRequestParameter("port", "");
*/
	    	    
/*
	    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"info server ".$this->server,$this->__VAR_LOG_PFIX__);
	    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"info port ".$this->port,$this->__VAR_LOG_PFIX__);	
	                    
	    $this->template->ShopInfoRs  = $this->model->editNode($this); 
*/
	}
/**************************
// print messageBox
***************************/
    private function messageBox($title,$message){        
        $this->template->title = $title;
        $this->template->msg = $message;
        $this->template->view('inc/saseul_header');
        $this->template->view('shop/shop_msg');
        $this->template->view('inc/saseul_footer');
    }
/**************************
// print errorBox
***************************/
    private function mbox($title,$message){      
        $this->template->title = $title;
        $this->template->msg = $message;
        $this->template->view('inc/saseul_header');
        $this->template->view('saseul/saseul_msg');
        $this->template->view('inc/saseul_footer');
    }
/**************************
// Node index
***************************/
	public function node(){
		    
	    if($this->_userid == ""){
	        header('location: ' .__ENV_URL__."saseul/login");
	    }
	    $this->setup();
		
		$this->_page =  $this->util->reqRequestParameter("page", "1");
		$this->_node =  $this->util->reqRequestParameter("node", "");
		
	    $this->template->ShopInfoRs  = $this->model->getShopInfo($this);
	    $this->template->ipRs  = $this->model->getServerIpList($this);
	
	    $this->template->_title = "";
	    $this->template->_cmp_no = $this->_cmp_no;
	    $this->template->_page = $this->_page;
	    
	    $this->util->log($this->__VAR_LOG_LEVEL__,__FUNCTION__,"node : ".$this->_node,$this->__VAR_LOG_PFIX__);              
	    $this->template->view('inc/saseul_header');
	    $this->template->view('inc/'.$this->__VAR_NAV__);
	    $this->template->view('saseul/saseul_node');
	    $this->template->view("inc/saseul_footer");
	}
/**************************
// Document END
***************************/
}// EOD