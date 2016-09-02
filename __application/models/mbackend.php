<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class mbackend extends CI_Model{
	function __construct(){
		parent::__construct();
		//$this->auth = unserialize(base64_decode($this->session->userdata('sipbbg-k3pr1')));
	}
	
	function getdata($type="", $p1="", $p2=""){
		$where = " WHERE 1=1 ";
		switch($type){
			case "tbl_berita":
				$sql = " SELECT * FROM tbl_berita";
				if($p1=='edit'){
					$sql .=" WHERE id=".$p2;
					return $this->result_query($sql,'row_array');
				}
			break;
			case "tbl_tutorial":
				$sql = " SELECT * FROM tbl_tutorial";
				if($p1=='edit'){
					$sql .=" WHERE id=".$p2;
					return $this->result_query($sql,'row_array');
				}
			break;
			case "tbl_newslatter":
				$sql = " SELECT * FROM tbl_newslatter";
				/*if($p1=='edit'){
					$sql .=" WHERE id=".$p2;
					return $this->result_query($sql,'row_array');
				}*/
			break;
			case "tbl_reservasi":
				$sql = " SELECT A.*,D.kota,B.lokasi,C.product_type FROM tbl_reservasi A
						LEFT JOIN cl_lokasi B ON A.cl_lokasi_id=B.id
						LEFT JOIN cl_product_type C ON A.cl_product_type=C.id
						LEFT JOIN cl_kota D ON B.cl_kota_id=D.id";
				if($p1=='edit'){
					$sql .=" WHERE id=".$p2;
					return $this->result_query($sql,'row_array');
				}
			break;
			case "tbl_product":
				$sql = " SELECT A.*,B.product_type FROM tbl_product A 
						LEFT JOIN cl_product_type B ON A.cl_product_type_id=B.id";
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
			break;
			case "tbl_gallery":
				$sql = " 
					SELECT A.*, B.lokasi 
					FROM tbl_gallery A 
					LEFT JOIN cl_lokasi B ON B.id = A.cl_lokasi_id
				";
				
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
			break;
			case "tbl_testimony":
				$sql = " SELECT * FROM tbl_testimony";
				if($p1=='edit'){
					$sql .=" WHERE id=".$p2;
					return $this->result_query($sql,'row_array');
				}
			break;			
			case "tbl_banner":
				$sql = " 
					SELECT A.*
					FROM tbl_banner A 
				";
				
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
			break;
			
			
			case "cl_kota":
			case "tbl_kota":
				$sql = " 
					SELECT A.*
					FROM cl_kota A
				";
				
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
				if($p1=='combo'){
					return $this->db->query($sql)->result_array();
				}
			break;
			case "cl_lokasi":
			case "tbl_lokasi":
				$sql = " 
					SELECT A.*,B.kota
					FROM cl_lokasi A LEFT JOIN cl_kota B ON A.cl_kota_id=B.id
				";
				
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
				if($p1=='combo'){
					return $this->db->query($sql)->result_array();
				}
			break;
			case "cl_product_type":
			case "tbl_product_type":
				$sql = " 
					SELECT A.*
					FROM cl_product_type A
				";
				
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
				if($p1=='combo'){
					return $this->db->query($sql)->result_array();
				}
			break;
			case "tbl_user":
				$sql = " 
					SELECT A.*
					FROM tbl_user A
				";
				
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
			break;
			case "tbl_services":
				$sql = " SELECT A.* FROM tbl_services A ";
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
			break;
			case "tbl_services_foto":
				$sql = " SELECT A.* FROM tbl_services_foto A ";
				$sql .=" WHERE A.tbl_services_id = ".$p2;
				
				return $this->result_query($sql);
			break;
			case "tbl_product_foto":
				$sql = " SELECT A.* FROM tbl_product_foto A ";
				$sql .=" WHERE A.tbl_product_id = ".$p2;
				
				return $this->result_query($sql);
			break;

			/*
			case "tbl_product_foto":
				$sql = " SELECT A.*
						FROM tbl_product_foto A 
						LEFT JOIN tbl_product B ON A.tbl_product_id=B.id ";
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
				if($p1=='get'){
					$sql .=" WHERE A.tbl_product_id=".$p2;
					return $this->result_query($sql);
				}
			break;
			case "tbl_services_foto":
				$sql = " SELECT A.*
						FROM tbl_services_foto A 
						LEFT JOIN tbl_services B ON A.tbl_services_id=B.id ";
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
				if($p1=='get'){
					$sql .=" WHERE A.tbl_services_id=".$p2;
					return $this->result_query($sql);
				}
			break;
			*/
			
			case "tbl_kota":
				$sql = "SELECT A.* FROM cl_kota A ";
				//echo $sql;
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
					return $this->result_query($sql,'row_array');
				}
				if($p1=='combo'){
					return $this->db->query($sql)->result_array();
				}
			break;
			
		}
		return $this->result_query($sql,'json');
	}
	
	function result_query($sql,$type=""){
		switch($type){
			case "json":
				$page = (integer) (($this->input->post('page')) ? $this->input->post('page') : "1");
				$limit = (integer) (($this->input->post('rows')) ? $this->input->post('rows') : "10");
				$count = $this->db->query($sql)->num_rows();
				
				if( $count >0 ) { $total_pages = ceil($count/$limit); } else { $total_pages = 0; } 
				if ($page > $total_pages) $page=$total_pages; 
				$start = $limit*$page - $limit; // do not put $limit*($page - 1)
				if($start<0) $start=0;
				  
				$sql = $sql . " LIMIT $start,$limit";
			
				$data=$this->db->query($sql)->result_array();  
						
				if($data){
				   $responce = new stdClass();
				   $responce->rows= $data;
				   $responce->total =$count;
				   return json_encode($responce);
				}else{ 
				   $responce = new stdClass();
				   $responce->rows = 0;
				   $responce->total = 0;
				   return json_encode($responce);
				} 
			break;
			case "row_obj":return $this->db->query($sql)->row();break;
			case "row_array":return $this->db->query($sql)->row_array();break;
			default:return $this->db->query($sql)->result_array();break;
		}
	}
	// GOYZ CROTZZZ
	function simpan_data($table,$data,$get_id=""){//$sts_crud --> STATUS NYEE INSERT, UPDATE, DELETE
		$this->db->trans_begin();
		$id=$this->input->post('id');
		$sts_crud=$this->input->post('sts_crud');
		unset($data['sts_crud']);
		//print_r($_POST);exit;
		switch ($table){
			case "tbl_user":
				$this->load->library('encrypt');
				if(isset($data['status'])){unset($data['status']);$data['status']=1;}
				if(isset($data['password'])){
					if($data['password']!=''){
						unset($data['password']);
						$pass=$this->encrypt->encode($this->input->post('password'));
						$data['password']=$pass;
					}
				}
				
				
			break;
			case "cl_product_type":
			case "tbl_product_type":
				$table="cl_product_type";
				$data['create_date']=date('Y-m-d H:i:s');
				$data['create_by']=$this->auth['nama_user'];
			break;
			case "cl_kota":
			case "tbl_kota":
				$table="cl_kota";
				$data['create_date']=date('Y-m-d H:i:s');
				$data['create_by']=$this->auth['nama_user'];
			break;
			case "cl_lokasi":
			case "tbl_lokasi":
				$table="cl_lokasi";
				$data['create_date']=date('Y-m-d H:i:s');
				$data['create_by']=$this->auth['nama_user'];
			break;
			case "tbl_product":
				$path='__repository/product/';
				$data['create_date']=date('Y-m-d H:i:s');
				$data['create_by']=$this->auth['nama_user'];
				if($sts_crud=='delete'){
					$this->hapus_foto('tbl_product_foto',$path,'tbl_product_id',$id,'file_foto');
					$foto = $this->db->get_where('tbl_product', array('id'=>$id) )->row_array();
					if($foto['foto_icon'] != ""){
						$this->hapus_foto_satu($path.$foto['foto_icon']);
					}
				}
				
				if(!empty($_FILES['file_icon_foto_product']['name'])){
					if($sts_crud == 'edit'){
						if($data['foto_lama'] != ""){
							$this->hapus_foto_satu($path.$data['foto_lama']);
						}
					}
					
					$nm = str_replace(' ', '', $data['nama_product_ind']);
					$file = date('YmdHis')."_".$nm;
					$filename =  $this->lib->uploadnong($path, 'file_icon_foto_product', $file); //$file.'.'.$extension;
					$data['foto_icon'] = $filename;
				}else{
					if($sts_crud == 'edit'){
						if(isset($data['foto_lama'])){
							$data['foto_icon'] = $data['foto_lama'];
						}else{
							$data['foto_icon'] = null;
						}
					}elseif($sts_crud == 'add'){
						$data['foto_icon'] = null;
					}
					
				}
				
				unset($data['foto_lama']);
			break;
			case "tbl_services":
				$path='__repository/services/';
				$data['create_date']=date('Y-m-d H:i:s');
				$data['create_by']=$this->auth['nama_user'];
				if($sts_crud=='delete'){
					$this->hapus_foto('tbl_services_foto',$path,'tbl_services_id',$id,'file_foto');
					$foto = $this->db->get_where('tbl_services', array('id'=>$id) )->row_array();
					if($foto['foto_icon'] != ""){
						$this->hapus_foto_satu($path.$foto['foto_icon']);
					}
				}
				
				if(!empty($_FILES['file_icon_foto_services']['name'])){
					if($sts_crud == 'edit'){
						if($data['foto_lama'] != ""){
							$this->hapus_foto_satu($path.$data['foto_lama']);
						}
					}
					$nm = str_replace(' ', '', $data['nama_service_ind']);
					$file = date('YmdHis')."_".$nm;
					$filename =  $this->lib->uploadnong($path, 'file_icon_foto_services', $file); //$file.'.'.$extension;
					$data['foto_icon'] = $filename;
				}else{
					if($sts_crud == 'edit'){
						if(isset($data['foto_lama'])){
							$data['foto_icon'] = $data['foto_lama'];
						}else{
							$data['foto_icon'] = null;
						}
					}elseif($sts_crud == 'add'){
						$data['foto_icon'] = null;
					}
					
				}
				
				unset($data['foto_lama']);
			break;
			case "tbl_berita":
				$path = '__repository/berita/';
				$this->lib->makedir($path);
				
				$data['create_date']=date('Y-m-d H:i:s');
				$data['create_by']=$this->auth['nama_user'];
				if($sts_crud=='delete'){
					$foto = $this->db->get_where('tbl_berita', array('id'=>$id) )->row_array();
					if($foto['file_foto'] != ""){
						$this->hapus_foto_satu($path.$foto['file_foto']);
					}
				}
				
				if(!empty($_FILES['file_foto_berita']['name'])){
					if($sts_crud == 'edit'){
						if($data['foto_lama'] != ""){
							$this->hapus_foto_satu($path.$data['foto_lama']);
						}
					}
					
					$file = date('YmdHis')."_news";
					$filename =  $this->lib->uploadnong($path, 'file_foto_berita', $file); //$file.'.'.$extension;
					$data['file_foto'] = $filename;
				}else{
					if($sts_crud == 'edit'){
						if(isset($data['foto_lama'])){
							$data['file_foto'] = $data['foto_lama'];
						}else{
							$data['file_foto'] = null;
						}
					}elseif($sts_crud == 'add'){
						$data['file_foto'] = null;
					}
				}
				
				
				if($sts_crud == 'add'){
					$newsletter = $this->db->get('tbl_newslatter')->result_array();
					foreach($newsletter as $k => $v){ 
						$this->lib->kirimemail('email_news', $v['email'], $data['judul_ind'], $data['isi_berita_ind']);
						$this->lib->kirimemail('email_news', 'subscribe@rogersalon.com', $data['judul_ind'], $data['isi_berita_ind']);
					}
				}
				
				
				unset($data['foto_lama']);
			break;
			case "tbl_gallery_header":
				return 1;
				exit;
			break;
			case "tbl_gallery":
				$path = '__repository/gallery/';
				if($sts_crud=='delete'){
					$foto = $this->db->get_where('tbl_gallery', array('id'=>$id) )->row_array();
					if($foto['file_foto'] != ""){
						$this->hapus_foto_satu($path.$foto['file_foto']);
					}
				}
			break;
			case "tbl_banner_header":
				return 1;
				exit;
			break;
			case "tbl_banner":
				$path = '__repository/banner/';
				$this->lib->makedir($path);
				
				if($sts_crud=='delete'){
					$foto = $this->db->get_where('tbl_banner', array('id'=>$id) )->row_array();
					if($foto['file_banner'] != ""){
						$this->hapus_foto_satu($path.$foto['file_banner']);
					}
				}
				
				$data['create_date']=date('Y-m-d H:i:s');
				$data['create_by']=$this->auth['nama_user'];
			break;
			case "tbl_banner_confirm":
				$table = 'tbl_banner';
				$sts_crud = 'edit';
				
				if($data['confirm'] == 'ok'){
					$data['status'] = 1;
				}elseif($data['confirm'] == 'notok'){
					$data['status'] = 0;
				}
				
				unset($data['confirm']);
			break;
			
			case "tbl_testimony":
				$path = '__repository/testimony/';
				$this->lib->makedir($path);
				
				if($sts_crud=='delete'){
					$foto = $this->db->get_where('tbl_testimony', array('id'=>$id) )->row_array();
					if($foto['file_foto'] != ""){
						$this->hapus_foto_satu($path.$foto['file_foto']);
					}
				}
				
				if(!empty($_FILES['file_foto_testimony']['name'])){
					if($sts_crud == 'edit'){
						if($data['foto_lama'] != ""){
							$this->hapus_foto_satu($path.$data['foto_lama']);
						}
					}
					
					$file = date('YmdHis')."_".$data['nama'];
					$filename =  $this->lib->uploadnong($path, 'file_foto_testimony', $file); //$file.'.'.$extension;
					$data['file_foto'] = $filename;
				}else{
					if($sts_crud == 'edit'){
						if(isset($data['foto_lama'])){
							$data['file_foto'] = $data['foto_lama'];
						}else{
							$data['file_foto'] = null;
						}
					}elseif($sts_crud == 'add'){
						$data['file_foto'] = null;
					}
				}
				
				$data['create_date']=date('Y-m-d H:i:s');
				$data['create_by']=$this->auth['nama_user'];
				unset($data['foto_lama']);
			break;
			
			case "tbl_reservasi_frontend":
				$table = 'tbl_reservasi';
				$data['create_date'] = date('Y-m-d H:i:s');
				
				$emailnya = $this->db->get_where('cl_lokasi', array('id'=>$data['cl_lokasi_id']) )->row_array();
				$services = $this->db->get_where('tbl_services', array('id'=>$data['cl_product_type']) )->row_array();
				
				$this->lib->kirimemail('email_reservasi', $emailnya['email'], $emailnya['lokasi'], $data, $services['nama_service_ind']);
				$this->lib->kirimemail('email_reservasi', $data['email'], $emailnya['lokasi'], $data, $services['nama_service_ind']);
			break;
			case "tbl_reservasi_confirm":
				$table = 'tbl_reservasi';
				$sts_crud = 'edit';
				
				if($data['confirm'] == 'ok'){
					$data['flag'] = 1;
				}elseif($data['confirm'] == 'notok'){
					$data['flag'] = 0;
				}
				
				unset($data['confirm']);
			break;
			
			case "newsletter_frontend":
				$table = 'tbl_newslatter';
				$sts_crud = 'add';
				
				$data['create_date'] = date('Y-m-d H:i:s');
				$data['create_by'] = "User Online";
				$data['email'] = $data['valnya'];
				
				unset($data['valnya']);
			break;
			case "tbl_tutorial":
				$table = 'tbl_tutorial';
				//$sts_crud = 'add';
				
				$data['create_date'] = date('Y-m-d H:i:s');
				$data['create_by'] = "User Online";
			//	$data['email'] = $data['valnya'];
				
				//unset($data['valnya']);
			break;
			
		}
		//print_r($data);exit;
		switch ($sts_crud){
			case "add":
				$this->db->insert($table,$data);
				$id=$this->db->insert_id();
			break;
			case "edit":
				$this->db->where('id',$id);
				$this->db->update($table,$data);
			break;
			case "delete":
				//unset($data);
				$this->db->where('id',$id);
				$this->db->delete($table);
			break;
		}
		//echo $this->db->last_query();exit;
		
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return 0;
		} else{
			if($get_id=='get_id'){
				$this->db->trans_commit();
				return $id;
			}else{
				return $this->db->trans_commit();
			}
		}
		
	}
	
	
	function konversi_bulan($bln){
		switch($bln){
			case 1:$bulan='Januari';break;
			case 2:$bulan='Februari';break;
			case 3:$bulan='Maret';break;
			case 4:$bulan='April';break;
			case 5:$bulan='Mei';break;
			case 6:$bulan='Juni';break;
			case 7:$bulan='Juli';break;
			case 8:$bulan='Agustus';break;
			case 9:$bulan='September';break;
			case 10:$bulan='Oktober';break;
			case 11:$bulan='November';break;
			case 12:$bulan='Desember';break;
		}
		return $bulan;
	}
	
	function hapus_foto($tabel,$path,$field_id_header,$id_header,$field_foto_db){
		/*switch($table){
			case "tbl_product_foto":
			
			break;
		}*/
		$ex_foto=$this->mbackend->getdata($tabel,'get',$id_header);
		foreach($ex_foto as $v){
			if(file_exists($path.$v[$field_foto_db])){
				chmod($path.$v[$field_foto_db],0777);
				unlink($path.$v[$field_foto_db]);
			}
		}
		$this->db->where($field_id_header,$id_header);
		$this->db->delete($tabel);
	}
	
	function hapus_foto_satu($path, $filename=""){
		//chmod($path, 0777);
		unlink($path);
	}
	
	// END GOYZ CROTZZZ
	
}