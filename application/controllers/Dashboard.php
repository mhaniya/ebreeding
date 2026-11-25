<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
		parent::__construct(); 
		$this->load->model(array('M_farm','M_sapi','M_kambing','M_susu','M_ib'));
		$this->session->set_userdata('menu','dashboard');
		$this->session->set_userdata('submenu','');
	 
		belum_login();
	}
	public function index()
	{
		 
		$user = $this->utility->user_login();
		$data['user'] = $user;
		$id_user=$user->user_id;
		$id_level=$user->level_id;
		$this->session->set_userdata('user',$user);
		$kodekoperasiuser="";
		$idfarmuser=""; 
		if($id_level==2){
            $kodekoperasiuser=$user->kodekoperasi;
        }else
        if($id_level==4){
            $idfarmuser=$user->idfarmuser;
		};
		$this->session->set_userdata('kodekoperasiuser',$kodekoperasiuser);
		$this->session->set_userdata('idfarmuser',$idfarmuser);
		$data['kodekoperasiuser']=$kodekoperasiuser;
		$data['idfarmuser']=$idfarmuser;
		$data['judul']="Dashboard";
		$data['n_sapi_belum_pkb']=$this->M_ib->get_count_sapi_belum_pkb();
		$data['n_sapi_dara_belum_ib']=$this->M_ib->get_count_sapi_dara_belum_ib();
		$data['n_saneen']=$this->M_kambing->get_count_saneen();
		$data['n_pe']=$this->M_kambing->get_count_pe();
		$data['n_kambing_jantan']=$this->M_kambing->get_count_jantan();
		$data['n_kambing_betina']=$this->M_kambing->get_count_betina();
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('dashboard/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('dashboard/footer');
	}

	
}
