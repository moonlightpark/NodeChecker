<?php
class Model {

	protected $_rows = 10;
	protected $_table_name = "";
	protected $_page = 1;
	protected $_search = "";	
	protected $_key = "";
	protected $_subkey = "";
	protected $_sortindex = "1";
	protected $_response_ = "";
	protected $_adminId = "";
	protected $_loginid = "";	
	protected $util ;
	protected $__VAR_LOG_PFIX__ = __ENV_LOG_PFIX__;
	protected $__VAR_LOG_LEVEL__ = 5;
	protected $__VAR_SQL_LOG_LEVEL__ = 5;
	
    function __construct() {
        $this->db = new Database(__ENV_DB_TYPE__, __ENV_DB_HOST__, __ENV_DB_PORT__, __ENV_DB_NAME__, __ENV_DB_USER__, __ENV_DB_PASS__,false);
        $this->db->query("set session character_set_connection=utf8;");
        $this->db->query("set session character_set_results=utf8;");
        $this->db->query("set session character_set_client=utf8;");
        $this->util = new Util();
        //$crypt = new ApiCrypter();
        //$this->_adminId = $crypt->decrypt($this->util->getLoginId());
    }
    /**
     * Setter
     * @param
     */
    public function setSortIndex($value){
    	$this->_sortindex = $value;
    }
    
    public function setRows($value){
    	$this->_rows = $value;
    }
    public function setPage($value){
    	$this->_page = $value;
    }    
    public function setSearch($val){
    	$this->_search = $val;
    }
    public function setKey($val){
    	$this->_key = $val;
    }
    public function setSubKey($val){
    	$this->_subkey = $val;
    }
    public function setStartDt($val){
    	$this->_startdt = $val;
    }
    public function setEndDt($val){
    	$this->_enddt = $val;
    }    
    public function setLoginId($val){
        $this->_loginid = $val;
    }    
    public function getVersion(){
        return "1.0.1";
    }    
    public function getDateTime(){
        
        $sql = "select now() as dt ";
        $FilterData = array();
        $rs = $this->db->select($sql,$FilterData);
        return $rs[0]['dt'];
    }

} // end -class