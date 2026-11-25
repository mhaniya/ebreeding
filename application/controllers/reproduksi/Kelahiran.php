<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelahiran extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_kelahiran','M_propinsi','M_kabupaten','M_kecamatan','M_farm','M_user']);
		$this->session->set_userdata('menu','reproduksi');
		$this->session->set_userdata('submenu','kelahiran');
		belum_login();
	}

	public function index()
	{
		//Seharusnya ada di model
		//kelahirantara di controller
		 
		$data['judul']="Data Kelahiran";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$user = $this->utility->user_login();
		$data['user'] = $user;
		$id_user=$user->user_id;
		$kodepropinsi=($this->session->userdata("kodepropinsi")!=""?$this->session->userdata("kodepropinsi"):$this->M_user->get_kodepropinsi($id_user));
		$kodekabupaten=($this->session->userdata("kodekabupaten")!=""?$this->session->userdata("kodekabupaten"):$this->M_user->get_kodekabupaten($id_user));
		$kodekecamatan=($this->session->userdata("kodekecamatan")!=""?$this->session->userdata("kodekecamatan"):$this->M_user->get_kodekecamatan($id_user));
		$idfarm=($this->session->userdata("idfarm")!=""?$this->session->userdata("idfarm"):$this->M_user->get_idfarm($id_user));
		
		$this->session->set_userdata('kodepropinsi',$kodepropinsi);
		$this->session->set_userdata('kodekabupaten',$kodekabupaten);
		$this->session->set_userdata('kodekecamatan',$kodekecamatan);
		$this->session->set_userdata('idfarm',$idfarm);

		$data['kodepropinsi']=$kodepropinsi;
		$data['kodekabupaten']=$kodekabupaten;
		$data['kodekecamatan']=$kodekecamatan;
		$data['idfarm']=$idfarm;

		$data['propinsi'] = $this->M_propinsi->get_all();
		$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
		$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten); 
		$data['farm'] = $this->M_farm->get_all_in_kecamatan($kodepropinsi,$kodekabupaten,$kodekecamatan);

		$data['tahun']=$this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
		$data['bulan']=$this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m'); 
		$data['xlaktasi']=$this->session->userdata('xlaktasi'); 
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('reproduksi/kelahiran/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('reproduksi/kelahiran/footer');	
	}
	
	public function ajax_tabel()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');
			echo $this->M_kelahiran->get_data_json();
		}
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_kelahiran->get_json();
		}
	}
	
	public function get_data_by_idkelahiran($id)
	{
		echo json_encode($this->M_kelahiran->get($id)->row());
	}

	public function save()
    {
		$this->M_kelahiran->save();
		$this->session->set_flashdata('status_insert','success');
		redirect('/reproduksi/kelahiran');

    }
    public function add()
    {
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Tambah Data Susu";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('reproduksi/kelahiran/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('reproduksi/kelahiran/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['rs'] = $this->M_kelahiran->get($id)->row();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data Kelahiran";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('reproduksi/kelahiran/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('reproduksi/kelahiran/footer');
    }
     
    public function update()
    {
		$this->M_kelahiran->update();  
		$this->session->set_flashdata('status_update','success');
        redirect('/reproduksi/kelahiran');
	}
	
    public function import()
    {
        $result = array('success' => 0, 'calves' => 0, 'errors' => array(), 'warnings' => array());
        if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK ||
            $_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 2097152 ||
            !is_uploaded_file($_FILES['file']['tmp_name'])) {
            $result['errors'][] = 'Pilih file Excel/CSV yang valid, maksimal 2 MB.';
        } elseif (!$this->db->field_exists('jam_lahir', 'reproduksi_kelahiran')) {
            $result['errors'][] = 'Penyimpanan detail kelahiran belum tersedia. Jalankan scripts/kelahiran_import_schema.php --apply pada server.';
        } else {
            $this->load->library('Kelahiran_import');
            try {
                $rows = $this->kelahiran_import->read($_FILES['file']['tmp_name'],
                    strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)), 16, array(3, 5), array(11));
                $parsed = $this->kelahiran_import->parse($rows);
                $result['errors'] = $parsed['errors'];
                $user = $this->utility->user_login();
                $scope = array('level_id' => $user->level_id,
                    'idfarm' => $this->M_user->get_idfarm($user->user_id),
                    'kodekoperasi' => $this->M_user->get_kodekoperasi($user->user_id));
                $saved = $this->M_kelahiran->import_records($parsed['records'], $scope);
                $result['success'] = $saved['success'];
                $result['calves'] = $saved['calves'];
                $result['errors'] = array_merge($result['errors'], $saved['errors']);
                $result['warnings'] = $saved['warnings'];
            } catch (Exception $e) {
                $result['errors'][] = $e->getMessage();
            }
        }
        $this->session->set_userdata('kelahiran_last_import_report', $result);
        if ($this->config->item('csrf_protection')) {
            $result['csrf'] = array('name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function hapus()
    {
		$this->M_kelahiran->delete();
		$this->session->set_flashdata('status_delete','success');
		redirect('/reproduksi/kelahiran');
    }
	 
}
