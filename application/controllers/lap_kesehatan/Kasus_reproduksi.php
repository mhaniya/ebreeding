<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasus_reproduksi extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_pemeriksaankesehatan']);
		$this->session->set_userdata('menu','lap_kesehatan');
		$this->session->set_userdata('submenu','kasus_reproduksi');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//susu_vertikaltara di controller
		 
		$data['judul']="Laporan Kasus Reproduksi";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('lap_kesehatan/kasus_reproduksi/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('lap_kesehatan/kasus_reproduksi/footer');
		
	}
	

	public function get_data($jenis="Reproduksi")
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_pemeriksaankesehatan->get_json_report_kasus($jenis);
		}
	}

	public function get_data_by_idpengukuran($id)
	{
		echo json_encode($this->M_susu->get($id)->row());
	}	 
}
