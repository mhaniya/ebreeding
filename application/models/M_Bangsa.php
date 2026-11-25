<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Bangsa extends CI_Model {
	public function get_all()
	{
		$this->db->select('ref_bangsa.id,ref_bangsa.nama,ref_bangsa.id_jenis_ternak
							,ref_jenis_ternak.nama nama_jenis_ternak');
		$this->db->join('ref_jenis_ternak','ref_bangsa.id_jenis_ternak=ref_jenis_ternak.id');
		return $this->db->get('ref_bangsa'); 
	}
	
	public function get_data($id){
		$this->db->where('id',$id);
		
		return $this->db->get('ref_bangsa')->row();
	}
}
