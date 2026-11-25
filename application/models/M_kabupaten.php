<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kabupaten extends CI_Model {
	public function get_all()
	{
		$this->db->order_by('namakabupaten');
		
		$user=$this->session->userdata('user');
		$kodekoperasi=$user->kodekoperasi;
		$idfarm=$user->idfarmuser;
		if($user->level_id==2){
			$this->db->where("kodekabupaten IN (SELECT kodekabupaten FROM farm WHERE kodekoperasi='$kodekoperasi')");
		}else
		if($user->level_id>3){
			$this->db->where("kodekabupaten IN (SELECT kodekabupaten FROM farm WHERE idfarm='$idfarm')");
		}
		return $this->db->get('wil_kabupaten'); 
	}
	public function get_all_in_propinsi($kodepropinsi)
	{
		$this->db->order_by('namakabupaten');
		$this->db->where('kodepropinsi',$kodepropinsi);
		$user=$this->session->userdata('user');
		$kodekoperasi=$user->kodekoperasi;
		$idfarm=$user->idfarmuser;
		if($user->level_id==2){
			$this->db->where("kodekabupaten IN (SELECT kodekabupaten FROM farm WHERE kodekoperasi='$kodekoperasi')");
		}else
		if($user->level_id>3){
			$this->db->where("kodekabupaten IN (SELECT kodekabupaten FROM farm WHERE idfarm='$idfarm')");
		}
		return $this->db->get('wil_kabupaten'); 
	}
	
	public function get_data($kodepropinsi,$kodekabupaten){
		$this->db->where('kodepropinsi',$kodepropinsi);
		$this->db->where('kodekabupaten',$kodekabupaten);
		
		return $this->db->get('wil_kabupaten')->row();
	}

	function get_list_data_by_propinsi($kode){
		$this->db->from('wil_kabupaten');
		$this->db->where('wil_kabupaten.kodepropinsi',$kode);
		$this->db->order_by('namakabupaten');
		return $this->db->get();
	}
}
