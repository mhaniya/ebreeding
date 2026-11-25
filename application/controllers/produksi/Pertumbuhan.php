<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pertumbuhan extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_pertumbuhan','M_propinsi','M_kabupaten','M_kecamatan','M_farm']);
		$this->session->set_userdata('menu','produksi');
		$this->session->set_userdata('submenu','pertumbuhan');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//pertumbuhantara di controller
		 
		$data['judul']="Data Pertumbuhan";
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
		// $data['xlaktasi']=$this->session->userdata('xlaktasi'); 
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('produksi/pertumbuhan/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('produksi/pertumbuhan/footer');
		
	}
	public function getByIDSapi($idsapi)
	{
		return $this->M_pertumbuhan->getByIDSapi($idsapi);

	}
	public function ajax_tabel()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_pertumbuhan->get_data_json();
		}
	}
	public function test()
	{
		echo "Ini hanya test";
	}
	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			$user = $this->utility->user_login();
			$id_user=$user->user_id;
			$kodepropinsi=($this->session->has_userdata("kodepropinsi")?$this->session->userdata("kodepropinsi"):$this->M_user->get_kodepropinsi($id_user));
			$kodekabupaten=($this->session->has_userdata("kodekabupaten")?$this->session->userdata("kodekabupaten"):$this->M_user->get_kodekabupaten($id_user));
			$kodekecamatan=($this->session->has_userdata("kodekecamatan")?$this->session->userdata("kodekecamatan"):$this->M_user->get_kodekecamatan($id_user));
			
			$idfarm=($this->session->has_userdata("idfarm")?$this->session->userdata("idfarm"):$this->M_user->get_idfarm($id_user));
			$tahun=$this->session->has_userdata('tahun')?$this->session->userdata('tahun'):date('Y');
			$bulan=$this->session->has_userdata('bulan')?$this->session->userdata('bulan'):date('m'); 
			
			echo $this->M_pertumbuhan->get_json($kodepropinsi,$kodekabupaten,$kodekecamatan,$idfarm,$bulan,$tahun);
		}
	}
	
	public function get_data_by_idpengukuran($id)
	{
		echo json_encode($this->M_pertumbuhan->get($id)->row());
	}

	public function save()
    {
		$this->M_pertumbuhan->save();
		$this->session->set_flashdata('status_insert','success');
		redirect('/produksi/pertumbuhan');

    }
    public function add()
    {
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Tambah Data Pertumbuhan";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('produksi/pertumbuhan/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('produksi/pertumbuhan/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['rs'] = $this->M_pertumbuhan->get($id)->row();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data Pertumbuhan";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('produksi/pertumbuhan/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('produksi/pertumbuhan/footer');
    }
     
    public function update()
    {
		$this->M_pertumbuhan->update(); 
		$this->session->set_flashdata('status_update','success');
        redirect('/produksi/pertumbuhan');
	}
	
    public function import()
    {
        $result = array('success' => 0, 'errors' => array(), 'warnings' => array());
        if ($this->input->method(true) !== 'POST') {
            $this->output->set_status_header(405);
            $result['errors'][] = 'Import harus menggunakan POST.';
        } elseif (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK ||
            $_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 2097152 ||
            !is_uploaded_file($_FILES['file']['tmp_name'])) {
            $result['errors'][] = 'Pilih file .xlsx, .xls, atau .csv yang valid, maksimal 2 MB.';
        } else {
            $this->load->library('Pertumbuhan_import');
            try {
                $rows = $this->pertumbuhan_import->read($_FILES['file']['tmp_name'],
                    strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)));
                $parsed = $this->pertumbuhan_import->parse($rows);
                $user = $this->utility->user_login();
                $scope = array('level_id' => $user->level_id,
                    'idfarm' => $this->M_user->get_idfarm($user->user_id),
                    'kodekoperasi' => $this->M_user->get_kodekoperasi($user->user_id),
                    'selected_farm' => $this->session->userdata('idfarm'));
                $saved = $this->M_pertumbuhan->import_records($parsed['records'], $scope);
                $result['success'] = $saved['success'];
                $result['errors'] = array_merge($parsed['errors'], $saved['errors']);
                $result['warnings'] = $saved['warnings'];
            } catch (Exception $e) {
                log_message('error', 'Import pertumbuhan gagal: ' . $e->getMessage());
                $result['errors'][] = 'File gagal diproses. Periksa format file atau log aplikasi.';
            }
        }
        $this->session->set_userdata('pertumbuhan_last_import_report', $result);
        if ($this->config->item('csrf_protection')) {
            $result['csrf'] = array('name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash());
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function hapus()
    {
		$this->M_pertumbuhan->delete();
		$this->session->set_flashdata('status_delete','success');
		redirect('/produksi/pertumbuhan');
    }
	 
}
