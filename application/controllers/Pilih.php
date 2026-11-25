<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pilih extends CI_Controller {
	public function __construct()
	{
		parent::__construct(); 
		$this->load->model(array('M_farm','M_sapi','M_susu','M_ib'));
		$this->session->set_userdata('menu','dashboard');
		$this->session->set_userdata('submenu','');
	 
		belum_login();
	}
	public function sesi($id)
	{
		if($id=="sapi"){
			$this->session->set_userdata('sesi_aktif','sapi');
		}else{
			$this->session->set_userdata('sesi_aktif','kambing');
		}
		redirect('/dashboard');
	}
	public function index()
	{
		//Seharusnya ada di model
		//Sementara di controller
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
		$data['judul']="Pilih Sesi";
		
		$this->load->view('layout/header');
		$this->load->view('layout/navbar',$data);
		$this->load->view('layout/main_sidebar' ); 
		$this->load->view('pilihsesi/table',$data);
		$this->load->view('layout/footer');
		$this->load->view('pilihsesi/footer');
	}

	
}
