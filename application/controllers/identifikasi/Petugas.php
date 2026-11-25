<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_petugas','M_level','M_Koperasi']);
		$this->session->set_userdata('menu','identifikasi');
		$this->session->set_userdata('submenu','petugas');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//petugastara di controller
		 
		$data['judul']="Data Petugas";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/petugas/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/petugas/footer');
		
	}
	public function get_num_idpetugas()
	{
		$kode=$this->input->post('idpetugas');
		$rs=$this->M_petugas->get($kode);
		
		echo $rs->num_rows();
	}
	public function get_data_bynama()
	{
		$nama=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_petugas->get_data_bynama($nama);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->idpetugas,
				"data"=>$row->nama
			);
		}
		echo json_encode($arr);
	}
	public function get_by_idpetugas($kode)
	{
		$rs=$this->M_petugas->get($kode)->row_array();
		echo(json_encode($rs));
	}
	public function get_data()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			echo $this->M_petugas->get_json();
		// }
	}

	public function save()
    {
		$this->M_petugas->save();
		$this->session->set_flashdata('status_insert','success');
		redirect('/identifikasi/petugas');

    }
    public function add()
    {
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Tambah Data Petugas";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/petugas/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/petugas/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['rs'] = $this->M_petugas->get($id)->row();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data petugas";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/petugas/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/petugas/footer');
    }
     
    public function update()
    {
		$this->M_petugas->update(); 
		$this->session->set_flashdata('status_update','success');
        redirect('/identifikasi/petugas');
	}
	
    public function hapus()
    {
		$this->M_petugas->delete();
		$this->session->set_flashdata('status_delete','success');
		redirect('/identifikasi/petugas');
    }
	 
}
