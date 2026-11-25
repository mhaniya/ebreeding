<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_level extends CI_Model
{
    public function get()
    {
        $user=$this->utility->user_login();

        $this->db->order_by('level_nama');
        if($user->level_id==2)
            $this->db->where('level_id !=',3);
        return $this->db->get('web_level');
    }
}