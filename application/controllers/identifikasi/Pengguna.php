<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_user','M_level','M_Koperasi','M_farm']);
		$this->session->set_userdata('menu','identifikasi');
		$this->session->set_userdata('submenu','pengguna');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//Sementara di controller
		 
		$data['judul']="Data Pengguna";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/pengguna/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/pengguna/footer');
		
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_user->get_json();
		}
	}

	public function save()
    {
        $this->form_validation->set_rules('user_nama','Nama','required|trim',['required' => '%s harus diisi']);
		$this->form_validation->set_rules('user_username','Username','required|trim|max_length[15]|is_unique[web_user.user_username]',[
			'is_unique' => '%s telah digunakan',
			'required' => '%s belum diisi'
		]);

		//validasi password
		$this->form_validation->set_rules('pass1','Password','required|trim|min_length[3]|matches[pass2]',[
			'required' => '%s belum terisi.',
			'matches' => 'Password tidak sama!',
			'min_length' => 'Password terlalu pendek!'
		]);
		$this->form_validation->set_rules('pass2','Password','required|trim|min_length[3]|matches[pass1]',[
			'required' => '%s belum terisi',
			'matches' => '%s tidak sama!'
		]);
		
		if($this->form_validation->run() == false){
			$data['level'] = $this->M_level->get();
			$data['koperasi'] = $this->M_Koperasi->get();
			$data['user'] = $this->utility->user_login();
			$data['judul'] = "Tambah Data Pengguna";
			$this->load->view('layout/header');
			$this->load->view('layout/navbar',$data);
			$this->load->view('layout/main_sidebar' ); 
			$this->load->view('identifikasi/pengguna/form_tambah',$data);
			$this->load->view('layout/footer');
			$this->load->view('identifikasi/pengguna/footer');
		}else{
			$this->M_user->save();
			$this->session->set_flashdata('status_insert','success');
			redirect('/identifikasi/pengguna');
		}

    }
    public function add()
    {
        $data['level'] = $this->M_level->get();
		$data['koperasi'] = $this->M_Koperasi->get();
		$data['user'] = $this->utility->user_login();
		$data['farm'] = $this->M_farm->get();
        $data['judul'] = "Tambah Data Pengguna";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/pengguna/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/pengguna/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
		$data['rs'] = $this->M_user->get($id)->row();
		
        $data['level'] = $this->M_level->get();
		$data['koperasi'] = $this->M_Koperasi->get();
		$data['user'] = $this->utility->user_login();
		$data['farm'] = $this->M_farm->get();
        $data['judul'] = "Edit Data Pengguna";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/pengguna/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/pengguna/footer');
    }
    public function editpass()
    {
        $id = $this->input->post('id');
        $data['rs'] = $this->M_user->get($id)->row();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Password Pengguna";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('identifikasi/pengguna/form_edit_pass',$data);
		$this->load->view('layout/footer');
		$this->load->view('identifikasi/pengguna/footer');
    }
    public function update()
    {
		$this->M_user->update();
		$this->session->set_flashdata('status_update','success');
        redirect('/identifikasi/pengguna');
	}
	public function updatepass()
    {
       
		//validasi password
		$this->form_validation->set_rules('pass1','Password','required|trim|min_length[3]|matches[pass2]',[
			'required' => '%s belum terisi.',
			'matches' => 'Password tidak sama!',
			'min_length' => 'Password terlalu pendek!'
		]);
		$this->form_validation->set_rules('pass2','Password','required|trim|min_length[3]|matches[pass1]',[
			'required' => '%s belum terisi',
			'matches' => '%s tidak sama!'
		]);
		
		if($this->form_validation->run() == false){
			$id = $this->input->post('id');
        	$data['rs'] = $this->M_user->get($id)->row();
			$data['user'] = $this->utility->user_login();
			$data['judul'] = "Edit Password Pengguna";
			$this->load->view('layout/header');
			$this->load->view('layout/navbar',$data);
			$this->load->view('layout/main_sidebar' ); 
			$this->load->view('identifikasi/pengguna/form_edit_pass',$data);
			$this->load->view('layout/footer');
			$this->load->view('identifikasi/pengguna/footer');
		}else{
			$this->M_user->updatepass();
			$this->session->set_flashdata('status_update','success');
			redirect('/identifikasi/pengguna');
		}

    }
    public function hapus()
    {
		$this->M_user->delete();
		$this->session->set_flashdata('status_delete','success');
		redirect('/identifikasi/pengguna');
    }
	 
}
