<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
	}
	
	public function login_frontend(){
		//print_r($_POST);
		$user = $this->db->escape_str($this->input->post('usr'));
		$pass = $this->db->escape_str($this->input->post('pss'));
		$error=false;
		if($user && $pass){
			$cek_user = $this->mfrontend->getdata('data_login', 'row_array', $user);
			//print_r($cek_user);exit;
			if(count($cek_user)>0){
				if($pass == $this->encrypt->decode($cek_user['password'])){
					$this->session->set_userdata($this->config->item('user_data'), base64_encode(serialize($cek_user)));
				}else{
					$error=true;
					$this->session->set_flashdata('error', 'Password Invalid');
				}
			}else{
				$error=true;
				$this->session->set_flashdata('error', 'User Not Found');
			}
		}else{
			$error=true;
			$this->session->set_flashdata('error', "Username & Password Can't Empty!");
		}
		
		header("Location: {$this->host}");
	}
	
	function logout_frontend(){
		$this->session->unset_userdata($this->config->item('user_data'), 'limit');
		$this->session->sess_destroy();
		header("Location: ".$this->host."logout");
	}

}
