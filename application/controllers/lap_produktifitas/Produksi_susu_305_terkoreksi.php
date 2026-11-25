<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class produksi_susu_305_terkoreksi extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_susu']);
		$this->session->set_userdata('menu','lap_produktifitas');
		$this->session->set_userdata('submenu','produksi_susu_305_terkoreksi');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//susu_vertikaltara di controller
		 
		$data['judul']="Laporan Produksi Susu 305 Terkoreksi";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('lap_produktifitas/produksi_susu_305_terkoreksi/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('lap_produktifitas/produksi_susu_305_terkoreksi/footer');
		
	}
	
	public function ajax_tabel()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_susu->get_data_json();
		// }
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			$data=$this->M_susu->get_terkoreksi_json();
			echo json_encode($data);
		}
	}
	public function get_data_bulan_produksi($xlaktasi=0)
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			$data=$this->M_susu->get_data_bulan_produksi($xlaktasi);
			echo json_encode($data);
		// }
	}
	public function get_data_by_idpengukuran($id)
	{
		echo json_encode($this->M_susu->get($id)->row());
	}
}
