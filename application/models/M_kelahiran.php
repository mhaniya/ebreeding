<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_kelahiran extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idkelahiran',$id);
        }
        $this->db->select('reproduksi_kelahiran.*,register.nomorregister,sapi.tagsapi,pedet.tagsapi tagsapipedet,
            COALESCE(pedet.kelamin,reproduksi_kelahiran.jkelpedet) jkelpedet,
            COALESCE(pedet.bobotlahir,reproduksi_kelahiran.bobotlahirpedet) bobotlahirpedet');
        $this->db->join('sapi','sapi.idsapi = reproduksi_kelahiran.idsapi');
        $this->db->join('register','sapi.idsapi = register.idsapi','left');
        $this->db->join('sapi pedet','pedet.idsapi = reproduksi_kelahiran.idsapipedet','left');
        $this->db->join('petugas','petugas.idpetugas = reproduksi_kelahiran.idpetugas','left');
        return $this->db->get('reproduksi_kelahiran');
    }
    public function get_json()
    {
        $this->datatables->select('reproduksi_kelahiran.idkelahiran,reproduksi_kelahiran.idsapi,reproduksi_kelahiran.tanggal,
                                    reproduksi_kelahiran.xlaktasi,reproduksi_kelahiran.statuslahir,reproduksi_kelahiran.keterangan,
                                    reproduksi_kelahiran.idpetugas,reproduksi_kelahiran.tglinput,reproduksi_kelahiran.idsapipedet,
                                    reproduksi_kelahiran.statuslahirpedet,reproduksi_kelahiran.idfarm,sapi.tagsapi,
                                    COALESCE(reproduksi_kelahiran.tanggal_ib,(SELECT tanggal FROM reproduksi_ib 
                                    WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi
                                    and reproduksi_ib.tanggal BETWEEN DATE_SUB(reproduksi_kelahiran.tanggal, INTERVAL 12 MONTH)
                                    AND DATE_SUB(reproduksi_kelahiran.tanggal, INTERVAL 6 MONTH) ORDER BY reproduksi_ib.tanggal DESC LIMIT 1))
                                    as tanggalib
                                    ,register.nomorregister, COALESCE(NULLIF(pedet.tagsapi,""),NULLIF(reproduksi_kelahiran.tagsapi,""),
                                      CASE WHEN reproduksi_kelahiran.statuslahirpedet="Mati" THEN "Lahir Mati" ELSE "Belum bernomor" END) as tagsapianak
                                    ,(SELECT nomorregister FROM register r WHERE r.idsapi=reproduksi_kelahiran.idsapipedet) nomorregisteranak 
                                    ,COALESCE(pedet.kelamin,reproduksi_kelahiran.jkelpedet) as jkelanak');
		$this->datatables->from('reproduksi_kelahiran');
		$this->datatables->join('sapi','sapi.idsapi=reproduksi_kelahiran.idsapi');
		$this->datatables->join('farm','farm.idfarm=sapi.idfarm');
		$this->datatables->join('sapi as pedet','reproduksi_kelahiran.idsapipedet=pedet.idsapi','left');
		$this->datatables->join('register','register.idsapi=reproduksi_kelahiran.idsapi','left');
        $this->datatables->join('petugas','petugas.idpetugas=reproduksi_kelahiran.idpetugas','left');
        // $this->datatables->join('(SELECT @no:=0) r','','left');
        
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
        if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(reproduksi_kelahiran.tanggal)',$tahun);
        if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(reproduksi_kelahiran.tanggal)',$bulan);
        if(($tanggal!=""))  $this->datatables->where('reproduksi_kelahiran.tanggal',$tanggal);
        if(($xlaktasi==-1)){
            $this->datatables->where('laktasike=maxxlaktasi');
        }else   
        if(($xlaktasi!="")&&($xlaktasi!="0"))  
            $this->datatables->where('laktasike',$xlaktasi);

        $this->datatables->add_column('aksi','<div class="btn-group">
            <button class="btn btn-warning" id="editdata" data-id="$1"><i class="fas fa-pen"></i></button>
            <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button>
        </div>','idkelahiran');
        
        return $this->datatables->generate();
    }
    
    
    public function import_records($records, $scope)
    {
        $result = array('success' => 0, 'calves' => 0, 'errors' => array(), 'warnings' => array());
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            foreach ($records as $record) {
                $label = 'Baris ' . $record['line'] . ' (' . $record['tagsapi'] . ')';
                $warnings = array();
                try {
                    $this->db->trans_begin();
                    $sql = "SELECT idsapi, idfarm, idbangsa FROM sapi WHERE tagsapi = ? AND kelamin = 'Betina' AND (tipesapi IS NULL OR tipesapi <> 'Semen')";
                    $params = array($record['tagsapi']);
                    if ($scope['level_id'] == 2) {
                        $sql .= ' AND idfarm IN (SELECT idfarm FROM farm WHERE kodekoperasi = ?)';
                        $params[] = $scope['kodekoperasi'];
                    } elseif ($scope['level_id'] == 4) {
                        $sql .= ' AND idfarm = ?';
                        $params[] = $scope['idfarm'];
                    }
                    $mothers = $this->import_query($sql . ' FOR UPDATE', $params)->result();
                    if (count($mothers) !== 1) { throw new RuntimeException('induk tidak ditemukan, ganda, atau di luar akses pengguna.'); }
                    $mother = $mothers[0];
                    $births = $this->import_query(
                        'SELECT idkelahiran, idsapipedet, tagsapi, statuslahirpedet FROM reproduksi_kelahiran WHERE idsapi = ? AND tanggal = ? FOR UPDATE',
                        array($mother->idsapi, $record['tanggal']))->result();
                    if (count($births) > 1) { throw new RuntimeException('terdapat beberapa kelahiran pada tanggal yang sama; periksa data terlebih dahulu.'); }
                    $birth = $births ? $births[0] : null;
                    if ($birth && $birth->idsapipedet && $record['tagpedet'] === '' && $record['statuspedet'] === 'mati') {
                        throw new RuntimeException('kelahiran sudah terhubung ke pedet bernomor; perubahan menjadi Lahir Mati perlu diperiksa manual.');
                    }
                    $ib = $this->import_query(
                        'SELECT idib, ibke, kodesemen, jenis FROM reproduksi_ib WHERE idsapi = ? AND tanggal = ?',
                        array($mother->idsapi, $record['tanggal_ib']))->row();
                    if ($ib && ((int) $ib->ibke !== $record['ibke'] || trim((string) $ib->kodesemen) !== $record['kodestraw'])) {
                        throw new RuntimeException('IB Ke atau kode straw berbeda dari IB yang tercatat.');
                    }
                    if (!$ib) { $warnings[] = $label . ': IB belum tercatat; informasi IB dari file tetap disimpan pada kelahiran.'; }
                    $sires = $this->import_query('SELECT idsapi, tipesapi FROM sapi WHERE tagsapi = ?',
                        array($record['kodestraw']))->result();
                    $sire = count($sires) === 1 ? $sires[0] : null;
                    if (!$sire) { $warnings[] = $label . ': pejantan belum ditemukan atau kodenya ganda; nama/kode tetap disimpan tanpa id pejantan.'; }
                    $calfId = $birth && $birth->idsapipedet ? $birth->idsapipedet : null;
                    $newCalf = false;
                    $tag = $record['tagpedet'];
                    if ($tag !== '') {
                        $calves = $this->import_query(
                            'SELECT idsapi, iddam, tgllahir, status FROM sapi WHERE idfarm = ? AND tagsapi = ? FOR UPDATE',
                            array($mother->idfarm, $tag))->result();
                        if (count($calves) > 1) { throw new RuntimeException('tag pedet ganda.'); }
                        $calf = $calves ? $calves[0] : null;
                        if ($calf && (($calf->iddam && $calf->iddam != $mother->idsapi) ||
                            ($calf->tgllahir && substr($calf->tgllahir, 0, 10) !== '0000-00-00' &&
                            substr($calf->tgllahir, 0, 10) !== $record['tanggal']))) {
                            throw new RuntimeException('tag pedet sudah digunakan untuk induk atau tanggal lahir berbeda.');
                        }
                        if ($calfId && (!$calf || $calfId != $calf->idsapi)) {
                            throw new RuntimeException('kelahiran sudah terhubung ke pedet berbeda; tag tidak ditimpa.');
                        }
                        $calfData = array('tagsapi' => $tag, 'idfarm' => $mother->idfarm,
                            'iddam' => $mother->idsapi, 'kodedam' => $record['tagsapi'],
                            'kelamin' => $record['jkelpedet'], 'tgllahir' => $record['tanggal'],
                            'kodesire' => $record['kodestraw'], 'namasire' => $record['namabull']);
                        if ($sire) { $calfData['idsire'] = $sire->idsapi; }
                        if ($record['bobotlahirpedet'] !== null) { $calfData['bobotlahir'] = $record['bobotlahirpedet']; }
                        if ($calf) {
                            $calfId = $calf->idsapi;
                            $this->db->where('idsapi', $calfId);
                            if (!$this->db->update('sapi', $calfData)) { throw new RuntimeException('gagal memperbarui pedet.'); }
                        } else {
                            $calfData['status'] = $record['statuspedet'];
                            $calfData['idbangsa'] = $mother->idbangsa ?: null;
                            $calfData['tglinput'] = date('Y-m-d H:i:s');
                            $calfData['tipesapi'] = strtoupper($record['namabull']) === 'KA' ||
                                ($sire && in_array($sire->tipesapi, array('Sire', 'Alam'), true)) ? 'Alam' :
                                ($ib && $ib->jenis === 'ET' ? 'ET' : 'IB');
                            if (!$this->db->insert('sapi', $calfData)) { throw new RuntimeException('gagal menambahkan pedet.'); }
                            $calfId = $this->db->insert_id();
                            $newCalf = true;
                        }
                    } elseif (!$calfId) {
                        $warnings[] = $label . ': kelahiran disimpan tanpa data sapi pedet karena ' .
                            ($record['statuspedet'] === 'mati' ? 'Lahir Mati tidak memiliki nomor pedet.' : 'nomor pedet kosong; lengkapi nomor lalu import ulang.');
                    }
                    if ($calfId) {
                        $register = $this->import_query('SELECT nomorregister FROM register WHERE idsapi = ?', array($calfId))->row();
                        if (!$register) { $this->M_sapi->buatregister($calfId); }
                        $measure = array('idsapi' => $calfId, 'tanggal' => $record['tanggal']);
                        foreach (array('bobotlahirpedet' => 'bobotkg', 'panjang_badan' => 'panjang_badan',
                            'lingkar_dada' => 'lingkar_dada', 'tinggi_gumba' => 'tinggi_gumba',
                            'lingkar_skrotum' => 'lingkar_skrotum') as $from => $to) {
                            if ($record[$from] !== null) { $measure[$to] = $record[$from]; }
                        }
                        if (count($measure) > 2) {
                            $existingMeasure = $this->import_query(
                                'SELECT idpengukuran FROM pengukuran_bobotsapi WHERE idsapi = ? AND tanggal = ?',
                                array($calfId, $record['tanggal']))->row();
                            if ($existingMeasure) {
                                $this->db->where('idpengukuran', $existingMeasure->idpengukuran);
                                if (!$this->db->update('pengukuran_bobotsapi', $measure)) { throw new RuntimeException('gagal memperbarui ukuran pedet.'); }
                            } else {
                                $measure['tglinput'] = date('Y-m-d H:i:s');
                                if (!$this->db->insert('pengukuran_bobotsapi', $measure)) { throw new RuntimeException('gagal menyimpan ukuran pedet.'); }
                            }
                        }
                    }
                    $data = array('idsapi' => $mother->idsapi, 'tanggal' => $record['tanggal'],
                        'xlaktasi' => $record['xlaktasi'], 'idsapipedet' => $calfId,
                        'statuslahirpedet' => ucfirst($record['statuspedet']), 'idfarm' => $mother->idfarm,
                        'tglinput' => date('Y-m-d'), 'tanggal_ib' => $record['tanggal_ib'],
                        'ibke' => $record['ibke'], 'namabull' => $record['namabull'], 'kodestraw' => $record['kodestraw']);
                    if ($ib) { $data['idib'] = $ib->idib; }
                    if (!$birth) {
                        $data['statuslahir'] = 'single';
                        $data['idpetugas'] = 0;
                        $data['tagsapi'] = $tag;
                    } elseif ($tag !== '') { $data['tagsapi'] = $tag; }
                    foreach (array('bobotlahirpedet', 'jam_lahir', 'jkelpedet', 'panjang_badan', 'lingkar_dada',
                        'tinggi_gumba', 'lingkar_skrotum') as $field) {
                        if ($record[$field] !== null) { $data[$field] = $record[$field]; }
                    }
                    if ($birth) {
                        $this->db->where('idkelahiran', $birth->idkelahiran);
                        $saved = $this->db->update('reproduksi_kelahiran', $data);
                    } else { $saved = $this->db->insert('reproduksi_kelahiran', $data); }
                    if (!$saved || !$this->db->trans_status()) { throw new RuntimeException('penyimpanan gagal; seluruh perubahan baris dibatalkan.'); }
                    if (!$this->db->trans_commit()) { throw new RuntimeException('transaksi gagal.'); }
                    $result['success']++;
                    if ($newCalf) { $result['calves']++; }
                    $result['warnings'] = array_merge($result['warnings'], $warnings);
                } catch (Exception $e) {
                    $this->db->trans_rollback();
                    $result['errors'][] = $label . ': ' . $e->getMessage();
                }
            }
        } finally { $this->db->db_debug = $debug; }
        return $result;
    }

    private function import_query($sql, $params)
    {
        $query = $this->db->query($sql, $params);
        if (!$query) { throw new RuntimeException('gagal membaca data pendukung; baris dibatalkan.'); }
        return $query;
    }

    public function save()
    {
        $idsapiInduk=$this->input->post('idsapiInduk');
        $sql="SELECT idfarm from sapi WHERE idsapi='$idsapiInduk'";
        
        $rsInduk=$this->db->query($sql);
        if($rsInduk->num_rows()>0){
            $rowInduk=$rsInduk->row();
            $idfarm=$rowInduk->idfarm;
        }else{
            $idfarm="";
        }
        //Input Sapi Pedet
        $statuspedet=$this->input->post('statuspedet');
        $tagsapipedet = $this->input->post('tagsapiPedet');
        $bobotlahirpedet = $this->input->post('bobotlahir');
        $dataPedet=[
            'idsapi' => '',
            'tagsapi' => $tagsapipedet,
            'idfarm' => $idfarm,
            'bobotlahir' => $this->input->post('bobotlahir'),
            'kelamin' => $this->input->post('jkelpedet'),
            'tgllahir' => $this->input->post('tanggal'),
            'iddam' => $idsapiInduk,
            'status' => $statuspedet
        ];
        $sql="SELECT idsapi from sapi where tagsapi='".$this->input->post('tagsapiPedet')."' AND idfarm='$idfarm'";
        $rs=$this->db->query($sql);
        if($rs->num_rows()==0){
            $this->db->insert('sapi',$dataPedet);
            $idsapiPedet=$this->db->insert_id();
        }else{
            $rowPedet=$rs->row();
            $idsapiPedet=$rowPedet->idsapi;
            unset($dataPedet['idsapi']);
            $this->db->where('tagsapi',$tagsapipedet);
            $this->db->where('idfarm',$idfarm);
            $this->db->update('sapi',$dataPedet);
        }

        

        //Membuat nomor register
        $this->M_sapi->buatregister($idsapiPedet);
        $idsapiPedet2 ="";
        $tagsapipedet2 ="";
        $bobotlahirpedet2 ="";

        $data = [
            'idkelahiran' => '',
            'idsapi' => $idsapiInduk,
            'tanggal' => $this->input->post('tanggal'),
            'xlaktasi' => $this->input->post('xlaktasi'),
            'statuslahir' => $this->input->post('status_kelahiran'),
            'keterangan' => $this->input->post('keterangan'),
            'idpetugas' => $this->input->post('idpetugas'),
            'idsapipedet' => $idsapiPedet,
            'tagsapi' => $tagsapipedet,
            'bobotlahirpedet' => $bobotlahirpedet,
            // 'idsapipedet2' => $idsapiPedet2,
            // 'tagsapi2' => $tagsapipedet2,
            // 'bobotlahirpedet2' => $bobotlahirpedet2,
            'statuslahirpedet' => $statuspedet,
            'idfarm' => $idfarm,
            'tglinput' => date('Y-m-d')
        ];
        $this->db->insert('reproduksi_kelahiran',$data);

        if($this->input->post('status_kelahiran')=='kembar'){
            $statuspedet2=$this->input->post('statuspedet2');
            $tagsapipedet2 = $this->input->post('tagsapiPedet2');
            $bobotlahirpedet2 = $this->input->post('bobotlahir2');
            $dataPedet=[
                'idsapi' => '',
                'tagsapi' => $tagsapipedet2,
                'idfarm' => $idfarm,
                'bobotlahir' => $bobotlahirpedet2,
                'kelamin' => $this->input->post('jkelpedet2'),
                'tgllahir' => $this->input->post('tanggal'),
                'iddam' => $idsapiInduk,
                'status' => $statuspedet2
            ];
            $sql="SELECT idsapi from sapi where tagsapi='".$this->input->post('tagsapiPedet2')."' AND idfarm='$idfarm'";
            $rs=$this->db->query($sql);
            if($rs->num_rows()==0){
                $this->db->insert('sapi',$dataPedet);
                $idsapiPedet2=$this->db->insert_id();
            }else{
                $rowPedet=$rs->row();
                $idsapiPedet2=$rowPedet->idsapi;
                unset($dataPedet['idsapi']);
                $this->db->where('tagsapi',$tagsapipedet2);
                $this->db->where('idfarm',$idfarm);
                $this->db->update('sapi',$dataPedet);
            }

            

            //Membuat nomor register
            $this->M_sapi->buatregister($idsapiPedet2);

            $data = [
                'idkelahiran' => '',
                'idsapi' => $idsapiInduk,
                'tanggal' => $this->input->post('tanggal'),
                'xlaktasi' => $this->input->post('xlaktasi'),
                'statuslahir' => $this->input->post('status_kelahiran'),
                'keterangan' => $this->input->post('keterangan'),
                'idpetugas' => $this->input->post('idpetugas'),
                'idsapipedet' => $idsapiPedet2,
                'tagsapi' => $tagsapipedet2,
                'bobotlahirpedet' => $bobotlahirpedet2,
                // 'idsapipedet2' => $idsapiPedet2,
                // 'tagsapi2' => $tagsapipedet2,
                // 'bobotlahirpedet2' => $bobotlahirpedet2,
                'statuslahirpedet' => $statuspedet,
                'idfarm' => $idfarm,
                'tglinput' => date('Y-m-d')
            ];
            $this->db->insert('reproduksi_kelahiran',$data);
        }
    }
    public function update()
    {
        $id = $this->input->post('idkelahiran');
        $idsapi=$this->input->post('idsapiInduk');

        $sql="SELECT idfarm from sapi where idsapi='$idsapi'";
        $rsinduk=$this->db->query($sql);
        if($rsinduk->num_rows()>0){
            $rowinduk=$rsinduk->row();
            $idfarm=$rowinduk->idfarm;
        }else{
            $idfarm="";
        }
        $statuspedet=$this->input->post('statuspedet');
        if($statuspedet='hidup'){
            $statuslahirpedet='hidup';
        }else{
            $statuslahirpedet='mati';
        }
        $idsapiPedet=$this->input->post('idsapiPedet');
        
        if($idsapiPedet=="0"){
            $dataPedet=[
                'idsapi' => '',
                'tagsapi' => $this->input->post('tagsapiPedet'),
                'idfarm' => $idfarm,
                'bobotlahir' => $this->input->post('bobotlahir'),
                'kelamin' => $this->input->post('jkelpedet'),
                'tgllahir' => $this->input->post('tanggal'),
                'status' => $statuspedet
            ];
            $sql="SELECT idsapi from sapi where tagsapi='".$this->input->post('tagsapiPedet')."' AND idfarm='$idfarm'";
            $rs=$this->db->query($sql);
            if($rs->num_rows()==0)
                $this->db->insert('sapi',$dataPedet);
            else{
                $dataPedet['idsapi']=null;
                $this->db->where('tagsapi',$this->input->post('tagsapiPedet'));
                $this->db->where('idfarm',$idfarm);
                    $this->db->update('sapi',$dataPedet);
            }

            $idsapiPedet=$this->db->insert_id();

            //Membuat nomor register
            $this->M_sapi->buatregister($idsapiPedet);
        }
        $data = [ 
            'idsapi' => $idsapi,
            'tanggal' => $this->input->post('tanggal'),
            'xlaktasi' => $this->input->post('xlaktasi'),
            'statuslahir' => $this->input->post('status_kelahiran'),
            'keterangan' => $this->input->post('keterangan'),
            'idpetugas' => $this->input->post('idpetugas'),
            'idsapipedet' => $idsapiPedet,
            'statuslahirpedet' => $statuspedet,
            'idfarm' => $idfarm,
            'tglinput' => date('Y-m-d')
        ];
        
        $this->db->where('idkelahiran',$id);
        $this->db->update('reproduksi_kelahiran',$data);
    }
    public function updatepass()
    {
        $id = $this->input->post('user_id');
        $data = [
            'user_password' => sha1($this->input->post('pass1')),
        ];
        $this->db->where('user_id',$id);
        $this->db->update('reproduksi_kelahiran',$data);
    }
    public function delete()
    {
        $id = $this->input->post('id');
        //mendapatkan idPedet
        $this->db->where('idkelahiran',$id);
        $rowkelahiran=$this->db->get('reproduksi_kelahiran')->row();
        $idsapipedet=$rowkelahiran->idsapipedet;

        //menghapus data register pedet
        $this->db->where('idsapi',$idsapipedet);
        $this->db->delete('register');
        
        //menghapus data sapi pedet
        $this->db->where('idsapi',$idsapipedet);
        $this->db->delete('sapi');

        //menghapus data kelahiran
        $this->db->where('idkelahiran',$id);
        $this->db->delete('reproduksi_kelahiran');
    }
}
