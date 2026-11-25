<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_asal extends CI_Model {
	public function get_all()
	{ 
		return $this->db->get('ref_asal'); 
	}
	
	public function get_data($id){
		$this->db->where('idasal',$id);
		
		return $this->db->get('ref_asal')->row();
	}
	
}
