<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_JenisTernak extends CI_Model {
	public function get_all()
	{
		return $this->db->get('ref_jenis_ternak'); 
    }
}
