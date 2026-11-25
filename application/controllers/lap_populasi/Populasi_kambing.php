<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Populasi_kambing extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('form_validation','simpliparse'));
        $this->load->model(['M_sapi','M_susu','M_kambing']);
		$this->session->set_userdata('menu','lap_populasi');
		$this->session->set_userdata('submenu','populasi_sapi');
		belum_login();
	}
	public function index()
	{
		//Seharusnya ada di model
		//susu_vertikaltara di controller
		 
		$data['judul']="Laporan Populasi Sapi";
		$data['menu']=$this->session->userdata('menu');
		$data['submenu']=$this->session->userdata('submenu');
		$this->load->view('layout/header');
		$data['user'] = $this->utility->user_login();
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		if($this->session->userdata('hakakses')==1){
			
			if($this->session->userdata('kodepropinsi')!="") 
				$kodepropinsi=$this->session->userdata('kodepropinsi');
			else	
				$kodepropinsi= $this->uri->segment(4,0);
			if($this->session->userdata('kodekabupaten')!="") 
				$kodekabupaten=$this->session->userdata('kodekabupaten');
			else
				$kodekabupaten= $this->uri->segment(5,0);
			if($this->session->userdata('kodekecamatan')!="") 
				$kodekecamatan=$this->session->userdata('kodekecamatan');
			else	
				$kodekecamatan= $this->uri->segment(6,0);
			
			if($this->session->userdata('idfarm')!="") 
				$idfarm=$this->session->userdata('idfarm');
			else	
				$idfarm= $this->uri->segment(7,0);
		}else{
			$sql="SELECT kodepropinsi,kodekabupaten,kodekecamatan FROM koperasi 
				LEFT JOIN wil_kecamatan USING(kodepropinsi,kodekabupaten,kodekecamatan)
				LEFT JOIN wil_kabupaten
				USING (kodepropinsi,kodekabupaten)
				LEFT JOIN wil_propinsi
				USING(kodepropinsi)
				WHERE user_id='".$this->session->userdata('user_id')."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()>0){
				$row=$rs->row();
				$kodekecamatan=$row->kodekecamatan;
				$kodekabupaten=$row->kodekabupaten;
				$kodepropinsi=$row->kodepropinsi;
			}else{
				$kodekecamatan="0";
				$kodekabupaten="0";
				$kodepropinsi="0";
			}
		}
		 
		$idfarm= $this->uri->segment(7,0);
		$sql="select kodepropinsi,namapropinsi ,
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE farm.kodepropinsi=wil_propinsi.kodepropinsi) as n,
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Jantan' AND `status`='hidup' and farm.kodepropinsi=wil_propinsi.kodepropinsi) as nJantanHidup, 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Betina' AND `status`='hidup' and farm.kodepropinsi=wil_propinsi.kodepropinsi) as nBetinaHidup, 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Jantan' AND `status`='afkir' and farm.kodepropinsi=wil_propinsi.kodepropinsi) as nJantanAfkir, 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Betina' AND `status`='afkir' and farm.kodepropinsi=wil_propinsi.kodepropinsi) as nBetinaAfkir, 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Jantan' AND `status`='mati' and farm.kodepropinsi=wil_propinsi.kodepropinsi) as nJantanMati, 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Betina' AND `status`='mati' and farm.kodepropinsi=wil_propinsi.kodepropinsi) as nBetinaMati 
				from wil_propinsi ";
		if($kodepropinsi!="0") $sql .= " WHERE wil_propinsi.kodepropinsi='$kodepropinsi'";
		 
		$sql .=" GROUP BY kodepropinsi HAVING n>0";
		$rs=$this->db->query($sql);
		$data['propinsi']=$rs;
		
		$sql="select kodepropinsi,namapropinsi ,namakabupaten,
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE farm.kodepropinsi=wil_propinsi.kodepropinsi AND farm.kodekabupaten=wil_kabupaten.kodekabupaten) as n,
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Jantan' AND `status`='hidup' and farm.kodepropinsi=wil_propinsi.kodepropinsi AND farm.kodekabupaten=wil_kabupaten.kodekabupaten) as nJantanHidup, 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Betina' AND `status`='hidup' and farm.kodepropinsi=wil_propinsi.kodepropinsi AND farm.kodekabupaten=wil_kabupaten.kodekabupaten) as nBetinaHidup, 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Jantan' AND `status`='Afkir' and farm.kodepropinsi=wil_propinsi.kodepropinsi AND farm.kodekabupaten=wil_kabupaten.kodekabupaten) as nJantanAfkir, 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Betina' AND `status`='Afkir' and farm.kodepropinsi=wil_propinsi.kodepropinsi AND farm.kodekabupaten=wil_kabupaten.kodekabupaten) as nBetinaAfkir , 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Jantan' AND `status`='mati' and farm.kodepropinsi=wil_propinsi.kodepropinsi AND farm.kodekabupaten=wil_kabupaten.kodekabupaten) as nJantanMati, 
				(SELECT count(*) FROM sapi JOIN farm  using(idfarm) WHERE sapi.kelamin='Betina' AND `status`='mati' and farm.kodepropinsi=wil_propinsi.kodepropinsi AND farm.kodekabupaten=wil_kabupaten.kodekabupaten) as nBetinaMati 
				from wil_propinsi JOIN wil_kabupaten USING(kodepropinsi)";
		if($kodepropinsi!="0") $sql .= " WHERE wil_propinsi.kodepropinsi='$kodepropinsi'";
		if($kodekabupaten!="0") $sql .= " AND wil_kabupaten.kodekabupaten='$kodekabupaten'";
		$sql .=" GROUP BY kodepropinsi,kodekabupaten HAVING n>0";
		$rs=$this->db->query($sql);
		$data['kabupaten']=$rs;
		
		$sql="select kodepropinsi,namapropinsi ,namakabupaten, namakecamatan, namafarm,
				(SELECT count(*) FROM sapi JOIN farm using(idfarm) WHERE farm.kodepropinsi=wil_propinsi.kodepropinsi 
				AND farm.kodekabupaten=wil_kabupaten.kodekabupaten AND farm.kodekecamatan=wil_kecamatan.kodekecamatan AND farm.idfarm=f.idfarm) as n, 
				(SELECT count(*) FROM sapi JOIN farm using(idfarm) 
				WHERE sapi.kelamin='Jantan' AND `status`='hidup' and farm.kodepropinsi=wil_propinsi.kodepropinsi 
				AND farm.kodekabupaten=wil_kabupaten.kodekabupaten AND farm.kodekecamatan=wil_kecamatan.kodekecamatan AND farm.idfarm=f.idfarm) as nJantanHidup, 
				(SELECT count(*) FROM sapi JOIN farm using(idfarm) 
				WHERE sapi.kelamin='Betina' AND `status`='hidup' and farm.kodepropinsi=wil_propinsi.kodepropinsi 
				AND farm.kodekabupaten=wil_kabupaten.kodekabupaten AND farm.kodekecamatan=wil_kecamatan.kodekecamatan AND farm.idfarm=f.idfarm) as nBetinaHidup, 
				(SELECT count(*) FROM sapi JOIN farm using(idfarm) 
				WHERE sapi.kelamin='Jantan' AND `status`='afkir' and farm.kodepropinsi=wil_propinsi.kodepropinsi 
				AND farm.kodekabupaten=wil_kabupaten.kodekabupaten AND farm.kodekecamatan=wil_kecamatan.kodekecamatan AND farm.idfarm=f.idfarm) as nJantanAfkir, 
				(SELECT count(*) FROM sapi JOIN farm using(idfarm) 
				WHERE sapi.kelamin='Betina' AND `status`='afkir' and farm.kodepropinsi=wil_propinsi.kodepropinsi 
				AND farm.kodekabupaten=wil_kabupaten.kodekabupaten AND farm.kodekecamatan=wil_kecamatan.kodekecamatan AND farm.idfarm=f.idfarm) as nBetinaAfkir , 
				(SELECT count(*) FROM sapi JOIN farm using(idfarm) 
				WHERE sapi.kelamin='Jantan' AND `status`='mati' and farm.kodepropinsi=wil_propinsi.kodepropinsi 
				AND farm.kodekabupaten=wil_kabupaten.kodekabupaten AND farm.kodekecamatan=wil_kecamatan.kodekecamatan AND farm.idfarm=f.idfarm) as nJantanMati, 
				(SELECT count(*) FROM sapi JOIN farm using(idfarm) 
				WHERE sapi.kelamin='Betina' AND `status`='mati' and farm.kodepropinsi=wil_propinsi.kodepropinsi 
				AND farm.kodekabupaten=wil_kabupaten.kodekabupaten AND farm.kodekecamatan=wil_kecamatan.kodekecamatan AND farm.idfarm=f.idfarm) as nBetinaMati 
				from wil_propinsi 
				JOIN wil_kabupaten USING(kodepropinsi)
				JOIN wil_kecamatan USING(kodepropinsi,kodekabupaten) 
				JOIN farm f USING(kodepropinsi,kodekabupaten,kodekecamatan)
				";
		if($kodepropinsi!="0") $sql .= " WHERE wil_propinsi.kodepropinsi='$kodepropinsi'";
		if($kodekabupaten!="0") $sql .= " AND wil_kabupaten.kodekabupaten='$kodekabupaten'";
		if($kodekecamatan!="0") $sql .= " AND wil_kecamatan.kodekecamatan='$kodekecamatan'";
		if($idfarm!="0") $sql .= " AND f.idfarm='$idfarm'";
		
		$sql .=" GROUP BY kodepropinsi,kodekabupaten,kodekecamatan,idfarm HAVING n>0";
		$rs=$this->db->query($sql);
		$data['kecamatan']=$rs;
		
		
		$data['kodepropinsi']=$kodepropinsi;
		$this->load->view('lap_populasi/populasi_sapi/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('lap_populasi/populasi_sapi/footer');
		
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
	public function get_data_today()
	{
		// if (!$this->input->is_ajax_request()) {
		// 	exit('No direct script access allowed');
		// } else {
		// 	header('Content-Type: application/json');
			echo $this->M_kambing->get_json_populasi_today(); 
		// }
	}
	public function get_data_by_idpengukuran($id)
	{
		echo json_encode($this->M_susu->get($id)->row());
	}	 
}