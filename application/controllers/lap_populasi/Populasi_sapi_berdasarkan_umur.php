<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Populasi_sapi_berdasarkan_umur extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_sapi']);
		$this->session->set_userdata('menu','lap_populasi');
		$this->session->set_userdata('submenu','populasi_sapi_berdasarkan_umur');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//susu_vertikaltara di controller
		 
		$data['judul']="Laporan Populasi Sapi Berdasarkan Umur";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('lap_populasi/populasi_sapi_berdasarkan_umur/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('lap_populasi/populasi_sapi_berdasarkan_umur/footer');
		
	}
	
	public function ajax_tabel()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_sapi->get_data_json();
		// }
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_sapi->get_populasi_berdasarkan_umur_json();
		}
	}
	public function get_data_by_idpengukuran($id)
	{
		echo json_encode($this->M_sapi->get($id)->row());
	}	 
}
