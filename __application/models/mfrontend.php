<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class mfrontend extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->auth = unserialize(base64_decode($this->session->userdata($this->config->item('user_data'))));
	}
	
	function getdata($type, $balikan="", $p1="", $p2="", $p3=""){
		switch($type){
			case "data_login":
				$sql = "
					SELECT *
					FROM tbl_userxx
					WHERE username = '".$p1."'
				";
				//echo $sql;
			break;
		}
		
		if($balikan == 'json'){
			return $ci->mhome->result_query($sql,'json',$type);
		}elseif($balikan == 'row_array'){
			return $this->db->query($sql)->row_array();
		}elseif($balikan == 'result_array'){
			return $this->db->query($sql)->result_array();
		}
		
	}
	
	function simpansavedatabase($type="", $post="", $p1="", $p2="", $p3=""){
		$this->load->library('lib');
		$this->db->trans_begin();
		$post_benar = array();
		
		switch($type){
			case "__registeraccount":
				$this->load->library('encrypt');
				$post_benar['real_name'] = $post['rlnm'];
				$post_benar['nick_name'] = $post['nknm'];
				$post_benar['username']  = $post['em'];
				$post_benar['password']  = $this->encrypt->encode($post['pssw']);
				$post_benar['email']  = $post['em'];
				$post_benar['dateregist']  = date('Y-m-d H:i:s');
				
				$cekdata = $this->db->get_where('tbl_userxx', array('username'=>$post['em']) )->row_array();
				if($cekdata){
					return 2;exit;
				}
				
				$this->db->insert('tbl_userxx', $post_benar);
			break;
		}
		
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return "Data not saved";
		} else{
			return $this->db->trans_commit();
		}
	}
}