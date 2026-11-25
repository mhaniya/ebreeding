<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kandang extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_user','M_kandang','M_farm','M_propinsi','M_kabupaten','M_kecamatan']);
		$this->session->set_userdata('menu','identifikasi');
		$this->session->set_userdata('submenu','kandang');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//Sementara di controller
		 
		$data['judul']="Data Kandang";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/kandang/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/kandang/footer');
		
	}

	public function ajax_tabel()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_kandang->get_data_json();
		}
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_kandang->get_json();
		}
	}

	public function save()
    {
        $this->form_validation->set_rules('namakandang','Nama Kandang','required|trim',['required' => '%s harus diisi']);
		$this->form_validation->set_rules('idfarm','Nama Farm','required|trim|min_length[5]',[
			'required' => '%s belum dipilih',
			'min_length' => '%s belum dipilih'
			]);
		
		if($this->form_validation->run() == false){
			$user = $this->utility->user_login();
			$id_user=$user->user_id;
			
			$data['farm']=$this->M_farm->get();
			
			$data['judul'] = "Tambah Data Kandang";
			$this->load->view('layout/header');
			$this->load->view('layout/navbar',$data);
			$this->load->view('layout/main_sidebar' ); 
			$this->load->view('identifikasi/kandang/form_tambah',$data);
			$this->load->view('layout/footer');
			$this->load->view('identifikasi/kandang/footer');
		}else{
			$this->M_kandang->save();
			$this->session->set_flashdata('status_insert','success');
			redirect('/identifikasi/kandang');
		}

    }
    public function add()
    {
		$user = $this->utility->user_login();
		$id_user=$user->user_id;
		
		
		$data['farm']=$this->M_farm->get();
		$idfarmuser=$user->idfarmuser;
		if($user->level_id>3) 
			$data['idfarm']=$idfarmuser;
		else
			$data['idfarm']="";

        $data['judul'] = "Tambah Data Kandang";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/kandang/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/kandang/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $rs= $this->M_kandang->get($id)->row();
        $data['rs'] = $rs;
        $data['farm']=$this->M_farm->get();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data Kandang";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/kandang/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/kandang/footer');
    }
   
    public function update()
    {
		$this->M_kandang->update();
		echo $this->db->last_query();
		$this->session->set_flashdata('status_update','success');
        redirect('/identifikasi/kandang');
	}
	
    public function hapus()
    {
		$this->M_kandang->delete();
		$this->session->set_flashdata('status_delete','success');
		redirect('/identifikasi/kandang');
    }
	 
}
