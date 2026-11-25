<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_kualitassusu extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idpengukuran',$id);
        }
        $this->db->select('pengukuran_kualitassusu.*,sapi.tagsapi,register.nomorregister');
        $this->db->join('sapi','sapi.idsapi=pengukuran_kualitassusu.idsapi');
        $this->db->join('register','sapi.idsapi=register.idsapi','left');
         return $this->db->get('pengukuran_kualitassusu');
    }
   
    public function get_json($kodepropinsi,$kodekabupaten,$kodekecamatan,$idfarm,$bulan,$tahun)
    {
        
        $this->datatables->select('susu.idpengukuran,DATE_FORMAT(susu.tanggal,"%Y-%m-%d") as tanggal,susu.kadarlemak,susu.kadarair,susu.kadarbk,susu.protein,susu.bahankeringtanpalemak,susu.beratjenis,susu.laktosa,sapi.tagsapi,register.nomorregister');
        $this->datatables->from('pengukuran_kualitassusu susu');
        $this->datatables->join('sapi','sapi.idsapi=susu.idsapi');
        $this->datatables->join('farm','sapi.idfarm=farm.idfarm');
        $this->datatables->join('register','sapi.idsapi=register.idsapi','left');

        if(($tahun<>"")&&($tahun<>"0")) $this->datatables->where('YEAR(susu.tanggal)',$tahun);
        if(($bulan<>"")&&($bulan<>"0")) $this->datatables->where('MONTH(susu.tanggal)',$bulan);
        if(($kodepropinsi<>"")&&($kodepropinsi<>"0")) $this->datatables->where('kodepropinsi',$kodepropinsi);
        if(($kodekabupaten<>"")&&($kodekabupaten<>"0")) $this->datatables->where('kodekabupaten',$kodekabupaten);
        if(($kodekecamatan<>"")&&($kodekecamatan<>"0")) $this->datatables->where('kodekecamatan',$kodekecamatan);
        if(($idfarm<>"")&&($idfarm<>"0")) $this->datatables->where('farm.idfarm',$idfarm);
        
        $this->datatables->order_by('susu.tanggal DESC,sapi.tagsapi');
        $this->datatables->add_column('aksi','<div class="btn-group"><button id="editdata" data-id="$1" class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button>
        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idpengukuran');
        
        return $this->datatables->generate();
    }
    
    
    public function import_records($records, $scope)
    {
        $result = array('success' => 0, 'errors' => array(), 'warnings' => array());
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            foreach ($records as $record) {
                $label = 'Baris ' . $record['line'] . ' (' . $record['tagsapi'] . ')';
                try {
                    $this->db->trans_begin();
                    $sql = "SELECT idsapi FROM sapi WHERE tagsapi = ? AND (tipesapi IS NULL OR tipesapi <> 'Semen')";
                    $params = array($record['tagsapi']);
                    if ($scope['level_id'] == 2) { $sql .= ' AND idfarm IN (SELECT idfarm FROM farm WHERE kodekoperasi = ?)'; $params[] = $scope['kodekoperasi']; }
                    elseif ($scope['level_id'] == 4) { $sql .= ' AND idfarm = ?'; $params[] = $scope['idfarm']; }
                    if (!empty($scope['selected_farm'])) { $sql .= ' AND idfarm = ?'; $params[] = $scope['selected_farm']; }
                    $query = $this->db->query($sql . ' FOR UPDATE', $params);
                    if (!$query) { throw new RuntimeException('gagal membaca sapi.'); }
                    $cows = $query->result();
                    if (count($cows) !== 1) { throw new RuntimeException('sapi tidak ditemukan, tag ganda, atau di luar peternakan/akses pengguna.'); }
                    $query = $this->db->query('SELECT idpengukuran FROM pengukuran_kualitassusu WHERE idsapi = ? AND tanggal >= ? AND tanggal < DATE_ADD(?, INTERVAL 1 DAY) FOR UPDATE', array($cows[0]->idsapi, $record['tanggal'], $record['tanggal']));
                    if (!$query) { throw new RuntimeException('gagal membaca pengukuran.'); }
                    $existing = $query->result();
                    if (count($existing) > 1) { throw new RuntimeException('terdapat beberapa pengukuran pada tanggal yang sama; periksa data ganda terlebih dahulu.'); }
                    $data = $record; unset($data['line'], $data['tagsapi']); $data['idsapi'] = $cows[0]->idsapi;
                    if ($existing) {
                        unset($data['tanggal']);
                        $this->db->where('idpengukuran', $existing[0]->idpengukuran);
                        $saved = $this->db->update('pengukuran_kualitassusu', $data);
                    } else { $saved = $this->db->insert('pengukuran_kualitassusu', $data); }
                    if (!$saved || !$this->db->trans_status()) { throw new RuntimeException('gagal menyimpan; perubahan baris dibatalkan.'); }
                    if (!$this->db->trans_commit()) { throw new RuntimeException('transaksi gagal.'); }
                    $result['success']++;
                } catch (Exception $e) { $this->db->trans_rollback(); $result['errors'][] = $label . ': ' . $e->getMessage(); }
            }
        } finally { $this->db->db_debug = $debug; }
        return $result;
    }

    public function save()
    {
        $data = [
            'idpengukuran' => '',
            'idsapi' => htmlspecialchars($this->input->post('idsapi')),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'kadarlemak' => htmlspecialchars($this->input->post('kadarlemak')),
            'kadarair' => htmlspecialchars($this->input->post('kadarair')),
            'kadarbk' => htmlspecialchars($this->input->post('kadarbk')),
            'protein' => htmlspecialchars($this->input->post('protein')),
            'bahankeringtanpalemak' => htmlspecialchars($this->input->post('bahankeringtanpalemak')),
            'beratjenis' => htmlspecialchars($this->input->post('beratjenis')),
            'laktosa' => htmlspecialchars($this->input->post('laktosa'))
        ];
        $this->db->insert('pengukuran_kualitassusu',$data);
    }
    public function update()
    {
        $id = $this->input->post('idpengukuran');
        $data = [
            'idsapi' => htmlspecialchars($this->input->post('idsapi')),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'kadarlemak' => htmlspecialchars($this->input->post('kadarlemak')),
            'kadarair' => htmlspecialchars($this->input->post('kadarair')),
            'kadarbk' => htmlspecialchars($this->input->post('kadarbk')),
            'protein' => htmlspecialchars($this->input->post('protein')),
            'bahankeringtanpalemak' => htmlspecialchars($this->input->post('bahankeringtanpalemak')),
            'beratjenis' => htmlspecialchars($this->input->post('beratjenis')),
            'laktosa' => htmlspecialchars($this->input->post('laktosa'))
        ];
        $this->db->where('idpengukuran',$id);
        $this->db->update('pengukuran_kualitassusu',$data);
    }
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idpengukuran',$id);
        $this->db->delete('pengukuran_kualitassusu');
    }
}
