<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_obat']);
		$this->session->set_userdata('menu','kesehatan');
		$this->session->set_userdata('submenu','obat');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//susu_vertikaltara di controller
		 
		$data['judul']="Data Obat";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('kesehatan/obat/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('kesehatan/obat/footer');
		
	}
	
	public function ajax_tabel()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_obat->get_data_json();
		// }
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_obat->get_json();
		}
	}

	public function get_data_bynama()
	{
		$nama=str_replace("%20"," ",$this->uri->segment(4));
		$query=$this->M_obat->get_data_bynama($nama);
		$arr=array();
		foreach($query->result() as $row){
			$arr[]=array(
				"id"=>$row->idobat,
				"data"=>$row->namaobat
			);
		}
		echo json_encode($arr);
	}

	public function get_data_by_id($id)
	{
		echo json_encode($this->M_obat->get($id)->row());
	}

	public function save()
    {
		$this->M_obat->save();
		$this->session->set_flashdata('status_insert','success');
		redirect('/kesehatan/obat');

    }
    public function add()
    {
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Tambah Data Obat";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('kesehatan/obat/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('kesehatan/obat/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['rs'] = $this->M_obat->get($id)->row();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data Obat";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('kesehatan/obat/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('kesehatan/obat/footer');
    }
     
    public function update()
    {
		$this->M_obat->update(); 
		$this->session->set_flashdata('status_update','success');
        redirect('/kesehatan/obat');
	}
	
    public function hapus()
    {
		$this->M_obat->delete();
		$this->session->set_flashdata('status_delete','success');
		redirect('/kesehatan/obat');
    }
	 
}
