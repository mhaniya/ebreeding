<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_propinsi extends CI_Model {
	public function get_all()
	{
		$this->db->order_by('namapropinsi');
		$user=$this->session->userdata('user');
		$kodekoperasi=$user->kodekoperasi;
		$idfarm=$user->idfarmuser;
		if($user->level_id==2){
			$this->db->where("kodepropinsi IN (SELECT kodepropinsi FROM farm WHERE kodekoperasi='$kodekoperasi')");
		}else
		if($user->level_id>3){
			$this->db->where("kodepropinsi IN (SELECT kodepropinsi FROM farm WHERE idfarm='$idfarm')");
		}
		return $this->db->get('wil_propinsi'); 
	}
	
	public function get_data($id){
		$this->db->where('kodepropinsi',$id);
		
		return $this->db->get('wil_propinsi')->row();
	}
	
}
