<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kecamatan extends CI_Model {
	public function get_all()
	{
		$this->db->order_by('namakecamatan');
		return $this->db->get('wil_kecamatan'); 
	}
	
	public function get_all_in_kabupaten($kodepropinsi,$kodekabupaten)
	{
		$this->db->order_by('namakecamatan');
		$this->db->where('kodepropinsi',$kodepropinsi);
		$this->db->where('kodekabupaten',$kodekabupaten);
		$user=$this->session->userdata('user');
		$kodekoperasi=$user->kodekoperasi;
		$idfarm=$user->idfarmuser;
		if($user->level_id==2){
			$this->db->where("kodekecamatan IN (SELECT kodekecamatan FROM farm WHERE kodekoperasi='$kodekoperasi')");
		}else
		if($user->level_id>3){
			$this->db->where("kodekecamatan IN (SELECT kodekecamatan FROM farm WHERE idfarm='$idfarm')");
		}
		return $this->db->get('wil_kecamatan'); 
	}
	
	public function get_data($kodepropinsi,$kodekabupaten,$kodekecamatan){
		$this->db->where('kodepropinsi',$kodepropinsi);
		$this->db->where('kodekabupaten',$kodekabupaten);
		$this->db->where('kodekecamatan',$kodekecamatan);
		
		return $this->db->get('wil_kecamatan')->row();
	}
	function get_list_data_by_kabupaten($kodepropinsi,$kodekabupaten){
		$this->db->from('wil_kecamatan');
		$this->db->where('wil_kecamatan.kodepropinsi',$kodepropinsi);
		$this->db->where('wil_kecamatan.kodekabupaten',$kodekabupaten);
		$this->db->order_by('namakecamatan');
		return $this->db->get();
	}
}
