<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_kandang extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idkandang',$id);
        }
        $this->db->join('farm','farm.idfarm = kandangsapi.idfarm');
        $this->db->join('wil_propinsi','wil_propinsi.kodepropinsi = farm.kodepropinsi');
        $this->db->join('wil_kabupaten','wil_kabupaten.kodepropinsi = farm.kodepropinsi AND wil_kabupaten.kodekabupaten=farm.kodekabupaten');
        $this->db->join('wil_kecamatan','wil_kecamatan.kodepropinsi = farm.kodepropinsi AND wil_kecamatan.kodekabupaten = farm.kodekabupaten AND wil_kecamatan.kodekecamatan = farm.kodekecamatan');
        return $this->db->get('kandangsapi');
    }
    public function get_data_json()
    {
        $table = "(SELECT kandangsapi.*,farm.namafarm,prop.namapropinsi,kab.namakabupaten,kec.namakecamatan 
                        FROM kandangsapi
                        JOIN farm USING(idfarm)
						JOIN wil_propinsi prop USING(kodepropinsi)
						JOIN wil_kabupaten kab USING(kodepropinsi,kodekabupaten)
						JOIN wil_kecamatan kec USING(kodepropinsi,kodekabupaten,kodekecamatan) ";
			
			$table .= " ) temp";
			// $this->session->set_userdata('sql',$table);
			// Table's primary key
			$primaryKey = 'idkandang';

			$columns = array(
				array('db' => 'idkandang', 'dt' => 'idkandang'),
				array('db' => 'namakandang', 'dt' => 'namakandang'),
				array('db' => 'namafarm', 'dt' => 'namafarm'),
				array('db' => 'lokasikandang', 'dt' => 'lokasikandang'),
				array('db' => 'kapasitas', 'dt' => 'kapasitas'),
				array('db' => 'namakecamatan', 'dt' => 'namakecamatan'),
				array('db' => 'namakabupaten', 'dt' => 'namakabupaten'),
				array('db' => 'namapropinsi', 'dt' => 'namapropinsi'),
				array(
					'db' => 'idkandang',
					'dt' => 'aksi',
					'formatter' => function ($d) {
                        return "<div class='btn-group'><form action='/identifikasi/kandang/edit' method='post'><button class='btn btn-warning btn-sm' name='id' value='$d'><i class='fas fa-pen'></i></button></form>
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
    public function get_json()
    {
        
        $this->datatables->select('kandangsapi.idkandang,kandangsapi.namakandang,kandangsapi.alamatkandang,kandangsapi.namapeternak,namakecamatan,namakabupaten,namapropinsi');
        $this->datatables->from('kandangsapi');
        $this->db->join('farm','farm.idfarm = kandangsapi.idfarm');
        $this->db->join('wil_propinsi','wil_propinsi.kodepropinsi = farm.kodepropinsi');
        $this->db->join('wil_kabupaten','wil_kabupaten.kodepropinsi = farm.kodepropinsi AND wil_kabupaten.kodekabupaten=farm.kodekabupaten');
        $this->db->join('wil_kecamatan','wil_kecamatan.kodepropinsi = farm.kodepropinsi AND wil_kecamatan.kodekabupaten = farm.kodekabupaten AND wil_kecamatan.kodekecamatan = farm.kodekecamatan');
        $this->datatables->add_column('aksi','<div class="btn-group"><form action="/identifikasi/pengguna/edit" method="post"><button class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button></form><button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idkandang');
        
        return $this->datatables->generate();
    }

    public function get_last_id($kodepropinsi,$kodekabupaten,$kodekecamatan)
    {
        $kode=$kodepropinsi.$kodekabupaten.$kodekecamatan;
        $sql="select concat('$kode',lpad((count(*)+1),4,'0')) last_kode from kandang WHERE idkandang LIKE '$kode%'";
        $rs=$this->db->query($sql);
        if($rs->num_rows()>0){
            $row=$rs->row();
            return $row->last_kode;
        }else
            return "";
    }
    public function save()
    {
      
        $data = [
            'idfarm' => htmlspecialchars($this->input->post('idfarm')),
            'namakandang' => htmlspecialchars($this->input->post('namakandang')),
            'lokasikandang' => htmlspecialchars($this->input->post('lokasikandang')),
            'kapasitas' => htmlspecialchars($this->input->post('kapasitas'))
        ];
        $this->db->insert('kandangsapi',$data);
    }
    public function update()
    {
        $id = $this->input->post('idkandang');
        $data = [
            'namakandang' => htmlspecialchars($this->input->post('namakandang')),
            'lokasikandang' => htmlspecialchars($this->input->post('lokasikandang')),
            'kapasitas' => htmlspecialchars($this->input->post('kapasitas')),
            'idfarm' => htmlspecialchars($this->input->post('idfarm'))
        ];
        $this->db->where('idkandang',$id);
        $this->db->update('kandangsapi',$data);
    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idkandang',$id);
        $this->db->delete('kandangsapi');
    }
}