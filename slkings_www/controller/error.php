<?php
class ErrorNew extends Controller {

    public function __construct() {
        parent::__construct(); 
    }
    
    public function index($msg="error") {
        $title = $this->util->reqGetParameter("title","404");
        $message = $this->util->reqGetParameter("message","404 error");
        $this->template->title = $title;
        $this->template->msg = $msg;
        $this->template->view('saseul/tpl_msg');
    }
    
    public function mbox(){        
        $title = $this->util->reqGetParameter("title","404");
        $message = $this->util->reqGetParameter("message","404 error");
        $this->template->title = $title;
        $this->template->msg = $message;
        $this->template->view('inc/saseul_header');
        $this->template->view('inc/saseul_nav');
        $this->template->view('saseul/tpl_msg');
        $this->template->view('inc/saseul_footer');
    }
}