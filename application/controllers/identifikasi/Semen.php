<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semen extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_semen','M_level','M_Koperasi']);
		$this->session->set_userdata('menu','identifikasi');
		$this->session->set_userdata('submenu','semen');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//Sementara di controller
		 
		$data['judul']="Data Semen";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/semen/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/semen/footer');
		
	}
	public function get_num_kodesemen()
	{
		$kode=$this->input->post('kodesemen');
		$rs=$this->M_semen->get($kode);
		
		echo $rs->num_rows();
	}
	public function get_by_kodesemen($kode)
	{
		$rs=$this->M_semen->get($kode)->row_array();
		echo(json_encode($rs));
	}
	public function get_by_id($id)
	{
		$rs=$this->M_semen->get_data_by_id($id)->row_array();
		echo(json_encode($rs));
	}
	function get_data_bykode(){
		$tagsapi=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_semen->get_data_bykode($tagsapi);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->kodesemen, 
				"data"=>$row->kodesemen,
				"description"=>$row->namasemen,
				"idsapi"=>$row->idsapi
			);
		}
		echo json_encode($arr);
	}
	function get_data_bynama(){
		$namasapi=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_semen->get_data_bynama($namasapi);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->kodesemen,
				"data"=>$row->kodesemen,
				"description"=>$row->namasemen,
				"idsapi"=>$row->idsapi
			);
		}
		echo json_encode($arr);
	}
	function get_dam_bykode(){
		$tagsapi=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_semen->get_dam_bykode($tagsapi);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->kodedam, 
				"data"=>$row->kodedam,
				"description"=>$row->namadam,
				"idsapi"=>$row->idsapi
			);
		}
		echo json_encode($arr);
	}
	function get_dam_bynama(){
		$namasapi=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_semen->get_dam_bynama($namasapi);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->kodedam, 
				"data"=>$row->kodedam,
				"description"=>$row->namadam,
				"idsapi"=>$row->idsapi
			);
		}
		echo json_encode($arr);
	}
	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_semen->get_json();
		}
	}

	public function save()
    {
		$this->M_semen->save();
		$this->session->set_flashdata('status_insert','success');
		redirect('/identifikasi/semen');

    }
    public function add()
    {
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Tambah Data semen";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/semen/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/semen/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['rs'] = $this->M_semen->get($id)->row();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data semen";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/semen/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/semen/footer');
    }
     
    public function update()
    {
		$this->M_semen->update(); 
		// echo $this->db->last_query();
		// exit;
		$this->session->set_flashdata('status_update','success');
        redirect('/identifikasi/semen');
	}
	
    public function hapus()
    {
		$this->M_semen->delete();
		// echo $this->db->last_query();
		$this->session->set_flashdata('status_delete','success');
		redirect('/identifikasi/semen');
    }
	 
}
