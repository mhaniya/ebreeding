<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_susu extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idpengukuran',$id);
        }
        $this->db->select('pengukuran_produksisusu.*,sapi.tagsapi,register.nomorregister');
        $this->db->join('sapi','sapi.idsapi=pengukuran_produksisusu.idsapi');
        $this->db->join('register','sapi.idsapi=register.idsapi','left');
         return $this->db->get('pengukuran_produksisusu');
    }
    
    function getDataProduksiSapi($idsapi)
	{
//(SELECT IFNULL(max(xlaktasi),1) FROM reproduksi_kelahiran k WHERE k.idsapi=pengukuran_produksisusu.idsapi AND k.tanggal<pengukuran_produksisusu.tanggal) as 
		$this->db->select("xlaktasi 
,sum(pagi+sore) as jmlproduksi
,min(pagi+sore) as minproduksi
,max(pagi+sore) as maxproduksi
,datediff(max(tanggal),min(tanggal)) as jhp,0 as jmlterkoreksi",FALSE);
		$this->db->from('pengukuran_produksisusu');
		$this->db->where('pengukuran_produksisusu.idsapi',$idsapi);
		$this->db->where('xlaktasi >','0');
		$this->db->group_by('xlaktasi');
		return $this->db->get();
	}
    public function getProduksiPerLaktasiByIDSapi($id = null)
    {
        if($id != null){
            $this->db->where('sapi.idsapi',$id);
        }
        $this->db->select('pengukuran_produksisusu.*,sapi.tagsapi,register.nomorregister');
        $this->db->join('sapi','sapi.idsapi=pengukuran_produksisusu.idsapi');
        $this->db->join('register','sapi.idsapi=register.idsapi','left');
         return $this->db->get('pengukuran_produksisusu');
    }
    public function get_data_json()
    {
        $table = "(SELECT susu.idpengukuran,susu.idsapi,susu.tanggal,round(susu.pagi,2) as pagi,round(susu.sore,2) as sore,xlaktasi
                    ,sapi.tagsapi,register.nomorregister,round(susu.pagi+susu.sore,2) as jumlah
                    ,(SELECT kel.tanggal FROM reproduksi_kelahiran kel 
                        WHERE kel.idsapi=susu.idsapi 
                        AND kel.tanggal<susu.tanggal 
                        ORDER BY kel.tanggal DESC LIMIT 1) as tglberanak
						FROM pengukuran_produksisusu susu
						JOIN sapi ON sapi.idsapi=susu.idsapi
                        LEFT JOIN register ON sapi.idsapi=register.idsapi
                        ORDER BY susu.tanggal DESC
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
				array(
                    'db' => 'tanggal', 
                    'dt' => 'tanggal'
                ),
				array('db' => 'pagi', 'dt' => 'pagi'),
				array('db' => 'sore', 'dt' => 'sore'),
				array('db' => 'jumlah', 'dt' => 'jumlah'),
				array('db' => 'xlaktasi', 'dt' => 'xlaktasi'),
				array('db' => 'tglberanak', 'dt' => 'tglberanak'),
				array(
					'db' => 'idpengukuran',
					'dt' => 'aksi',
					'formatter' => function ($d) {
                        return "<div class='btn-group'><form action='/produksi/susu_vertikal/edit' method='post'>
                        <button class='btn btn-warning btn-sm' name='id' value='$d'><i class='fas fa-pen'></i></button></form>
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

    public function get_produksi_per_tahun()
    {
        $sql="SELECT * FROM (SELECT year(tanggal) tahun,round(sum(pagi),1) pagi, round(sum(sore),1) sore,round(sum(pagi+sore),1) jumlah 
        FROM pengukuran_produksisusu
        GROUP BY tahun 
        ORDER BY tahun DESC 
        LIMIT 5) tabel ORDER BY tahun";
        return $this->db->query($sql);
    }
    public function get_data_produksi($kodepropinsi,$kodekabupaten,$kodekecamatan,$idfarm,$bulan,$tahun)
    {
        $sql="SELECT sapi.idsapi,sapi.tagsapi,sapi.tgllahir ,register.*
			  FROM pengukuran_produksisusu susu
			  JOIN sapi ON sapi.idsapi=susu.idsapi
			  JOIN farm ON farm.idfarm=sapi.idfarm
			  LEFT JOIN register ON sapi.idsapi=register.idsapi
              WHERE 1";
        
        if(($tahun<>"")&&($tahun<>"0")) $sql .= " AND year(susu.tanggal)='$tahun'";
        if(($bulan<>"")&&($bulan<>"0")) $sql .= " AND month(susu.tanggal)='$bulan'";
        if(($kodepropinsi<>"")&&($kodepropinsi<>"0")) $sql .= " AND kodepropinsi='$kodepropinsi'";
        if(($kodekabupaten<>"")&&($kodekabupaten<>"0")) $sql .= " AND kodekabupaten='$kodekabupaten'";
        if(($kodekecamatan<>"")&&($kodekecamatan<>"0")) $sql .= " AND kodekecamatan='$kodekecamatan'";
        if(($idfarm<>"")&&($idfarm<>"0")) $sql .= " AND sapi.idfarm='$idfarm'";
		$sql .= "GROUP BY sapi.idsapi";
		
        $data=$this->db->query($sql);
        return $data;
    }

    public function get_json_produksi_dan_tetua()
    {
        $sql="SELECT 
        sapi.tagsapi,nomorregister,DATE_FORMAT(tgllahir,'%Y-%m-%d') tgllahir
        ,kel.tanggal tgllaktasi,kel.xlaktasi
        ,(SELECT tanggal FROM reproduksi_ib ib where ib.idsapi=sapi.idsapi ORDER BY tanggal DESC LIMIT 1) tglibterakhir
        ,(SELECT kodesemen FROM reproduksi_ib ib where ib.idsapi=sapi.idsapi ORDER BY tanggal DESC LIMIT 1) kodesemenibterakhir
        ,(SELECT semen.namasapi as namasemen FROM reproduksi_ib ib JOIN sapi semen ON semen.tagsapi=ib.kodesemen WHERE ib.idsapi=sapi.idsapi ORDER BY tanggal DESC LIMIT 1) namasemenibterakhir
        ,(SELECT pedet.tagsapi FROM sapi pedet WHERE pedet.idsapi=kel.idsapipedet) tagsapipedet
        ,(SELECT pedet.kelamin FROM sapi pedet WHERE pedet.idsapi=kel.idsapipedet) kelaminpedet
        ,(SELECT pedet.bobotlahir FROM sapi pedet WHERE pedet.idsapi=kel.idsapipedet) bobotlahirpedet
        ,0 produksisusuterkoreksi
        ,sapi.kodesire
        ,sapi.namasire
        ,sapi.kodedam
        ,sapi.namadam
        ,(SELECT kodesire FROM sapi sire where sire.idsapi=sapi.idsire) kodepgs
        ,(SELECT namasire FROM sapi sire where sire.idsapi=sapi.idsire) namapgs
        
        ,(SELECT kodedam FROM sapi sire where sire.idsapi=sapi.idsire) kodepgd
        ,(SELECT namadam FROM sapi sire where sire.idsapi=sapi.idsire) namapgd
        
        ,(SELECT kodesire FROM sapi dam where dam.idsapi=sapi.iddam) kodemgs
        ,(SELECT namasire FROM sapi dam where dam.idsapi=sapi.iddam) namamgs
        
        ,(SELECT kodedam FROM sapi dam where dam.idsapi=sapi.iddam) kodemgd
        ,(SELECT namadam FROM sapi dam where dam.idsapi=sapi.iddam) namamgd
        
        FROM sapi
        JOIN farm ON farm.idfarm=sapi.idfarm
        LEFT JOIN register ON register.idsapi=sapi.idsapi
        JOIN reproduksi_kelahiran kel ON kel.idsapi=sapi.idsapi
        -- LEFT JOIN tetua ON tetua.idsapi=sapi.idsapi
        WHERE sapi.`status`='hidup' and kelamin='betina'";
    $kodepropinsi  = $this->session->userdata('kodepropinsi');
    $kodekabupaten = $this->session->userdata('kodekabupaten');
    $kodekecamatan = $this->session->userdata('kodekecamatan');
    $idfarm = $this->session->userdata('idfarm');
    // $tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
    // $bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
    // $tanggal = $this->session->userdata('tanggal');
    // $xlaktasi = $this->session->userdata('xlaktasi');

    if(($kodepropinsi!="")&&($kodepropinsi!="0")) $sql .=" AND kodepropinsi='$kodepropinsi'";
    if(($kodekabupaten!="")&&($kodekabupaten!="0")) $sql .=" AND kodekabupaten='$kodekabupaten'";
    if(($kodekecamatan!="")&&($kodekecamatan!="0")) $sql .=" AND kodekecamatan='$kodekecamatan'";
    if(($idfarm!="")&&($idfarm!="0")) $sql .=" AND farm.idfarm='$idfarm'";
     
    // if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(tanggal)',$tahun);
    // if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(tanggal)',$bulan);
    // if(($tanggal!=""))  $this->datatables->where('tanggal',$tanggal);
    // if(($xlaktasi==-1)){
    //     $this->datatables->where('laktasike=maxxlaktasi');
    // }else   
    // if(($xlaktasi!="")&&($xlaktasi!="0"))  
    // $this->datatables->where('laktasike',$xlaktasi);

        $sql .=" ORDER BY tgllaktasi DESC,kel.xlaktasi"; 
        $rs=$this->db->query($sql);
        return $rs;

    }
    public function get_json()
    {
        
        // $this->db->query($sql);
        $this->datatables->select('susu.idpengukuran,susu.idsapi,susu.tanggal,susu.kandang,round(susu.pagi,2) as pagi,round(susu.sore,2) as sore,xlaktasi 
        ,kodepropinsi,kodekabupaten,kodekecamatan,farm.idfarm
        ,sapi.tagsapi,register.nomorregister,round(susu.pagi+susu.sore,2) as jumlah
        ,(SELECT max(tanggal) FROM reproduksi_kelahiran kel WHERE kel.idsapi=susu.idsapi AND kel.tanggal<susu.tanggal) as tglberanak
        ,(SELECT max(xlaktasi) FROM reproduksi_kelahiran kel WHERE kel.idsapi=susu.idsapi AND kel.tanggal<susu.tanggal) as laktasike
        ,(SELECT max(xlaktasi) FROM reproduksi_kelahiran kel WHERE kel.idsapi=susu.idsapi ) as maxxlaktasi');
        $this->datatables->from('pengukuran_produksisusu susu');
        $this->datatables->join('sapi','sapi.idsapi=susu.idsapi');
        $this->datatables->join('register','sapi.idsapi=register.idsapi','left');
        $this->datatables->join('farm','farm.idfarm=sapi.idfarm','left');
        $this->datatables->where('sapi.status','hidup');
        $this->datatables->order_by('susu.tanggal DESC,tagsapi');
       
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
        if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(susu.tanggal)',$tahun);
        if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(susu.tanggal)',$bulan);
        if(($tanggal!=""))  $this->datatables->where('susu.tanggal',$tanggal);
        if(($xlaktasi==-1)){
            $this->datatables->where('laktasike=maxxlaktasi');
        }else   
        if(($xlaktasi!="")&&($xlaktasi!="0"))  
            $this->datatables->where('laktasike',$xlaktasi);
        
        // if(($xlaktasi!="")&&($xlaktasi!="0"))  $this->datatables->where('(SELECT max(xlaktasi) FROM reproduksi_kelahiran kel WHERE kel.idsapi=susu.idsapi AND kel.tanggal<susu.tanggal)',$xlaktasi);
        
        $this->datatables->add_column('aksi','<div class="btn-group"><button id="editdata" data-id="$1" class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button>
        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idpengukuran');
        
        $rs =$this->datatables->generate();  
        return $rs;
    }

    public function get_json_produksi_5tahun_terakhir()
    {
        $user = $this->utility->user_login();
        $id_user=$user->user_id;
        $id_level=$user->level_id;
        $kodekoperasi="";
        $idfarmuser="";
        if($id_level==2){
            $this->db->where('user_id',$id_user);
            $rs=$this->db->get('web_user');
            $row=$rs->row();
            $kodekoperasi=$row->kodekoperasi;
        }else
        if($id_level==4){
            $this->db->where('user_id',$id_user);
            $rs=$this->db->get('web_user');
            $row=$rs->row();
            $idfarmuser=$row->idfarmuser;
        }
        $sql="SELECT year(tanggal) tahun,round(avg(pagi),1) pagi, round(avg(sore),1) sore,round(avg(pagi+sore),1) rerata 
        FROM pengukuran_produksisusu
        JOIN sapi USING(idsapi)
        JOIN farm USING(idfarm)";
        if($kodekoperasi<>""){
            $sql .= " WHERE kodekoperasi='$kodekoperasi'";
        }else
        if($idfarmuser<>""){
            $sql .= " WHERE sapi.idfarm='$idfarmuser'";
        }
        $sql.=" GROUP BY tahun
        ORDER BY tahun DESC
        LIMIT 5";
        $this->datatables->select("tabel.tahun, tabel.pagi,tabel.sore, tabel.rerata");
        $this->datatables->from("($sql) tabel");
        $this->datatables->order_by('tahun');
        
        return $this->datatables->generate();
    }
    public function get_report_json()
    {
        
        $this->datatables->select('susu.idpengukuran,susu.idsapi,susu.tanggal,round(susu.pagi,2) as pagi,round(susu.sore,2) as sore,xlaktasi
                ,sapi.tagsapi,register.nomorregister,round(susu.pagi+susu.sore,2) as jumlah');
        $this->datatables->from('pengukuran_produksisusu susu');
        $this->datatables->join('sapi','sapi.idsapi=susu.idsapi');
        $this->datatables->join('register','sapi.idsapi=register.idsapi','left');
        $this->datatables->order_by('susu.tanggal DESC,sapi.tagsapi');
        return $this->datatables->generate();
    }
    
    public function get_produksi_terkoreksi($idsapi=""){
        $this->db->select('sapi.idsapi,sapi.tagsapi
	            ,register.nomorregister,sapi.tgllahir
                ,reproduksi_kelahiran.tanggal as tglmelahirkan
                ,reproduksi_kelahiran.xlaktasi
                ,IF((SELECT count(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k 
                where k.idsapi=reproduksi_kelahiran.idsapi 
                and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
                ))>0
                ,(SELECT max(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k 
                where k.idsapi=reproduksi_kelahiran.idsapi 
                and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
                ORDER BY tanggal DESC LIMIT 1)),
                (SELECT max(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                )
                )
                as tanggalibterakhir
                ,IF((SELECT count(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k 
                where k.idsapi=reproduksi_kelahiran.idsapi 
                and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
                ))>0
                ,(SELECT kodesemen FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k  							where k.idsapi=reproduksi_kelahiran.idsapi  							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1  							ORDER BY tanggal DESC LIMIT 1) ORDER BY reproduksi_ib.tanggal DESC LIMIT 1)
                ,(SELECT kodesemen FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal  ORDER BY reproduksi_ib.tanggal DESC LIMIT 1))
                as kodesemen
                ,IF((SELECT count(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k 
                where k.idsapi=reproduksi_kelahiran.idsapi 
                and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
                ))>0
                ,(SELECT semen.namasapi as namasemen FROM reproduksi_ib LEFT JOIN sapi semen ON semen.tagsapi=reproduksi_ib.kodesemen WHERE reproduksi_ib.idsapi=sapi.idsapi AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k  							where k.idsapi=reproduksi_kelahiran.idsapi
                and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1  							
                ORDER BY tanggal DESC LIMIT 1) ORDER BY reproduksi_ib.tanggal DESC LIMIT 1)
                ,(SELECT semen.namasapi as namasemen FROM reproduksi_ib LEFT JOIN sapi semen ON semen.tagsapi=reproduksi_ib.kodesemen WHERE reproduksi_ib.idsapi=sapi.idsapi AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal  ORDER BY reproduksi_ib.tanggal DESC LIMIT 1))
                as namasemen
                ,s1.tagsapi as tagpedet
                ,reproduksi_kelahiran_anak.jeniskelamin as kelaminpedet
                ,reproduksi_kelahiran_anak.bobotlahir
                ,DATEDIFF(max(pengukuran_produksisusu.tanggal), reproduksi_kelahiran.tanggal)-6 as jhp
                ,ROUND(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365) + ((DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)-(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)))*12/100,2) as umur
                ,(SELECT sum(p.pagi+p.sore) FROM pengukuran_produksisusu p WHERE p.xlaktasi=pengukuran_produksisusu.xlaktasi 
                AND p.idsapi=pengukuran_produksisusu.idsapi) as produksinyata
                ,(SELECT min(p.pagi+p.sore) FROM pengukuran_produksisusu p WHERE p.xlaktasi=pengukuran_produksisusu.xlaktasi 
                AND p.idsapi=pengukuran_produksisusu.idsapi) as minproduksi
                ,(SELECT max(p.pagi+p.sore) FROM pengukuran_produksisusu p WHERE p.xlaktasi=pengukuran_produksisusu.xlaktasi 
                AND p.idsapi=pengukuran_produksisusu.idsapi) as maxproduksi
                ,(SELECT KOREKSI FROM con_koreksiumur WHERE UMUR=(ROUND(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365) + ((DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)-(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)))*12/100,2))) as koreksiumur
                ,(SELECT KOREKSI FROM con_koreksijhp WHERE JHP=(DATEDIFF(max(pengukuran_produksisusu.tanggal), reproduksi_kelahiran.tanggal)-6)) as koreksijhp
                ,round((SELECT sum(p.pagi+p.sore) FROM pengukuran_produksisusu p WHERE p.xlaktasi=pengukuran_produksisusu.xlaktasi 
                AND p.idsapi=pengukuran_produksisusu.idsapi) 
                *(SELECT KOREKSI FROM con_koreksiumur WHERE UMUR=(ROUND(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365) + ((DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)-(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)))*12/100,2))) 
                *(SELECT KOREKSI FROM con_koreksijhp WHERE JHP=(DATEDIFF(max(pengukuran_produksisusu.tanggal), reproduksi_kelahiran.tanggal)-6)),3) as produksiterkoreksi
                ,(SELECT sum(pagi+sore) FROM pengukuran_produksisusu p WHERE p.idsapi=pengukuran_produksisusu.idsapi AND p.xlaktasi=pengukuran_produksisusu.xlaktasi AND p.tanggal<=DATE_ADD(reproduksi_kelahiran.tanggal,INTERVAL 305 day)) as produksi305');
        $this->db->from('sapi'); 
        $this->db->join('register','sapi.idsapi=register.idsapi','left');
        $this->db->join('reproduksi_kelahiran','reproduksi_kelahiran.idsapi=sapi.idsapi','left');
        $this->db->join('pengukuran_produksisusu','pengukuran_produksisusu.idsapi=reproduksi_kelahiran.idsapi AND pengukuran_produksisusu.xlaktasi=reproduksi_kelahiran.xlaktasi','left');
        $this->db->join('reproduksi_kelahiran_anak','reproduksi_kelahiran_anak.idkelahiran=reproduksi_kelahiran.idkelahiran','left');
        $this->db->join('sapi s1','s1.idsapi=reproduksi_kelahiran_anak.idsapi','left');
        $this->db->join('farm','farm.idfarm=sapi.idfarm','left');
        $this->db->where('sapi.status','hidup');
        $this->db->where('sapi.kelamin','BETINA');
        if($idsapi!=""){
            $this->db->where('sapi.idsapi',$idsapi);
        }
        $this->db->group_by('sapi.idsapi,pengukuran_produksisusu.xlaktasi');
        $this->db->having('produksi305>0');
        $this->db->order_by('sapi.idsapi');
        $rs= $this->db->get(); 
		return $rs;
    }

    public function get_terkoreksi_json($idsapi=""){
        $this->db->select('sapi.idsapi,sapi.tagsapi
	            ,register.nomorregister,sapi.tgllahir
                ,reproduksi_kelahiran.tanggal as tglmelahirkan
                ,reproduksi_kelahiran.xlaktasi
                ,IF((SELECT count(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k 
                where k.idsapi=reproduksi_kelahiran.idsapi 
                and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
                ))>0
                ,(SELECT max(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k 
                where k.idsapi=reproduksi_kelahiran.idsapi 
                and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
                ORDER BY tanggal DESC LIMIT 1)),
                (SELECT max(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                )
                )
                as tanggalibterakhir
                ,IF((SELECT count(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k 
                where k.idsapi=reproduksi_kelahiran.idsapi 
                and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
                ))>0
                ,(SELECT kodesemen FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k  							where k.idsapi=reproduksi_kelahiran.idsapi  							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1  							ORDER BY tanggal DESC LIMIT 1) ORDER BY reproduksi_ib.tanggal DESC LIMIT 1)
                ,(SELECT kodesemen FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal  ORDER BY reproduksi_ib.tanggal DESC LIMIT 1))
                as kodesemen
                ,IF((SELECT count(reproduksi_ib.tanggal) FROM reproduksi_ib WHERE reproduksi_ib.idsapi=sapi.idsapi 
                AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal 
                AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k 
                where k.idsapi=reproduksi_kelahiran.idsapi 
                and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1 
                ))>0
                ,(SELECT semen.namasapi as namasemen FROM reproduksi_ib LEFT JOIN sapi semen ON semen.tagsapi=reproduksi_ib.kodesemen WHERE reproduksi_ib.idsapi=sapi.idsapi AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal AND reproduksi_ib.tanggal>(SELECT k.tanggal FROM reproduksi_kelahiran k  							where k.idsapi=reproduksi_kelahiran.idsapi  							and k.xlaktasi=reproduksi_kelahiran.xlaktasi-1  							ORDER BY tanggal DESC LIMIT 1) ORDER BY reproduksi_ib.tanggal DESC LIMIT 1)
                ,(SELECT semen.namasapi as namasemen FROM reproduksi_ib LEFT JOIN sapi semen ON semen.tagsapi=reproduksi_ib.kodesemen WHERE reproduksi_ib.idsapi=sapi.idsapi AND reproduksi_ib.tanggal<reproduksi_kelahiran.tanggal  ORDER BY reproduksi_ib.tanggal DESC LIMIT 1))
                as namasemen
                ,s1.tagsapi as tagpedet
                ,reproduksi_kelahiran_anak.jeniskelamin as kelaminpedet
                ,reproduksi_kelahiran_anak.bobotlahir
                ,DATEDIFF(max(pengukuran_produksisusu.tanggal), reproduksi_kelahiran.tanggal)-6 as jhp
                ,ROUND(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365) + ((DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)-(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)))*12/100,2) as umur
                ,(SELECT sum(p.pagi+p.sore) FROM pengukuran_produksisusu p WHERE p.xlaktasi=pengukuran_produksisusu.xlaktasi 
                AND p.idsapi=pengukuran_produksisusu.idsapi) as produksinyata
                ,(SELECT min(p.pagi+p.sore) FROM pengukuran_produksisusu p WHERE p.xlaktasi=pengukuran_produksisusu.xlaktasi 
                AND p.idsapi=pengukuran_produksisusu.idsapi) as minproduksi
                ,(SELECT max(p.pagi+p.sore) FROM pengukuran_produksisusu p WHERE p.xlaktasi=pengukuran_produksisusu.xlaktasi 
                AND p.idsapi=pengukuran_produksisusu.idsapi) as maxproduksi
                ,(SELECT KOREKSI FROM con_koreksiumur WHERE UMUR=(ROUND(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365) + ((DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)-(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)))*12/100,2))) as koreksiumur
                ,(SELECT KOREKSI FROM con_koreksijhp WHERE JHP=(DATEDIFF(max(pengukuran_produksisusu.tanggal), reproduksi_kelahiran.tanggal)-6)) as koreksijhp
                ,round((SELECT sum(p.pagi+p.sore) FROM pengukuran_produksisusu p WHERE p.xlaktasi=pengukuran_produksisusu.xlaktasi 
                AND p.idsapi=pengukuran_produksisusu.idsapi) 
                *(SELECT KOREKSI FROM con_koreksiumur WHERE UMUR=(ROUND(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365) + ((DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)-(floor(DATEDIFF(max(pengukuran_produksisusu.tanggal), sapi.tgllahir)/365)))*12/100,2))) 
                *(SELECT KOREKSI FROM con_koreksijhp WHERE JHP=(DATEDIFF(max(pengukuran_produksisusu.tanggal), reproduksi_kelahiran.tanggal)-6)),3) as produksiterkoreksi
                ,(SELECT sum(pagi+sore) FROM pengukuran_produksisusu p WHERE p.idsapi=pengukuran_produksisusu.idsapi AND p.xlaktasi=pengukuran_produksisusu.xlaktasi AND p.tanggal<=DATE_ADD(reproduksi_kelahiran.tanggal,INTERVAL 305 day)) as produksi305');
        $this->db->from('sapi'); 
        $this->db->join('register','sapi.idsapi=register.idsapi','left');
        $this->db->join('reproduksi_kelahiran','reproduksi_kelahiran.idsapi=sapi.idsapi','left');
        $this->db->join('pengukuran_produksisusu','pengukuran_produksisusu.idsapi=reproduksi_kelahiran.idsapi AND pengukuran_produksisusu.xlaktasi=reproduksi_kelahiran.xlaktasi','left');
        $this->db->join('reproduksi_kelahiran_anak','reproduksi_kelahiran_anak.idkelahiran=reproduksi_kelahiran.idkelahiran','left');
        $this->db->join('sapi s1','s1.idsapi=reproduksi_kelahiran_anak.idsapi','left');
        $this->db->join('farm','farm.idfarm=sapi.idfarm','left');
        $this->db->where('sapi.status','hidup');
        $this->db->where('sapi.kelamin','BETINA');
        if($idsapi!=""){
            $this->db->where('sapi.idsapi',$idsapi);
        }
        $this->db->group_by('sapi.idsapi,pengukuran_produksisusu.xlaktasi');
        $this->db->having('produksi305>0');
        $this->db->order_by('sapi.idsapi');
        $rs= $this->db->get()->result(); 
		return $rs;
    }

    public function get_data_bulan_produksi($xlaktasi=0)
    {
        $sql="select month(pp.tanggal) as bulanproduksi,pp.xlaktasi
			from pengukuran_produksisusu pp
			join sapi using(idsapi)
			join register using(idsapi) 
			join reproduksi_kelahiran rk on rk.idsapi=sapi.idsapi and rk.xlaktasi=pp.xlaktasi
			join jumlahhari on (jumlahhari.idbulan=month(pp.tanggal) )
			left join con_koreksiumur on con_koreksiumur.umur=(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )+round(((datediff(pp.tanggal,sapi.tgllahir)/365)-(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2))
			join con_koreksijhp on con_koreksijhp.jhp=datediff(pp.tanggal,rk.tanggal)
			where sapi.tagsapi='$tagsapi' ";
			$xlaktasi=$row->xlaktasi;
			if($xlaktasi==0){
				//$sql .= " AND pp.xlaktasi=(select max(xlaktasi) from pengukuran_produksisusu WHERE idsapi=sapi.idsapi)";
			}else
				$sql .= " AND pp.xlaktasi='$xlaktasi'";
				
			$sql .= " group by bulanproduksi order by pp.tanggal";
 
			return $this->db->query($sql)->result();		
    }

    public function get_data_terkoreksi($tagsapi=0,$xlaktasi=0,$bulanproduksi=0)
    {
        $sql="select nomorregister,sapi.tagsapi,sapi.tgllahir
			,pp.xlaktasi
			,pagi+sore as jmlsusu 
			,rk.tanggal as tgllaktasi
			,pp.tanggal as tglproduksi
			,month(pp.tanggal) as bulanproduksi
			,year(pp.tanggal) as tahunproduksi
			,datediff(pp.tanggal,rk.tanggal) as jhp
			,datediff(pp.tanggal,sapi.tgllahir)/365 as umur
			,floor(datediff(pp.tanggal,sapi.tgllahir)/365 ) as umurtahun
			,round(((datediff(pp.tanggal,sapi.tgllahir)/365)-(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2) as umurbulan
			,jumlahhari.jumlah as jumlahhari,con_koreksiumur.koreksi as koreksiumur,con_koreksijhp.koreksi as koreksijhp
			from pengukuran_produksisusu pp
			join sapi using(idsapi)
			join register using(idsapi) 
			join reproduksi_kelahiran rk on rk.idsapi=sapi.idsapi and rk.xlaktasi=pp.xlaktasi
			join jumlahhari on (jumlahhari.idbulan=month(pp.tanggal) )
			left join con_koreksiumur on con_koreksiumur.umur=(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )+round(((datediff(pp.tanggal,sapi.tgllahir)/365)-(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2))
			join con_koreksijhp on con_koreksijhp.jhp=datediff(pp.tanggal,rk.tanggal)
			where sapi.tagsapi='$tagsapi'
			AND pp.xlaktasi='$xlaktasi'
            AND month(pp.tanggal)='$bulanproduksi'";
            return $this->db->query($sql)->result();
    }
    public function save()
    {
        $data = [
            'idpengukuran' => '',
            'idsapi' => htmlspecialchars($this->input->post('idsapi')),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'pagi' => htmlspecialchars($this->input->post('pagi')),
            'sore' => htmlspecialchars($this->input->post('sore')),
            'kandang' => trim((string) $this->input->post('kandang'))
        ];
        $this->db->insert('pengukuran_produksisusu',$data);
    }
    public function update()
    {
        $id = $this->input->post('idpengukuran');
        $data = [
            'idsapi' => htmlspecialchars($this->input->post('idsapi')),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'pagi' => htmlspecialchars($this->input->post('pagi')),
            'sore' => htmlspecialchars($this->input->post('sore')),
            'kandang' => trim((string) $this->input->post('kandang'))
        ];
        $this->db->where('idpengukuran',$id);
        $this->db->update('pengukuran_produksisusu',$data);
    }
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idpengukuran',$id);
        $this->db->delete('pengukuran_produksisusu');
    }
}
