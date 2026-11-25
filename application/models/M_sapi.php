<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_sapi extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('sapi.idsapi',$id);
        }
        $this->db->select('sapi.*,farm.namafarm,register.nomorregister,ref_asal.namaasal
                        ,wil_propinsi.kodepropinsi,wil_propinsi.namapropinsi
                        ,wil_kabupaten.kodekabupaten,wil_kabupaten.namakabupaten
                        ,wil_kecamatan.kodekecamatan,wil_kecamatan.namakecamatan');
        $this->db->join('farm','farm.idfarm=sapi.idfarm');
        $this->db->join('wil_propinsi','wil_propinsi.kodepropinsi = farm.kodepropinsi');
        $this->db->join('wil_kabupaten','wil_kabupaten.kodepropinsi = farm.kodepropinsi AND wil_kabupaten.kodekabupaten=farm.kodekabupaten');
        $this->db->join('wil_kecamatan','wil_kecamatan.kodepropinsi = farm.kodepropinsi AND wil_kecamatan.kodekabupaten = farm.kodekabupaten AND wil_kecamatan.kodekecamatan = farm.kodekecamatan');
        $this->db->join('register','register.idsapi=sapi.idsapi','left');
        $this->db->join('ref_asal','ref_asal.idasal=sapi.idasal','left');
        
        return $this->db->get('sapi');
    }
    public function getTagSapi($id = null)
    {
        if($id != null){
            $this->db->where('sapi.idsapi',$id);
        }
        
        $rs= $this->db->get('sapi')->row();
        return $rs->tagsapi;
    }

    public function get_data_bytagsapi($tagsapi){
        $sql="SELECT idsapi,tagsapi,nomorregister,kelamin 
              FROM sapi 
              JOIN register USING(idsapi)
              WHERE tagsapi LIKE '$tagsapi%' LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }
    
    public function get_data_bykode($kode){
        $sql="SELECT idsapi,tagsapi,nomorregister,namasapi 
        FROM sapi 
        LEFT JOIN register USING(idsapi)
        WHERE kelamin='Betina' AND tagsapi LIKE '$kode%' LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }
    public function get_data_bynama($kode){
        $sql="SELECT idsapi,tagsapi,nomorregister ,namasapi
        FROM sapi 
        LEFT JOIN register USING(idsapi)
        WHERE kelamin='Betina' AND namasapi LIKE '$kode%' LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }
    public function get_data_bytagsapiequal($tagsapi){
        $sql="SELECT idsapi,tagsapi,nomorregister 
              FROM sapi 
              JOIN register USING(idsapi)
              WHERE tagsapi = '$tagsapi'";
		$query=$this->db->query($sql);
		return $query;
    }
    public function get_numdata_bytagsapi($tagsapi){
        $sql="SELECT * 
              FROM sapi 
              WHERE tagsapi = '$tagsapi'";
		$query=$this->db->query($sql);
		return $query->num_rows();
    }
    
    public function search_data_bytagsapi($data){
        $this->db->like('tagsapi', $data , 'both');
        $this->db->order_by('tagsapi', 'ASC');
        $this->db->limit(10);
        $this->db->join('register','register.idsapi=sapi.idsapi');
        return $this->db->get('sapi')->result();
    }

    public function get_data_json()
    {
        $table = "(SELECT sapi.idsapi,sapi.idfarm,sapi.namasapi,farm.namafarm,sapi.kelamin,sapi.tipesapi,sapi.status
                    ,nomorregister,sapi.tgllahir,ref_asal.namaasal status_asal,'' status_bunting,'' status_laktasi, tagsapi,bobotlahir,if(is_balai=1,'BALAI',if(is_uzur=1,'UZUR','')) balai_uzur 
                    ,(SELECT is_bunting FROM reproduksi_ib ib where ib.idsapi=sapi.idsapi ORDER BY tanggal DESC LIMIT 1) is_bunting_ib_terakhir
                    ,(SELECT max(tanggal) FROM reproduksi_ib ib where ib.idsapi=sapi.idsapi ) tanggal_ib_terakhir
                    ,(SELECT DATEDIFF(NOW(),max(tanggal)) FROM reproduksi_ib ib where ib.idsapi=sapi.idsapi ) lama_ib_terakhir
                    ,(SELECT max(tanggal) FROM reproduksi_kelahiran k where k.idsapi=sapi.idsapi ) tanggal_melahirkan_terakhir
                    ,(SELECT max(xlaktasi) FROM reproduksi_kelahiran k where k.idsapi=sapi.idsapi ) laktasi_terakhir
                    ,(SELECT DATEDIFF(NOW(),max(tanggal)) FROM reproduksi_kelahiran k where k.idsapi=sapi.idsapi ) lama_melahirkan_terakhir
                    ,(SELECT max(tanggal) FROM reproduksi_pkb pkb where pkb.idsapi=sapi.idsapi and pkb.hasil='P') pkb_positif_terakhir
                    ,(SELECT DATEDIFF(NOW(),max(tanggal)) FROM reproduksi_pkb pkb where pkb.idsapi=sapi.idsapi and pkb.hasil='P') lama_pkb_positif_terakhir
                    FROM sapi
                    JOIN farm USING(idfarm)
                    LEFT JOIN register USING(idsapi) 
                    LEFT JOIN ref_asal USING(idasal)
                    WHERE 1
                    ";
            $user = $this->utility->user_login();
            $id_user=$user->user_id;
            $kodepropinsi=($this->session->userdata("kodepropinsi")!=""?$this->session->userdata("kodepropinsi"):$this->M_user->get_kodepropinsi($id_user));
            $kodekabupaten=($this->session->userdata("kodekabupaten")!=""?$this->session->userdata("kodekabupaten"):$this->M_user->get_kodekabupaten($id_user));
            $kodekecamatan=($this->session->userdata("kodekecamatan")!=""?$this->session->userdata("kodekecamatan"):$this->M_user->get_kodekecamatan($id_user));
            $idfarm=((($this->session->userdata("idfarm")!="")&&($this->session->userdata("idfarm")!="0"))?$this->session->userdata("idfarm"):$this->M_user->get_idfarm($id_user));
            
            $kelamin=$this->session->userdata('kelamin');
            $status=$this->session->userdata('status');
            $is_balai=$this->session->userdata('is_balai');
            $is_uzur=$this->session->userdata('is_uzur');
            $is_vbc=$this->session->userdata('is_vbc');

            if($kodepropinsi!='') $table .= " AND farm.kodepropinsi='$kodepropinsi'";
            if($kodekabupaten!='') $table .= " AND farm.kodekabupaten='$kodekabupaten'";
            if($kodekecamatan!='') $table .= " AND farm.kodekecamatan='$kodekecamatan'";
            if($idfarm!='0' && $idfarm!='') $table .= " AND sapi.idfarm='$idfarm'";
            if($kelamin!='') $table .= " AND sapi.kelamin='$kelamin'";
            if($status!='') 
                $table .= " AND sapi.status='$status'";
            else
                $table .= " AND sapi.status='Hidup'";
            
            if($is_balai=='1') $table .= " AND sapi.is_balai='1'";
            if($is_uzur=='1') $table .= " AND sapi.is_uzur='1'";
            if($is_vbc=='1') $table .= " AND sapi.is_vbc='1'";
             
            $table .= " ) temp"; 
            // $this->session->set_userdata('sql',$table);
            // echo $table;
			// Table's primary key
			$primaryKey = 'idsapi';

			$columns = array(
				array('db' => 'nomorregister', 'dt' => 'nomorregister'),
				array('db' => 'idsapi', 'dt' => 'idsapi'),
				array('db' => 'idfarm', 'dt' => 'idfarm'),
				array('db' => 'namasapi', 'dt' => 'namasapi'),
				array('db' => 'namafarm', 'dt' => 'namafarm'),
                array('db' => 'tagsapi', 'dt' => 'tagsapi',
                'formatter' => function ($d,$row) {
                    return "<div id='tagsapi-$row[idsapi]'>$d</div>";
                }
            ),
				array('db' => 'kelamin', 'dt' => 'kelamin'),
				array('db' => 'bobotlahir', 'dt' => 'bobotlahir'),
				array('db' => 'tipesapi', 'dt' => 'tipesapi'),
                array('db' => 'tgllahir', 'dt' => 'tgllahir',
                                'formatter' => function ($d, $row) {
                                    return date('Y-m-d', strtotime($d));
                                }
                     ),
				array('db' => 'balai_uzur', 'dt' => 'balai_uzur'),
				array('db' => 'status_asal', 'dt' => 'status_asal'),
				array('db' => 'tanggal_ib_terakhir', 'dt' => 'status_bunting'),
                array('db' => 'laktasi_terakhir', 'dt' => 'status_laktasi',
                    'formatter'=> function($d){
                        return "<div class='text-center'>$d<div>";
                    }
                ),
				// array('db' => 'status', 'dt' => 'status',
                //         'formatter' => function ($d, $row) {
                //             return strtoupper($d);
                //         }
                //     ),
				array(
					'db' => 'idsapi',
					'dt' => 'aksi',
					'formatter' => function ($d) {
                        return "<div class='btn-group'>
                        <a href='/identifikasi/sapi/detail/$d' class='btn btn-info btn-sm' name='id' ><i class='fas fa-search'></i></a>
                        <form action='/identifikasi/sapi/edit' method='post'><button class='btn btn-warning btn-sm' name='id' value='$d'><i class='fas fa-pen'></i></button></form>
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
    public function get_json()
    {
        
        $this->datatables->select('farm.idfarm,farm.namafarm,farm.alamatfarm,farm.namapeternak,namakecamatan,namakabupaten,namapropinsi');
        $this->datatables->from('farm');
        $this->datatables->join('wil_propinsi','wil_propinsi.kodepropinsi = farm.kodepropinsi');
        $this->datatables->join('wil_kabupaten','wil_kabupaten.kodepropinsi = farm.kodepropinsi AND wil_kabupaten.kodekabupaten=farm.kodekabupaten');
        $this->datatables->join('wil_kecamatan','wil_kecamatan.kodepropinsi = farm.kodepropinsi AND wil_kecamatan.kodekabupaten = farm.kodekabupaten AND wil_kecamatan.kodekecamatan = farm.kodekecamatan');
        $this->datatables->add_column('aksi','<div class="btn-group"><form action="/identifikasi/pengguna/edit" method="post"><button class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button></form><button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idfarm');
        
        return $this->datatables->generate();
    }
    public function get_json_populasi_today()
    {
        $user = $this->utility->user_login();
        $id_user=$user->user_id;
        $id_level=$user->level_id;
        
        $kodekoperasiuser=$this->session->userdata('kodekoperasiuser');
        $idfarmuser=$this->session->userdata('idfarmuser');

        $this->datatables->select("namafarm
                ,(SELECT count(idsapi) FROM sapi where sapi.idfarm=farm.idfarm AND kelamin='Jantan' and status='hidup') as jantan
                ,(SELECT count(idsapi) FROM sapi where sapi.idfarm=farm.idfarm AND kelamin='Betina' and status='hidup') as betina
                ,(SELECT count(idsapi) FROM sapi where sapi.idfarm=farm.idfarm and status='hidup') as jumlah");
        $this->datatables->from('farm');
        if($kodekoperasiuser<>""){
            $this->datatables->where('kodekoperasi',$kodekoperasiuser);
        }else
        if($idfarmuser<>""){
            $this->datatables->where('idfarm',$idfarmuser);
        }

        return $this->datatables->generate();
    }
    public function get_populasi_today()
    {
        
        $user = $this->utility->user_login();
        $id_user=$user->user_id;
        $id_level=$user->level_id;
        $kodekoperasiuser=$this->session->userdata('kodekoperasiuser');
        $idfarmuser=$this->session->userdata('idfarmuser');
        
        $this->db->select("namafarm
                ,(SELECT count(idsapi) FROM sapi where sapi.idfarm=farm.idfarm AND kelamin='Jantan' and status='hidup') as jantan
                ,(SELECT count(idsapi) FROM sapi where sapi.idfarm=farm.idfarm AND kelamin='Betina' and status='hidup') as betina
                ,(SELECT count(idsapi) FROM sapi where sapi.idfarm=farm.idfarm and status='hidup') as jumlah");
        $this->db->from('farm');
        if($kodekoperasiuser<>""){
            $this->db->where('kodekoperasi',$kodekoperasiuser);
        }else
        if($idfarmuser<>""){
            $this->db->where('idfarm',$idfarmuser);
        }

        $rs =$this->db->get();
        // echo $this->db->last_query();
        return $rs;
    }

    public function get_populasi_berdasarkan_umur_json()
    {    
        $sql="SELECT idfarm,namafarm,namapropinsi,namakabupaten,namakecamatan,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm ) as n,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND (tgllahir IS NULL OR tgllahir='0000-00-00') AND kelamin='Betina' AND `status`='hidup') as BetinaTanpaTglLahir 
        ,(SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 < 4 AND kelamin='Betina' AND `status`='hidup') as Betinakurang4bl ,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 BETWEEN 4 AND 12 AND kelamin='Betina' AND `status`='hidup') as Betinakurang12bl ,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 >12 AND kelamin='Betina' AND `status`='hidup') as Betinalebih1th,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND (tgllahir IS NULL OR tgllahir='0000-00-00') AND kelamin='Jantan' AND `status`='hidup') as JantanTanpaTglLahir,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 < 4 AND kelamin='Jantan' AND `status`='hidup') as Jantankurang4bl ,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 BETWEEN 4 AND 12 AND kelamin='Jantan' AND `status`='hidup') as Jantankurang12bl ,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND DATEDIFF(CURDATE(),tgllahir)/30 >12 AND kelamin='Jantan' AND `status`='hidup') as Jantanlebih1th,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND  `status`='hidup') as totalSapiHidup,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND kelamin='Jantan' AND `status`='hidup') as totalSapiJantan,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND kelamin='Betina' AND `status`='hidup') as totalSapiBetina,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND kelamin='Jantan' AND `status`='Afkir') as totalSapiJantanAfkir,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND kelamin='Betina' AND `status`='Afkir') as totalSapiBetinaAfkir,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND kelamin='Jantan' AND `status`='mati') as totalSapiJantanMati,
        (SELECT count(*) FROM sapi WHERE sapi.idfarm=farm.idfarm AND kelamin='Betina' AND `status`='mati') as totalSapiBetinaMati
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

    function buatregister($idsapi){
		$sql="SELECT * FROM sapi WHERE idsapi='$idsapi'";
		$rs=$this->db->query($sql);
		$row=$rs->row();
		$status='hidup';
		$status_pc='';
		$tagsapi = $row->tagsapi;
		$idfarm = $row->idfarm;
		
		$kelamin = $row->kelamin;
		$tipesapi = $row->tipesapi;
		$namasapi = $row->namasapi;
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
		
		$sql="SELECT count(*)+1 as n FROM sapi WHERE idfarm like '".substr($idfarm,0,3)."%"."' AND tgllahir='$tgllahir' AND idsapi IN (SELECT idsapi FROM register )";
		
		$rs=$this->db->query($sql);
		$row1=$rs->row();
		if($row->tgllahir<>null){
			$n=str_pad($row1->n,2,"0",STR_PAD_LEFT);
			$kodefikasi=substr($idfarm,0,3).$n.$tanggal.$bulan.substr($tahun,2,2).($tipesapi=="IB");
			$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
			$rs2=$this->db->query($sql);
			while($rs2->num_rows()>0){
				$n++;
				$n=str_pad($n,2,"0",STR_PAD_LEFT);
				$kodefikasi=substr($idfarm,0,3).$n.$tanggal.$bulan.substr($tahun,2,2).($tipesapi=="IB");
				$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
				$rs2=$this->db->query($sql);
			}
		}else{
			$n=str_pad($row1->n,7,"0",STR_PAD_LEFT);
			$kodefikasi=substr($idfarm,0,3).$n.($tipesapi=="IB");
			$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
			$rs2=$this->db->query($sql);
			while($rs2->num_rows()>0){
				$n++;
				$n=str_pad($n,7,"0",STR_PAD_LEFT);
				$kodefikasi=substr($idfarm,0,3).$n.($tipesapi=="IB");
				$sql="SELECT * FROM register WHERE nomorregister='$kodefikasi'";
				$rs2=$this->db->query($sql);
			}
		}
		if($kodefikasi<>""){	
			$sql="REPLACE INTO register SET
				nomorregister='$kodefikasi'
				,idsapi='$idsapi'
				,tanggal=CURRENT_DATE
				,status='Aktif'";
			$this->db->query($sql);
		}	
    }
    
    public function save()
    {
        $kodepropinsi=$this->input->post('kodepropinsi');
        $kodekabupaten=$this->input->post('kodekabupaten');
        $kodekecamatan=$this->input->post('kodekecamatan'); 
        $is_balai=($this->input->post('sapibalai')=="Balai");
        $is_uzur=($this->input->post('sapiuzur')=="Uzur");
        $is_vbc=($this->input->post('sapivbc')=="VBC"); 
        $data = [
            'idsapi' => null,
            'namasapi' => htmlspecialchars($this->input->post('namasapi')), 
            'idfarm' => $this->input->post('idfarm'),
            'tagsapi' => htmlspecialchars($this->input->post('tagsapi')),
            'idbangsa' => '1',
            'kelamin' => $this->input->post('kelamin'),
            'tipesapi' => $this->input->post('tipesapi'),
            'tgllahir' => $this->input->post('tgllahir'),
            'bobotlahir' => $this->input->post('bobotlahir'),
            'status' => 'hidup',
            'is_balai' => $is_balai,
            'is_uzur' => $is_uzur,
            'is_vbc' => $is_vbc,
            'tglinput' => date('Y-m-d'),
            'idasal' => $this->input->post('idasal')        
        ];
        $this->db->insert('sapi',$data);
        $idsapi=$this->db->insert_id();
        $this->buatregister($idsapi);
    }
     
    
    public function update()
    {
        $id = $this->input->post('idsapi');
        $kodepropinsi=$this->input->post('kodepropinsi');
        $kodekabupaten=$this->input->post('kodekabupaten');
        $kodekecamatan=$this->input->post('kodekecamatan'); 
        $is_balai=($this->input->post('sapibalai')=="Balai");
        $is_uzur=($this->input->post('sapiuzur')=="Uzur");
        $is_vbc=($this->input->post('sapivbc')=="VBC");  
        $data = [ 
            'namasapi' => htmlspecialchars($this->input->post('namasapi')), 
            'idfarm' => $this->input->post('idfarm'),
            'tagsapi' => htmlspecialchars($this->input->post('tagsapi')),
            'idbangsa' => '1',
            'kelamin' => $this->input->post('kelamin'),
            'tipesapi' => $this->input->post('tipesapi'),
            'tgllahir' => $this->input->post('tgllahir'),
            'bobotlahir' => $this->input->post('bobotlahir'),
            'status' => 'hidup',
            'is_balai' => $is_balai,
            'is_uzur' => $is_uzur,
            'is_vbc' => $is_vbc,
            'tglinput' => date('Y-m-d'),
            'idasal' => $this->input->post('idasal')        
        ];
        
        $this->db->where('idsapi',$id);
        $this->db->update('sapi',$data);
        
        $this->db->where('idsapi',$id);
        $rs=$this->db->get('register');
        if($rs->num_rows()==0) $this->buatregister($id);
    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idsapi',$id);
        $this->db->delete('sapi');
    }
    public function setmati($alasan=1)
    {
        $id = $this->input->post('id');
        $tglmati = $this->input->post('tglmati');
        $this->db->where('idsapi',$id);
        if($alasan==1){
            $status="mati";
        }else
        if($alasan==2){
            $status="dijual";
        }else
        if($alasan==3){
            $status="afkir";
        }else
        if($alasan==1){
            $status="hibah";
        }
        
        $data['status']=$status;
        $this->db->update('sapi',$data);
        
        if($alasan==1){
            $data_kematian['idsapi']=$id;
            $data_kematian['tanggal']=$tglmati;
            $this->db->insert('kematian',$data_kematian);
        }

    }
    function getInduk1($idsapi){
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
			,(SELECT milk FROM sapi WHERE sapi.idsapi=tetua.kodedam) milkdam
            ,(SELECT fat FROM sapi WHERE sapi.idsapi=tetua.kodedam) fatdam
            ,(SELECT protein FROM sapi WHERE sapi.idsapi=tetua.kodedam) proteindam

            ,nomorregistersire as nomorregisterpejantan
            ,kodesire 
            ,kodesire idpejantan 
            ,tagsire  
            ,tgllahirsire  
            ,tgllahirsire tgllahirpejantan 
            ,namasire 
            ,namasire namapejantan 
			,tagsire as tagpejantan  
            ,(SELECT milkbv FROM sapi WHERE sapi.idsapi=tetua.kodesire) milksire
            ,(SELECT fatbv FROM sapi WHERE sapi.idsapi=tetua.kodesire) fatsire
            ,(SELECT proteinbv FROM sapi WHERE sapi.idsapi=tetua.kodesire) proteinsire
			FROM tetua 
			WHERE idsapi='$idsapi'";
		$rs=$this->db->query($sql);
        
		if($rs->num_rows()==0){
            $sql="SELECT 
			register.nomorregister as nomorregisterinduk,
			sapi.idsapi as kodedam,
			sapi.idsapi as idinduk,
			sapi.tagsapi as tagdam,
			sapi.tgllahir as tgllahirdam,
			sapi.tgllahir as tgllahirinduk,
			sapi.namasapi as namadam,
			sapi.namasapi as namainduk,
			sapi.tagsapi as taginduk
            ,sapi.milk milkdam
            ,sapi.fat fatdam
            ,sapi.protein proteindam,

			'-' as nomorregisterpejantan,
			(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as kodesire, 
			(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as idpejantan, 
			(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as tagsire, 
			(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as tagpejantan, 
			(SELECT semen.namasapi FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as namasire ,
			(SELECT semen.namasapi FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as namapejantan 
            ,'0000-00-00' as tgllahirsire
			,'0000-00-00' as tgllahirpejantan
            ,(SELECT semen.milk FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) milksire
            ,(SELECT semen.fat FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) fatsire
            ,(SELECT semen.protein FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) proteinsire
			from reproduksi_kelahiran 
			join reproduksi_kelahiran_anak USING(idkelahiran)
			join sapi as pedet ON pedet.idsapi=reproduksi_kelahiran_anak.idsapi
			join sapi ON sapi.idsapi=reproduksi_kelahiran.idsapi
			LEFT join register ON sapi.idsapi=register.idsapi
			WHERE pedet.idsapi='$idsapi'"; 
			$rs=$this->db->query($sql);
		}
		return $rs;
	}
    
    function getInduk($idsapi){
		$sql="SELECT 
        iddam 
        ,kodedam 
        ,(SELECT nomorregister FROM register where register.idsapi=sapi.iddam) nomorregisterdam
        ,(SELECT tagsapi FROM sapi dam where dam.idsapi=sapi.iddam) tagdam
        ,(SELECT tgllahir FROM sapi dam where dam.idsapi=sapi.iddam) tgllahirdam
        ,(SELECT namasapi FROM sapi dam where dam.idsapi=sapi.iddam) namadam
        ,(SELECT milk FROM sapi dam where dam.idsapi=sapi.iddam) milkdam
        ,(SELECT fat FROM sapi dam where dam.idsapi=sapi.iddam) fatdam
        ,(SELECT protein FROM sapi dam where dam.idsapi=sapi.iddam) proteindam
        
        ,idsire 
        ,kodesire
        ,(SELECT nomorregister FROM register where register.idsapi=sapi.idsire) nomorregistersire
        ,(SELECT tagsapi FROM sapi dam where dam.idsapi=sapi.idsire) tagsire
        ,(SELECT tgllahir FROM sapi dam where dam.idsapi=sapi.idsire) tgllahirsire
        ,(SELECT namasapi FROM sapi dam where dam.idsapi=sapi.idsire) namasire
        ,(SELECT milk FROM sapi dam where dam.idsapi=sapi.idsire) milksire
        ,(SELECT fat FROM sapi dam where dam.idsapi=sapi.idsire) fatsire
        ,(SELECT protein FROM sapi dam where dam.idsapi=sapi.idsire) proteinsire

        FROM sapi
        WHERE idsapi='$idsapi'";
		$rs=$this->db->query($sql);
        
		if($rs->num_rows()==0){
            $sql="SELECT 
			sapi.idsapi as iddam
            ,sapi.idsapi as kodedam
            ,register.nomorregister as nomorregisterdam
            ,sapi.tagsapi as tagdam
            ,sapi.tgllahir as tgllahirdam
            ,sapi.namasapi as namadam
            ,sapi.milk milkdam
            ,sapi.fat fatdam
            ,sapi.protein proteindam
            
            ,(SELECT sapi.idsapi FROM reproduksi_ib JOIN sapi ON sapi.tagsapi=reproduksi_ib.kodesemen 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as idsire

            ,(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as kodesire

            ,'-' as nomorregistersire

            ,(SELECT kodesemen FROM reproduksi_ib 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as tagsire

            ,(SELECT semen.tgllahir FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as tgllahirsire
            
            ,(SELECT semen.namasapi FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) as namasire 
			
            ,(SELECT semen.milk FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) milksire

            ,(SELECT semen.fat FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) fatsire
            ,(SELECT semen.protein FROM reproduksi_ib 
			LEFT JOIN sapi semen ON reproduksi_ib.kodesemen=semen.tagsapi 
			WHERE reproduksi_ib.idsapi=reproduksi_kelahiran.idsapi AND tanggal<reproduksi_kelahiran.tanggal 
			ORDER BY tanggal DESC limit 1) proteinsire
			from reproduksi_kelahiran 
			join reproduksi_kelahiran_anak USING(idkelahiran)
			join sapi as pedet ON pedet.idsapi=reproduksi_kelahiran_anak.idsapi
			join sapi ON sapi.idsapi=reproduksi_kelahiran.idsapi
			LEFT join register ON sapi.idsapi=register.idsapi
			WHERE pedet.idsapi='$idsapi'"; 
			$rs=$this->db->query($sql);
		}
		return $rs;
	}
}
