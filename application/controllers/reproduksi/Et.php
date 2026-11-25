<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Et extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_et','M_propinsi','M_kabupaten','M_kecamatan','M_farm']);
		$this->session->set_userdata('menu','reproduksi');
		$this->session->set_userdata('submenu','et');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//ettara di controller
		 
		$data['judul']="Data Embrio Transfer";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$user = $this->utility->user_login();
		$data['user'] = $user;
		$id_user=$user->user_id;
		$kodepropinsi=($this->session->userdata("kodepropinsi")!=""?$this->session->userdata("kodepropinsi"):$this->M_user->get_kodepropinsi($id_user));
		$kodekabupaten=($this->session->userdata("kodekabupaten")!=""?$this->session->userdata("kodekabupaten"):$this->M_user->get_kodekabupaten($id_user));
		$kodekecamatan=($this->session->userdata("kodekecamatan")!=""?$this->session->userdata("kodekecamatan"):$this->M_user->get_kodekecamatan($id_user));
		$idfarm=($this->session->userdata("idfarm")!=""?$this->session->userdata("idfarm"):$this->M_user->get_idfarm($id_user));
		
		$this->session->set_userdata('kodepropinsi',$kodepropinsi);
		$this->session->set_userdata('kodekabupaten',$kodekabupaten);
		$this->session->set_userdata('kodekecamatan',$kodekecamatan);
		$this->session->set_userdata('idfarm',$idfarm);

		$data['kodepropinsi']=$kodepropinsi;
		$data['kodekabupaten']=$kodekabupaten;
		$data['kodekecamatan']=$kodekecamatan;
		$data['idfarm']=$idfarm;

		$data['propinsi'] = $this->M_propinsi->get_all();
		$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
		$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten); 
		$data['farm'] = $this->M_farm->get_all_in_kecamatan($kodepropinsi,$kodekabupaten,$kodekecamatan);

		$data['tahun']=$this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
		$data['bulan']=$this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m'); 
		$data['xlaktasi']=$this->session->userdata('xlaktasi'); 
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('reproduksi/et/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('reproduksi/et/footer');
		
	}
	
	public function ajax_tabel()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_et->get_data_json();
		// }
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_et->get_json();
		}
	}
	public function get_data_by_id($id)
	{
		echo json_encode($this->M_et->get($id)->row());
	}

	public function save()
    {
		$this->M_et->save();
		$this->session->set_flashdata('status_insert','success');
		redirect('/reproduksi/et');

    }
    public function add()
    {
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Tambah Data Embrio Transfer";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('reproduksi/et/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('reproduksi/et/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['rs'] = $this->M_et->get($id)->row();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data Embrio Transfer";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('reproduksi/et/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('reproduksi/et/footer');
    }
     
    public function update()
    {
		$this->M_et->update();  
		$this->session->set_flashdata('status_update','success');
        redirect('/reproduksi/et');
	}
	
    public function hapus()
    {
		$this->M_et->delete();
		$this->session->set_flashdata('status_delete','success');
		redirect('/reproduksi/et');
    }
	 
}
