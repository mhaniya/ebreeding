<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_et extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('idtransfer',$id);
        }
        $this->db->select("reproduksi_et.*
        ,sapirecipient.tagsapi as tagsapirecipient
        ,(SELECT nomorregister FROM register rr WHERE rr.idsapi=sapirecipient.idsapi ORDER BY tanggal DESC limit 1) as nomorregisterrecipient
        ,sapidonor.tagsapi as tagsapidonor
        ,(SELECT nomorregister FROM register rd WHERE rd.idsapi=sapidonor.idsapi ORDER BY tanggal DESC limit 1) as nomorregisterdonor
        
        ,petugas.nama as namapetugas"); 
        $this->db->join('sapi sapidonor','sapidonor.idsapi=reproduksi_et.idsapidonor','left');
        $this->db->join('sapi sapirecipient','sapirecipient.idsapi=reproduksi_et.idsapirecipient','left');
        $this->db->join('petugas','petugas.idpetugas=reproduksi_et.idpetugas','left');
        $this->db->join('farm','farm.idfarm=sapirecipient.idfarm','left');
        return $this->db->get('reproduksi_et');
    }
    public function get_json()
    {
        
        $this->datatables->select("reproduksi_et.idtransfer,reproduksi_et.idsapirecipient,reproduksi_et.idsapidonor,reproduksi_et.tanggal,reproduksi_et.keterangan,reproduksi_et.idpetugas
                    ,sapirecipient.tagsapi as tagsapirecipient
                    ,(SELECT nomorregister FROM register rr WHERE rr.idsapi=sapirecipient.idsapi ORDER BY tanggal DESC limit 1) as nomorregisterrecipient
                    ,sapidonor.tagsapi as tagsapidonor
                    ,(SELECT nomorregister FROM register rd WHERE rd.idsapi=sapidonor.idsapi ORDER BY tanggal DESC limit 1) as nomorregisterdonor
                    
                    ,petugas.nama as namapetugas");
		$this->datatables->from('reproduksi_et');
		$this->datatables->join('sapi sapidonor','sapidonor.idsapi=reproduksi_et.idsapidonor','left');
		$this->datatables->join('sapi sapirecipient','sapirecipient.idsapi=reproduksi_et.idsapirecipient','left');
		$this->datatables->join('petugas','petugas.idpetugas=reproduksi_et.idpetugas','left');
		$this->datatables->join('farm','farm.idfarm=sapirecipient.idfarm','left');
        $this->datatables->add_column('aksi','<div class="btn-group">
        <button class="btn btn-warning" id="editdata" data-id="$1"><i class="fas fa-pen"></i></button>
        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button>
        </div>'
        ,'idtransfer');
        
        return $this->datatables->generate();
    }
    
    
    public function save()
    {
        $data = [
            'idtransfer' => '',
            'idsapirecipient' => htmlspecialchars($this->input->post('idsapi_r')),
            'idsapidonor' => htmlspecialchars($this->input->post('idsapi_d')),
            'tanggal' => $this->input->post('tanggal'),
            'keterangan' => $this->input->post('keterangan'),
            'idpetugas' => $this->input->post('idpetugas')
        ];
        $this->db->insert('reproduksi_et',$data);
    }
    public function update()
    {
        $id = $this->input->post('idtransfer');
        $data = [
            'idsapirecipient' => htmlspecialchars($this->input->post('idsapi_r')),
            'idsapidonor' => htmlspecialchars($this->input->post('idsapi_d')),
            'tanggal' => $this->input->post('tanggal'),
            'keterangan' => $this->input->post('keterangan'),
            'idpetugas' => $this->input->post('idpetugas')
        ];
        $this->db->where('idtransfer',$id);
        $this->db->update('reproduksi_et',$data);
    }
     
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('idtransfer',$id);
        $this->db->delete('reproduksi_et');
    }
}