<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_keluarmasuk_obat extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idpemasukan',$id);
        } 
        $this->db->select('keluarmasuk_obat.*,petugas.nama namapetugas,namaobat');
        $this->db->join('obat','obat.idobat=keluarmasuk_obat.idobat'); 
        $this->db->join('petugas','petugas.idpetugas=keluarmasuk_obat.idpetugas','left');
        return $this->db->get('keluarmasuk_obat');
    }
    public function get_json()
    {
        
        $this->datatables->select("`keluarmasuk_obat`.idpemasukan,keluarmasuk_obat.tanggal,keluarmasuk_obat.jumlah,keluarmasuk_obat.status, `namaobat`, satuan_obat.nama as namasatuan,
        `petugas`.`nama` as namapetugas ");
        $this->datatables->from('keluarmasuk_obat');
        $this->datatables->join('obat','`obat`.`idobat`=`keluarmasuk_obat`.`idobat`');
        $this->datatables->join('petugas','`petugas`.`idpetugas`=`keluarmasuk_obat`.`idpetugas`','left');
        $this->datatables->join('satuan_obat','`satuan_obat`.`idsatuan`=`obat`.`idsatuan`','left');
        $this->datatables->where('status','Pemasukan');
        $this->datatables->add_column('aksi','<div class="btn-group"> <a href="javascript:" id="editdata" class="btn btn-warning" data-id="$1">
                        <i class="fas fa-pen"></i></a> 
                        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idpemasukan');
        return $this->datatables->generate();
    }
    
     
    public function save()
    {
        $data = [
            'idpemasukan'=>'',
            'idobat' => htmlspecialchars($this->input->post('idobat')),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'jumlah' => htmlspecialchars($this->input->post('jumlah')),
            'idpetugas' => htmlspecialchars($this->input->post('idpetugas')),
            'status' => 'Pemasukan'
        ];
        $this->db->insert('keluarmasuk_obat',$data);
    }
    public function update()
    {
        $id = $this->input->post('idpemasukan');
        $data = [
            'idobat' => htmlspecialchars($this->input->post('idobat')),
            'tanggal' => htmlspecialchars($this->input->post('tanggal')),
            'jumlah' => htmlspecialchars($this->input->post('jumlah')),
            'idpetugas' => htmlspecialchars($this->input->post('idpetugas')),
            'status' => 'Pemasukan'
        ];
        $this->db->where('idpemasukan',$id);
        $this->db->update('keluarmasuk_obat',$data);
    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idpemasukan',$id);
        $this->db->delete('keluarmasuk_obat');
    }
}