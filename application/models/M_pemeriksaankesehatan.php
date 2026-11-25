<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pemeriksaankesehatan extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idpemeriksaan',$id);
        } 
        $this->db->select('pemeriksaankesehatan.idpemeriksaan,pemeriksaankesehatan.idsapi,pemeriksaankesehatan.idpetugas,pemeriksaankesehatan.tanggal,pemeriksaankesehatan.keterangan,pemeriksaankesehatan.idpemeriksaan,pemeriksaankesehatan.diagnosa,pemeriksaankesehatan.pengobatan
                            ,' . $this->keswan_officer_expression() . ' as namapetugas,sapi.tagsapi,register.nomorregister', false);
        $this->db->join('sapi','sapi.idsapi=pemeriksaankesehatan.idsapi');
        $this->db->join('register','register.idsapi=sapi.idsapi','left');
        $this->db->join('petugas','petugas.idpetugas=pemeriksaankesehatan.idpetugas','left');
        return $this->db->get('pemeriksaankesehatan');
    }
    public function getByIDSapi($id = null)
    {
        if($id != null){
            $this->db->where('sapi.idsapi',$id);
        } 
        $this->db->SELECT('pemeriksaankesehatan.idpemeriksaan,pemeriksaankesehatan.kategori,pemeriksaankesehatan.idsapi,pemeriksaankesehatan.idpetugas,pemeriksaankesehatan.tanggal,pemeriksaankesehatan.keterangan,pemeriksaankesehatan.idpemeriksaan,pemeriksaankesehatan.diagnosa,pemeriksaankesehatan.pengobatan
                            ,petugas.nama namapetugas,sapi.tagsapi,register.nomorregister');
        $this->db->JOIN('sapi','sapi.idsapi=pemeriksaankesehatan.idsapi');
        $this->db->JOIN('register','register.idsapi=sapi.idsapi');
        $this->db->JOIN('petugas','petugas.idpetugas=pemeriksaankesehatan.idpetugas');
        return $this->db->get('pemeriksaankesehatan');
    }
    public function get_data_bynama($nama)
    {
        $sql="SELECT * FROM pemeriksaankesehatan
        WHERE namapemeriksaankesehatan LIKE '$nama%' LIMIT 20";
        $query=$this->db->query($sql);
        return $query;
    }
    public function get_json($kategori="")
    {
        
        $this->datatables->select("pemeriksaankesehatan.idpemeriksaan,pemeriksaankesehatan.tanggal,pemeriksaankesehatan.diagnosa,
                            pemeriksaankesehatan.gejala_penyakit,pemeriksaankesehatan.hasil_pengobatan,pemeriksaankesehatan.keterangan
                            ,pemeriksaankesehatan.idpetugas,pemeriksaankesehatan.idsapi,pemeriksaankesehatan.pengobatan,pemeriksaankesehatan.kategori
        ,tagsapi,nomorregister," . $this->keswan_officer_expression() . " as namapetugas", false);
        $this->datatables->from('pemeriksaankesehatan');
        $this->datatables->join('sapi','sapi.idsapi=pemeriksaankesehatan.idsapi');
        $this->datatables->join('farm','farm.idfarm=sapi.idfarm','left');
        $this->datatables->join('register','register.idsapi=sapi.idsapi','left');
        $this->datatables->join('petugas','petugas.idpetugas=pemeriksaankesehatan.idpetugas','left');

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
        if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(pemeriksaankesehatan.tanggal)',$tahun);
        if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(pemeriksaankesehatan.tanggal)',$bulan);
        if(($tanggal!=""))  $this->datatables->where('pemeriksaankesehatan.tanggal',$tanggal);
      
        $this->datatables->add_column('aksi','<div class="btn-group"> 
                <a href="javascript:" id="editdata" class="btn btn-warning" data-id="$1"><i class="fas fa-pen"></i></a> 
                <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idpemeriksaan');
        $this->datatables->where('kategori',$kategori);
        return $this->datatables->generate();
    }
    
    public function get_json_report_kasus($jenis='keswan')
    {
        $user_id=$this->session->userdata('user_id');

        $sql="SELECT * FROM farm 
                LEFT JOIN web_user ON farm.kodekoperasi=web_user.kodekoperasi 
                WHERE web_user.user_id='$user_id'";
        $rs_farm=$this->db->query($sql);
        $sql1="";
        foreach($rs_farm->result() as $row_farm){
            $sql1 .= ",(SELECT count(*)FROM pemeriksaankesehatan 
                        LEFT JOIN sapi USING(idsapi) 
                        WHERE idfarm='".$row_farm->idfarm."' 
                        AND diagnosa=pk.diagnosa) ".$row_farm->idfarm;
        }
         
        $this->datatables->SELECT('DISTINCT diagnosa '.$sql1,FALSE); 
        $this->datatables->FROM('pemeriksaankesehatan pk');
        $this->datatables->JOIN('sapi','sapi.idsapi=pk.idsapi');
        $this->datatables->JOIN('register','register.idsapi=sapi.idsapi','left');
        $this->datatables->WHERE('kategori',$jenis);
        return $this->datatables->generate();
    }

    private function keswan_officer_expression()
    {
        // Older hosting schemas must still be able to display the page before migration.
        return $this->db->field_exists('petugas', 'pemeriksaankesehatan')
            ? "COALESCE(NULLIF(pemeriksaankesehatan.petugas,''),petugas.nama)" : 'petugas.nama';
    }

    public function keswan_import_ready()
    {
        if (!$this->db->field_exists('petugas', 'pemeriksaankesehatan')) { return false; }
        foreach ($this->db->field_data('pemeriksaankesehatan') as $field) {
            if ($field->name === 'pengobatan') {
                return in_array(strtolower($field->type), array('text', 'mediumtext', 'longtext'), true);
            }
        }
        return false;
    }

    private function keswan_import_query($sql, $params)
    {
        $query = $this->db->query($sql, $params);
        if (!$query) { throw new RuntimeException('gagal membaca data pendukung; baris dibatalkan.'); }
        return $query;
    }

    public function import_keswan_records($records, $scope)
    {
        return $this->import_health_records($records, $scope, 'Keswan');
    }

    public function import_reproduksi_records($records, $scope)
    {
        return $this->import_health_records($records, $scope, 'Reproduksi');
    }

    private function import_health_records($records, $scope, $category)
    {
        $result = array('success' => 0, 'skipped' => 0, 'errors' => array(), 'warnings' => array());
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            foreach ($records as $record) {
                $label = 'Baris ' . $record['line'] . ' (' . $record['tagsapi'] . ')';
                try {
                    $this->db->trans_begin();
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
                    // Serialize imports for this cow, including reimports of identical rows.
                    $cows = $this->keswan_import_query($sql . ' FOR UPDATE', $params)->result();
                    if (count($cows) !== 1) {
                        throw new RuntimeException('eartag tidak ditemukan, ganda, atau di luar peternakan/akses pengguna.');
                    }
                    $officers = $this->keswan_import_query('SELECT idpetugas FROM petugas WHERE TRIM(nama) = ?',
                        array($record['petugas']))->result();
                    if (count($officers) > 1) { throw new RuntimeException('nama petugas ganda di master; periksa terlebih dahulu.'); }
                    $existing = $this->keswan_import_query(
                        "SELECT pk.idpemeriksaan FROM pemeriksaankesehatan pk
                         LEFT JOIN petugas p ON p.idpetugas = pk.idpetugas
                         WHERE pk.idsapi = ? AND pk.kategori = '" . $category . "'
                         AND pk.tanggal >= ? AND pk.tanggal < DATE_ADD(?, INTERVAL 1 DAY)
                         AND pk.diagnosa = ? AND COALESCE(pk.pengobatan,'') = ?
                         AND COALESCE(NULLIF(pk.petugas,''),p.nama,'') = ?" .
                         ($category === 'Reproduksi' ? " AND COALESCE(pk.keterangan,'') = ?" : ''),
                        array_merge(array($cows[0]->idsapi, $record['tanggal'], $record['tanggal'],
                            $record['diagnosa'], $record['pengobatan'], $record['petugas']),
                            $category === 'Reproduksi' ? array($record['keterangan']) : array()))->result();
                    if ($existing) {
                        if (!$this->db->trans_commit()) { throw new RuntimeException('transaksi gagal.'); }
                        $result['skipped']++;
                        continue;
                    }
                    $data = array('idsapi' => $cows[0]->idsapi, 'tanggal' => $record['tanggal'],
                        'diagnosa' => $record['diagnosa'], 'pengobatan' => $record['pengobatan'],
                        'petugas' => $record['petugas'], 'idpetugas' => $officers ? $officers[0]->idpetugas : null,
                        'kategori' => $category, 'idpenyakit' => 0);
                    if ($category === 'Reproduksi') { $data['keterangan'] = $record['keterangan']; }
                    if (!$this->db->insert('pemeriksaankesehatan', $data) || !$this->db->trans_status()) {
                        throw new RuntimeException('gagal menyimpan pemeriksaan; baris dibatalkan.');
                    }
                    if (!$this->db->trans_commit()) { throw new RuntimeException('transaksi gagal.'); }
                    $result['success']++;
                    if (!$officers) {
                        $result['warnings'][] = $label . ': nama petugas tersimpan, tetapi belum terhubung ke master petugas.';
                    }
                } catch (Exception $e) {
                    $this->db->trans_rollback();
                    $result['errors'][] = $label . ': ' . $e->getMessage();
                }
            }
        } finally { $this->db->db_debug = $debug; }
        return $result;
    }

    public function save()
    {
        $data = [
            'idpemeriksaan' => '',
            'idsapi' => $this->input->post('idsapi'), 
            'tanggal' => $this->input->post('tanggal'), 
            'diagnosa' => $this->input->post('diagnosa'), 
            'pengobatan'=> $this->input->post('pengobatan'), 
            'keterangan'=> $this->input->post('keterangan'), 
            'kategori'=>$this->input->post('kategori')   ,        
            'idpetugas'=>$this->input->post('idpetugas')           
        ];
        if ($this->db->field_exists('petugas', 'pemeriksaankesehatan') && $this->input->post('petugas') !== null) {
            $data['petugas'] = $this->input->post('petugas');
        }
        $this->db->insert('pemeriksaankesehatan',$data);
    }
    public function update()
    {
        $id = $this->input->post('idpemeriksaan');
        $data = [
            'idsapi' => $this->input->post('idsapi'), 
            'tanggal' => $this->input->post('tanggal'), 
            'diagnosa' => $this->input->post('diagnosa'), 
            'pengobatan'=> $this->input->post('pengobatan'), 
            'keterangan'=> $this->input->post('keterangan'), 
            'kategori'=>$this->input->post('kategori')   ,        
            'idpetugas'=>$this->input->post('idpetugas')         
        ];
        if ($this->db->field_exists('petugas', 'pemeriksaankesehatan') && $this->input->post('petugas') !== null) {
            $data['petugas'] = $this->input->post('petugas');
        }
        $this->db->where('idpemeriksaan',$id);
        $this->db->update('pemeriksaankesehatan',$data);
    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idpemeriksaan',$id);
        $this->db->delete('pemeriksaankesehatan');
    }
}
