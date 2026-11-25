<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_obat extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idobat',$id);
        } 
        return $this->db->get('obat');
    }
    public function get_data_bynama($nama)
    {
        $sql="SELECT * FROM obat
        WHERE namaobat LIKE '$nama%' LIMIT 20";
        $query=$this->db->query($sql);
        return $query;
    }
    public function get_json()
    {
        
        $this->datatables->select("obat.idobat,obat.kodeobat,obat.namaobat,obat.idkategoriobat,obat.fungsiobat,obat.penggunaanobat
        ,obat.idsatuan
        ,con_kategoriobat.nama as namakategori,satuan_obat.nama  as namasatuan,
                    (SELECT sum(jumlah) FROM keluarmasuk_obat k WHERE k.idobat=obat.idobat 
                    AND (status='Stok Awal' OR status='Pemasukan')) as jumlahstok");
        $this->datatables->from('obat');
        $this->datatables->join('con_kategoriobat','con_kategoriobat.idkategoriobat=obat.idkategoriobat','left');
        $this->datatables->join('satuan_obat','satuan_obat.idsatuan=obat.idsatuan','left');
        $this->datatables->add_column('aksi','<div class="btn-group"> <a href="javascript:" id="editdata" class="btn btn-warning" data-id="$1"><i class="fas fa-pen"></i></a> 
                <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idobat');
        return $this->datatables->generate();
    }
    
     
    public function save()
    {
        $data = [
            'idobat' => '',
            'kodeobat' => htmlspecialchars($this->input->post('kodeobat')),
            'namaobat' => htmlspecialchars($this->input->post('namaobat')),
            'idkategoriobat' => htmlspecialchars($this->input->post('idkategoriobat')),
            'fungsiobat' => htmlspecialchars($this->input->post('fungsiobat')),
            'penggunaanobat' => htmlspecialchars($this->input->post('penggunaanobat')), 
            'idsatuan' => htmlspecialchars($this->input->post('idsatuan'))
        ];
        $this->db->insert('obat',$data);
        $idobat=$this->db->insert_id();

        $datastok = [
            'idobat'=>$idobat,
            'tanggal' => date('Y-m-d'),
            'jumlah' => $this->input->post('stok'),
            'status' => 'Stok Awal'
        ];
        $this->db->insert('keluarmasuk_obat',$datastok);
    }
    public function update()
    {
        $id = $this->input->post('idobat');
        $data = [
            'kodeobat' => htmlspecialchars($this->input->post('kodeobat')),
            'namaobat' => htmlspecialchars($this->input->post('namaobat')),
            'idkategoriobat' => htmlspecialchars($this->input->post('edtidkategoriobat')),
            'fungsiobat' => htmlspecialchars($this->input->post('fungsiobat')),
            'penggunaanobat' => htmlspecialchars($this->input->post('penggunaanobat')), 
            'idsatuan' => htmlspecialchars($this->input->post('edtidsatuan'))
        ];
        $this->db->where('idobat',$id);
        $this->db->update('obat',$data);
    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idobat',$id);
        $this->db->delete('obat');
    }
}