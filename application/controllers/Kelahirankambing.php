<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelahirankambing extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_user','M_kambing','M_farm','M_propinsi','M_kabupaten','M_kecamatan','M_asal','M_susu','M_pertumbuhan','M_ib','M_pemeriksaankesehatan']);
		$this->session->set_userdata('menu','identifikasi');
		$this->session->set_userdata('submenu','kelahirankambing');
		// belum_login();
	}
	public function index()
	{
		 
		$data['judul']="Data Kambing";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$data['halaman']='index';
		
		$user = $this->utility->user_login();
		$data['user'] = $user;
		$id_user=$user->user_id;
	
		
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('kelahirankambing/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('kelahirankambing/footer',$data);
		
	}
	public function pilihbulan()
	{
		$bulan=$this->input->post('bulan'); 
		$this->session->set_userdata('bulan',$bulan);
	}
	public function pilihtanggal()
	{
		$tanggal=$this->input->post('tanggal'); 
		$tgl=explode("-",$tanggal);
		$tahun= $tgl[0];
		$bulan= $tgl[1];
		$this->session->set_userdata('tanggal',$tanggal);
		$this->session->set_userdata('bulan',$bulan);
		$this->session->set_userdata('tahun',$tahun);
	}
	public function pilihchktanggal()
	{
		$chktanggal=$this->input->post('chktanggal'); 
		
		$this->session->set_userdata('chktanggal',$chktanggal);
		if($chktanggal=="false")
			$this->session->set_userdata('tanggal',"");
		else{
			$this->session->set_userdata('tanggal',date('Y-m-d'));
			$this->session->set_userdata('bulan',date('m'));
			$this->session->set_userdata('tahun',date('Y'));
		}
		
	}
	public function pilihtahun()
	{
		$tahun=$this->input->post('tahun'); 
		$this->session->set_userdata('tahun',$tahun);
	}
	public function pilihlaktasi()
	{
		$xlaktasi=$this->input->post('xlaktasi'); 
		$this->session->set_userdata('xlaktasi',$xlaktasi);
	}
	public function gettetua($jenis,$idkambing)
	{
		$data=$this->M_kambing->getInduk($idkambing)->result(); 
		echo json_encode($data);
	}
	 
	public function detail($idkambing)
	{
		$this->session->set_userdata('iddetailaktif',$idkambing);
		$data['idkambing']=$idkambing;
		$data['tagkambing']=$this->M_kambing->getTagkambing($idkambing);
		$data['kambing']=$this->M_kambing->get($idkambing)->row();
		$data['dataTetua']=$this->M_kambing->getInduk($idkambing);
		
		$data['pertumbuhan']=$this->M_pertumbuhan->getByIDkambing($idkambing);
		$data['kesehatan']=$this->M_pemeriksaankesehatan->getByIDkambing($idkambing);
		$data['reproduksi']=$this->M_ib->getByIDkambing($idkambing);
		$data['produksi']=$this->M_susu->getDataProduksikambing($idkambing);
		$data['produksi1']=$this->M_susu->getProduksiPerLaktasiByIDkambing($idkambing);
	 
		$data['halaman']='detail';
		$data['judul']="Detail Data Kambing";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('kelahirankambing/tabledetail',$data);
		$this->load->view('layout/footer');
		$this->load->view('kelahirankambing/footerdetail',$data);
		
	}

	public function ajax_tabel()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_kambing->get_data_json();
		}
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_kambing->get_json();
		}
	}
	function get_data_bytagkambing(){
		$tagkambing=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_kambing->get_data_bytagkambing($tagkambing);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->idkambing,
				"data"=>$row->tagkambing,
				"description"=>$row->nomorregister
			);
		}
		echo json_encode($arr);
	}
	function get_data_bykode(){
		$tagkambing=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_kambing->get_data_bykode($tagkambing);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->idkambing,
				"data"=>$row->tagkambing,
				"description"=>$row->namakambing,
				"nomorregister"=>$row->nomorregister
			);
		}
		echo json_encode($arr);
	}
	function get_data_bynama(){
		$namakambing=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_kambing->get_data_bynama($namakambing);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->idkambing,
				"data"=>$row->tagkambing,
				"description"=>$row->namakambing,
				"nomorregister"=>$row->nomorregister
			);
		}
		echo json_encode($arr);
	}
	
	function get_data_bytagkambingequal(){
		$tagkambing=$this->input->post('tagkambing');
		
		if($tagkambing!=""){
			$query=$this->M_kambing->get_data_bytagkambingequal($tagkambing);
			$arr=array();
			foreach($query->result() as $row){
				$arr[]=array(
					"id"=>$row->idkambing,
					"data"=>$row->tagkambing,
					"description"=>$row->nomorregister
				);
			}
			echo json_encode($arr);	
		}else{
			echo null;
		}
		
	}
	function get_numdata_bytagkambing(){
		$tagkambing=$this->input->post('tagkambing');
		$n=$this->M_kambing->get_numdata_bytagkambing($tagkambing);
		echo $n;
	}

	public function get_auto_bytagkambing()
    {
        if (isset($_GET['term'])) {
            $result = $this->M_kambing->search_data_bytagkambing($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = [ 'label' => $row->tagkambing,'kode' => $row->idkambing,'nomorregister' => $row->nomorregister ];
                echo json_encode($arr_result);
            }
        }
	}
	public function isfarm($str)
	{
		$rs=$this->M_farm->get($str);	
		return ($rs->num_rows() > 0);
	}
	public function save()
    {
        $this->form_validation->set_rules('eartag','Ear Tag','required|trim',['required' => '%s harus diisi']);
		$this->form_validation->set_rules('tgllahir','Tanggal Lahir','required|trim',['required' => '%s belum diisi']);
		
		if($this->form_validation->run() == false){
			$data['halaman']='add';
			
			$data['judul'] = "Tambah Data Farm/kambing";
			$this->load->view('layoutkelahirankambing/header');
			$this->load->view('layoutkelahirankambing/navbar',$data);
			$this->load->view('layoutkelahirankambing/main_sidebar' ); 
			$this->load->view('kelahirankambing/form_tambah',$data);
			$this->load->view('layoutkelahirankambing/footer');
			$this->load->view('kelahirankambing/footer',$data);
		}else{
			$this->M_kambing->save();
			$this->session->set_flashdata('status_insert','success');
			redirect('/kambing');
		}

    }
    public function add()
    {
		$user = $this->utility->user_login();
		$data['user']=$user;
		$id_user=$user->user_id;
		
		$data['halaman']='add';
		

        $data['judul'] = "Tambah Data Farm/kambing";
		$this->load->view('layoutkelahirankambing/header');
		$this->load->view('layoutkelahirankambing/navbar',$data);
		$this->load->view('layoutkelahirankambing/main_sidebar' ); 
		$this->load->view('kelahirankambing/form_tambah',$data);
		$this->load->view('layoutkelahirankambing/footer');
		$this->load->view('kelahirankambing/footer',$data);

    }
    public function edit()
    {
        $id = $this->input->post('id');
		
		$rs= $this->M_kambing->get($id);
		
		$data['rs'] = $rs;
        $user = $this->utility->user_login();
		$data['user']=$user;
		$id_user=$user->user_id;
	 
		
        $data['judul'] = "Edit Data Kambing";
		$this->load->view('layoutkelahirankambing/header');
		$this->load->view('layoutkelahirankambing/navbar',$data);
		$this->load->view('layoutkelahirankambing/main_sidebar' ); 
		$this->load->view('kelahirankambing/form_edit',$data);
		$this->load->view('layoutkelahirankambing/footer');
		$this->load->view('kelahirankambing/footer',$data);
    }
   
    public function update()
    {
		$this->M_kambing->update(); 
		// echo $this->db->last_query();
		$this->session->set_flashdata('status_update','success');
        redirect('/kambing');
	}
	
    public function hapus()
    {
		if($this->input->post('alasan')=='0'){
			$this->M_kambing->delete();
			$this->session->set_flashdata('status_delete','success');
		}else
		{
			$alasan=$this->input->post('alasan');
			$this->M_kambing->setmati($alasan);
			$this->session->set_flashdata('status_delete','success');
		}
		redirect('/kambing');
    }
	
	function pilihkelamin(){
		$kelamin=$this->input->post('kelamin');
		$this->session->set_userdata('kelamin',$kelamin); 
	}	 

	function pilihstatus(){
		$status=$this->input->post('status');
		$this->session->set_userdata('status',$status); 
	}	 
	
	function upload(){
		if(isset($_POST) == true){ 
			//menghasilkan nama file yang unik, akan ada angka acak didepannya
			 $namaFile = $this->session->userdata('iddetailaktif').".jpg"; //time().'_'.basename($_FILES["file"]["name"]);
			$tmp_name=$_FILES["file"]["tmp_name"];
			$size=$_FILES["file"]["size"];
			if (($size > 1024 * 1024)||($size==0))
			{
				imagejpeg(imagecreatefromjpeg($tmp_name),$tmp_name,75);
			}
			
			//folder upload
			
			$targetDir = "assets/images/upload/foto/kelahirankambing/";
			$targetFilePath = $targetDir . $namaFile;
			
			//membolehkan ekstensiOk file tertentu
			$ekstensiFile = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			$ekstensiOk = array('jpg','png','jpeg','gif');
			
			if(in_array(strtolower($ekstensiFile), $ekstensiOk)){
				//upload file ke server
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
					//memasukkan file data ke dalam database jika diperlukan
					//........
					$respon['status'] = 'ok|'.$namaFile;
				}else{
					$respon['status'] = 'err';
				}
			}else{
				$respon['status'] = 'type_err';
			}
			
			//menampilkan data respon dalam format JSON
			echo json_encode($respon);
		}
	}
	function settanggalsertifikat(){
		$idkambing=$this->input->post('idkambing');
		$tanggal=$this->input->post('tanggal');
		$sql="UPDATE kambing set tglsertifikat='$tanggal' WHERE idkambing='$idkambing'";
		$this->db->query($sql); 
	}
	function cetaksertifikat(){
		$data['idkambing']=$this->uri->segment(4);
		$this->load->view("kelahirankambing/sertifikat",$data);
	}
	function cetaksertifikatlspro(){
		$data['idkambing']=$this->uri->segment(4);
		$this->load->view("kelahirankambing/sertifikatlspro",$data);
	}

	function upload_excel(){
		if(isset($_POST) == true){ 
			//menghasilkan nama file yang unik, akan ada angka acak didepannya
			 $namaFile = time().'_'.basename($_FILES["file"]["name"]);
			 $this->session->set_flashdata('namafile',$namaFile);
			$tmp_name=$_FILES["file"]["tmp_name"];
			$size=$_FILES["file"]["size"];
			if (($size > 1024 * 1024)||($size==0))
			{
				imagejpeg(imagecreatefromjpeg($tmp_name),$tmp_name,75);
			}
			
			//folder upload
			
			$targetDir = "assets/files/upload/kelahirankambing/";
			$targetFilePath = $targetDir . $namaFile;
			
			//membolehkan ekstensiOk file tertentu
			$ekstensiFile = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			$ekstensiOk = array('xls','csv');
			
			if(in_array(strtolower($ekstensiFile), $ekstensiOk)){
				//upload file ke server
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
					//memasukkan file data ke dalam database jika diperlukan
					//........
					$respon['status'] = 'ok|'.$namaFile;
				}else{
					$respon['status'] = 'err';
				}
			}else{
				$respon['status'] = 'type_err';
			}
			
			//menampilkan data respon dalam format JSON
			echo json_encode($respon);
		}
	}	 
	function import()
	{
		$user = $this->utility->user_login();
		$data['user'] = $user;
		$id_user=$user->user_id;
		
		$idfarm=$this->session->userdata('idfarm');
		$tanggalinput=date('Y-m-d');

		$filename=$this->input->post('filename');

		 // Load the spreadsheet reader library
			$this->load->library('excel_reader');

            $file =  $_SERVER['DOCUMENT_ROOT']."/assets/files/upload/kelahirankambing/".$filename ;

			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');
			
			
			$this->excel_reader->read($file);

			error_reporting(E_ALL ^ E_NOTICE);

			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
			$nError=0;$nSukses=0;$log="";
			
			for ($i = 2; $i <= $data['numRows']; $i++) {
				$status='hidup';
				$status_pc='';
				for ($j = 1; $j <= $data['numCols']; $j++) {				
					if($j=="1")
						$tagkambing = $data['cells'][$i][$j];
					if($j=="2")
						$kelamin = $data['cells'][$i][$j];
					if($j=="3")
						$tipekambing = $data['cells'][$i][$j];
					    
					if($j=="4")
                                        $namakambing = $data['cells'][$i][$j];
					if($j=="5")
                                        $tgllahir = $data['cells'][$i][$j];
					
					if($j=="6")
                                        $bobotlahir = $data['cells'][$i][$j];
					if($j=="7")
                                        $status = $data['cells'][$i][$j]; 
					if($j=="8")
                                        $is_uzur = $data['cells'][$i][$j];
					if($j=="9")
                                        $is_vbc = $data['cells'][$i][$j];
					if ($j=="10")
                                        $is_kso = $data['cells'][$i][$j];
					if ($j=="11")
                                        $is_balai = $data['cells'][$i][$j];
				}   
			
					$sql="SELECT idkambing,tagkambing FROM kambing WHERE tagkambing='$tagkambing' AND idfarm='$idfarm'";
					$rs=$this->db->query($sql);
					$row=$rs->row();
					$idkambing=$row->idkambing;
					
					$ada=($rs->num_rows>0);
					
					if($tgllahir=='')$tgllahir='00/00/0000';
					
					$tgl = explode('/',$tgllahir);
					
					$tanggal=str_pad($tgl[0],2,"0",STR_PAD_LEFT);
					$bulan=str_pad($tgl[1],2,"0",STR_PAD_LEFT);
					$tahun=$tgl[2];
					
					$tgllahir=$tahun."-".$bulan."-".$tanggal;
										
					if($ada)
						$sql="UPDATE kambing ";
					else
						$sql="INSERT INTO kambing ";
                    
					$sql .= " SET `idfarm` ='$idfarm',
						   `tagkambing`='$tagkambing',
						   `idbangsa`='1',
						   `kelamin`='$kelamin',
						   `tipekambing`='$tipekambing',
						   `namakambing`='$namakambing',
						   `tgllahir`=SUBDATE('$tgllahir',INTERVAL 1 day),
						   `bobotlahir`='$bobotlahir',
			  			   `status` ='$status',
					  	   `is_uzur`='$is_uzur',
						   `is_kso`='$is_kso',
  						   `is_balai`='$is_balai',
						   `is_vbc`='$is_vbc',
						   `tglinput`=CURRENT_DATE";
					//`statuspc`='$status_pc',
					if($ada){
						$sql.=" WHERE tagkambing='$tagkambing' AND idfarm='$idfarm'";
					}
					
					$this->db->query($sql);     
					
					if(!$ada){	
						if(checkdate($bulan,$tanggal,$tahun))
							$sql="SELECT count(*)+1 as n,date_format(SUBDATE('$tgllahir',INTERVAL 1 day),'%d%m%y') tgl FROM kambing WHERE idfarm LIKE '".substr($idfarm,0,3)."%"."' AND tgllahir=SUBDATE('$tgllahir',INTERVAL 1 day)";
						else
							$sql="SELECT count(*)+1 as n FROM kambing WHERE idfarm like '".substr($idfarm,0,3)."%"."' AND tgllahir='0000-00-00'";

						$rs=$this->db->query($sql);
						$row=$rs->row();
						if(checkdate($bulan,$tanggal,$tahun)){
							$n=str_pad($row->n,2,"0",STR_PAD_LEFT);
							$tgl=$row->tgl;
							$kodefikasi=substr($idfarm,0,3).$n.$tgl.($tipekambing=="IB");
						}else{
							$n=str_pad($row->n,8,"0",STR_PAD_LEFT);
							$kodefikasi=substr($idfarm,0,3).$n.($tipekambing=="IB");
						}	
						
						$sql="SELECT idkambing,tagkambing FROM kambing WHERE tagkambing='$tagkambing' AND idfarm='$idfarm'";
						$rs=$this->db->query($sql);
						$row=$rs->row();
						$idkambing=$row->idkambing;
					}else{			
						if(checkdate($bulan,$tanggal,$tahun))
							$sql="SELECT count(*)+1 as n,date_format(SUBDATE('$tgllahir',INTERVAL 1 day),'%d%m%y') tgl FROM kambing WHERE idfarm LIKE '".substr($idfarm,0,3)."%"."' AND tgllahir=SUBDATE('$tgllahir',INTERVAL 1 day) AND idkambing<>'$idkambing'";
						else
							$sql="SELECT count(*)+1 as n FROM kambing WHERE idfarm like '".substr($idfarm,0,3)."%"."' AND tgllahir='0000-00-00'  AND idkambing<>'$idkambing'";

						$rs=$this->db->query($sql);
						$row=$rs->row();
						if(checkdate($bulan,$tanggal,$tahun)){
							$n=str_pad($row->n,2,"0",STR_PAD_LEFT);
							$tgl=$row->tgl;
							$kodefikasi=substr($idfarm,0,3).$n.$tgl.($tipekambing=="IB");
						}else{
							$n=str_pad($row->n,8,"0",STR_PAD_LEFT);
							$kodefikasi=substr($idfarm,0,3).$n.($tipekambing=="IB");
						}
					}
					if($kodefikasi<>""){	
						$sql="REPLACE INTO register SET
							nomorregister='$kodefikasi'
							,idkambing='$idkambing'
							,tanggal=CURRENT_DATE
							,status='Aktif'";
						$this->db->query($sql);
						
					}	
					//if($rs){
						$nSukses++;
						$log .= "<font color='blue'>".$tagkambing." Sukses Diinputkan/Diupdate</font><br>";
				    //}else{$nError++;$log .= "<font color='red'>".$peternakan." Belum terregistrasi</font><br>";}
			}
            
			$this->session->set_flashdata('info_log',$log);
			$this->session->set_flashdata('status_info',"Update Data Berhasil sebanyak $nSukses Baris");
			echo $log;
	}
}
