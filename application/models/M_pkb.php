<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pkb extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idpkb',$id);
        }
        $this->db->select("reproduksi_pkb.idpkb,SUBSTR(reproduksi_pkb.tanggal,1,10) as tanggal,reproduksi_pkb.hasil,reproduksi_pkb.keterangan
                    ,sapi.tagsapi,sapi.idsapi,register.nomorregister,reproduksi_pkb.idpetugas,
                    COALESCE(NULLIF(petugas.nama,''),reproduksi_pkb.petugas) as namapetugas");
		$this->db->join('sapi','reproduksi_pkb.idsapi=sapi.idsapi');
		$this->db->join('register','register.idsapi=sapi.idsapi','left');
		$this->db->join('petugas','petugas.idpetugas=reproduksi_pkb.idpetugas','left');
		$this->db->join('farm','farm.idfarm=sapi.idfarm','left');
        return $this->db->get('reproduksi_pkb');
    }
    public function get_json()
    {
        
        $this->datatables->select("pkb.idpkb,SUBSTR(pkb.tanggal,1,10) as tanggal,pkb.hasil,pkb.keterangan,sapi.tagsapi,register.nomorregister,COALESCE(NULLIF(petugas.nama,''),pkb.petugas) as namapetugas");
        $this->datatables->select($this->db->field_exists('hpl', 'reproduksi_pkb') ? 'pkb.hpl' : 'NULL as hpl', false);
		$this->datatables->from('reproduksi_pkb pkb');
		$this->datatables->join('sapi','pkb.idsapi=sapi.idsapi');
		$this->datatables->join('register','register.idsapi=sapi.idsapi','left');
		$this->datatables->join('petugas','petugas.idpetugas=pkb.idpetugas','left');
        $this->datatables->join('farm','farm.idfarm=sapi.idfarm');
        
        $kodepropinsi  = $this->session->userdata('kodepropinsi');
        $kodekabupaten = $this->session->userdata('kodekabupaten');
        $kodekecamatan = $this->session->userdata('kodekecamatan');
        $idfarm = $this->session->userdata('idfarm');
        $tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
        $bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
        $tanggal = $this->session->userdata('tanggal');
        $xlaktasi = $this->session->userdata('xlaktasi');
        
        if($kodepropinsi!="") $this->datatables->where('kodepropinsi',$kodepropinsi);
        if($kodekabupaten!="") $this->datatables->where('kodekabupaten',$kodekabupaten);
        if($kodekecamatan!="") $this->datatables->where('kodekecamatan',$kodekecamatan);
        if(($idfarm!="")&&($idfarm!="0")) $this->datatables->where('farm.idfarm',$idfarm);
        if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(pkb.tanggal)',$tahun);
        if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(pkb.tanggal)',$bulan);
        if(($tanggal!=""))  $this->datatables->where('pkb.tanggal',$tanggal);
        if(($xlaktasi==-1)){
            $this->datatables->where('laktasike=maxxlaktasi');
        }else   
        if(($xlaktasi!="")&&($xlaktasi!="0"))  
            $this->datatables->where('laktasike',$xlaktasi);

        $this->datatables->add_column('aksi','<div class="btn-group">
        <button class="btn btn-warning" id="editdata" data-id="$1"><i class="fas fa-pen"></i></button>
        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button>
        </div>'
        ,'idpkb');
        
        return $this->datatables->generate();
    }
    
    public function get_json_pkb_today()
    {
        $this->datatables->select('tagsapi,DATE_FORMAT(reproduksi_pkb.tanggal,"%Y-%m-%d") as tanggal,hasil,petugas.nama');
        $this->datatables->from('reproduksi_pkb');
        $this->datatables->join('sapi','sapi.idsapi=reproduksi_pkb.idsapi');
        $this->datatables->join('petugas','petugas.idpetugas=reproduksi_pkb.idpetugas');
        $this->datatables->where('reproduksi_pkb.tanggal',date('Y-m-d'));
        
        return $this->datatables->generate();
    }
    public function get_json_should_pkb_today()
    {
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
        $idfarm=$this->M_user->get_idfarm($id_user);
        

        $this->datatables->select('reproduksi_ib.*,sapi.tagsapi,farm.namafarm,register.nomorregister,DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal) as umurkawin');
        $this->datatables->from('reproduksi_ib');
        $this->datatables->join('sapi','sapi.idsapi=reproduksi_ib.idsapi');
        $this->datatables->join('register','sapi.idsapi=register.idsapi');
        $this->datatables->join('farm','sapi.idfarm=farm.idfarm');
        $this->datatables->where('sapi.`status`', 'hidup');
        $this->datatables->where('sapi.idsapi NOT IN (select idsapi from reproduksi_pkb WHERE reproduksi_pkb.tanggal>reproduksi_ib.tanggal)');
        $this->datatables->where('DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal) BETWEEN 60 AND 65');

        if(($idfarm<>"")&&($idfarm<>"0")){
            $this->datatables->where('sapi.idfarm',$idfarm);
        }
        
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
            $cows = $this->db->query($sql, $params)->result();
            if (count($cows) !== 1) {
                $result['errors'][] = $label . ': EAR TAG tidak ditemukan, ganda, atau di luar akses pengguna.';
                continue;
            }
            $ib = $this->db->query(
                'SELECT idib, ibke, kodesemen, petugas FROM reproduksi_ib WHERE idsapi = ? AND tanggal = ?',
                array($cows[0]->idsapi, $record['tanggal_ib']))->row();
            if (!$ib) {
                $result['errors'][] = $label . ': IB tanggal ' . $record['tanggal_ib'] . ' belum tercatat; import/tambahkan IB terlebih dahulu.';
                continue;
            }
            if ((int) $ib->ibke !== $record['ibke'] ||
                trim((string) $ib->kodesemen) !== $record['kodesemen']) {
                $result['errors'][] = $label . ': IB Ke atau kode straw berbeda dari IB yang tercatat.';
                continue;
            }
            $officers = $this->db->query('SELECT idpetugas FROM petugas WHERE TRIM(nama) = ?',
                array($record['petugas']))->result();
            if (count($officers) > 1) {
                $result['errors'][] = $label . ': nama petugas PKB ganda; perbaiki master petugas terlebih dahulu.';
                continue;
            }
            $idpetugas = $officers ? $officers[0]->idpetugas : 0;
            $data = array($cows[0]->idsapi, $record['tanggal'], $record['hasil'], $idpetugas,
                $record['petugas'], $record['keterangan'], date('Y-m-d'), $ib->idib, $record['hpl']);
            $saved = $this->db->query(
                'INSERT INTO reproduksi_pkb (idsapi, tanggal, hasil, idpetugas, petugas, keterangan, tglinput, idib, hpl)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE hasil = VALUES(hasil), idpetugas = VALUES(idpetugas),
                 petugas = VALUES(petugas), keterangan = VALUES(keterangan), tglinput = VALUES(tglinput),
                 idib = VALUES(idib), hpl = VALUES(hpl)',
                $data);
            if ($saved) {
                $result['success']++;
                if (!$officers) {
                    $result['warnings'][] = $label . ': nama petugas PKB disimpan, tetapi belum terhubung ke master petugas.';
                }
                if (strcasecmp(trim((string) $ib->petugas), $record['petugas_ib']) !== 0) {
                    $result['warnings'][] = $label . ': nama petugas IB pada file berbeda dari data IB; PKB tetap dihubungkan berdasarkan tanggal, IB Ke, dan kode straw.';
                }
            } else {
                $result['errors'][] = $label . ': gagal disimpan.';
            }
        }
        return $result;
    }

    public function save()
    {
        $data = [
            'idpkb' => '',
            'idsapi' => $this->input->post('idsapi'),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'hasil' => $this->input->post('hasil'),
            'idpetugas' => $this->input->post('idpetugas'),
            'petugas' => $this->input->post('petugas'),
            'keterangan' => htmlspecialchars($this->input->post('keterangan')),
            'tglinput' => date('Y-m-d')
        ];
        $this->db->insert('reproduksi_pkb',$data);
    }
    public function update()
    {
        $id = $this->input->post('id');
        $data = [
            'idsapi' => $this->input->post('idsapi'),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'hasil' => $this->input->post('hasil'),
            'idpetugas' => $this->input->post('idpetugas'),
            'petugas' => $this->input->post('petugas'),
            'keterangan' => htmlspecialchars($this->input->post('keterangan')),
            'tglinput' => date('Y-m-d')
        ];
        $this->db->where('idpkb',$id);
        $this->db->update('reproduksi_pkb',$data);
    }
    public function updatepass()
    {
        $id = $this->input->post('idpkb');
        $data = [
            'user_password' => sha1($this->input->post('pass1')),
        ];
        $this->db->where('idpkb',$id);
        $this->db->update('reproduksi_pkb',$data);
    }
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idpkb',$id);
        $this->db->delete('reproduksi_pkb');
    }
}
