<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_satuan_obat extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idsatuan',$id);
        } 
        return $this->db->get('satuan_obat');
    }
    public function get_json()
    {
        
        $this->datatables->select('satuan_obat.idsatuan,satuan_obat.nama');
        $this->datatables->from('satuan_obat');
        $this->datatables->add_column('aksi','<div class="btn-group"> <a href="javascript:" id="editdata" class="btn btn-warning" data-id="$1"><i class="fas fa-pen"></i></a> 
                <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idsatuan');
        return $this->datatables->generate();
    }
    
     
    public function save()
    {
        $data = [
            'idsatuan' => '',
            'nama' => htmlspecialchars($this->input->post('nama'))
        ];
        $this->db->insert('satuan_obat',$data);
    }
    public function update()
    {
        $id = $this->input->post('idsatuan');
        $data = [
            'nama' => htmlspecialchars($this->input->post('nama'))
        ];
        $this->db->where('idsatuan',$id);
        $this->db->update('satuan_obat',$data);
    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idsatuan',$id);
        $this->db->delete('satuan_obat');
    }
}