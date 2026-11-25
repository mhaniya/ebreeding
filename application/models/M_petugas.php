<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_petugas extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idpetugas',$id);
        }
         return $this->db->get('petugas');
    }
    public function get_json()
    {
        
        $this->datatables->select('idpetugas,nama,jabatan,nip');
        $this->datatables->from('petugas');
        $this->datatables->add_column('aksi','<div class="btn-group"><button id="editdata" data-id="$1" class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button>
        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idpetugas');
        
        return $this->datatables->generate();
    }
    
    public function get_data_bynama($nama)
    {
        $sql="SELECT * FROM petugas
        WHERE nama LIKE '$nama%' LIMIT 20";
        $query=$this->db->query($sql);
        return $query;
    }
    public function save()
    {
        $data = [
            'idpetugas' => '',
            'nama' => htmlspecialchars($this->input->post('nama')),
            'jabatan' => htmlspecialchars($this->input->post('jabatan')),
            'nip' => htmlspecialchars($this->input->post('nip'))
        ];
        $this->db->insert('petugas',$data);
    }
    public function update()
    {
        $id = $this->input->post('idpetugas');
        $data = [
            'nama' => htmlspecialchars($this->input->post('nama')),
            'jabatan' => htmlspecialchars($this->input->post('jabatan')),
            'nip' => htmlspecialchars($this->input->post('nip'))
        ];
        $this->db->where('idpetugas',$id);
        $this->db->update('petugas',$data);
    }
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idpetugas',$id);
        $this->db->delete('petugas');
    }
}