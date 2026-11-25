<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_farm extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idfarm',$id);
        }
        $this->db->join('wil_propinsi','wil_propinsi.kodepropinsi = farm.kodepropinsi');
        $this->db->join('wil_kabupaten','wil_kabupaten.kodepropinsi = farm.kodepropinsi AND wil_kabupaten.kodekabupaten=farm.kodekabupaten');
        $this->db->join('wil_kecamatan','wil_kecamatan.kodepropinsi = farm.kodepropinsi AND wil_kecamatan.kodekabupaten = farm.kodekabupaten AND wil_kecamatan.kodekecamatan = farm.kodekecamatan');
        $user = $this->session->userdata('user'); 
		$kodekoperasi=$user->kodekoperasi;
        $idfarm=$user->idfarmuser;
        if($user->level_id==2){
			$this->db->where("idfarm IN (SELECT idfarm FROM farm WHERE kodekoperasi='$kodekoperasi')");
		}else
		if($user->level_id>3){
			$this->db->where("idfarm",$idfarm);
        }
        return $this->db->get('farm');
    }

    public function get_all_in_kecamatan($kodepropinsi="G",$kodekabupaten="I",$kodekecamatan="D")
    {
        $this->db->where('kodepropinsi',$kodepropinsi);
        $this->db->where('kodekabupaten',$kodekabupaten);
        $this->db->where('kodekecamatan',$kodekecamatan);
        
        
		$user=$this->session->userdata('user');
		$kodekoperasi=$user->kodekoperasi;
        $idfarm=$user->idfarmuser;
        if($user->level_id==2){
			$this->db->where("idfarm IN (SELECT idfarm FROM farm WHERE kodekoperasi='$kodekoperasi')");
		}else
		if($user->level_id>3){
			$this->db->where("idfarm",$idfarm);
        }
        
        $rs=$this->db->order_by('namafarm');
        $rs=$this->db->get('farm');
        return $rs;
    }
    public function get_data_json()
    {
        $table = "(SELECT farm.*,prop.namapropinsi,kab.namakabupaten,kec.namakecamatan 
						FROM farm
						JOIN wil_propinsi prop USING(kodepropinsi)
						JOIN wil_kabupaten kab USING(kodepropinsi,kodekabupaten)
						JOIN wil_kecamatan kec USING(kodepropinsi,kodekabupaten,kodekecamatan) ";
			
			$table .= " ) temp";
			// $this->session->set_userdata('sql',$table);
			// Table's primary key
			$primaryKey = 'idfarm';

			$columns = array(
				array('db' => 'idfarm', 'dt' => 'idfarm'),
				array('db' => 'namafarm', 'dt' => 'namafarm'),
				array('db' => 'alamatfarm', 'dt' => 'alamatfarm'),
				array('db' => 'namapeternak', 'dt' => 'namapeternak'),
				array('db' => 'namakecamatan', 'dt' => 'namakecamatan'),
				array('db' => 'namakabupaten', 'dt' => 'namakabupaten'),
				array('db' => 'namapropinsi', 'dt' => 'namapropinsi'),
				array(
					'db' => 'idfarm',
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
    public function get_json()
    {
        $user = $this->utility->user_login(); 
		$id_user=$user->user_id;
        $kodepropinsi=($this->session->userdata("kodepropinsi")!=""?$this->session->userdata("kodepropinsi"):$this->M_user->get_kodepropinsi($id_user));
		$kodekabupaten=($this->session->userdata("kodekabupaten")!=""?$this->session->userdata("kodekabupaten"):$this->M_user->get_kodekabupaten($id_user));
		$kodekecamatan=($this->session->userdata("kodekecamatan")!=""?$this->session->userdata("kodekecamatan"):$this->M_user->get_kodekecamatan($id_user));
	 
        $this->datatables->select('farm.namafarm,farm.idfarm,farm.alamatfarm,farm.namapeternak,namakecamatan,namakabupaten,namapropinsi');
        $this->datatables->from('farm');
        $this->datatables->join('wil_propinsi','wil_propinsi.kodepropinsi = farm.kodepropinsi');
        $this->datatables->join('wil_kabupaten','wil_kabupaten.kodepropinsi = farm.kodepropinsi AND wil_kabupaten.kodekabupaten=farm.kodekabupaten');
        $this->datatables->join('wil_kecamatan','wil_kecamatan.kodepropinsi = farm.kodepropinsi AND wil_kecamatan.kodekabupaten = farm.kodekabupaten AND wil_kecamatan.kodekecamatan = farm.kodekecamatan');
        if(($user->level_id==2)||($user->level_id==3)){
            $this->datatables->add_column('aksi','<div class="btn-group"><form action="/identifikasi/peternakan/edit" method="post">
            <button class="btn btn-warning" name="id" value="$1">
            <i class="fas fa-pen"></i></button></form><button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idfarm');
        }else{
            $this->datatables->add_column('aksi','<div class="btn-group">&nbsp;</div>','idfarm');
        }
        $this->datatables->where('farm.kodepropinsi',$kodepropinsi);
        $this->datatables->where('farm.kodekabupaten',$kodekabupaten);
        $this->datatables->where('farm.kodekecamatan',$kodekecamatan);
        return $this->datatables->generate();
    }

    public function get_last_id($kodepropinsi,$kodekabupaten,$kodekecamatan)
    {
        $kode=$kodepropinsi.$kodekabupaten.$kodekecamatan;
        $sql="select concat('$kode',lpad((count(*)+1),4,'0')) last_kode from farm WHERE idfarm LIKE '$kode%'";
        $rs=$this->db->query($sql);
        if($rs->num_rows()>0){
            $row=$rs->row();
            return $row->last_kode;
        }else
            return "";
    }
    public function save()
    {
        $kodepropinsi=$this->input->post('kodepropinsi');
        $kodekabupaten=$this->input->post('kodekabupaten');
        $kodekecamatan=$this->input->post('kodekecamatan');
        $last_id=$this->get_last_id($kodepropinsi,$kodekabupaten,$kodekecamatan);
        
        $data = [
            'idfarm' => $last_id,
            'namafarm' => htmlspecialchars($this->input->post('namafarm')),
            'alamatfarm' => htmlspecialchars($this->input->post('alamatfarm')),
            'namapeternak' => htmlspecialchars($this->input->post('namapeternak')),
            'kodepropinsi' => $kodepropinsi,
            'kodekabupaten' => $kodekabupaten,
            'kodekecamatan' => $kodekecamatan
        ];
        $this->db->insert('farm',$data);
    }
    public function update()
    {
        $id = $this->input->post('idfarm');
        $data = [
            'namafarm' => htmlspecialchars($this->input->post('namafarm')),
            'namapeternak' => htmlspecialchars($this->input->post('namapeternak')),
            'alamatfarm' => $this->input->post('alamatfarm'),
            'kodepropinsi' => $this->input->post('kodepropinsi'),
            'kodekabupaten' => $this->input->post('kodekabupaten'),
            'kodekecamatan' => $this->input->post('kodekecamatan')
        ];
        $this->db->where('idfarm',$id);
        $this->db->update('farm',$data);
    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idfarm',$id);
        $this->db->delete('farm');
    }
    function get_list_data_by_kecamatan($kodepropinsi,$kodekabupaten,$kodekecamatan){
		$this->db->from('farm');
		$this->db->where('kodepropinsi',$kodepropinsi);
		$this->db->where('kodekabupaten',$kodekabupaten);
		$this->db->where('kodekecamatan',$kodekecamatan);
		$this->db->order_by('namafarm');
		return $this->db->get();
	}
}