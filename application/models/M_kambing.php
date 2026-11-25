<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_kambing extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('kambing.eartag',$id);
        }
        $this->db->select('kambing.*');
        return $this->db->get('kambing');
    }
    public function getTagkambing($id = null)
    {
        if($id != null){
            $this->db->where('kambing.eartag',$id);
        }
        
        $rs= $this->db->get('kambing')->row();
        return $rs->tagkambing;
    }

    public function get_data_bytagkambing($tagkambing){
        $sql="SELECT * 
              FROM kambing 
              WHERE eartag LIKE '$tagkambing%' LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }
    
    public function get_data_bykode($kode){
        $sql="SELECT *
        FROM kambing 
        WHERE kelamin='Betina' AND tagkambing LIKE '$kode%' LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }
    public function get_data_bynama($kode){
        $sql="SELECT eartag,tagkambing ,namakambing
        FROM kambing 
        LEFT JOIN register USING(eartag)
        WHERE kelamin='Betina' AND namakambing LIKE '$kode%' LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }
    public function get_data_bytagkambingequal($tagkambing){
        $sql="SELECT eartag,tagkambing,nomorregister 
              FROM kambing 
              JOIN register USING(eartag)
              WHERE tagkambing = '$tagkambing'";
		$query=$this->db->query($sql);
		return $query;
    }
    public function get_numdata_bytagkambing($tagkambing){
        $sql="SELECT * 
              FROM kambing 
              WHERE tagkambing = '$tagkambing'";
		$query=$this->db->query($sql);
		return $query->num_rows();
    }
    

    public function search_data_bytagkambing($data){
        $this->db->like('tagkambing', $data , 'both');
        $this->db->order_by('tagkambing', 'ASC');
        $this->db->limit(10);
        $this->db->join('register','register.eartag=kambing.eartag');
        return $this->db->get('kambing')->result();
    }

    public function get_data_json()
    {
        $status = $this->session->userdata('status');
        if ($status==""){
            $status="hidup";
            $this->session->set_userdata('status',$status);
        } 

        $table = "(SELECT * FROM kambing WHERE status='$status'";
            $user = $this->utility->user_login();
            $id_user=$user->user_id;
            $table .= " ) temp"; 
            // $this->session->set_userdata('sql',$table);
            // echo $table;
			// Table's primary key
			$primaryKey = 'eartag';

			$columns = array(
				array('db' => 'eartag', 'dt' => 'eartag'),
				array('db' => 'jenis', 'dt' => 'jenis'),
				array('db' => 'rumpun', 'dt' => 'rumpun'),
				array('db' => 'asal', 'dt' => 'asal'),
				array('db' => 'kelamin', 'dt' => 'kelamin'),
				array('db' => 'tgllahir', 'dt' => 'tgllahir'),
				array('db' => 'bobotlahir', 'dt' => 'bobotlahir'),
				array('db' => 'taginduk', 'dt' => 'taginduk'),
				array('db' => 'tagindukjantan', 'dt' => 'tagindukjantan'),
                array(
					'db' => 'eartag',
					'dt' => 'aksi',
					'formatter' => function ($d) {
                        return "<div class='btn-group'>
                        <a href='/identifikasi/kambing/sertifikat/$d' target='_blank' class='btn btn-info btn-sm' name='id' ><i class='fas fa-search'></i></a>
                        <form action='/kambing/edit' method='post'><button class='btn btn-warning btn-sm' name='id' value='$d'><i class='fas fa-pen'></i></button></form>
                        <button class='btn btn-danger btn-sm' id='hapusdata' data-id='$d'><i class='fas fa-trash'></i></button>
                        </div>";
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

    

    public function setmati($alasan=1)
    {
        $id = $this->input->post('id');
        // $tglmati = $this->input->post('tglmati');
        $this->db->where('eartag',$id);
        if($alasan==1){
            $status="mati";
        }else
        if($alasan==2){
            $status="dijual";
        }else
        if($alasan==3){
            $status="afkir";
        }else
        if($alasan==4){
            $status="hibah";
        }
        
        $data['status']=$status;
        $this->db->update('kambing',$data);
        
        // if($alasan==1){
        //     $data_kematian['idsapi']=$id;
        //     $data_kematian['tanggal']=$tglmati;
        //     $this->db->insert('kematian',$data_kematian);
        // }

    }

    public function get_json_populasi_today()
    {
        $user = $this->utility->user_login();
        $id_user=$user->user_id;
        $id_level=$user->level_id;
        
        $kodekoperasiuser=$this->session->userdata('kodekoperasiuser');
        $idfarmuser=$this->session->userdata('idfarmuser');
         
        // $this->datatables->select("rumpun
        // ,(SELECT count(eartag) FROM kambing k1 where kambing.rumpun=k1.rumpun AND kelamin='Jantan' and status='hidup') as jantan
        // ,(SELECT count(eartag) FROM kambing k1 where kambing.rumpun=k1.rumpun AND kelamin='Betina' and status='hidup') as betina
        // ,(SELECT count(eartag) FROM kambing k1 where kambing.rumpun=k1.rumpun and status='hidup') as jumlah");
        // $this->datatables->from('kambing');
        // $this->datatables->group_by('rumpun');

        // return $this->datatables->generate();

        $this->db->select("rumpun namarumpun
                ,(SELECT count(eartag) FROM kambing k1 where kambing.rumpun=k1.rumpun AND kelamin='Jantan' and status='hidup') as jantan
                ,(SELECT count(eartag) FROM kambing k1 where kambing.rumpun=k1.rumpun AND kelamin='Betina' and status='hidup') as betina
                ,(SELECT count(eartag) FROM kambing k1 where kambing.rumpun=k1.rumpun and status='hidup') as jumlah");
        $this->db->from('kambing');
        $this->db->group_by('namarumpun');
        

        $rs =$this->db->get();
        $data['data']=$rs->result_array();
        return json_encode($data);
    }
    public function get_populasi_today()
    {   
        $this->db->select("rumpun namarumpun
                ,(SELECT count(eartag) FROM kambing k1 where kambing.rumpun=k1.rumpun AND kelamin='Jantan' and status='hidup') as jantan
                ,(SELECT count(eartag) FROM kambing k1 where kambing.rumpun=k1.rumpun AND kelamin='Betina' and status='hidup') as betina
                ,(SELECT count(eartag) FROM kambing k1 where kambing.rumpun=k1.rumpun and status='hidup') as jumlah");
        $this->db->from('kambing');
        $this->db->group_by('namarumpun');
        

        $rs =$this->db->get(); 
        return $rs;
    }

    public function get_count_pe()
    {
        $sql = "SELECT count(*) n FROM kambing WHERE rumpun='PE'";
        $rs = $this->db->query($sql);
        $row= $rs->row();
        return $row->n;
    }
    public function get_count_saneen()
    {
        $sql = "SELECT count(*) n FROM kambing WHERE rumpun='SAANEN'";
        $rs = $this->db->query($sql);
        $row= $rs->row();
        return $row->n;
    }
    
    public function get_count_jantan()
    {
        $sql = "SELECT count(*) n FROM kambing WHERE kelamin='Jantan'";
        $rs = $this->db->query($sql);
        $row= $rs->row();
        return $row->n;
    }
    
    
    public function get_count_betina()
    {
        $sql = "SELECT count(*) n FROM kambing WHERE kelamin='Betina'";
        $rs = $this->db->query($sql);
        $row= $rs->row();
        return $row->n;
    }

    public function get_populasi_berdasarkan_umur_json()
    {    
        $sql="SELECT idfarm,namafarm,namapropinsi,namakabupaten,namakecamatan,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm ) as n,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND (tgllahir IS NULL OR tgllahir='0000-00-00') AND kelamin='Betina' AND `status`='hidup') as BetinaTanpaTglLahir 
        ,(SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 < 4 AND kelamin='Betina' AND `status`='hidup') as Betinakurang4bl ,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 BETWEEN 4 AND 12 AND kelamin='Betina' AND `status`='hidup') as Betinakurang12bl ,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 >12 AND kelamin='Betina' AND `status`='hidup') as Betinalebih1th,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND (tgllahir IS NULL OR tgllahir='0000-00-00') AND kelamin='Jantan' AND `status`='hidup') as JantanTanpaTglLahir,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 < 4 AND kelamin='Jantan' AND `status`='hidup') as Jantankurang4bl ,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 BETWEEN 4 AND 12 AND kelamin='Jantan' AND `status`='hidup') as Jantankurang12bl ,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 >12 AND kelamin='Jantan' AND `status`='hidup') as Jantanlebih1th,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND  `status`='hidup') as totalkambingHidup,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND kelamin='Jantan' AND `status`='hidup') as totalkambingJantan,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND kelamin='Betina' AND `status`='hidup') as totalkambingBetina,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND kelamin='Jantan' AND `status`='Afkir') as totalkambingJantanAfkir,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND kelamin='Betina' AND `status`='Afkir') as totalkambingBetinaAfkir,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND kelamin='Jantan' AND `status`='mati') as totalkambingJantanMati,
        (SELECT count(*) FROM kambing WHERE kambing.idfarm=farm.idfarm AND kelamin='Betina' AND `status`='mati') as totalkambingBetinaMati
        FROM farm 
        JOIN wil_propinsi USING(kodepropinsi)
        JOIN wil_kabupaten USING(kodepropinsi,kodekabupaten)
        JOIN wil_kecamatan USING(kodepropinsi,kodekabupaten,kodekecamatan) WHERE 1 ";
         
                
        $sql .= " ORDER BY farm.idfarm";
                    
        return json_encode($this->db->query($sql)->result());
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

    function buatregister($eartag){
		$sql="SELECT * FROM kambing WHERE eartag='$eartag'";
		$rs=$this->db->query($sql);
		$row=$rs->row();
		echo $sql;
		$ada=($rs->num_rows>0);
		$status='hidup';
		$status_pc='';
		$tagkambing = $row->tagkambing;
		$idfarm = $row->idfarm;
		
		$kelamin = $row->kelamin;
		$tipekambing = $row->tipekambing;
		$namakambing = $row->namakambing;
		$tgllahir = $row->tgllahir;
		$bobotlahir = $row->bobotlahir;
		$status = $row->status; 
		$is_uzur = $row->is_uzur;
		$is_vbc = $row->is_vbc;
		$is_kso = $row->is_kso;
		$is_balai = $row->is_balai;
		if($row->tgllahir<>null)
			$tgllahir=$row->tgllahir;
		else	
			$tgllahir='0000-00-00';
		
		$tanggal=substr($tgllahir,8,2);
		$bulan=substr($tgllahir,5,2);
		$tahun=substr($tgllahir,0,4);
		
		$sql="SELECT count(*)+1 as n FROM kambing WHERE idfarm like '".substr($idfarm,0,3)."%"."' AND tgllahir='$tgllahir' AND eartag IN (SELECT eartag FROM register )";
		
		$rs=$this->db->query($sql);
		$row1=$rs->row();
		if($row->tgllahir<>null){
			$n=str_pad($row1->n,2,"0",STR_PAD_LEFT);
			$kodefikasi=substr($idfarm,0,3).$n.$tanggal.$bulan.substr($tahun,2,2).($tipekambing=="IB");
			$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
			$rs2=$this->db->query($sql);
			while($rs2->num_rows()>0){
				$n++;
				$n=str_pad($n,2,"0",STR_PAD_LEFT);
				$kodefikasi=substr($idfarm,0,3).$n.$tanggal.$bulan.substr($tahun,2,2).($tipekambing=="IB");
				$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
				$rs2=$this->db->query($sql);
			}
		}else{
			$n=str_pad($row1->n,7,"0",STR_PAD_LEFT);
			$kodefikasi=substr($idfarm,0,3).$n.($tipekambing=="IB");
			$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
			$rs2=$this->db->query($sql);
			while($rs2->num_rows()>0){
				$n++;
				$n=str_pad($n,7,"0",STR_PAD_LEFT);
				$kodefikasi=substr($idfarm,0,3).$n.($tipekambing=="IB");
				$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
				$rs2=$this->db->query($sql);
			}
		}
		if($kodefikasi<>""){	
			$sql="REPLACE INTO register SET
				nomorregister='$kodefikasi'
				,eartag='$eartag'
				,tanggal=CURRENT_DATE
				,status='Aktif'";
			$this->db->query($sql);
		}	
    }
    
    public function save()
    {
        $data = [
            'eartag' => htmlspecialchars($this->input->post('eartag')),
            'kelamin' => $this->input->post('kelamin'),
            'rumpun' => $this->input->post('rumpun'),
            'tgllahir' => $this->input->post('tgllahir'),
            'bobotlahir' => $this->input->post('bobotlahir'),
            'taginduk' => $this->input->post('taginduk'),
            'tagindukjantan' => $this->input->post('tagindukjantan'),
        ];
        $this->db->insert('kambing',$data);
    }
     
    
    public function update()
    {
        $id = $this->input->post('id');
       
        $data = [ 
            'eartag' => htmlspecialchars($this->input->post('eartag')),
            'kelamin' => $this->input->post('kelamin'),
            'rumpun' => $this->input->post('rumpun'),
            'tgllahir' => $this->input->post('tgllahir'),
            'bobotlahir' => $this->input->post('bobotlahir'),
            'taginduk' => $this->input->post('taginduk'),
            'tagindukjantan' => $this->input->post('tagindukjantan'),
        ];
        
        $this->db->where('eartag',$id);
        $this->db->update('kambing',$data);
        
        $this->db->where('eartag',$id);
       
    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('eartag',$id);
        $this->db->delete('kambing');
    }
    
    function getInduk($eartag){
		$sql="SELECT 
            nomorregisterdam as nomorregisterinduk 
			,kodedam 
			,kodedam idinduk
			,tagdam
			,tgllahirdam 
			,tgllahirdam tgllahirinduk
			,namadam 
			,namadam namainduk 
			,tagdam as taginduk
			,(SELECT milk FROM kambing WHERE kambing.eartag=tetua.kodesire) milkdam
            ,(SELECT fat FROM kambing WHERE kambing.eartag=tetua.kodesire) fatdam
            ,(SELECT protein FROM kambing WHERE kambing.eartag=tetua.kodesire) proteindam

            ,nomorregistersire as nomorregisterpejantan
            ,kodesire 
            ,kodesire idpejantan 
            ,tagsire  
            ,tgllahirsire  
            ,tgllahirsire tgllahirpejantan 
            ,namasire 
            ,namasire namapejantan 
			,tagsire as tagpejantan  
            ,(SELECT milkbv FROM kambing WHERE kambing.eartag=tetua.kodesire) milksire
            ,(SELECT fatbv FROM kambing WHERE kambing.eartag=tetua.kodesire) fatsire
            ,(SELECT proteinbv FROM kambing WHERE kambing.eartag=tetua.kodesire) proteinsire
			FROM tetua 
			WHERE eartag='$eartag'";
		$rs=$this->db->query($sql);
		
		if($rs->num_rows()==0){
            $sql="SELECT 
			register.nomorregister as nomorregisterinduk,
			kambing.eartag as kodedam,
			kambing.eartag as idinduk,
			kambing.tagkambing as tagdam,
			kambing.tgllahir as tgllahirdam,
			kambing.tgllahir as tgllahirinduk,
			kambing.namakambing as namadam,
			kambing.tagkambing as taginduk,
			'-' as nomorregisterpejantan,
			(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.eartag=reproduksi_kelahiran.eartag AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as kodesire, 
			(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.eartag=reproduksi_kelahiran.eartag AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as idpejantan, 
			(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.eartag=reproduksi_kelahiran.eartag AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as tagsire, 
			(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.eartag=reproduksi_kelahiran.eartag AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as tagpejantan, 
			(SELECT semen.namakambing FROM reproduksi_ib 
			LEFT JOIN kambing semen ON reproduksi_ib.kodesemen=semen.tagkambing 
			WHERE reproduksi_ib.eartag=reproduksi_kelahiran.eartag AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as namapejantan ,
			'0000-00-00' as tgllahirpejantan
			from reproduksi_kelahiran 
			join reproduksi_kelahiran_anak USING(idkelahiran)
			join kambing as pedet ON pedet.eartag=reproduksi_kelahiran_anak.eartag
			join kambing ON kambing.eartag=reproduksi_kelahiran.eartag
			LEFT join register ON kambing.eartag=register.eartag
			WHERE pedet.eartag='$eartag'"; 
			$rs=$this->db->query($sql);
		}
		return $rs;
	}
}