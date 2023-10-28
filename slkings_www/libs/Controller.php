<?php
class Controller {

	protected  $template;
	protected  $model;
	protected  $util ;
	protected  $staff_lev = 0;
	
    function __construct() {    	
	    $this->template = new Template();
        $this->util = new Util();
    }
    /**
     * @param string $name Name of the model
     * @param string $path Location of the models
     */
    public function loadModel($name, $modelPath = 'model/') {        
        $path = $modelPath . $name.'_model.php';
       
     //   $this->util->log(9,__FUNCTION__."path",$path);
        if (file_exists($path)) {
            require $path;
            $modelName = $name . '_Model';
            $this->model = new $modelName();           
        }        
    }

    /**
     * Display an error messages
     *
     * @return boolean
     */
    public function _error($msg) {
    /*
    	require "controllers/error.php";
    	$err = new ErrorNew();
    	$err->message($msg);
    	exit;
    */
    }
    /**
     * 요금계산
     */
    public function compute(){
        $out = $this->model->getCompute();
        echo $this->util->resJson($out);
    }
    /**
     * 게시물 리스트
     * @param number $page
     */
    public function datalist($page=1){
        
        $this->_page =  $this->util->reqRequestParameter("page", $page);
        $this->_rows  =  $this->util->reqPostParameter("row", "10");
        $this->_search = $this->util->reqPostParameter("search", "");
        $this->_block  = $this->util->reqPostParameter("block", "10");
        $this->_key= $this->util->reqPostParameter('key',"0");
        $this->_subkey= $this->util->reqPostParameter('subkey',"0");
        $this->_module = $this->util->reqPostParameter('module',""); // module_name
        $this->_funlist = $this->util->reqPostParameter('funlist',$this->_module); // list function
        $this->_kind = $this->util->reqPostParameter('kind',"");     // kind
        $this->_status = $this->util->reqPostParameter('status',""); // status
        $this->_view = $this->util->reqPostParameter('view',"");     // view_name
        $this->_used = $this->util->reqPostParameter('used',"N");    //
        $this->template->_total_page_id  = $this->util->reqPostParameter('idtotalpage',"id_total_page");    //
                
        $this->model->setPage($this->_page);
        $this->model->setRows($this->_rows);
        $this->model->setSearch($this->_search);
        $this->model->setKey($this->_key);
        $this->model->setSubKey($this->_subkey);
        
        $this->template->rs = $this->model->{ "find".$this->_module}($this);
        
        $this->template->page($this->_page, $this->template->rs["count"][0]['p_count'], $this->template->rs["count"][0]['t_count'], $this->_block);
        
        $this->template->module = $this->_module;
        $this->template->list = $this->_funlist.".list";
        $this->template->_kind = $this->_kind;
        $this->template->view($this->_view);
    }    
    public function jlist($page=1){
        
        $this->_page =  $this->util->reqPostParameter("page", $page);
        $this->_rows  =  $this->util->reqPostParameter("row", "10");
        $this->_search = $this->util->reqPostParameter("search", "");
        $this->_block  = $this->util->reqPostParameter("block", "10");
        $this->_key= $this->util->reqPostParameter('key',"0");
        $this->_subkey= $this->util->reqPostParameter('subkey',"0");
        $this->_module = $this->util->reqPostParameter('module',""); // module_name
        $this->_funlist = $this->util->reqPostParameter('funlist',$this->_module); // list function
        $this->_kind = $this->util->reqPostParameter('kind',"");     // kind
        $this->_status = $this->util->reqPostParameter('status',""); // status
        $this->_view = $this->util->reqPostParameter('view',"");     // view_name
        $this->_used = $this->util->reqPostParameter('used',"N");    //
        
        $this->model->setPage($this->_page);
        $this->model->setRows($this->_rows);
        $this->model->setSearch($this->_search);
        $this->model->setKey($this->_key);
        $this->model->setSubKey($this->_subkey);
        
        $rs = $this->model->{ "find".$this->_module}($this);  
        $this->util->resJson($rs);        
    }
    
    public function listhtml(){
        $this->_type= $this->util->reqPostParameter('type',"0");
        $this->_key= $this->util->reqPostParameter('key',"0");
        $this->_subkey= $this->util->reqPostParameter('subkey',"0");
        $this->_kind = $this->util->reqPostParameter('kind',"");     // kind
        $this->_module = $this->util->reqPostParameter('module',""); // module_name
        $this->_view = $this->util->reqPostParameter('view',"");     // view_name
        $this->template->rs = $this->model->{ "all".$this->_module}($this);
        $this->template->view($this->_view);
    }
    
    public function listall(){
        
        $this->_type= $this->util->reqPostParameter('type',"0");
        $this->_key= $this->util->reqPostParameter('key',"0");
        $this->_subkey= $this->util->reqPostParameter('subkey',"0");
        $this->_module = $this->util->reqPostParameter('module',""); // module_name
        $rs = $this->model->{ "rs".$this->_module}($this);
        $this->util->resJson($rs);
        
    }
    
    public function info(){
        
        $this->_type= $this->util->reqPostParameter('type',"0");
        $this->_key= $this->util->reqPostParameter('key',"0");
        $this->_subkey= $this->util->reqPostParameter('subkey',"0");
        $this->_module = $this->util->reqPostParameter('module',""); // module_name
        $this->model->setKey($this->_key);
        $this->model->setSubKey($this->_subkey);
        $rs = $this->model->{ "get".$this->_module}($this);
        $this->util->resJson($rs);
        
    }
    
    public function save(){
        $this->_key= $this->util->reqPostParameter('key',"0");
        $this->_subkey= $this->util->reqPostParameter('subkey',"0");
        $this->_nextkey= $this->util->reqPostParameter('nextkey',"0");
        $this->_module = $this->util->reqPostParameter('module',""); // module_name
        $out = $this->model->{ "set".$this->_module}($this);
        $this->util->resJson($out);
    }
    
    public function delete(){
        $this->_key= $this->util->reqPostParameter('key',"0");
        $this->_subkey= $this->util->reqPostParameter('subkey',"0");
        $this->_module = $this->util->reqPostParameter('module',""); // module_name        
        $out = $this->model->{ "delete".$this->_module}($this);
        $this->util->resJson($out);
    }

} //--  class end