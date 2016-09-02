<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class frontend extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->cek_user();		
		$this->load->library('lib');
	}
	
	public function index(){		
		if($this->auth){
			$this->smarty->display('frontend/index-main.html');
		}
	}
	
	private function cek_user(){
		if(!$this->auth){
			if($this->session->flashdata('error')){
				$this->smarty->assign("error", $this->session->flashdata('error'));
			}
			$this->smarty->display('frontend/index-login.html');
		}
	}	
	
	function getdisplay($type="", $p1="", $p2="", $p3=""){
		switch($type){
			case "__loginuser":
				$content = "frontend/index-login.html";
			break;
			case "__registeruser":
				$this->load->library('recaptcha');
				$content = "frontend/index-register.html";
				$this->smarty->assign('html_captcha', $this->recaptcha->recaptcha_get_html());
			break;
		}
		
		$this->smarty->display($content);
	}
	
	function simpansavedbx($type=""){
		$post = array();
        foreach($_POST as $k=>$v) $post[$k] = $this->db->escape_str($this->input->post($k));
        //foreach($_POST as $k=>$v) $post[$k] = $this->input->post($k);
		
		/*
		echo "<pre>";
		print_r($post);
		exit;
		//*/
		
		echo $this->mfrontend->simpansavedatabase($type, $post);
	}
	
	function coretcoret(){
		echo "<pre>";
		print_r($this->auth);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */