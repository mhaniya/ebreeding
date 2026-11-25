<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi_dan_tetua extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_susu','M_farm','M_propinsi','M_kabupaten','M_kecamatan','M_asal','M_susu','M_ib']);
		$this->session->set_userdata('menu','lap_produktifitas');
		$this->session->set_userdata('submenu','produksi_dan_tetua');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//susu_vertikaltara di controller
		 
		$data['judul']="Laporan Produksi dan Tetua";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$user = $this->utility->user_login();
		$data['user'] = $user;
		$id_user=$user->user_id;
		$kodepropinsi=($this->session->userdata("kodepropinsi")!=""?$this->session->userdata("kodepropinsi"):$this->M_user->get_kodepropinsi($id_user));
		$kodekabupaten=($this->session->userdata("kodekabupaten")!=""?$this->session->userdata("kodekabupaten"):$this->M_user->get_kodekabupaten($id_user));
		$kodekecamatan=($this->session->userdata("kodekecamatan")!=""?$this->session->userdata("kodekecamatan"):$this->M_user->get_kodekecamatan($id_user));
		$idfarm=($this->session->userdata("idfarm")!=""?$this->session->userdata("idfarm"):$this->M_user->get_idfarm($id_user));
		
		$this->session->set_userdata('kodepropinsi',$kodepropinsi);
		$this->session->set_userdata('kodekabupaten',$kodekabupaten);
		$this->session->set_userdata('kodekecamatan',$kodekecamatan);
		$this->session->set_userdata('idfarm',$idfarm);

		$data['kodepropinsi']=$kodepropinsi;
		$data['kodekabupaten']=$kodekabupaten;
		$data['kodekecamatan']=$kodekecamatan;
		$data['idfarm']=$idfarm;

		$data['propinsi'] = $this->M_propinsi->get_all();
		$data['kabupaten'] = $this->M_kabupaten->get_all_in_propinsi($kodepropinsi);
		$data['kecamatan'] = $this->M_kecamatan->get_all_in_kabupaten($kodepropinsi,$kodekabupaten); 
		$data['farm'] = $this->M_farm->get_all_in_kecamatan($kodepropinsi,$kodekabupaten,$kodekecamatan);

		$data['tahun']=$this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
		$data['bulan']=$this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m'); 
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('lap_produktifitas/produksi_dan_tetua/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('lap_produktifitas/produksi_dan_tetua/footer');
		
	}
	
	public function ajax_tabel()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
			header('Content-Type: application/json');
			$this->load->library('Datatables_ssp');

			echo $this->M_susu->get_data_json();
		// }
	}

	public function get_data()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			header('Content-Type: application/json');
			echo $this->M_susu->get_json();
		}
	}

	public function get_json_produksi_dan_tetua()
	{
		echo json_encode($this->M_susu->get_json_produksi_dan_tetua()->result());
	}

	
	public function get_json_produksi_dan_tetua1()
	{
		$sql="select nomorregister,sapi.tagsapi,sapi.tgllahir
				,pp.xlaktasi
				,pagi+sore as jmlsusu 
				,rk.tanggal as tgllaktasi
				,pp.tanggal as tglproduksi
				,month(pp.tanggal) as bulanproduksi
				,year(pp.tanggal) as tahunproduksi
				,(year(pp.tanggal)-year(rk.tanggal))*12+MONTH(pp.tanggal)-MONTH(rk.tanggal) as bulanke
				,datediff(pp.tanggal,rk.tanggal) as jhp
				,datediff(pp.tanggal,sapi.tgllahir)/365 as umur
				,floor(datediff(pp.tanggal,sapi.tgllahir)/365 ) as umurtahun
				,round(((datediff(pp.tanggal,sapi.tgllahir)/365)-(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2) as umurbulan
				,jumlahhari.jumlah as jumlahhari,con_koreksiumur.koreksi as koreksiumur,con_koreksijhp.koreksi as koreksijhp
				from pengukuran_produksisusu pp
				join sapi using(idsapi)
				left join register using(idsapi) 
				left join reproduksi_kelahiran rk on rk.idsapi=sapi.idsapi and rk.xlaktasi=pp.xlaktasi
				left join jumlahhari on (jumlahhari.idbulan=month(pp.tanggal) )
				left join con_koreksiumur on con_koreksiumur.umur=(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )+round(((datediff(pp.tanggal,sapi.tgllahir)/365)-(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2))
				join con_koreksijhp on con_koreksijhp.jhp=datediff(pp.tanggal,rk.tanggal)
				where 1 ";
				
					// $sql .= " AND pp.xlaktasi='$xlaktasi'";
					
				$sql .= " group by bulanke,pp.xlaktasi
						order by tglproduksi";
				

			$data=$this->db->query($sql);

		
		$i=0;
		$prodsebelum=0;
		$tagsapi1="";
		$xlaktasi1="";
		$nomorregister="";
		$data_produksi=array();
		foreach($data->result() as $rowdata){
			$i++;
			
			$sql="select nomorregister,sapi.tagsapi,sapi.tgllahir
				,pp.xlaktasi
				,max(pagi+sore) as jmlsusu 
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
				left join register using(idsapi) 
				left join reproduksi_kelahiran rk on rk.idsapi=sapi.idsapi and rk.xlaktasi=pp.xlaktasi
				left join jumlahhari on (jumlahhari.idbulan=month(pp.tanggal) )
				left join con_koreksiumur on con_koreksiumur.umur=(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )+round(((datediff(pp.tanggal,sapi.tgllahir)/365)-(floor(datediff(pp.tanggal,sapi.tgllahir)/365 )))*12/100,2))
				join con_koreksijhp on con_koreksijhp.jhp=datediff(pp.tanggal,rk.tanggal)
				where 1
				AND pp.xlaktasi='".$rowdata->xlaktasi."'
				AND month(pp.tanggal)='".$rowdata->bulanproduksi."'";
			
			if($i==1){
				
				$rs=$this->db->query($sql);
				$row=$rs->row();
				$tglsebelum=$row->tglproduksi;
			}else{
				if($tglsebelum!="0000-00-00") $sql .= " AND pp.tanggal between date_add('$tglsebelum', interval 1 day) and date_add('$tglsebelum', interval $jumlahhari day)  ";
				$sql .= " ORDER BY tglproduksi DESC limit 1";
				$rs=$this->db->query($sql);
				$row=$rs->row();
				
				$tglsebelum=$row->tglproduksi;
				
			}
	
			if($xlaktasi1!=$rowdata->xlaktasi){
				$i=1;
				$xlaktasi1=$rowdata->xlaktasi;
				$nomorregister=$rowdata->nomorregister;
				$tagsapi1=$rowdata->tagsapi;
				$prodsebelum=0;
			} else { 
				$nomorregister="";
				$tagsapi1="";
			}
			
			$dt['nomorregister']=$nomorregister;
			$dt['tagsapi1']=$tagsapi1;
			$dt['tgllahir']=$rowdata->tgllahir;
			$dt['xlaktasi']=$rowdata->xlaktasi;
			$dt['i']=$i;
			$dt['jmlsusu']=$rowdata->jmlsusu;
			$dt['tgllaktasi']=$rowdata->tgllaktasi;
			$dt['tglproduksi']=$rowdata->tglproduksi;
			$dt['jhp']=$rowdata->jhp;
			$dt['umur']=number_format($rowdata->umurtahun+$rowdata->umurbulan,2,",",".");
			$dt['prodsebelum']=number_format($prodsebelum,2,",",".");
			 
			 
				if($rowdata->bulanproduksi!=2){
					$jumlahhari=$rowdata->jumlahhari;
				}else
				if(($rowdata->bulanproduksi==2)&&($rowdata->tahunproduksi%4==0)){
					$jumlahhari=29;
				}else
					$jumlahhari=28;
			$dt["jumlahhari"]=$jumlahhari;
			
			if($i==1)
					$produksibulanan=$rowdata->jmlsusu*$rowdata->jhp;
				else
					$produksibulanan=$rowdata->jmlsusu*$jumlahhari;
			
			$dt['produksibulanan']=number_format($produksibulanan,2,",",".");
			$produksinyata=$prodsebelum+$produksibulanan;
			$dt['produksinyata']=number_format($produksinyata,2,",",".");
			$dt['koreksiumur']=number_format($rowdata->koreksiumur,2,",",".");
			$dt['koreksijhp']=number_format($rowdata->koreksijhp,2,",",".");
			$prodterkoreksi=$produksinyata*$rowdata->koreksiumur*$row->koreksijhp;
			$dt['prodterkoreksi']=number_format($prodterkoreksi,2,",",".");
			
			$prodsebelum=$produksinyata;
			array_push($data_produksi,$dt);
		 } 
		echo json_encode($data_produksi);
	}


	public function get_data_by_idpengukuran($id)
	{
		echo json_encode($this->M_susu->get($id)->row());
	}
}