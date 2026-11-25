<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ib extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_ib','M_propinsi','M_kabupaten','M_kecamatan','M_farm','M_user']);
		$this->session->set_userdata('menu','reproduksi');
		$this->session->set_userdata('submenu','ib');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//susu_vertikaltara di controller
		 
		$data['judul']="Data Inseminasi Buatan";
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
		$this->load->view('reproduksi/ib/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('reproduksi/ib/footer');
		
	}
	
	public function get_data_ib_today()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			$rs= $this->M_ib->get_json_ib_today();
			echo $rs;
		}
	}
	
	public function get_pengamatan_birahi_today()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			$rs= $this->M_ib->get_pengamatan_birahi_today();
			$data['recordsTotal']=$rs->num_rows();
			$data['recordsFiltered']=$rs->num_rows();
			$data['data']=$rs->result();
			echo json_encode($data);
		// }
	}
	
	public function get_prediksibirahi()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			$rs= $this->M_ib->get_prediksibirahi();
			$data['recordsTotal']=$rs->num_rows();
			$data['recordsFiltered']=$rs->num_rows();
			$data['data']=$rs->result();
			echo json_encode($data);
		// }
	}
	
	public function get_prediksikelahiran()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			$rs= $this->M_ib->get_prediksikelahiran();
			
			echo $rs;
		// }
	}
	
	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_ib->get_json();
		}
	}
	
	public function get_data_sapi_belum_ib()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_ib->get_json_sapi_belum_ib();
		}
	}
	public function get_data_sapi_belum_pkb()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			echo $this->M_ib->get_json_sapi_belum_pkb();
		// }
	}
	 
	public function get_data_sapi_dara_belum_ib()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			echo $this->M_ib->get_json_sapi_dara_belum_ib();
		// }
	}
	 
	public function get_data_by_id($id)
	{
		echo json_encode($this->M_ib->get($id)->row());
	}

	public function save()
    {
		$this->M_ib->save();
		echo $this->db->last_query();
		$this->session->set_flashdata('status_insert','success');
		redirect('/reproduksi/ib');

    }
    public function add()
    {
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Tambah Data Inseminasi Buatan";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('reproduksi/ib/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('reproduksi/ib/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['rs'] = $this->M_ib->get($id)->row();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data Inseminasi Buatan";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('reproduksi/ib/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('reproduksi/ib/footer');
    }
     
    public function update()
    { 
		$this->M_ib->update(); 
		$this->session->set_flashdata('status_update','success');
        redirect('/reproduksi/ib');
	}
	
    public function import()
    {
        $result = array('success' => 0, 'errors' => array(), 'warnings' => array());
        if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK ||
            $_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 2097152 ||
            !is_uploaded_file($_FILES['file']['tmp_name'])) {
            $result['errors'][] = 'Pilih file Excel/CSV yang valid, maksimal 2 MB.';
        } else {
            $this->load->library('Ib_import');
            try {
                $rows = $this->ib_import->read($_FILES['file']['tmp_name'],
                    strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)));
                $parsed = $this->ib_import->parse($rows);
                $result['errors'] = $parsed['errors'];
                $user = $this->utility->user_login();
                $scope = array('level_id' => $user->level_id,
                    'idfarm' => $this->M_user->get_idfarm($user->user_id),
                    'kodekoperasi' => $this->M_user->get_kodekoperasi($user->user_id));
                $saved = $this->M_ib->import_records($parsed['records'], $scope);
                $result['success'] = $saved['success'];
                $result['errors'] = array_merge($result['errors'], $saved['errors']);
                $result['warnings'] = $saved['warnings'];
            } catch (Exception $e) {
                $result['errors'][] = $e->getMessage();
            }
        }
        $this->session->set_userdata('ib_last_import_report', $result);
        if ($this->config->item('csrf_protection')) {
            $result['csrf'] = array('name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function hapus()
    {
		$this->M_ib->delete();
		$this->session->set_flashdata('status_delete','success');
		redirect('/reproduksi/ib');
    }
	 
}
