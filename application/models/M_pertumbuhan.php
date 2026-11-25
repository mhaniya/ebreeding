<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pertumbuhan extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idpengukuran',$id);
        }
        $this->db->select('pengukuran_bobotsapi.*,sapi.tagsapi,register.nomorregister');
        $this->db->join('sapi','sapi.idsapi=pengukuran_bobotsapi.idsapi');
        $this->db->join('register','sapi.idsapi=register.idsapi','left');
         return $this->db->get('pengukuran_bobotsapi');
    }
    public function getByIDSapi($id = null)
    {
        if($id != null){
            $this->db->where('sapi.idsapi',$id);
        }
        $this->db->select('pengukuran_bobotsapi.*,sapi.tagsapi,register.nomorregister');
        $this->db->join('sapi','sapi.idsapi=pengukuran_bobotsapi.idsapi');
        $this->db->join('register','sapi.idsapi=register.idsapi','left');
         return $this->db->get('pengukuran_bobotsapi');
    }
    public function get_data_json()
    {
        $table = "(SELECT pengukuran_bobotsapi.*,(lingkar_dada+18)*(lingkar_dada+18)/100 prediksi_bobot_badan, tagsapi, nomorregister,
                    datediff(curdate(), tgllahir)/365 umur 
                    FROM (`pengukuran_bobotsapi`) 
                    JOIN `sapi` ON `pengukuran_bobotsapi`.`idsapi`=`sapi`.`idsapi` 
                    LEFT JOIN `register` ON `pengukuran_bobotsapi`.`idsapi`=`register`.`idsapi`  
                    ORDER BY `pengukuran_bobotsapi`.`tanggal` DESC
                    ";
                        
			$table .= " ) temp";
			// $this->session->set_userdata('sql',$table);
			// Table's primary key
			$primaryKey = 'idpengukuran';

			$columns = array(
				array('db' => 'idpengukuran', 'dt' => 'idpengukuran'),
				array('db' => 'idsapi', 'dt' => 'idsapi'),
				array('db' => 'tagsapi', 'dt' => 'tagsapi'),
				array('db' => 'nomorregister', 'dt' => 'nomorregister'),
				array('db' => 'tanggal', 'dt' => 'tanggal'),
				array('db' => 'umur', 'dt' => 'umur'),
				array('db' => 'bobotkg', 'dt' => 'bobotkg'),
				array('db' => 'lingkar_dada', 'dt' => 'lingkar_dada'),
				array('db' => 'prediksi_bobot_badan', 'dt' => 'prediksi_bobot_badan'),
				array('db' => 'panjang_badan', 'dt' => 'panjang_badan'),
				array('db' => 'tinggi_gumba', 'dt' => 'tinggi_gumba'),
				array('db' => 'lingkar_skrotum', 'dt' => 'lingkar_skrotum'),
				array(
					'db' => 'idpengukuran',
					'dt' => 'aksi',
					'formatter' => function ($d) {
                        return "<div class='btn-group'><form action='/identifikasi/peternakan/edit' method='post'><button class='btn btn-warning btn-sm' name='id' value='$d'><i class='fas fa-pen'></i></button></form>
                        <button class='btn btn-danger btn-sm' id='hapusdata' data-id='$d'><i class='fas fa-trash'></i></button></div>";
					}
				),
			);
			// SQL server connection information
			$sql_details = array(
				'user' => $this->db->username,
				'pass' => $this->db->password,
				'db' => $this->db->database,
				'host' => 'localhost'
			);

			$db = Datatables_ssp::sql_connect($sql_details);
			$binding = array();

			return json_encode(
				Datatables_ssp::simple($_GET, $sql_details, $table, $primaryKey, $columns)
			);
    }

    public function get_json_report()
    {
        $sql="SELECT sapi.idsapi,sapi.tagsapi,substr(sapi.tgllahir,1,10) tgllahir, sapi.bobotlahir,register.nomorregister, kodepropinsi, kodekabupaten, kodekecamatan, farm.idfarm, datediff(curdate(), tgllahir)/365 umur 
        ,(SELECT substr(p.tanggal,1,10) FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 1,1) tanggal1
        ,(SELECT p.bobotkg FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 1,1) bobotkg1
        ,(SELECT p.bobotkg-sapi.bobotlahir FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 1,1) selisih1
        ,(SELECT substr(p.tanggal,1,10) FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 2,1) tanggal2
        ,(SELECT p.bobotkg FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 2,1) bobotkg2
        ,(SELECT p.bobotkg-sapi.bobotlahir FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 2,1) selisih2
        ,(SELECT substr(p.tanggal,1,10) FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 3,1) tanggal3
        ,(SELECT p.bobotkg FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 3,1) bobotkg3
        ,(SELECT p.bobotkg-sapi.bobotlahir FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 3,1) selisih3
        ,(SELECT substr(p.tanggal,1,10) FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 4,1) tanggal4
        ,(SELECT p.bobotkg FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 4,1) bobotkg4
        ,(SELECT p.bobotkg-sapi.bobotlahir FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 4,1) selisih4
        ,(SELECT substr(p.tanggal,1,10) FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 5,1) tanggal5
        ,(SELECT p.bobotkg FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 5,1) bobotkg5
        ,(SELECT p.bobotkg-sapi.bobotlahir FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 5,1) selisih5
        ,(SELECT substr(p.tanggal,1,10) FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 6,1) tanggal6
        ,(SELECT p.bobotkg FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 6,1) bobotkg6
        ,(SELECT p.bobotkg-sapi.bobotlahir FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 6,1) selisih6
        ,(SELECT substr(p.tanggal,1,10) FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 7,1) tanggal7
        ,(SELECT p.bobotkg FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 7,1) bobotkg7
        ,(SELECT p.bobotkg-sapi.bobotlahir FROM pengukuran_bobotsapi p WHERE p.idsapi=sapi.idsapi ORDER BY tanggal LIMIT 7,1) selisih7
        
        FROM (`pengukuran_bobotsapi`) 
        JOIN `sapi` ON `pengukuran_bobotsapi`.`idsapi`=`sapi`.`idsapi` 
        LEFT JOIN `register` ON `sapi`.`idsapi`=`register`.`idsapi` 
        JOIN `farm` ON `farm`.`idfarm`=`sapi`.`idfarm`
        WHERE 1 ";
        
        
        $kodepropinsi  = $this->session->userdata('kodepropinsi');
        $kodekabupaten = $this->session->userdata('kodekabupaten');
        $kodekecamatan = $this->session->userdata('kodekecamatan');
        $idfarm = $this->session->userdata('idfarm');
        $tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
        $bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
        // $tanggal = $this->session->userdata('tanggal');
        // $xlaktasi = $this->session->userdata('xlaktasi');

        if(($kodepropinsi!="")&&($kodepropinsi!="0")) $sql .=" AND kodepropinsi='$kodepropinsi'";
        if(($kodekabupaten!="")&&($kodekabupaten!="0")) $sql .=" AND kodekabupaten='$kodekabupaten'";
        if(($kodekecamatan!="")&&($kodekecamatan!="0")) $sql .=" AND kodekecamatan='$kodekecamatan'";
        if(($idfarm!="")&&($idfarm!="0")) $sql .=" AND farm.idfarm='$idfarm'";
        if(($tahun!="")&&($tahun!="0")) $sql .=" AND YEAR(pengukuran_bobotsapi.tanggal)='$tahun'";
        if(($bulan!="")&&($bulan!="0")) $sql .=" AND MONTH(pengukuran_bobotsapi.tanggal)='$bulan'";
        
        $sql .=" GROUP BY `sapi`.`idsapi` ORDER BY `sapi`.`tagsapi` desc";
        $rs=$this->db->query($sql);
        echo json_encode($rs->result());
    }
    public function get_json($kodepropinsi,$kodekabupaten,$kodekecamatan,$idfarm,$bulan,$tahun)
    {
        $this->datatables->select('pengukuran_bobotsapi.idpengukuran,pengukuran_bobotsapi.idsapi,DATE_FORMAT(pengukuran_bobotsapi.tanggal,"%Y-%m-%d") tanggal,pengukuran_bobotsapi.bobotkg
        ,pengukuran_bobotsapi.lingkar_dada,pengukuran_bobotsapi.panjang_badan,pengukuran_bobotsapi.tinggi_gumba,pengukuran_bobotsapi.lingkar_skrotum
        ,(lingkar_dada+18)*(lingkar_dada+18)/100 as prediksi_bobot_badan, tagsapi, nomorregister,datediff(curdate(), tgllahir)/365 as umur ') ;
        $this->datatables->from('pengukuran_bobotsapi');
        $this->datatables->join('sapi','sapi.idsapi=pengukuran_bobotsapi.idsapi');
        $this->datatables->join('farm','farm.idfarm=sapi.idfarm');
        $this->datatables->join('register','sapi.idsapi=register.idsapi','left');
        
        if(($tahun<>"")&&($tahun<>"0")) $this->datatables->where('YEAR(pengukuran_bobotsapi.tanggal)',$tahun);
        if(($bulan<>"")&&($bulan<>"0")) $this->datatables->where('MONTH(pengukuran_bobotsapi.tanggal)',$bulan);
        if(($kodepropinsi<>"")&&($kodepropinsi<>"0")) $this->datatables->where('kodepropinsi',$kodepropinsi);
        if(($kodekabupaten<>"")&&($kodekabupaten<>"0")) $this->datatables->where('kodekabupaten',$kodekabupaten);
        if(($kodekecamatan<>"")&&($kodekecamatan<>"0")) $this->datatables->where('kodekecamatan',$kodekecamatan);
        if(($idfarm<>"")&&($idfarm<>"0")) $this->datatables->where('farm.idfarm',$idfarm);

        $this->datatables->order_by('pengukuran_bobotsapi.tanggal DESC,sapi.tagsapi');
        $this->datatables->add_column('aksi','<div class="btn-group"><button id="editdata" data-id="$1" class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button>
        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idpengukuran');
        
        return $this->datatables->generate();
    }
    
    
    public function import_records($records, $scope)
    {
        $result = array('success' => 0, 'errors' => array(), 'warnings' => array());
        foreach ($records as $record) {
            $label = 'Baris ' . $record['line'] . ' (' . $record['tagsapi'] . ')';
            $sql = "SELECT idsapi FROM sapi WHERE tagsapi = ? AND (tipesapi IS NULL OR tipesapi <> 'Semen')";
            $params = array($record['tagsapi']);
            if ($scope['level_id'] == 2) {
                $sql .= ' AND idfarm IN (SELECT idfarm FROM farm WHERE kodekoperasi = ?)';
                $params[] = $scope['kodekoperasi'];
            } elseif ($scope['level_id'] == 4) {
                $sql .= ' AND idfarm = ?';
                $params[] = $scope['idfarm'];
            }
            if (!empty($scope['selected_farm'])) {
                $sql .= ' AND idfarm = ?';
                $params[] = $scope['selected_farm'];
            }
            $cows = $this->db->query($sql, $params)->result();
            if (count($cows) !== 1) {
                $result['errors'][] = $label . ': sapi tidak ditemukan, tag ganda, atau di luar peternakan/akses pengguna.';
                continue;
            }
            $idsapi = $cows[0]->idsapi;
            $data = array('idsapi' => $idsapi, 'tanggal' => $record['tanggal'],
                'bobotkg' => $record['bobotkg'], 'lingkar_dada' => $record['lingkar_dada'],
                'panjang_badan' => $record['panjang_badan'], 'tinggi_gumba' => $record['tinggi_gumba'],
                'lingkar_skrotum' => $record['lingkar_skrotum']);
            $this->db->trans_begin();
            $existing = $this->db->query(
                'SELECT idpengukuran FROM pengukuran_bobotsapi WHERE idsapi = ? AND tanggal >= ? AND tanggal < DATE_ADD(?, INTERVAL 1 DAY) FOR UPDATE',
                array($idsapi, $record['tanggal'], $record['tanggal']))->result();
            if (count($existing) > 1) {
                $this->db->trans_rollback();
                $result['errors'][] = $label . ': terdapat beberapa pengukuran pada tanggal tersebut; perbaiki data ganda sebelum import.';
                continue;
            }
            if ($existing) {
                unset($data['tanggal']); // Retain any time component on an existing measurement.
                $this->db->where('idpengukuran', $existing[0]->idpengukuran);
                $saved = $this->db->update('pengukuran_bobotsapi', $data);
            } else {
                $data['tglinput'] = date('Y-m-d H:i:s');
                $saved = $this->db->insert('pengukuran_bobotsapi', $data);
            }
            if (!$saved || !$this->db->trans_status()) {
                $this->db->trans_rollback();
                $result['errors'][] = $label . ': gagal disimpan.';
            } else {
                $this->db->trans_commit();
                $result['success']++;
            }
        }
        return $result;
    }

    public function save()
    {

        $data = [
            'idpengukuran' => '',
            'idsapi' => htmlspecialchars($this->input->post('idsapi')),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'bobotkg' => htmlspecialchars($this->input->post('bobotkg')),
            'lingkar_dada' => htmlspecialchars($this->input->post('lingkar_dada')),
            'panjang_badan' => htmlspecialchars($this->input->post('panjang_badan')),
            'tinggi_gumba' => htmlspecialchars($this->input->post('tinggi_gumba')) ,
            'lingkar_skrotum' => htmlspecialchars($this->input->post('lingkar_skrotum')),
            'tglinput' => date('Y-m-d')
        ];
        $this->db->insert('pengukuran_bobotsapi',$data);
    }
    public function update()
    {
        $id = $this->input->post('idpengukuran');
        $data = [
            'idsapi' => htmlspecialchars($this->input->post('idsapi')),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'bobotkg' => htmlspecialchars($this->input->post('bobotkg')),
            'lingkar_dada' => htmlspecialchars($this->input->post('lingkar_dada')),
            'panjang_badan' => htmlspecialchars($this->input->post('panjang_badan')),
            'tinggi_gumba' => htmlspecialchars($this->input->post('tinggi_gumba')) ,
            'lingkar_skrotum' => htmlspecialchars($this->input->post('lingkar_skrotum'))
        ];
        $this->db->where('idpengukuran',$id);
        $this->db->update('pengukuran_bobotsapi',$data);
    }
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idpengukuran',$id);
        $this->db->delete('pengukuran_bobotsapi');
    }
}
