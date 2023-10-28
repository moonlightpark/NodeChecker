<?php
class Index extends Controller {
	
    private $__VAR_LOG_PFIX__ = __ENV_LOG_PFIX__;
    private $__VAR_LOG_LEVEL__ = 5;
    
    public function __construct() {
        parent::__construct();
    }    
    public function index() {    	

        if( __ENV_HTTP_HOST__ == "www.slkings.com" ){
         
            header('location: ' .__ENV_URL__."saseul");
            
        }else{
            header('location: ' .__ENV_URL__."saseul");
        }
    }
 
}
