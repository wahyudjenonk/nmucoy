<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class backend extends CI_Controller {

	function __construct(){
        parent::__construct();
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("If-Modified-Since: Mon, 22 Jan 2008 00:00:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Cache-Control: private");
		header("Pragma: no-cache");
		$this->auth = unserialize(base64_decode($this->session->userdata($this->config->item('user_data'))));
		$this->host	= $this->config->item('base_url');
		$this->smarty->assign('host',$this->host);
		$this->smarty->assign('auth', $this->auth);
		$this->load->model('mbackend');
		$this->load->library('lib');
	}

	public function index(){
		if(!$this->auth){
			if($this->session->flashdata('error')){
				$this->smarty->assign("error", $this->session->flashdata('error'));
			}
			$this->smarty->display('main-login.html');
		}else{
			$this->smarty->display('main-backend.html');
		}
	}
	
	function modul($p1,$p2){
		if($this->auth){
			$this->smarty->assign("main", $p1);
			$this->smarty->assign("mod", $p2);
			$temp='template/'.$p2.'.html';
			if(!file_exists($this->config->item('appl').APPPATH.'views/'.$temp)){$this->smarty->display('konstruksi.html');}
			else{$this->smarty->display($temp);}
			
		}
	}
	
	function get_form($p1,$p2){
			//echo $_SERVER['DOCUMENT_ROOT'];
			$sts_crud=$this->input->post('editstatus');
			$this->smarty->assign("sts_crud", $sts_crud);
			switch($p1){
				case "product":
					$type=$data=$this->mbackend->getdata('cl_product_type','combo');
					$this->smarty->assign("type", $type);
					$this->smarty->assign("acak_ind", md5(date('YmdHis').'ind') );
					$this->smarty->assign("acak_en", md5(date('YmdHis').'en') );
					
					if($sts_crud=='edit'){
						$data_foto = $this->mbackend->getdata('tbl_product_foto','edit',$this->input->post('id'));
						$this->smarty->assign("data_foto", $data_foto);
					}
				break;
				case "lokasi":
					$kota=$data=$this->mbackend->getdata('cl_kota','combo');
					$this->smarty->assign("kota", $kota);
				break;
				case "berita":
					$this->smarty->assign("acak_ind", md5(date('YmdHis').'ind') );
					$this->smarty->assign("acak_en", md5(date('YmdHis').'en') );
					
					if($sts_crud=='edit'){
						$data=$this->mbackend->getdata('tbl_'.$p1,'edit',$this->input->post('id'));
						$this->smarty->assign("data", $data);
					}
				break;
				case "tutorial":
					$this->smarty->assign("acak_ind", md5(date('YmdHis').'ind') );
					$this->smarty->assign("acak_en", md5(date('YmdHis').'en') );
					
					if($sts_crud=='edit'){
						$data=$this->mbackend->getdata('tbl_'.$p1,'edit',$this->input->post('id'));
						$this->smarty->assign("data", $data);
					}
				break;
				case "services":
					$this->smarty->assign("acak_ind", md5(date('YmdHis').'ind') );
					$this->smarty->assign("acak_en", md5(date('YmdHis').'en') );

					if($sts_crud=='edit'){
						$data_foto = $this->mbackend->getdata('tbl_services_foto','edit',$this->input->post('id'));
						$this->smarty->assign("data_foto", $data_foto);
					}
				break;
				case "gallery":
					$lokasi = $data=$this->mbackend->getdata('cl_lokasi','combo');
					$this->smarty->assign("lokasi", $lokasi);
				break;
				case "testimony":
					$this->smarty->assign("acak_ind", md5(date('YmdHis').'ind') );
					$this->smarty->assign("acak_en", md5(date('YmdHis').'en') );

					if($sts_crud=='edit'){
						$data = $this->mbackend->getdata('tbl_testimony','edit',$this->input->post('id'));
						$this->smarty->assign("data", $data);
					}
				break;
			}
			
			
			if($sts_crud=='edit'){
				$data=$this->mbackend->getdata('tbl_'.$p1,'edit',$this->input->post('id'));
				$this->smarty->assign("data", $data);
			}
			$this->smarty->assign("main", $p1);
			$this->smarty->assign("mod", $p2);
			$temp=$p1.'/'.$p2.'.html';
			if(!file_exists($this->config->item('appl').APPPATH.'views/'.$temp)){$this->smarty->display('konstruksi.html');}
			else{$this->smarty->display($temp);}
		
	}
	
	function getdata($p1){
		echo $this->mbackend->getdata($p1);
	}
	
	function simpan_data($p1){
		$post = array();
		
        foreach($_POST as $k=>$v){
			if($this->input->post($k)!=""){
				//$post[$k] = $this->db->escape_str($this->input->post($k));
				$post[$k] = $this->input->post($k);
			}
			
		}
		
		if(isset($post['upload_na'])){
			if(isset($post['upload_na']))unset($post['upload_na']);
			if(isset($post['modul_detil']))unset($post['modul_detil']);
			$id_header=$this->mbackend->simpan_data($p1, $post,'get_id');
			
			unset($_FILES['file_icon_foto_services']);
			unset($_FILES['file_icon_foto_product']);
			
			echo $this->upload($this->input->post('modul_detil'), $id_header, $post);
		}else{
			echo $this->mbackend->simpan_data($p1, $post);
		}
	}
	
	function upload($modul, $id_header, $postnya=""){
		$upload=new lib();
		//print_r ($upload->uploadmultiplenong('__repository/product/'));exit;
		$path='__repository/'.$this->input->post('upload_na').'/';
		$file_name=$upload->uploadmultiplenong($path);
		$sts=1;
		if(count($file_name)>0){
			foreach($file_name as $x){
				switch($modul){
					case "tbl_product_foto":
						$post=array('tbl_product_id'=>$id_header,
									'file_foto'=>$x,
									'flag'=>1
						);
						if($this->input->post('sts_crud')=='edit'){
							$path='__repository/product/';
							//$this->mbackend->hapus_foto('tbl_product_foto',$path,'tbl_product_id',$id_header,'file_foto');
							unset($_POST['sts_crud']);
							$_POST['sts_crud']='add';
						}
					break;
					case "tbl_services_foto":
						$post=array('tbl_services_id'=>$id_header,
									'file_foto'=>$x,
									'flag'=>1
						);
						if($this->input->post('sts_crud')=='edit'){
							$path='__repository/services/';
							//echo $id_header;exit;
							//$this->mbackend->hapus_foto('tbl_services_foto',$path,'tbl_services_id',$id_header,'file_foto');
							unset($_POST['sts_crud']);
							$_POST['sts_crud']='add';
						}
					break;
					case "tbl_gallery":
						$post = array(
							'cl_lokasi_id' => $postnya['cl_lokasi_id'],
							'file_foto'=> $x,
							'flag'=>1
						);
					break;
					case "tbl_banner":
						$post = array(
							'file_banner'=> $x,
							'status'=>1
						);
					break;
				}
				
				if($this->mbackend->simpan_data($modul, $post)){
					$sts = 1;
				}
			}
		}
		return $sts;
	}
	
	function hapusfoto_detail($type, $p1="", $p2=""){
		$html = "";
		switch($type){
			case "produk":
				$path = '__repository/product/';
				$id = $this->input->post('id');
				$nama_file = $this->input->post('nama_file');
				$id_header = $this->input->post('id_header');
				
				$delete = $this->db->delete('tbl_product_foto', array('id'=>$id) );
				if($delete){
					unlink($path.$nama_file);
				}
				
				$data_gambar = $this->db->get_where('tbl_product_foto', array('tbl_product_id'=>$id_header) )->result_array();
				foreach($data_gambar as $k=>$v){
					$html .= "
						<a href='#' onClick=\"kumpulAction('hapus_produk', '".$v['id']."', '".$v['file_foto']."', '".$id_header."' );\" title='Hapus Foto'>X</a>
						<img src='".$this->host."__repository/product/".$v['file_foto']."' width='100px' height='150px'>  &nbsp;&nbsp;&nbsp;&nbsp;
					";
				}
			break;
			case "service":
				$path = '__repository/services/';
				$id = $this->input->post('id');
				$nama_file = $this->input->post('nama_file');
				$id_header = $this->input->post('id_header');
				
				$delete = $this->db->delete('tbl_services_foto', array('id'=>$id) );
				if($delete){
					unlink($path.$nama_file);
				}
				
				$data_gambar = $this->db->get_where('tbl_services_foto', array('tbl_services_id'=>$id_header) )->result_array();
				foreach($data_gambar as $k=>$v){
					$html .= "
						<a href='#' onClick=\"kumpulAction('hapus_service', '".$v['id']."', '".$v['file_foto']."', '".$id_header."' );\" title='Hapus Foto'>X</a>
						<img src='".$this->host."__repository/services/".$v['file_foto']."' width='100px' height='150px'>  &nbsp;&nbsp;&nbsp;&nbsp;
					";
				}
			break;
		}
		
		echo $html;
	}
	
	function kirimemailbro(){
		//$email = "triwahyunugroho11@gmail.com";
		//$pesan = "Promo Akhir Tahun";
		$data = array(
			'nama' => 'jenong',
			'id_member' => 'XX24',
			'cl_product_type' => '1',
			'cl_lokasi_id' => '1',
			'phone' => '0890909090',
			'email' => 'jenong@gmail.com',
			'tanggal' => '2016-09-01',
			'request' => 'jenong',
		);
		
		$emailnya = $this->db->get_where('cl_lokasi', array('id'=>$data['cl_lokasi_id']) )->row_array();
		$services = $this->db->get_where('tbl_services', array('id'=>$data['cl_product_type']) )->row_array();
		
		//echo "<pre>";
		//print_r($emailnya);
		//echo $emailnya['lokasi'];
		
		//date_parse_from_format('d-m-Y', strtotime($p2['email']) )
		//exit;
		
		$this->lib->kirimemail('email_reservasi', $emailnya['email'], $emailnya['lokasi'], $data, $services['nama_service_ind']);
	}
	
}
