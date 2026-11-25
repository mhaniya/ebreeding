<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Susu_vertikal extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_susu','M_propinsi','M_kabupaten','M_kecamatan','M_user','M_farm']);
		$this->session->set_userdata('menu','produksi');
		$this->session->set_userdata('submenu','susu_vertikal');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//susu_vertikaltara di controller
		 
		$data['judul']="Data Produksi Susu (Vertikal)";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
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
		$chktanggal=$this->session->userdata('chktanggal'); 
		if($chktanggal=="")$chktanggal=false;
		$data['chktanggal']=$chktanggal; 
		$this->session->set_userdata('chktanggal',$chktanggal);
		$data['tanggal']=$this->session->userdata('tanggal'); 
		
		$data['xlaktasi']=$this->session->userdata('xlaktasi'); 
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('produksi/susu_vertikal/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('produksi/susu_vertikal/footer');
		
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
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			echo $this->M_susu->get_json();  
		// }
	}
	public function getProduksiPerLaktasiByIDSapi($id)
	{
		$data['data']=$this->M_susu->getProduksiPerLaktasiByIDSapi($id)->result();
		echo json_encode($data);
	}
	public function get_data_by_idpengukuran($id)
	{
		echo json_encode($this->M_susu->get($id)->row());
	}

	public function save()
    {
		$this->M_susu->save();
		$this->session->set_flashdata('status_insert','success');
		redirect('/produksi/susu_vertikal');

    }
    public function add()
    {
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Tambah Data Susu";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('produksi/susu_vertikal/form_tambah',$data);
		$this->load->view('layout/footer');
		$this->load->view('produksi/susu_vertikal/footer');

    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['rs'] = $this->M_susu->get($id)->row();
		$data['user'] = $this->utility->user_login();
        $data['judul'] = "Edit Data Susu";
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('produksi/susu_vertikal/form_edit',$data);
		$this->load->view('layout/footer');
		$this->load->view('produksi/susu_vertikal/footer');
    }
     
    public function update()
    {
		$this->M_susu->update(); 
		$this->session->set_flashdata('status_update','success');
        redirect('/produksi/susu_vertikal');
	}
	
    public function hapus()
    {
		$this->M_susu->delete(); 
		$this->session->set_flashdata('status_delete','success');
		redirect('/produksi/susu_vertikal');
    }
    public function upload($jenis)
    {
        $respon = array('status' => 'err');
        if (!in_array($jenis, array('per_tanggal', 'per_bulan'), true) ||
            empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode($respon);
            return;
        }

        $file = $_FILES['file'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, array('xlsx', 'xls', 'csv'), true)) {
            $respon['status'] = 'type_err';
        } elseif ($file['size'] > 0 && $file['size'] <= 2097152) {
            $namaFile = uniqid('susu_', true) . '.' . $extension;
            $targetDir = FCPATH . 'assets/files/upload/susu/' . $jenis . '/';
            if ((is_dir($targetDir) || mkdir($targetDir, 0755, true)) &&
                move_uploaded_file($file['tmp_name'], $targetDir . $namaFile)) {
                $respon['status'] = 'ok|' . $namaFile;
            }
        }
        echo json_encode($respon);
    }

    public function import($jenis)
    {
        if (!in_array($jenis, array('per_tanggal', 'per_bulan'), true)) {
            show_error('Jenis import tidak valid.', 400);
            return;
        }

        $filename = basename((string) $this->input->post('namafile'));
        $file = FCPATH . 'assets/files/upload/susu/' . $jenis . '/' . $filename;
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!is_file($file) || !in_array($extension, array('xlsx', 'xls', 'csv'), true)) {
            $this->import_result(0, 0, 'File import tidak ditemukan atau format tidak didukung.<br>');
            return;
        }

        $tanggalSession = $this->import_date($this->session->userdata('tanggal'));
        if ($jenis === 'per_tanggal' && $tanggalSession === false) {
            $this->import_result(0, 0, 'Pilih tanggal produksi yang valid sebelum import per tanggal.<br>');
            return;
        }

        $rows = array();
        if ($extension === 'xlsx') {
            $this->load->library('Ib_import');
            try {
                $rows = $this->ib_import->read($file, 'xlsx',
                    $jenis === 'per_bulan' ? 5 : 4, $jenis === 'per_bulan' ? array(2) : array());
            } catch (Exception $e) {
                $this->import_result(0, 0, htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '<br>');
                return;
            }
        } elseif ($extension === 'csv') {
            $handle = fopen($file, 'r');
            $firstLine = fgets($handle);
            if ($firstLine === false) {
                fclose($handle);
                $this->import_result(0, 0, 'File import kosong.<br>');
                return;
            }
            $delimiter = ',';
            foreach (array(';', "\t") as $candidate) {
                if (count(str_getcsv($firstLine, $candidate)) > count(str_getcsv($firstLine, $delimiter))) {
                    $delimiter = $candidate;
                }
            }
            rewind($handle);
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                $rows[] = $row;
            }
            fclose($handle);
        } else {
            $this->load->library('excel_reader');
            $this->excel_reader->setOutputEncoding('UTF-8');
            $this->excel_reader->read($file);
            if (empty($this->excel_reader->sheets[0])) {
                $this->import_result(0, 0, 'Sheet pertama tidak dapat dibaca.<br>');
                return;
            }
            $sheet = $this->excel_reader->sheets[0];
            for ($i = 1; $i <= $sheet['numRows']; $i++) {
                $row = array();
                for ($j = 1; $j <= ($jenis === 'per_bulan' ? 5 : 4); $j++) {
                    $row[] = isset($sheet['cells'][$i][$j]) ? $sheet['cells'][$i][$j] : '';
                }
                // Excel's reader supplies Unix timestamps for date-formatted cells.
                if ($jenis === 'per_bulan' && isset($sheet['cellsInfo'][$i][2]['type']) &&
                    $sheet['cellsInfo'][$i][2]['type'] === 'date' &&
                    isset($sheet['cellsInfo'][$i][2]['raw'])) {
                    $row[1] = date('Y-m-d', $sheet['cellsInfo'][$i][2]['raw']);
                }
                $rows[] = $row;
            }
        }

        $user = $this->utility->user_login();
        $kodekoperasi = $this->M_user->get_kodekoperasi($user->user_id);
        $idfarm = $this->M_user->get_idfarm($user->user_id);
        $nSukses = 0;
        $nError = 0;
        $log = '';
        foreach ($rows as $index => $row) {
            if ($index === 0 || trim(implode('', $row)) === '') {
                continue;
            }
            $line = $index + 1;
            $offset = $jenis === 'per_bulan' ? 1 : 0;
            $tagsapi = $this->import_tag(isset($row[0]) ? $row[0] : '');
            $tanggal = $offset ? $this->import_date(isset($row[1]) ? $row[1] : '') : $tanggalSession;
            $pagi = str_replace(',', '.', trim(isset($row[1 + $offset]) ? $row[1 + $offset] : ''));
            $sore = str_replace(',', '.', trim(isset($row[2 + $offset]) ? $row[2 + $offset] : ''));
            $kandang = trim(isset($row[3 + $offset]) ? $row[3 + $offset] : '');
            $label = 'Baris ' . $line . ' (' . htmlspecialchars($tagsapi, ENT_QUOTES, 'UTF-8') . ')';
            if (count($row) < 4 + $offset || $tagsapi === '' || $tanggal === false ||
                !is_numeric($pagi) || !is_numeric($sore) || $pagi < 0 || $sore < 0 ||
                !is_finite((float) $pagi) || !is_finite((float) $sore) ||
                mb_strlen($kandang, 'UTF-8') > 10) {
                $nError++;
                $log .= $label . ': dilewati; periksa urutan kolom, tanggal, angka produksi, dan kandang (maksimal 10 karakter).<br>';
                continue;
            }

            $sql = 'SELECT idsapi FROM sapi WHERE tagsapi = ?';
            $params = array($tagsapi);
            if ($user->level_id == 2) {
                $sql .= ' AND idfarm IN (SELECT idfarm FROM farm WHERE kodekoperasi = ?)';
                $params[] = $kodekoperasi;
            } elseif ($user->level_id == 4) {
                $sql .= ' AND idfarm = ?';
                $params[] = $idfarm;
            }
            $sapi = $this->db->query($sql, $params)->row();
            if (!$sapi) {
                $nError++;
                $log .= $label . ': tag sapi belum terdaftar atau di luar akses pengguna.<br>';
                continue;
            }

            $kelahiran = $this->db->query(
                'SELECT xlaktasi FROM reproduksi_kelahiran WHERE idsapi = ? AND tanggal <= ? ORDER BY tanggal DESC, idkelahiran DESC LIMIT 1',
                array($sapi->idsapi, $tanggal)
            )->row();
            $xlaktasi = $kelahiran && (int) $kelahiran->xlaktasi > 0 ? (int) $kelahiran->xlaktasi : 1;
            $saved = $this->db->query(
                'INSERT INTO pengukuran_produksisusu (idsapi, tanggal, pagi, sore, kandang, xlaktasi)
                 VALUES (?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE pagi = VALUES(pagi), sore = VALUES(sore),
                 kandang = VALUES(kandang), xlaktasi = VALUES(xlaktasi)',
                array($sapi->idsapi, $tanggal, (float) $pagi, (float) $sore, $kandang, $xlaktasi)
            );
            if ($saved) {
                $nSukses++;
                $log .= $label . ': tanggal ' . $tanggal . ' berhasil disimpan, laktasi ' . $xlaktasi . '.<br>';
            } else {
                $nError++;
                $log .= $label . ': gagal disimpan.<br>';
            }
        }
        $this->import_result($nSukses, $nError, $log);
    }

    private function import_tag($value)
    {
        // Convert Excel's non-breaking spaces into regular spaces, preserving
        // meaningful separators in tags such as "2691 IM" and all leading zeros.
        $value = str_replace(array("\xC2\xA0", "\xE2\x80\xAF", "\xE2\x80\x87"), ' ', (string) $value);
        // Remove invisible copy/paste markers (BOM and zero-width characters).
        $value = str_replace(array("\xEF\xBB\xBF", "\xE2\x80\x8B", "\xE2\x80\x8C", "\xE2\x80\x8D", "\xE2\x81\xA0"), '', $value);
        return trim($value);
    }

    private function import_date($value)
    {
        $value = trim((string) $value);
        foreach (array('Y-m-d', 'd/m/Y', 'd-m-Y') as $format) {
            $date = DateTime::createFromFormat('!' . $format, $value);
            if ($date && $date->format($format) === $value) {
                return $date->format('Y-m-d');
            }
        }
        return false;
    }

    private function import_result($success, $errors, $log)
    {
        $summary = 'Import selesai: ' . $success . ' baris berhasil, ' . $errors . ' baris dilewati.';
        $this->session->set_userdata('susu_last_import_report', $summary . '<br><br>' . $log);
        $this->session->set_flashdata('susu_show_import_report', true);
        $this->session->set_flashdata('status_info', $summary);
        echo $summary . '<br><br>' . $log;
    }
}
