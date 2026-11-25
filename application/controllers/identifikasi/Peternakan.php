<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peternakan extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_user','M_farm','M_propinsi','M_kabupaten','M_kecamatan']);
		$this->session->set_userdata('menu','identifikasi');
		$this->session->set_userdata('submenu','peternakan');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//Sementara di controller
		 
		$data['judul']="Data Peternakan";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$user = $this->utility->user_login();
		$data['user'] = $user;
		$id_user=$user->user_id;
		
		$kodepropinsi=($this->session->userdata("kodepropinsi")!=""?$this->session->userdata("kodepropinsi"):$this->M_user->get_kodepropinsi($id_user));
		$kodekabupaten=($this->session->userdata("kodekabupaten")!=""?$this->session->userdata("kodekabupaten"):$this->M_user->get_kodekabupaten($id_user));
		$kodekecamatan=($this->session->userdata("kodekecamatan")!=""?$this->session->userdata("kodekecamatan"):$this->M_user->get_kodekecamatan($id_user));
		$kodekoperasi=$user->kodekoperasi;
        $idfarm=$user->idfarmuser;
        $level_id=$user->level_id;
		
		$data['propinsi'] = $this->M_propinsi->get_all();
		$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
		$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten);  
		$data['level_id']=$level_id;
		$data['kodepropinsi']=$kodepropinsi;
		$data['kodekabupaten']=$kodekabupaten;
		$data['kodekecamatan']=$kodekecamatan; 
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/peternakan/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/peternakan/footer');
		
	}

	public function ajax_tabel()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_farm->get_data_json();
		}
	}

	public function get_data()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			echo $this->M_farm->get_json();
			// }
	}

	public function save()
    {
        $this->form_validation->set_rules('namafarm','Nama Farm/Peternakan','required|trim',['required' => '%s harus diisi']);
		$this->form_validation->set_rules('namapeternak','Nama Peternak','required|trim',['required' => '%s belum diisi']);

		//validasi password
		$this->form_validation->set_rules('alamatfarm','Alamat Farm/Peternakan','required|trim',[
			'required' => '%s belum terisi.'
		]);
		
		if($this->form_validation->run() == false){
			$user = $this->utility->user_login();
			$id_user=$user->user_id;
			
			$kodepropinsi=$this->M_user->get_kodepropinsi($id_user);
			$kodekabupaten=$this->M_user->get_kodekabupaten($id_user);
			$kodekecamatan=$this->M_user->get_kodekecamatan($id_user);
			$kodekoperasi=$this->M_user->get_kodekoperasi($id_user);
			$data['kodepropinsi']=$kodepropinsi;
			$data['kodekabupaten']=$kodekabupaten;
			$data['kodekecamatan']=$kodekecamatan;
			$data['kodekoperasi']=$kodekoperasi;
			$data['propinsi'] = $this->M_propinsi->get_all();
			$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
			$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten);
			$data['judul'] = "Tambah Data Farm/Peternakan";
			$this->load->view('layout/header');
			$this->load->view('layout/navbar',$data);
			$this->load->view('layout/main_sidebar' ); 
			$this->load->view('identifikasi/peternakan/form_tambah',$data);
			$this->load->view('layout/footer');
			$this->load->view('identifikasi/peternakan/footer');
		}else{
			$this->M_farm->save();
			$this->session->set_flashdata('status_insert','success');
			redirect('/identifikasi/peternakan');
		}

    }
    public function add()
    {
		$user = $this->utility->user_login();
		$id_user=$user->user_id;
		
		$kodepropinsi=$this->M_user->get_kodepropinsi($id_user);
		$kodekabupaten=$this->M_user->get_kodekabupaten($id_user);
		$kodekecamatan=$this->M_user->get_kodekecamatan($id_user);
		$kodekoperasi=$this->M_user->get_kodekoperasi($id_user);
		$data['kodepropinsi']=$kodepropinsi;
		$data['kodekabupaten']=$kodekabupaten;
		$data['kodekecamatan']=$kodekecamatan;
		$data['kodekoperasi']=$kodekoperasi;
		$data['propinsi'] = $this->M_propinsi->get_all();
		$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
		$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten);
		
        $data['judul'] = "Tambah Data Farm/Peternakan";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/peternakan/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/peternakan/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $rs= $this->M_farm->get($id)->row();
        $data['rs'] = $rs;
        $data['propinsi'] = $this->M_propinsi->get_all();
        $data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($rs->kodepropinsi);
		$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($rs->kodepropinsi,$rs->kodekabupaten);
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data Farm/Peternakan";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/peternakan/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/peternakan/footer');
    }
   
    public function update()
    {
		$this->M_farm->update();
		$this->session->set_flashdata('status_update','success');
        redirect('/identifikasi/peternakan');
	}
	
    public function hapus()
    {
		$this->M_farm->delete();
		$this->session->set_flashdata('status_delete','success');
		redirect('/identifikasi/peternakan');
    }
	function get_list_data_by_kecamatan(){
        $kodepropinsi=$this->uri->segment(4);
        $kodekabupaten=$this->uri->segment(5);
		$kodekecamatan=$this->uri->segment(6);
		
        $this->session->set_userdata('kodekecamatan',$kodekecamatan);
        $data=$this->M_farm->get_list_data_by_kecamatan($kodepropinsi,$kodekabupaten,$kodekecamatan);
        
        $comma=",";
        echo "var newOptions={";
        echo "'0':':: Pilih Peternakan ::'";
        foreach($data->result() as $rs){
        echo $comma."'".$rs->idfarm."':'".addslashes($rs->namafarm)."'";   
        }
        echo "};";
	}
	function pilihfarm(){
		$idfarm=$this->input->post('idfarm');
		$this->session->set_userdata('idfarm',$idfarm); 
	}
	function upload(){
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
			
			$targetDir = "assets/files/upload/peternakan/";
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
		
		$kodepropinsi=$this->M_user->get_kodepropinsi($id_user);
		$kodekabupaten=$this->M_user->get_kodekabupaten($id_user);
		$kodekecamatan=$this->M_user->get_kodekecamatan($id_user);
		$kodekoperasi=$this->M_user->get_kodekoperasi($id_user);

		$tanggalinput=date('Y-m-d');

		$filename=$this->input->post('namafile');

		 // Load the spreadsheet reader library
		$this->load->library('excel_reader');

        $file =  $_SERVER['DOCUMENT_ROOT']."/assets/files/upload/peternakan/".$filename ;

			// Set output Encoding.
		$this->excel_reader->setOutputEncoding('CP1251');
			
			
		$this->excel_reader->read($file);

			error_reporting(E_ALL ^ E_NOTICE);

			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
			$nError=0;$nSukses=0;$log="";
			$log="";
			for ($i = 2; $i <= $data['numRows']; $i++) {
                            $idfarm=$kodepropinsi.$kodekabupaten.$kodekecamatan;
							$sql="SELECT * FROM farm WHERE idfarm LIKE '$idfarm%'";
							$rs=$this->db->query($sql);
							$n=$rs->num_rows();
							$idfarm .= str_pad($n+1, 4, "0", STR_PAD_LEFT);  ;
							
                            for ($j = 1; $j <= $data['numCols']; $j++) {
								if($j=="1")
									$namapeternakan = $data['cells'][$i][$j];
                                if($j=="2")
                                    $namapeternak = $data['cells'][$i][$j];
                                if($j=="3")
                                    $alamatfarm = $data['cells'][$i][$j];
							}
		
				$sql="REPLACE INTO farm SET 
					idfarm='$idfarm'
					,namafarm='$namapeternakan'
					,alamatfarm='$alamatfarm'
					,namapeternak='$namapeternak'
					,kodepropinsi='$kodepropinsi'
					,kodekabupaten='$kodekabupaten'
					,kodekecamatan='$kodekecamatan'
					,kodekoperasi='$kodekoperasi'
					";
				$this->db->query($sql);
				$nSukses++;
				$log .= "<font color='blue'>".$namapeternakan." Sukses DiInputkan</font><br>";
			}
			echo "Update Data Berhasil sebanyak $nSukses Baris<br><br>";
			
			$this->session->set_flashdata('info_log',$log);
			$this->session->set_flashdata('status_info',"Update Data Berhasil sebanyak $nSukses Baris");
			echo $log;
	}
}
