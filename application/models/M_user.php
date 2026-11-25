<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_user extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('web_user.user_id',$id);
        }
        $this->db->join('web_level','web_level.level_id = web_user.level_id');
        return $this->db->get('web_user');
    }
    public function get_json()
    {
        $user= $this->utility->user_login();;
        $user_id=$user->user_id;
        $this->datatables->select('web_user.user_id,user_nama,user_username,level_nama,namakoperasi,farm.namafarm,user_aktif');
        $this->datatables->from('web_user');
        $this->datatables->join('web_level','web_level.level_id = web_user.level_id');
        $this->datatables->join('koperasi','web_user.kodekoperasi = koperasi.kodekoperasi','left');
        $this->datatables->join('farm','web_user.idfarmuser = farm.idfarm','left');
        if($user->level_id=='2'){
            $kodekoperasi=$user->kodekoperasi;
            $this->datatables->where('web_user.kodekoperasi',$kodekoperasi);
        }else
        if($user->level_id!='3'){
            $this->db->where('web_user.user_id',$user_id);
        }

        if(($user->level_id==2)||($user->level_id=='3')){
            $this->datatables->add_column('aksi','<div class="btn-group"><form action="/identifikasi/pengguna/edit" method="post">
                        <button class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button></form>
                        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button>
                        <a href="/identifikasi/pengguna/editpass" data-id="$1" class="btn btn-secondary">Ubah Pass</a></div>'
                        ,'user_id');
        }else{
            $this->datatables->add_column('aksi','<div class="btn-group"><form action="/identifikasi/pengguna/edit" method="post">
                        <button class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button></form>
                        <a href="/identifikasi/pengguna/editpass" data-id="$1" class="btn btn-secondary">Ubah Pass</a></div>'
                        ,'user_id');
        }
        
        return $this->datatables->generate();
    }
    
    public function get_idfarm($id_user)
    {
        
        $sql="SELECT idfarmuser 
              FROM web_user
              WHERE web_user.user_id='$id_user'";
        $rs=$this->db->query($sql);
        if($rs->num_rows()==0)
            return "";
        else{
            $row=$rs->row();
            return $row->idfarmuser;
        }
    }
    public function get_kodepropinsi($id_user)
    {
        
        $sql="SELECT kodepropinsi 
              FROM web_user
              JOIN koperasi ON koperasi.kodekoperasi=web_user.kodekoperasi
              WHERE web_user.user_id='$id_user'";
        $rs=$this->db->query($sql);
        if($rs->num_rows()==0)
            return "";
        else{
            $row=$rs->row();
            return $row->kodepropinsi;
        }
    }
    public function get_kodekabupaten($id_user)
    {
        
        $sql="SELECT kodekabupaten
              FROM web_user
              JOIN koperasi ON koperasi.kodekoperasi=web_user.kodekoperasi
              WHERE web_user.user_id='$id_user'";
        $rs=$this->db->query($sql);
        if($rs->num_rows()==0)
            return "";
        else{
            $row=$rs->row();
            return $row->kodekabupaten;
        }
    }
    public function get_kodekecamatan($id_user)
    {
        
        $sql="SELECT kodekecamatan
              FROM web_user
              JOIN koperasi ON koperasi.kodekoperasi=web_user.kodekoperasi
              WHERE web_user.user_id='$id_user'";
        $rs=$this->db->query($sql);
        if($rs->num_rows()==0)
            return "";
        else{
            $row=$rs->row();
            return $row->kodekecamatan;
        }
    }
    public function get_kodekoperasi($id_user)
    {
        $sql="SELECT kodekoperasi
              FROM web_user
              WHERE web_user.user_id='$id_user'";
        $rs=$this->db->query($sql);
        if($rs->num_rows()==0)
            return "";
        else{
            $row=$rs->row();
            return $row->kodekoperasi;
        }
    }

    public function save()
    { 
        $user=$this->utility->user_login();
        
        $data = [
            'user_id' => '',
            'user_nama' => htmlspecialchars($this->input->post('user_nama')),
            'user_username' => htmlspecialchars($this->input->post('user_username')),
            'user_password' => sha1($this->input->post('pass1')),
            'level_id' => $this->input->post('level_id'),
            'idfarmuser' => $this->input->post('idfarmuser'),
            'user_aktif' => $this->input->post('status_user')
        ];
        if($user->level_id==2){
            $data['kodekoperasi']=$user->kodekoperasi;
        }
         
        $this->db->insert('web_user',$data);
    }
    public function update()
    {
        $id = $this->input->post('user_id');
        $data = [
            'user_nama' => htmlspecialchars($this->input->post('user_nama')),
            'user_username' => htmlspecialchars($this->input->post('user_username')),
            'level_id' => $this->input->post('level_id'),  
            'user_aktif' => $this->input->post('status_user')
        ];
        if($this->input->post('kodekoperasi')!=""){
            $data['kodekoperasi'] = $this->input->post('kodekoperasi');
        }
        if($this->input->post('idfarmuser')!=""){
            $data['idfarmuser'] = $this->input->post('idfarmuser');
        }
        $this->db->where('user_id',$id);
        $this->db->update('web_user',$data);
        
    }
    public function updatepass()
    {
        $id = $this->input->post('user_id');
        $data = [
            'user_password' => sha1($this->input->post('pass1')),
        ];
        $this->db->where('user_id',$id);
        $this->db->update('web_user',$data);
    }
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('user_id',$id);
        $this->db->delete('web_user');
    }
}