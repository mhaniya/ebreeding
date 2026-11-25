<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_ternak extends CI_Controller {
	 
	public function __construct()
	{
		parent::__construct();
		$this->session->set_userdata('menu','data_ref');
		$this->session->set_userdata('submenu','jenis_ternak');
	}
	public function index()
	{
		//Seharusnya ada di model
		//Sementara di controller
		$data['rs']=$this->db->get('ref_jenis_ternak');
		$data['judul']="Jenis Ternak";
		$this->load->view('header');
		$this->load->view('navbar');
		$this->load->view('main_sidebar'); 
		$this->load->view('jenis_ternak/table',$data);
		$this->load->view('footer');
	}

	public function edit($id){
		$data['id']=$id;
		$this->db->where('id',$id);
		$data['row']=$this->db->get('ref_jenis_ternak')->row();

		$this->load->view('header');
		$this->load->view('navbar');
		$this->load->view('main_sidebar'); 
		$this->load->view('jenis_ternak/form',$data);
		$this->load->view('footer');
	}
	public function dataedit(){
		$id=$this->input->post('id');
		$this->db->where('id',$id);
		$rs=$this->db->get('ref_jenis_ternak');
		$row=$rs->row_array();
		echo json_encode($row);
	}
	function form_input(){
		$this->load->view('jenis_ternak/forminput');
	}
	public function simpan(){
		$id=$this->input->post('id');
		if(empty($id)){
			$this->db->insert('ref_jenis_ternak',$_POST); 
		}else{
			$this->db->where('id',$id);
			$this->db->update('ref_jenis_ternak',$_POST);
		}
		redirect('jenis_ternak');
	}
	public function update(){
		$id=$this->input->post('id');
		$this->db->where('id',$id);
		$this->db->update('ref_jenis_ternak',$_POST);
		redirect('jenis_ternak');
	}

	public function hapus(){
		$id=$this->input->post('id');
		$this->db->where('id',$id);
		$this->db->delete('ref_jenis_ternak');
		redirect('jenis_ternak');
	}
}
