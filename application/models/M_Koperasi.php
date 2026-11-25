<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Koperasi extends CI_Model
{
    public function get()
    {
        $this->db->order_by('namakoperasi');
        return $this->db->get('koperasi');
    }
}