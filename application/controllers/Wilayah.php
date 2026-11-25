<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Wilayah extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
		$this->load->model(array('M_propinsi','M_kabupaten','M_kecamatan'));
    }
    
    public function index()
    {
        
    }

    function get_list_data_by_propinsi(){
        $kode=$this->uri->segment(3);
        $this->session->set_userdata('kodepropinsi',$kode);
        $data=$this->M_kabupaten->get_list_data_by_propinsi($kode);
        
        $comma=",";
        echo "var newOptions={";
        echo "'0':':: Pilih Kabupaten ::'";
        foreach($data->result() as $rs){
        echo $comma."'".$rs->kodekabupaten."':'".addslashes($rs->namakabupaten)."'";   
        }
        echo "};";
    }
    function get_list_data_by_kabupaten(){
        $kodepropinsi=$this->uri->segment(3);
        $kodekabupaten=$this->uri->segment(4);
        $this->session->set_userdata('kodekabupaten',$kodekabupaten);
        $data=$this->M_kecamatan->get_list_data_by_kabupaten($kodepropinsi,$kodekabupaten);
        
        $comma=",";
        echo "var newOptions={";
        echo "'0':':: Pilih Kecamatan ::'";
        foreach($data->result() as $rs){
        echo $comma."'".$rs->kodekecamatan."':'".addslashes($rs->namakecamatan)."'";   
        }
        echo "};";
    }
        
}
        
    /* End of file  Wilayah.php */
        
                            