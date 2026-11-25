<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Populasi_peternakan extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_susu']);
		$this->session->set_userdata('menu','lap_populasi');
		$this->session->set_userdata('submenu','populasi_peternakan');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//susu_vertikaltara di controller
		 
		$data['judul']="Laporan Populasi Peternakan";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 

	 
		
		$sql="select kodepropinsi,namapropinsi,COUNT(namapropinsi) as n from wil_propinsi JOIN farm USING(kodepropinsi) ";
		// if($kodepropinsi!="0") $sql .= " WHERE wil_propinsi.kodepropinsi='$kodepropinsi'";
		$sql .=" GROUP BY kodepropinsi";
		$rs=$this->db->query($sql);
		$data['propinsi']=$rs;
		
		$sql="select kodepropinsi,namapropinsi,kodekabupaten,namakabupaten,COUNT(namapropinsi) as n 
		FROM wil_propinsi 
		JOIN wil_kabupaten USING(kodepropinsi) 
		JOIN farm USING(kodepropinsi,kodekabupaten) ";
		// if($kodepropinsi!="0") $sql .= " WHERE wil_propinsi.kodepropinsi='$kodepropinsi'";
		// if($kodekabupaten!="0") $sql .= " AND wil_kabupaten.kodekabupaten='$kodekabupaten'";
		$sql .=" GROUP BY kodepropinsi,kodekabupaten";
		$rs=$this->db->query($sql);
		$data['kabupaten']=$rs;
		
		$sql="select farm.kodepropinsi,namapropinsi,farm.kodekabupaten,namakabupaten,farm.kodekoperasi,namakoperasi,COUNT(namapropinsi) as n 
		FROM wil_propinsi 
		JOIN wil_kabupaten USING(kodepropinsi) 
		JOIN farm USING(kodepropinsi,kodekabupaten) 
		JOIN koperasi USING(kodekoperasi) ";
		// if($kodepropinsi!="0") $sql .= " WHERE wil_propinsi.kodepropinsi='$kodepropinsi'";
		// if($kodekabupaten!="0") $sql .= " AND wil_kabupaten.kodekabupaten='$kodekabupaten'";
		$sql .=" GROUP BY farm.kodepropinsi,farm.kodekabupaten,farm.kodekoperasi";
		$rs=$this->db->query($sql);
		$data['koperasi']=$rs;

		$this->load->view('lap_populasi/populasi_peternakan/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('lap_populasi/populasi_peternakan/footer',$data);
		
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
			echo $this->M_susu->get_json();
		}
	}
	public function get_data_by_idpengukuran($id)
	{
		echo json_encode($this->M_susu->get($id)->row());
	}	 
}
