<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sapi extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_user','M_sapi','M_farm','M_propinsi','M_kabupaten','M_kecamatan','M_asal','M_susu','M_pertumbuhan','M_ib','M_pemeriksaankesehatan']);
		$this->session->set_userdata('menu','identifikasi');
		$this->session->set_userdata('submenu','sapi');
		belum_login();
	}
	public function index()
	{
		 
		$data['judul']="Data Sapi";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$data['halaman']='index';
		
		$user = $this->utility->user_login();
		$data['user'] = $user;
		$id_user=$user->user_id;
		
		$kodepropinsi=($this->session->userdata("kodepropinsi")!=""?$this->session->userdata("kodepropinsi"):$this->M_user->get_kodepropinsi($id_user));
		$kodekabupaten=($this->session->userdata("kodekabupaten")!=""?$this->session->userdata("kodekabupaten"):$this->M_user->get_kodekabupaten($id_user));
		$kodekecamatan=($this->session->userdata("kodekecamatan")!=""?$this->session->userdata("kodekecamatan"):$this->M_user->get_kodekecamatan($id_user));
		$idfarm=($this->session->userdata("idfarm")!="0"?$this->session->userdata("idfarm"):$this->M_user->get_idfarm($id_user));
		
		$data['propinsi'] = $this->M_propinsi->get_all();
		$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
		$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten); 
		$data['farm'] = $this->M_farm->get_all_in_kecamatan($kodepropinsi,$kodekabupaten,$kodekecamatan);
		
		$data['kodepropinsi']=$kodepropinsi;
		$data['kodekabupaten']=$kodekabupaten;
		$data['kodekecamatan']=$kodekecamatan;
		$data['idfarm']=$idfarm;
		// $data['kodekoperasi']=$kodekoperasi;
 
		$data['status']=$this->session->userdata("status");
		$data['is_balai']=$this->session->userdata("is_balai");
		$data['is_uzur']=$this->session->userdata("is_uzur");
		$data['is_vbc']=$this->session->userdata("is_vbc");
		$data['kelamin']=$this->session->userdata("kelamin");
		
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/sapi/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/sapi/footer',$data);
		
	}
	function buatregister($idsapi){
		$sql="SELECT * FROM sapi WHERE idsapi='$idsapi'";
		$rs=$this->db->query($sql);
		$row=$rs->row();
		
		$ada=($rs->num_rows>0);
		$status='hidup';
		$status_pc='';
		$tagsapi = $row->tagsapi;
		$idfarm = $row->idfarm;
		
		$kelamin = $row->kelamin;
		$tipesapi = $row->tipesapi;
		$namasapi = $row->namasapi;
		$tgllahir = $row->tgllahir;
		$bobotlahir = $row->bobotlahir;
		$status = $row->status; 
		$is_uzur = $row->is_uzur;
		$is_vbc = $row->is_vbc;
		$is_kso = $row->is_kso;
		$is_balai = $row->is_balai;
		if($row->tgllahir<>null)
			$tgllahir=$row->tgllahir;
		else	
			$tgllahir='0000-00-00';
		
		$tanggal=substr($tgllahir,8,2);
		$bulan=substr($tgllahir,5,2);
		$tahun=substr($tgllahir,0,4);
		
		$sql="SELECT count(*)+1 as n FROM sapi WHERE idfarm like '".substr($idfarm,0,3)."%"."' AND tgllahir='$tgllahir' AND idsapi IN (SELECT idsapi FROM register )";
		
		$rs=$this->db->query($sql);
		$row1=$rs->row();
		if($row->tgllahir<>null){
			$n=str_pad($row1->n,2,"0",STR_PAD_LEFT);
			$kodefikasi=substr($idfarm,0,3).$n.$tanggal.$bulan.substr($tahun,2,2).($tipesapi=="IB");
			$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
			$rs2=$this->db->query($sql);
			while($rs2->num_rows()>0){
				$n++;
				$n=str_pad($n,2,"0",STR_PAD_LEFT);
				$kodefikasi=substr($idfarm,0,3).$n.$tanggal.$bulan.substr($tahun,2,2).($tipesapi=="IB");
				$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
				$rs2=$this->db->query($sql);
			}
		}else{
			$n=str_pad($row1->n,7,"0",STR_PAD_LEFT);
			$kodefikasi=substr($idfarm,0,3).$n.($tipesapi=="IB");
			$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
			$rs2=$this->db->query($sql);
			while($rs2->num_rows()>0){
				$n++;
				$n=str_pad($n,7,"0",STR_PAD_LEFT);
				$kodefikasi=substr($idfarm,0,3).$n.($tipesapi=="IB");
				$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
				$rs2=$this->db->query($sql);
			}
		}
		if($kodefikasi<>""){	
			$sql="REPLACE INTO register SET
				nomorregister='$kodefikasi'
				,idsapi='$idsapi'
				,tanggal=CURRENT_DATE
				,status='Aktif'";
			$this->db->query($sql);
		}	
		
	}

	public function buatregisterbelumada()
	{
		$sql="SELECT * FROM sapi where status='hidup' AND idsapi NOT IN (SELECT idsapi from register)";
		$rs=$this->db->query($sql);
		foreach($rs->result() as $row){
			$idsapi=$row->idsapi;
			$this->buatregister($idsapi);
		}
		redirect("/identifikasi/sapi",'refresh');
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
	public function gettetua($jenis,$idsapi)
	{
		$data=$this->M_sapi->getInduk($idsapi)->result(); 
		echo json_encode($data);
	}
	public function simpantetua()
	{
		$jenis=$this->input->post('jenis');
		 
		$id=$this->input->post('id');
		
		$idsapi=$this->input->post('idsapi');
		$nomorregister=$this->input->post('nomorregister');
		$tagsapi=$this->input->post('tagsapi');
		$namasapi=$this->input->post('namasapi');
		$tgllahir=$this->input->post('tgllahir');
		$milk=$this->input->post('milk');
		$fat=$this->input->post('fat');
		$protein=$this->input->post('protein');
		 
		if($jenis=="Sire"){
			//Mencari semen apakah ada di data sapi
			$sql="SELECT * FROM sapi WHERE idsapi='$idsapi'";
			// echo $sql."===========================<br>";
			$rs_sapi=$this->db->query($sql);
			if($rs_sapi->num_rows()>0){
				//UPDATE sapi
				$sql="UPDATE sapi SET namasapi = '$namasapi', tagsapi='$tagsapi'";
				if($tgllahir<>"") $sql .= ", tgllahir='$tgllahir'";
				$sql .= ", kelamin='Jantan'";
				if($milk<>"") $sql .= ",milk='$milk'";
				if($fat <>"") $sql .= ",fat='$fat'";
				if($protein<>"") $sql .= ",protein='$protein'";
				$sql .=" WHERE idsapi='$idsapi'";
				$this->db->query($sql);
			}else{
				//INSERT sapi
				$sql="INSERT INTO sapi SET namasapi = '$namasapi', tagsapi='$tagsapi', tgllahir='$tgllahir',tipesapi='Semen', kelamin='Jantan',milk='$milk',fat='$fat',protein='$protein'";
				$rs=$this->db->query($sql);
				$idsapi=$this->db->insert_id();
			} 
			// echo $sql."<br>";
			// echo "=========================<br>";
			//Mencari semen apakah ada di data sapi
			$sql="SELECT * FROM sapi WHERE idsapi='$id'";
			
			$rs_tetua=$this->db->query($sql);
			if($rs_tetua->num_rows()>0){
				 
				$sql="UPDATE sapi SET idsire='$idsapi', namasire = '$namasapi', kodesire='$tagsapi' 
					WHERE idsapi='$id'"; 
				$this->db->query($sql);
				
			} 
			
			// echo $sql."A<br>=========================================<br>";
		}else{
			//Mencari induk apakah ada di data sapi
			$sql="SELECT * FROM sapi WHERE idsapi='$idsapi'";
			// echo $sql."B<br>=========================================<br>";
			$rs_sapi=$this->db->query($sql);
			if($rs_sapi->num_rows()>0){
				//UPDATE sapi
				$sql="UPDATE sapi SET namasapi = '$namasapi', tagsapi='$tagsapi', tgllahir='$tgllahir', kelamin='Betina',milk='$milk',fat='$fat',protein='$protein' WHERE idsapi='$idsapi'";
				$this->db->query($sql);
			}else{
				//INSERT sapi
				$sql="INSERT INTO sapi SET namasapi = '$namasapi', tagsapi='$tagsapi', tgllahir='$tgllahir', kelamin='Betina',milk='$milk',fat='$fat',protein='$protein'";
				$rs=$this->db->query($sql);
				$idsapi=$this->db->insert_id();
			}

			// echo $sql."<br>=========================================<br>";
			 
			$sql="UPDATE sapi SET iddam='$idsapi',namadam = '$namasapi', kodedam='$tagsapi' 
				WHERE idsapi='$id'";
			$this->db->query($sql);
			// echo $sql;
			 
		}
		if($nomorregister<>""){
			$sql="SELECT * FROM register WHERE idsapi='$idsapi'";
			$rs_register=$this->db->query($sql);
			if($rs_register->num_rows()>0){
				$sql="UPDATE register SET nomorregister='$nomorregister'";
			}else{
				$sql="INSERT INTO register SET nomorregister='$nomorregister',idsapi='$idsapi'";
			}
			$this->db->query($sql);
		}
		$iddetailaktif=$this->session->userdata('iddetailaktif');

		redirect("/identifikasi/sapi/detail/$iddetailaktif",'refresh');
		
	}
	public function detail($idsapi)
	{
		$this->session->set_userdata('iddetailaktif',$idsapi);
		$data['idsapi']=$idsapi;
		$data['tagsapi']=$this->M_sapi->getTagSapi($idsapi);
		$data['sapi']=$this->M_sapi->get($idsapi)->row();
		$data['dataTetua']=$this->M_sapi->getInduk($idsapi);
		// echo $this->db->last_query();
		$data['pertumbuhan']=$this->M_pertumbuhan->getByIDSapi($idsapi);
		$data['kesehatan']=$this->M_pemeriksaankesehatan->getByIDSapi($idsapi);
		$data['reproduksi']=$this->M_ib->getByIDSapi($idsapi);
		$data['produksi']=$this->M_susu->getDataProduksiSapi($idsapi);
		// echo $this->db->last_query();
		$data['produksi1']=$this->M_susu->getProduksiPerLaktasiByIDSapi($idsapi);
	 
		$data['halaman']='detail';
		$data['judul']="Detail Data Sapi";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/sapi/tabledetail',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/sapi/footerdetail',$data);
		
	}

	public function ajax_tabel()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_sapi->get_data_json();
		}
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_sapi->get_json();
		}
	}
	function get_data_bytagsapi(){
		$tagsapi=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_sapi->get_data_bytagsapi($tagsapi);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->idsapi,
				"data"=>$row->tagsapi,
				"kelamin"=>$row->kelamin,
				"description"=>$row->nomorregister
			);
		}
		echo json_encode($arr);
	}
	function get_data_bykode(){
		$tagsapi=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_sapi->get_data_bykode($tagsapi);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->idsapi,
				"data"=>$row->tagsapi,
				"description"=>$row->namasapi,
				"nomorregister"=>$row->nomorregister
			);
		}
		echo json_encode($arr);
	}
	function get_data_bynama(){
		$namasapi=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_sapi->get_data_bynama($namasapi);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->idsapi,
				"data"=>$row->tagsapi,
				"description"=>$row->namasapi,
				"nomorregister"=>$row->nomorregister
			);
		}
		echo json_encode($arr);
	}
	
	function get_data_bytagsapiequal(){
		$tagsapi=$this->input->post('tagsapi');
		
		if($tagsapi!=""){
			$query=$this->M_sapi->get_data_bytagsapiequal($tagsapi);
			$arr=array();
			foreach($query->result() as $row){
				$arr[]=array(
					"id"=>$row->idsapi,
					"data"=>$row->tagsapi,
					"description"=>$row->nomorregister
				);
			}
			echo json_encode($arr);	
		}else{
			echo null;
		}
		
	}
	function get_numdata_bytagsapi(){
		$tagsapi=$this->input->post('tagsapi');
		$n=$this->M_sapi->get_numdata_bytagsapi($tagsapi);
		echo $n;
	}

	public function get_auto_bytagsapi()
    {
        if (isset($_GET['term'])) {
            $result = $this->M_sapi->search_data_bytagsapi($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = [ 'label' => $row->tagsapi,'kode' => $row->idsapi,'nomorregister' => $row->nomorregister ];
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
        $this->form_validation->set_rules('tagsapi','No. Tag','required|trim',['required' => '%s harus diisi']);
		$this->form_validation->set_rules('tgllahir','Tanggal Lahir','required|trim',['required' => '%s belum diisi']);
		$this->form_validation->set_rules('idfarm','Peternakan','callback_isfarm',['isfarm' => '%s harus dipilih']);
		
		
		if($this->form_validation->run() == false){
			$user = $this->utility->user_login();
			$data['user']=$user;
			$id_user=$user->user_id;
			
			$kodepropinsi=$this->M_user->get_kodepropinsi($id_user);
			$kodekabupaten=$this->M_user->get_kodekabupaten($id_user);
			$kodekecamatan=$this->M_user->get_kodekecamatan($id_user);
			$kodekoperasi=$this->M_user->get_kodekoperasi($id_user);
			$idfarm=$this->M_user->get_idfarm($id_user);
			$data['halaman']='add';
			$data['kodepropinsi']=$kodepropinsi;
			$data['kodekabupaten']=$kodekabupaten;
			$data['kodekecamatan']=$kodekecamatan;
			$data['kodekoperasi']=$kodekoperasi;
			$data['idfarm']=$idfarm;
			$data['propinsi'] = $this->M_propinsi->get_all();
			$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
			$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten);
			$data['asal'] = $this->M_asal->get_all();
			$data['farm'] = $this->M_farm->get_all_in_kecamatan($kodepropinsi,$kodekabupaten,$kodekecamatan);

			$data['judul'] = "Tambah Data Farm/sapi";
			$this->load->view('layout/header');
			$this->load->view('layout/navbar',$data);
			$this->load->view('layout/main_sidebar' ); 
			$this->load->view('identifikasi/sapi/form_tambah',$data);
			$this->load->view('layout/footer');
			$this->load->view('identifikasi/sapi/footer',$data);
		}else{
			$this->M_sapi->save();
			$this->session->set_flashdata('status_insert','success');
			redirect('/identifikasi/sapi');
		}

    }
    public function add()
    {
		$user = $this->utility->user_login();
		$data['user']=$user;
		$id_user=$user->user_id;
		
		$kodepropinsi=$this->M_user->get_kodepropinsi($id_user);
		$kodekabupaten=$this->M_user->get_kodekabupaten($id_user);
		$kodekecamatan=$this->M_user->get_kodekecamatan($id_user);
		$kodekoperasi=$this->M_user->get_kodekoperasi($id_user);
		$idfarm=$this->M_user->get_idfarm($id_user);
		$data['halaman']='add';
		$data['kodepropinsi']=$kodepropinsi;
		$data['kodekabupaten']=$kodekabupaten;
		$data['kodekecamatan']=$kodekecamatan;
		$data['kodekoperasi']=$kodekoperasi;
		$data['idfarm']=$idfarm;
		$data['propinsi'] = $this->M_propinsi->get_all();
		$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
		$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten);
		$data['asal'] = $this->M_asal->get_all();
		$data['farm'] = $this->M_farm->get_all_in_kecamatan($kodepropinsi,$kodekabupaten,$kodekecamatan);

        $data['judul'] = "Tambah Data Farm/sapi";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/sapi/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/sapi/footer',$data);

    }
    public function edit()
    {
        $id = $this->input->post('id');
		
		$rs= $this->M_sapi->get($id);
		
		$data['rs'] = $rs;
        $user = $this->utility->user_login();
		$data['user']=$user;
		$id_user=$user->user_id;
		$kodepropinsi=$this->M_user->get_kodepropinsi($id_user);
		$kodekabupaten=$this->M_user->get_kodekabupaten($id_user);
		$kodekecamatan=$this->M_user->get_kodekecamatan($id_user);
		$kodekoperasi=$this->M_user->get_kodekoperasi($id_user);
		$idfarm=$this->M_user->get_idfarm($id_user);
		$data['halaman']='edit';
		$data['kodepropinsi']=$kodepropinsi;
		$data['kodekabupaten']=$kodekabupaten;
		$data['kodekecamatan']=$kodekecamatan;
		$data['kodekoperasi']=$kodekoperasi;
		$data['idfarm']=$idfarm;
		$data['propinsi'] = $this->M_propinsi->get_all();
		$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
		$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten);
		$data['asal'] = $this->M_asal->get_all();
		$data['farm'] = $this->M_farm->get_all_in_kecamatan($kodepropinsi,$kodekabupaten,$kodekecamatan);
		
        $data['judul'] = "Edit Data Sapi";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/sapi/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/sapi/footer',$data);
    }
   
    public function update()
    {
		$this->M_sapi->update(); 
		// echo $this->db->last_query();
		$this->session->set_flashdata('status_update','success');
        redirect('/identifikasi/sapi');
	}
	
    public function hapus()
    {
		if($this->input->post('alasan')=='0'){
			$this->M_sapi->delete();
			$this->session->set_flashdata('status_delete','success');
		}else
		{
			$alasan=$this->input->post('alasan');
			$this->M_sapi->setmati($alasan);
			$this->session->set_flashdata('status_delete','success');
		}
		redirect('/identifikasi/sapi');
    }
	function pilihkelamin(){
		$kelamin=$this->input->post('kelamin');
		$this->session->set_userdata('kelamin',$kelamin); 
	}	 
	function pilihstatus(){
		$status=$this->input->post('status');
		$this->session->set_userdata('status',$status); 
	}	 
	function pilih_balai(){
		$status=$this->input->post('is_balai');
		$this->session->set_userdata('is_balai',$status); 
	}	 
	function pilih_uzur(){
		$status=$this->input->post('is_uzur');
		$this->session->set_userdata('is_uzur',$status); 
	}	 
	function pilih_vbc(){
		$status=$this->input->post('is_vbc');
		$this->session->set_userdata('is_vbc',$status); 
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
			
			$targetDir = "assets/images/upload/foto/sapi/";
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
		$idsapi=$this->input->post('idsapi');
		$tanggal=$this->input->post('tanggal');
		$sql="UPDATE sapi set tglsertifikat='$tanggal' WHERE idsapi='$idsapi'";
		$this->db->query($sql); 
	}
	function cetaksertifikat(){
		$data['idsapi']=$this->uri->segment(4);
		$this->load->view("identifikasi/sapi/sertifikat",$data);
	}
	function cetaksertifikatlspro(){
		$data['idsapi']=$this->uri->segment(4);
		$this->load->view("identifikasi/sapi/sertifikatlspro",$data);
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
			
			$targetDir = "assets/files/upload/sapi/";
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

            $file =  $_SERVER['DOCUMENT_ROOT']."/assets/files/upload/sapi/".$filename ;

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
						$tagsapi = $data['cells'][$i][$j];
					if($j=="2")
						$kelamin = $data['cells'][$i][$j];
					if($j=="3")
						$tipesapi = $data['cells'][$i][$j];
					    
					if($j=="4")
                                        $namasapi = $data['cells'][$i][$j];
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
			
					$sql="SELECT idsapi,tagsapi FROM sapi WHERE tagsapi='$tagsapi' AND idfarm='$idfarm'";
					$rs=$this->db->query($sql);
					$row=$rs->row();
					$idsapi=$row->idsapi;
					
					$ada=($rs->num_rows>0);
					
					if($tgllahir=='')$tgllahir='00/00/0000';
					
					$tgl = explode('/',$tgllahir);
					
					$tanggal=str_pad($tgl[0],2,"0",STR_PAD_LEFT);
					$bulan=str_pad($tgl[1],2,"0",STR_PAD_LEFT);
					$tahun=$tgl[2];
					
					$tgllahir=$tahun."-".$bulan."-".$tanggal;
										
					if($ada)
						$sql="UPDATE sapi ";
					else
						$sql="INSERT INTO sapi ";
                    
					$sql .= " SET `idfarm` ='$idfarm',
						   `tagsapi`='$tagsapi',
						   `idbangsa`='1',
						   `kelamin`='$kelamin',
						   `tipesapi`='$tipesapi',
						   `namasapi`='$namasapi',
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
						$sql.=" WHERE tagsapi='$tagsapi' AND idfarm='$idfarm'";
					}
					
					$this->db->query($sql);     
					
					if(!$ada){	
						if(checkdate($bulan,$tanggal,$tahun))
							$sql="SELECT count(*)+1 as n,date_format(SUBDATE('$tgllahir',INTERVAL 1 day),'%d%m%y') tgl FROM sapi WHERE idfarm LIKE '".substr($idfarm,0,3)."%"."' AND tgllahir=SUBDATE('$tgllahir',INTERVAL 1 day)";
						else
							$sql="SELECT count(*)+1 as n FROM sapi WHERE idfarm like '".substr($idfarm,0,3)."%"."' AND tgllahir='0000-00-00'";

						$rs=$this->db->query($sql);
						$row=$rs->row();
						if(checkdate($bulan,$tanggal,$tahun)){
							$n=str_pad($row->n,2,"0",STR_PAD_LEFT);
							$tgl=$row->tgl;
							$kodefikasi=substr($idfarm,0,3).$n.$tgl.($tipesapi=="IB");
						}else{
							$n=str_pad($row->n,8,"0",STR_PAD_LEFT);
							$kodefikasi=substr($idfarm,0,3).$n.($tipesapi=="IB");
						}	
						
						$sql="SELECT idsapi,tagsapi FROM sapi WHERE tagsapi='$tagsapi' AND idfarm='$idfarm'";
						$rs=$this->db->query($sql);
						$row=$rs->row();
						$idsapi=$row->idsapi;
					}else{			
						if(checkdate($bulan,$tanggal,$tahun))
							$sql="SELECT count(*)+1 as n,date_format(SUBDATE('$tgllahir',INTERVAL 1 day),'%d%m%y') tgl FROM sapi WHERE idfarm LIKE '".substr($idfarm,0,3)."%"."' AND tgllahir=SUBDATE('$tgllahir',INTERVAL 1 day) AND idsapi<>'$idsapi'";
						else
							$sql="SELECT count(*)+1 as n FROM sapi WHERE idfarm like '".substr($idfarm,0,3)."%"."' AND tgllahir='0000-00-00'  AND idsapi<>'$idsapi'";

						$rs=$this->db->query($sql);
						$row=$rs->row();
						if(checkdate($bulan,$tanggal,$tahun)){
							$n=str_pad($row->n,2,"0",STR_PAD_LEFT);
							$tgl=$row->tgl;
							$kodefikasi=substr($idfarm,0,3).$n.$tgl.($tipesapi=="IB");
						}else{
							$n=str_pad($row->n,8,"0",STR_PAD_LEFT);
							$kodefikasi=substr($idfarm,0,3).$n.($tipesapi=="IB");
						}
					}
					if($kodefikasi<>""){	
						$sql="REPLACE INTO register SET
							nomorregister='$kodefikasi'
							,idsapi='$idsapi'
							,tanggal=CURRENT_DATE
							,status='Aktif'";
						$this->db->query($sql);
						
					}	
					//if($rs){
						$nSukses++;
						$log .= "<font color='blue'>".$tagsapi." Sukses Diinputkan/Diupdate</font><br>";
				    //}else{$nError++;$log .= "<font color='red'>".$peternakan." Belum terregistrasi</font><br>";}
			}
            
			$this->session->set_flashdata('info_log',$log);
			$this->session->set_flashdata('status_info',"Update Data Berhasil sebanyak $nSukses Baris");
			echo $log;
	}
}
