<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_ib extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idib',$id);
        }
        $this->db->select('reproduksi_ib.idib,reproduksi_ib.tanggal,reproduksi_ib.ibke
                ,reproduksi_ib.idsapi,sapi.tagsapi,register.nomorregister,reproduksi_ib.kodesemen,semen.namasapi as namasemen,reproduksi_ib.idpetugas
                ,reproduksi_ib.petugas namapetugas,reproduksi_ib.keterangan');
        $this->db->JOIN('sapi','sapi.idsapi=reproduksi_ib.idsapi');
        $this->db->JOIN('register','register.idsapi=sapi.idsapi','left');
        $this->db->JOIN('sapi semen','semen.tagsapi=reproduksi_ib.kodesemen','left');
        $this->db->JOIN('farm','farm.idfarm=sapi.idfarm','left');
        $this->db->JOIN('petugas','reproduksi_ib.idpetugas=petugas.idpetugas','left');
        return $this->db->get('reproduksi_ib');
    }
    public function getByIDSapi($id = null)
    {
        if($id != null){
            $this->db->where('sapi.idsapi',$id);
        }
        $this->db->select('reproduksi_ib.idib,reproduksi_ib.tanggal,reproduksi_ib.ibke
                ,reproduksi_ib.idsapi,sapi.tagsapi,register.nomorregister
                ,semen.tagsapi as kodesemen,semen.namasapi as namasemen
                ,reproduksi_ib.idpetugas
                ,reproduksi_ib.petugas namapetugas,reproduksi_ib.keterangan
                ,(SELECT date_format(tanggal,"%Y-%m-%d") FROM reproduksi_pkb pkb WHERE pkb.idsapi=sapi.idsapi AND pkb.tanggal>reproduksi_ib.tanggal ORDER BY tanggal LIMIT 1) tglpkb
                ,(SELECT tanggal FROM reproduksi_kelahiran k WHERE k.idsapi=sapi.idsapi AND k.tanggal>reproduksi_ib.tanggal ORDER BY tanggal LIMIT 1) tglmelahirkan
                ,(SELECT count(xlaktasi) FROM reproduksi_kelahiran k WHERE k.idsapi=sapi.idsapi AND k.tanggal<reproduksi_ib.tanggal) xlaktasi
                ');
        $this->db->JOIN('sapi','sapi.idsapi=reproduksi_ib.idsapi');
        $this->db->JOIN('register','register.idsapi=sapi.idsapi','left');
        $this->db->JOIN('sapi semen','semen.tagsapi=reproduksi_ib.kodesemen','left');
        $this->db->JOIN('farm','farm.idfarm=sapi.idfarm','left');
        $this->db->JOIN('petugas','reproduksi_ib.idpetugas=petugas.idpetugas','left');
        return $this->db->get('reproduksi_ib');
    }
    public function get_json()
    {
        
        $this->datatables->select('reproduksi_ib.idib,reproduksi_ib.idsapi,reproduksi_ib.tanggal,reproduksi_ib.ibke,sapi.tagsapi
        ,reproduksi_ib.petugas as namapetugas,reproduksi_ib.kodesemen,semen.namasapi as namasemen
        ,(SELECT nomorregister FROM register WHERE register.idsapi=sapi.idsapi ORDER BY tanggal DESC limit 1) nomorregister,
        (select COUNT(*)+1 FROM reproduksi_ib ib
        WHERE ib.tanggal<reproduksi_ib.tanggal and ib.idsapi=reproduksi_ib.idsapi
        and tanggal>(SELECT max(tanggal) FROM reproduksi_ib ib1 WHERE ib1.is_bunting="1" 
        AND ib1.tanggal <reproduksi_ib.tanggal
        AND ib1.idsapi=reproduksi_ib.idsapi)) as xkawin,
        (SELECT IFNULL((select xlaktasi-1 from reproduksi_kelahiran k where k.idsapi=reproduksi_ib.idsapi
        and k.tanggal>reproduksi_ib.tanggal limit 1),(SELECT IFNULL(max(xlaktasi),0) FROM reproduksi_kelahiran k1
        WHERE k1.idsapi=reproduksi_ib.idsapi))) as xlaktasi');
        $this->datatables->from('reproduksi_ib');
        $this->datatables->JOIN('sapi','sapi.idsapi=reproduksi_ib.idsapi','left');
        $this->datatables->JOIN('sapi semen','semen.tagsapi=reproduksi_ib.kodesemen','left');
        $this->datatables->JOIN('farm','farm.idfarm=sapi.idfarm','left');
        $this->datatables->JOIN('petugas','petugas.idpetugas=reproduksi_ib.idpetugas','left');

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
        if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(tanggal)',$tahun);
        if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(tanggal)',$bulan);
        if(($tanggal!=""))  $this->datatables->where('tanggal',$tanggal);
        if(($xlaktasi==-1)){
            $this->datatables->where('laktasike=maxxlaktasi');
        }else   
        if(($xlaktasi!="")&&($xlaktasi!="0"))  
            $this->datatables->where('laktasike',$xlaktasi);

        $this->datatables->add_column('aksi','<div class="btn-group">
        <button class="btn btn-warning" id="editdata" data-id="$1"><i class="fas fa-pen"></i></button>
        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button>
        </div>'
        ,'idib');
        
        return $this->datatables->generate();
    }


    public function get_json_sapi_belum_ib()
    {
        
        $this->datatables->select('k1.idkelahiran,k1.idsapi,sapi.tagsapi,sapi.idfarm,farm.namafarm
        ,register.nomorregister
        ,(SELECT max(tanggal) from reproduksi_kelahiran k2 WHERE k1.idsapi=k2.idsapi)  tglmelahirkan 
        ,(SELECT max(xlaktasi) from reproduksi_kelahiran k2 WHERE k1.idsapi=k2.idsapi)  xlaktasi 
        ,(SELECT tanggal from reproduksi_ib ib WHERE ib.idsapi=k1.idsapi ORDER BY tanggal DESC LIMIT 1)  tanggalib
        ,(SELECT datediff(current_date(),tanggal) from reproduksi_ib ib WHERE ib.idsapi=k1.idsapi ORDER BY tanggal DESC LIMIT 1)  umur');
        $this->datatables->from('reproduksi_kelahiran k1');
        $this->datatables->JOIN('sapi','sapi.idsapi=k1.idsapi');
        $this->datatables->JOIN('register','sapi.idsapi=register.idsapi','left');
        $this->datatables->JOIN('farm','farm.idfarm=sapi.idfarm','left');
    
        $kodepropinsi  = $this->session->userdata('kodepropinsi');
        $kodekabupaten = $this->session->userdata('kodekabupaten');
        $kodekecamatan = $this->session->userdata('kodekecamatan');
        $idfarm = $this->session->userdata('idfarm');
        $tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
        $bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
        $tanggal = $this->session->userdata('tanggal'); 
        
        if($kodepropinsi!="") $this->datatables->where('kodepropinsi',$kodepropinsi);
        if($kodekabupaten!="") $this->datatables->where('kodekabupaten',$kodekabupaten);
        if($kodekecamatan!="") $this->datatables->where('kodekecamatan',$kodekecamatan);
        if(($idfarm!="")&&($idfarm!="0")) $this->datatables->where('farm.idfarm',$idfarm);
        if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(k1.tanggal)',$tahun);
        if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(k1.tanggal)',$bulan);
        if(($tanggal!=""))  $this->datatables->where('k1.tanggal',$tanggal);
        
        return $this->datatables->generate();
    }

    public function get_json_ib_today()
    {
        $this->datatables->select('tagsapi,DATE_FORMAT(reproduksi_ib.tanggal,"%Y-%m-%d") as tanggal,ibke,kodesemen,petugas.nama');
        $this->datatables->from('reproduksi_ib');
        $this->datatables->join('sapi','sapi.idsapi=reproduksi_ib.idsapi');
        $this->datatables->join('petugas','petugas.idpetugas=reproduksi_ib.idpetugas');
        $this->datatables->where('reproduksi_ib.tanggal',date('Y-m-d'));
        return $this->datatables->generate();
    }
    public function get_json_penggunaan_straw()
    {
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
		
        $idfarm=($this->session->userdata("idfarm")!="0"?$this->session->userdata("idfarm"):$this->M_user->get_idfarm($id_user));
        
        $this->datatables->select('p.kodesemen as kodestraw,(SELECT namapropinsi FROM wil_propinsi WHERE wil_propinsi.kodepropinsi=farm.kodepropinsi) as namapropinsi,
        (SELECT namakabupaten FROM wil_kabupaten WHERE wil_kabupaten.kodepropinsi=farm.kodepropinsi AND wil_kabupaten.kodekabupaten=farm.kodekabupaten) as namakabupaten,
        (SELECT namakecamatan FROM wil_kecamatan WHERE wil_kecamatan.kodepropinsi=farm.kodepropinsi AND wil_kecamatan.kodekabupaten=farm.kodekabupaten AND wil_kecamatan.kodekecamatan=farm.kodekecamatan) as namakecamatan,
        farm.namafarm,
        (SELECT namasapi FROM sapi s WHERE s.tagsapi=p.kodesemen LIMIT 1) as namabull,
        COUNT(*) as jumlahpemakaian');
        $this->datatables->FROM('reproduksi_ib p');
        $this->datatables->JOIN('sapi','sapi.idsapi=p.idsapi');
        $this->datatables->JOIN('farm','farm.idfarm=sapi.idfarm','left');
        $this->datatables->JOIN('register','sapi.idsapi=register.idsapi','left');
        $this->datatables->JOIN('sapi semen','semen.tagsapi=p.kodesemen','left');
        $this->datatables->WHERE('NOT isnull(p.kodesemen)');

        $kodepropinsi  = $this->session->userdata('kodepropinsi');
        $kodekabupaten = $this->session->userdata('kodekabupaten');
        $kodekecamatan = $this->session->userdata('kodekecamatan');

        
        $tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
        $bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
        $tanggal = $this->session->userdata('tanggal');
        $xlaktasi = $this->session->userdata('xlaktasi');
        
        if($kodepropinsi!="") $this->datatables->where('kodepropinsi',$kodepropinsi);
        if($kodekabupaten!="") $this->datatables->where('kodekabupaten',$kodekabupaten);
        if($kodekecamatan!="") $this->datatables->where('kodekecamatan',$kodekecamatan);
        if(($idfarm!="")&&($idfarm!="0")) $this->datatables->where('farm.idfarm',$idfarm);
        if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(p.tanggal)',$tahun);
        if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(p.tanggal)',$bulan);
        if(($tanggal!=""))  $this->datatables->where('p.tanggal',$tanggal);
        if(($xlaktasi==-1)){
            $this->datatables->where('laktasike=maxxlaktasi');
        }else   
        if(($xlaktasi!="")&&($xlaktasi!="0")) 
            $this->datatables->where('laktasike',$xlaktasi);

        $this->db->GROUP_BY(' p.kodesemen,farm.kodepropinsi,farm.namafarm,farm.kodekabupaten,farm.kodekecamatan');
    
        
        return $this->datatables->generate();
    }
    
    public function get_json_sapi_dara_belum_ib()
    {
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
        $idfarm=($this->session->userdata("idfarm")!="0"?$this->session->userdata("idfarm"):$this->M_user->get_idfarm($id_user));
        
        $this->datatables->select('sapi.idsapi,sapi.tagsapi,sapi.kelamin,sapi.status,sapi.tgllahir,DATEDIFF(CURRENT_DATE(),sapi.tgllahir),ROUND(DATEDIFF(CURRENT_DATE(),sapi.tgllahir)/30,2) umur,register.nomorregister,farm.namafarm');
        $this->datatables->from('sapi'); 
        $this->datatables->JOIN('register','sapi.idsapi=register.idsapi');
        $this->datatables->JOIN('farm','sapi.idfarm=farm.idfarm');
        $this->datatables->WHERE('kelamin','Betina'); 
        $this->datatables->WHERE('sapi.`status`','hidup');  
        $this->datatables->WHERE('DATEDIFF(CURRENT_DATE(),tgllahir)>450');  
        $this->datatables->WHERE('DATEDIFF(CURRENT_DATE(),tgllahir)<720');  
        $this->datatables->WHERE('sapi.idsapi NOT IN (SELECT idsapi FROM reproduksi_ib)'); 
        
        if(($idfarm!="")&&($idfarm!="0")) $this->datatables->where('sapi.idfarm',$idfarm);
        
        return $this->datatables->generate();        
    }
    public function get_count_sapi_dara_belum_ib()
    {
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
        $idfarm=$this->M_user->get_idfarm($id_user);
        
        $this->db->select('sapi.idsapi,sapi.tagsapi,sapi.kelamin,sapi.status,sapi.tgllahir,DATEDIFF(CURRENT_DATE(),sapi.tgllahir),DATEDIFF(CURRENT_DATE(),sapi.tgllahir)/30 umur,register.nomorregister,farm.namafarm');
        $this->db->from('sapi'); 
        $this->db->JOIN('register','sapi.idsapi=register.idsapi');
        $this->db->JOIN('farm','sapi.idfarm=farm.idfarm');
        $this->db->WHERE('kelamin','Betina'); 
        $this->db->WHERE('sapi.`status`','hidup');  
        $this->db->WHERE('DATEDIFF(CURRENT_DATE(),tgllahir)>450');  
        $this->db->WHERE('DATEDIFF(CURRENT_DATE(),tgllahir)<720');  
        $this->db->WHERE('sapi.idsapi NOT IN (SELECT idsapi FROM reproduksi_ib)'); 
        
        if(($idfarm!="")&&($idfarm!="0")) $this->db->where('sapi.idfarm',$idfarm);
        
        $rs=$this->db->get();        
        return $rs->num_rows();
    }
    public function get_json_sapi_belum_pkb()
    {
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
        $idfarm=($this->session->userdata("idfarm")!="0"?$this->session->userdata("idfarm"):$this->M_user->get_idfarm($id_user));
        $this->datatables->select('reproduksi_ib.*,sapi.tagsapi,farm.namafarm,register.nomorregister,DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal) as umurkawin');
        $this->datatables->from('reproduksi_ib'); 
        $this->datatables->JOIN('sapi','sapi.idsapi=reproduksi_ib.idsapi');
        $this->datatables->JOIN('register','sapi.idsapi=register.idsapi');
        $this->datatables->JOIN('farm','sapi.idfarm=farm.idfarm');
        if(($idfarm!="")&&($idfarm!="0")) $this->datatables->where('sapi.idfarm',$idfarm);
        $this->datatables->where('sapi.status','hidup');
        $this->datatables->where('sapi.idsapi NOT IN (select idsapi from reproduksi_pkb WHERE reproduksi_pkb.tanggal>reproduksi_ib.tanggal)');
        $this->datatables->where('DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal)>30');
        $this->datatables->where('DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal)<150');

        return $this->datatables->generate();        
    }
    public function get_count_sapi_belum_pkb()
    {
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
        $idfarm=$this->M_user->get_idfarm($id_user);
        $this->db->from('reproduksi_ib'); 
        $this->db->JOIN('sapi','sapi.idsapi=reproduksi_ib.idsapi');
        $this->db->JOIN('register','sapi.idsapi=register.idsapi');
        $this->db->JOIN('farm','sapi.idfarm=farm.idfarm');
        if(($idfarm!="")&&($idfarm!="0")) $this->datatables->where('sapi.idfarm',$idfarm);
        $this->db->where('sapi.status','hidup');
        $this->db->where('sapi.idsapi NOT IN (select idsapi from reproduksi_pkb WHERE reproduksi_pkb.tanggal>reproduksi_ib.tanggal)');
        $this->db->where('DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal)>30');
        $this->db->where('DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal)<150');
        $rs=$this->db->get();
        return $rs->num_rows();        
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
            $semen = $this->db->query("SELECT idsapi FROM sapi WHERE tagsapi = ? AND tipesapi = 'Semen'",
                array($record['kodesemen']))->row();
            if (!$semen) {
                $result['errors'][] = $label . ': kode straw ' . $record['kodesemen'] . ' belum terdaftar di master semen.';
                continue;
            }
            $officers = $this->db->query('SELECT idpetugas FROM petugas WHERE TRIM(nama) = ?',
                array($record['petugas']))->result();
            if (count($officers) > 1) {
                $result['errors'][] = $label . ': nama petugas ganda; perbaiki master petugas terlebih dahulu.';
                continue;
            }
            $idpetugas = $officers ? $officers[0]->idpetugas : 0;
            $birth = $this->db->query(
                'SELECT xlaktasi FROM reproduksi_kelahiran WHERE idsapi = ? AND tanggal <= ? ORDER BY tanggal DESC, idkelahiran DESC LIMIT 1',
                array($cows[0]->idsapi, $record['tanggal']))->row();
            $xlaktasi = $birth && (int) $birth->xlaktasi > 0 ? (int) $birth->xlaktasi : 0;
            $data = array($cows[0]->idsapi, $record['tanggal'], $record['ibke'], $record['kodesemen'],
                $idpetugas, $record['petugas'], $record['keterangan'], $record['intensitas_birahi'], $xlaktasi);
            $saved = $this->db->query(
                "INSERT INTO reproduksi_ib (idsapi, tanggal, ibke, kodesemen, idpetugas, petugas, keterangan, intensitas_birahi, xlaktasi, jenis)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'IB')
                 ON DUPLICATE KEY UPDATE ibke = VALUES(ibke), kodesemen = VALUES(kodesemen),
                 idpetugas = VALUES(idpetugas), petugas = VALUES(petugas), keterangan = VALUES(keterangan),
                 intensitas_birahi = VALUES(intensitas_birahi), xlaktasi = VALUES(xlaktasi)",
                $data);
            if ($saved) {
                $result['success']++;
                if (!$officers) {
                    $result['warnings'][] = $label . ': nama petugas disimpan, tetapi belum terhubung ke master petugas.';
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
            'idib' => '',
            'idsapi' => htmlspecialchars($this->input->post('idsapi')),
            'kodesemen' => htmlspecialchars($this->input->post('kodesemen')),
            'tanggal' => $this->input->post('tanggal'),
            'ibke' => $this->input->post('ibke'),
            'keterangan' => $this->input->post('keterangan') ,
            'idpetugas' => $this->input->post('idpetugas') ,
            'petugas' => $this->input->post('petugas') 
        ];
        $this->db->insert('reproduksi_ib',$data);
    }
    public function update()
    {
        $id = $this->input->post('idib');
        $data = [
            'idsapi' => htmlspecialchars($this->input->post('idsapi')),
            'kodesemen' => htmlspecialchars($this->input->post('kodesemen')),
            'tanggal' => $this->input->post('tanggal'),
            'ibke' => $this->input->post('ibke'),
            'keterangan' => $this->input->post('keterangan') ,
            'idpetugas' => $this->input->post('idpetugas') ,
            'petugas' => $this->input->post('petugas') 
        ];
        $this->db->where('idib',$id);
        $this->db->update('reproduksi_ib',$data);
    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idib',$id);
        $this->db->delete('reproduksi_ib');
    }

    public function get_pengamatan_birahi_today()
    {
       
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
        $idfarm=$this->M_user->get_idfarm($id_user);

        $sql="SELECT reproduksi_ib.*,sapi.tagsapi,farm.namafarm,register.nomorregister,DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal) as umurkawin,'Pengamatan I' status
        FROM reproduksi_ib
        JOIN sapi ON sapi.idsapi=reproduksi_ib.idsapi
        JOIN register ON sapi.idsapi=register.idsapi
        JOIN farm ON sapi.idfarm=farm.idfarm
        WHERE sapi.`status` ='hidup'
        AND sapi.idsapi NOT IN (select idsapi from reproduksi_pkb WHERE reproduksi_pkb.tanggal>reproduksi_ib.tanggal)
        AND DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal) BETWEEN 18 AND 23";

        if(($idfarm<>"0")&&($idfarm<>"")) $sql .= " AND sapi.idfarm='$idfarm'";
        $sql .= " UNION 
        SELECT reproduksi_ib.*,sapi.tagsapi,farm.namafarm,register.nomorregister,DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal) as umurkawin,'Pengamatan II' status
        FROM reproduksi_ib
        JOIN sapi ON sapi.idsapi=reproduksi_ib.idsapi
        JOIN register ON sapi.idsapi=register.idsapi
        JOIN farm ON sapi.idfarm=farm.idfarm
        WHERE sapi.`status` ='hidup'
        AND sapi.idsapi NOT IN (select idsapi from reproduksi_pkb WHERE reproduksi_pkb.tanggal>reproduksi_ib.tanggal)
        AND DATEDIFF(CURRENT_DATE(),reproduksi_ib.tanggal) BETWEEN 41 AND 46";
        if(($idfarm<>"0")&&($idfarm<>"")) $sql .= " AND sapi.idfarm='$idfarm'";
        return $this->db->query($sql);
    }
    
    public function get_prediksibirahi()
    {
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
        $idfarm=$this->M_user->get_idfarm($id_user);

        $sql="SELECT * FROM (select sapi.idsapi,sapi.tagsapi,farm.namafarm ,reg.nomorregister,max(ib.tanggal) tanggal_ib_terakhir
        , DATE_ADD(max(ib.tanggal),INTERVAL 18 day) p1_awal,DATE_ADD(max(ib.tanggal),INTERVAL 23 day) p1_akhir
        , DATE_ADD(max(ib.tanggal),INTERVAL 38 day) p2_awal,DATE_ADD(max(ib.tanggal),INTERVAL 43 day) p2_akhir
        , DATE_ADD(max(ib.tanggal),INTERVAL 58 day) p3_awal,DATE_ADD(max(ib.tanggal),INTERVAL 63 day) P3_akhir
        
        , CONCAT(DATE_ADD(max(ib.tanggal),INTERVAL 18 day) ,' s/d ',DATE_ADD(max(ib.tanggal),INTERVAL 23 day)) p1
        , CONCAT(DATE_ADD(max(ib.tanggal),INTERVAL 38 day) ,' s/d ',DATE_ADD(max(ib.tanggal),INTERVAL 43 day)) p2
        , CONCAT(DATE_ADD(max(ib.tanggal),INTERVAL 58 day) ,' s/d ',DATE_ADD(max(ib.tanggal),INTERVAL 63 day)) p3

        FROM reproduksi_ib ib
        LEFT JOIN reproduksi_pkb pkb ON pkb.idib=ib.idib
        LEFT JOIN sapi ON sapi.idsapi=ib.idsapi
        LEFT JOIN farm ON sapi.idfarm=farm.idfarm
        LEFT JOIN register reg ON reg.idsapi=ib.idsapi
        WHERE (ISNULL(pkb.idpkb) OR pkb.hasil!='P')
        GROUP BY sapi.idsapi,sapi.tagsapi ,reg.nomorregister
        )tabel 
        WHERE 
        CURRENT_DATE BETWEEN p1_awal and p1_akhir
        OR CURRENT_DATE BETWEEN p2_awal and p2_akhir
        OR CURRENT_DATE BETWEEN p3_awal and p3_akhir";
        if(($idfarm<>"0")&&($idfarm<>"")) $sql .= " AND sapi.idfarm='$idfarm'";
        return $this->db->query($sql);
    }
    public function get_prediksikelahiran()
    {
         
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
        
        $this->datatables->select('reproduksi_ib.idib,reproduksi_ib.tanggal tanggalib,sapi.tagsapi,register.nomorregister,farm.namafarm,DATE_ADD(reproduksi_ib.tanggal,INTERVAL 280 day) hpl');
        $this->datatables->from('reproduksi_pkb');
        $this->datatables->join('reproduksi_ib','reproduksi_ib.idib=reproduksi_pkb.idib');
        $this->datatables->join('sapi','sapi.idsapi=reproduksi_pkb.idsapi');
        $this->datatables->join('register','sapi.idsapi=register.idsapi');
        $this->datatables->join('farm','sapi.idfarm=farm.idfarm');
        $this->datatables->where('DATE_ADD(reproduksi_ib.tanggal,INTERVAL 280 day)>',date('Y-m-d'));
        $this->datatables->where('sapi.status','Hidup');
        
        $kodepropinsi  = $this->session->userdata('kodepropinsi');
        $kodekabupaten = $this->session->userdata('kodekabupaten');
        $kodekecamatan = $this->session->userdata('kodekecamatan');
        $idfarm = $this->session->userdata('idfarm');
        $tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
        $bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
        $tanggal = $this->session->userdata('tanggal'); 
        
        if($kodepropinsi!="") $this->datatables->where('kodepropinsi',$kodepropinsi);
        if($kodekabupaten!="") $this->datatables->where('kodekabupaten',$kodekabupaten);
        if($kodekecamatan!="") $this->datatables->where('kodekecamatan',$kodekecamatan);
        if(($idfarm!="")&&($idfarm!="0")) $this->datatables->where('farm.idfarm',$idfarm);
        if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(DATE_ADD(reproduksi_ib.tanggal,INTERVAL 280 day)) =',$tahun);
        if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(DATE_ADD(reproduksi_ib.tanggal,INTERVAL 280 day)) =',$bulan);
        if(($tanggal!=""))  $this->datatables->where('DATE_ADD(reproduksi_ib.tanggal,INTERVAL 280 day)',$tanggal);
         
        return $this->datatables->generate();
    }
}
