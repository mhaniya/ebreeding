<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_semen extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('tagsapi',$id);
        }
        $this->db->select('idsapi, tagsapi as kodesemen, namasapi as namasemen,DATE_FORMAT(tgllahir,"%Y-%m-%d") as tgllahir,idsire,kodesire,namasire,iddam,kodedam,namadam');
        $this->db->where('tipesapi','Semen');
         return $this->db->get('sapi');
    }
    public function get_data_by_id($id = null)
    {
        if($id != null){
            $this->db->where('idsapi',$id);
        }
        $this->db->select('idsapi, tagsapi as kodesemen, namasapi as namasemen,DATE_FORMAT(tgllahir,"%Y-%m-%d") as tgllahir,idsire,kodesire,namasire,iddam,kodedam,namadam');
        $this->db->where('tipesapi','Semen');
         return $this->db->get('sapi');
    }
    public function get_json()
    {
        $this->datatables->select('semen.idsapi,semen.tagsapi as kodesemen,DATE_FORMAT(semen.tgllahir,"%Y-%m-%d") as tgllahir, semen.namasapi as namasemen,sire.tagsapi as kodesire, sire.namasapi as namasire, dam.tagsapi as kodedam, dam.namasapi as namadam,regsire.nomorregister noregsire, regdam.nomorregister noregdam');
        $this->datatables->from('sapi semen');
        $this->datatables->join('sapi sire','sire.idsapi=semen.idsire','left');
        $this->datatables->join('sapi dam','dam.idsapi=semen.iddam','left');
        $this->datatables->join('register regsire','regsire.idsapi=semen.idsire','left');
        $this->datatables->join('register regdam','regdam.idsapi=semen.iddam','left');
        $this->datatables->where('semen.tipesapi','Semen');
        $this->datatables->add_column('aksi','<div class="btn-group">
        <button id="editdata" data-id="$1" class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button>
        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>','idsapi');
        
        return $this->datatables->generate();
    }
    
    public function get_data_bykode($kode){
        $sql="SELECT tagsapi as kodesemen,namasapi as namasemen,idsapi
              FROM sapi 
              WHERE tipesapi='Semen' AND tagsapi LIKE '$kode%' LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }
    
     
    public function get_data_bynama($kode){
        $sql="SELECT tagsapi as kodesemen,namasapi as namasemen,idsapi
              FROM sapi 
              WHERE tipesapi='Semen' AND namasapi LIKE '$kode%'   LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }
    public function get_dam_bykode($kode){
        $sql="SELECT tagsapi as kodedam,namasapi as namadam,idsapi
              FROM sapi 
              WHERE kelamin='Betina' AND tagsapi LIKE '$kode%' LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }
    public function get_dam_bynama($kode){
        $sql="SELECT tagsapi as kodedam,namasapi as namadam,idsapi
              FROM sapi 
              WHERE kelamin='Betina' AND namasapi LIKE '$kode%' LIMIT 20";
		$query=$this->db->query($sql);
		return $query;
    }

    public function save()
    {
        $kodesire=$this->input->post('kodesire');
        $namasire=$this->input->post('namasire');
        $kodedam=$this->input->post('kodedam');
        $namadam=$this->input->post('namadam');
        $this->db->where('namasapi',$namasire);
        $this->db->where('kelamin','Jantan');
        $rs_sire=$this->db->get('sapi');
        if($rs_sire->num_rows()>0){
            $row_sire=$rs_sire->row();
            $idsire=$row_sire->idsapi;
        }else{
            $datasire['namasapi']=$namasire;
            $datasire['tagsapi']=$kodesire;
            $datasire['kelamin']='Jantan';
            $datasire['tipesapi']='Semen';
            $this->db->insert('sapi',$datasire);
            $idsire=$this->db->insert_id();
        }
        
        $this->db->where('namasapi',$namadam);
        $this->db->where('kelamin','Betina');
        $rs_dam=$this->db->get('sapi');
        if($rs_dam->num_rows()>0){
            $row_dam=$rs_dam->row();
            $iddam=$row_dam->idsapi;
        }else{
            $datadam['namasapi']=$namadam;
            $datadam['tagsapi']=$kodedam;
            $datasire['kelamin']='Betina';
            $datasire['tipesapi']='Dam';
            $this->db->insert('sapi',$datadam);
            $iddam=$this->db->insert_id();
        }
        
        $data = [
            'tagsapi'  => htmlspecialchars($this->input->post('kodesemen')),
            'namasapi' => htmlspecialchars($this->input->post('namasemen')),
            'tipesapi' => 'Semen',
            'kelamin'  => 'Jantan',
            'tgllahir'    => $this->input->post('tanggallahir'),
            'idsire'      => $idsire,
            'kodesire'    => $kodesire,
            'namasire'    => $namasire,
            'iddam'       => $iddam,
            'kodedam'     => $kodedam,
            'namadam'     => $namadam,
        ];
        $this->db->insert('sapi',$data);
    }
    public function update()
    {
        $kodesire=$this->input->post('kodesire');
        $namasire=$this->input->post('namasire');
        $kodedam=$this->input->post('kodedam');
        $namadam=$this->input->post('namadam');
        
        $this->db->where('namasapi',$namasire);
        $this->db->where('kelamin','Jantan');
        $rs_sire=$this->db->get('sapi');
        $datasire['namasapi']=$namasire;
        $datasire['tagsapi']=$kodesire;
        $datasire['kelamin']='Jantan';
        $datasire['tipesapi']='Semen';
        if($rs_sire->num_rows()>0){
            $row_sire=$rs_sire->row();
            $idsire=$row_sire->idsapi;
            if($kodesire<>""){
                $this->db->where('idsapi',$idsire);
                $this->db->update('sapi',$datasire);
            }
        }else{
            $this->db->insert('sapi',$datasire);
            $idsire=$this->db->insert_id();
        }
        
        $this->db->where('namasapi',$namadam);
        $this->db->where('kelamin','Betina');
        $rs_dam=$this->db->get('sapi');
        $datadam['namasapi']=$namadam;
        $datadam['tagsapi']=$kodedam;
        $datadam['kelamin']='Betina';
        $datadam['tipesapi']='Dam';
        if($rs_dam->num_rows()>0){
            $row_dam=$rs_dam->row();
            $iddam=$row_dam->idsapi;
            if($kodedam<>""){
                $this->db->where('idsapi',$iddam);
                $this->db->update('sapi',$datadam);
            }
        }else{
            
            $this->db->insert('sapi',$datadam);
            $iddam=$this->db->insert_id();
        }

        $id = $this->input->post('kode');
        $data = [
            'tagsapi' => htmlspecialchars($this->input->post('kodesemen')),
            'namasapi' => htmlspecialchars($this->input->post('namasemen')),
            'tipesapi' => 'Semen',
            'kelamin' => 'Jantan',
            'tgllahir'    => $this->input->post('tanggallahir'),
            'idsire'    => $idsire,
            'kodesire'    => $kodesire,
            'namasire'    => $namasire,
            'iddam'    => $iddam,
            'kodedam'    => $kodedam,
            'namadam'    => $namadam,
        ];
        $this->db->where('tipesapi','Semen');
        $this->db->where('idsapi',$id);
        $this->db->update('sapi',$data);
    }
    public function delete()
    {
        $id = $this->input->post('id');
        $sql="DELETE from sapi where idsapi='$id' and tipesapi='Semen' LIMIT 1";
        $this->db->query($sql);
    }
}