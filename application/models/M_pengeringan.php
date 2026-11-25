<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pengeringan extends CI_Model
{
    public function get($id = null)
    {
        if($id != null){
            $this->db->where('user_id',$id);
        }
        $this->db->select("reproduksi_pengeringan.idpengeringan
		, reproduksi_ib.idsapi
		,ADDDATE(max(reproduksi_ib.tanggal),INTERVAL 7 month) tglmulai
		,'' tglakhir
        ,'Belum pengeringan' keterangan
        ,max(reproduksi_ib.idib) idib
        ,max(reproduksi_ib.tanggal) tanggalib
        ,sapi.tagsapi
        ,register.nomorregister
        ,(SELECT max(xlaktasi) from reproduksi_kelahiran k where k.idsapi=reproduksi_ib.idsapi AND k.tanggal<reproduksi_ib.tanggal) xlaktasi");
         
        $this->db->JOIN('sapi','sapi.idsapi=reproduksi_ib.idsapi','left');
        $this->db->JOIN('register','register.idsapi=sapi.idsapi','left');
        $this->db->JOIN('reproduksi_pengeringan','reproduksi_pengeringan.idib=reproduksi_ib.idib','left');
        $this->db->JOIN('farm','farm.idfarm=sapi.idfarm','left');
        $this->db->group_by('`reproduksi_pengeringan`.`idpengeringan`, `reproduksi_ib`.`idsapi`,tglakhir,keterangan, `xlaktasi`, `sapi`.`tagsapi`, `register`.`nomorregister`');
        return $this->db->get('reproduksi_ib');
    }
    public function get_json()
    {
        
        $this->datatables->select("reproduksi_pengeringan.idpengeringan
		, reproduksi_ib.idsapi
		,ADDDATE(max(reproduksi_ib.tanggal),INTERVAL 7 month) tglmulai
		,'' tglakhir
        ,'Belum pengeringan' ket
        ,max(reproduksi_ib.idib) idib
        ,max(reproduksi_ib.tanggal) tanggalib
        ,sapi.tagsapi
        ,register.nomorregister
        ,(SELECT max(xlaktasi) from reproduksi_kelahiran k where k.idsapi=reproduksi_ib.idsapi AND k.tanggal<reproduksi_ib.tanggal) xlaktasi");
        $this->datatables->from('reproduksi_ib');
        $this->datatables->JOIN('sapi','sapi.idsapi=reproduksi_ib.idsapi','left');
        $this->datatables->JOIN('register','register.idsapi=sapi.idsapi','left');
        $this->datatables->JOIN('reproduksi_pengeringan','reproduksi_pengeringan.idib=reproduksi_ib.idib','left');
        $this->datatables->JOIN('farm','farm.idfarm=sapi.idfarm');

        $kodepropinsi  = $this->session->userdata('kodepropinsi');
        $kodekabupaten = $this->session->userdata('kodekabupaten');
        $kodekecamatan = $this->session->userdata('kodekecamatan');
        $idfarm = $this->session->userdata('idfarm');
        $tahun = $this->session->userdata('tahun')<>""?$this->session->userdata('tahun'):date('Y');
        $bulan = $this->session->userdata('bulan')<>""?$this->session->userdata('bulan'):date('m');
        $tanggal = $this->session->userdata('tanggal');
        $xlaktasi = $this->session->userdata('xlaktasi');
        
        if($kodepropinsi!="") $this->datatables->where('kodepropinsi',$kodepropinsi);
        if($kodekabupaten!="") $this->datatables->where('kodekabupaten',$kodekabupaten);
        if($kodekecamatan!="") $this->datatables->where('kodekecamatan',$kodekecamatan);
        if(($idfarm!="")&&($idfarm!="0")) $this->datatables->where('farm.idfarm',$idfarm);
        if(($tahun!="")&&($tahun!="0"))  $this->datatables->where('YEAR(reproduksi_pengeringan.tglmulai)',$tahun);
        if(($bulan!="")&&($bulan!="0"))  $this->datatables->where('MONTH(reproduksi_pengeringan.tglmulai)',$bulan);
        if(($tanggal!=""))  $this->datatables->where('reproduksi_pengeringan.tglmulai',$tanggal);
        if(($xlaktasi==-1)){
            $this->datatables->where('laktasike=maxxlaktasi');
        }else   
        if(($xlaktasi!="")&&($xlaktasi!="0"))  
            $this->datatables->where('laktasike',$xlaktasi);

        $this->datatables->group_by('`reproduksi_pengeringan`.`idpengeringan`, `reproduksi_ib`.`idsapi`,tglakhir, `xlaktasi`, `sapi`.`tagsapi`, `register`.`nomorregister`');
        $this->datatables->add_column('aksi','<div class="btn-group"><form action="/reproduksi/pengeringan/edit" method="post"><button class="btn btn-warning" name="id" value="$1"><i class="fas fa-pen"></i></button></form>
        <button class="btn btn-danger" id="hapusdata" data-id="$1"><i class="fas fa-trash"></i></button></div>'
        ,'idpengeringan');
        
        return $this->datatables->generate();
    }
    
    
    public function save()
    {
        $data = [
            'idpengeringan' => '',
            'idsapi' => $this->input->post('idsapi'),
            'tglmulai' => $this->input->post('tglmulai'),
            'tglakhir' => $this->input->post('tglakhir'),
            'keterangan' => $this->input->post('keterangan'),
            'idib' => $idib
        ];
        $this->db->insert('reproduksi_pengeringan',$data);
    }
    public function update()
    {
        $id = $this->input->post('user_id');
        $data = [
            'user_nama' => htmlspecialchars($this->input->post('user_nama')),
            'user_username' => htmlspecialchars($this->input->post('user_username')),
            'level_id' => $this->input->post('level_id'),
            'kodekoperasi' => $this->input->post('kodekoperasi'),
            'user_aktif' => $this->input->post('status_user')
        ];
        $this->db->where('user_id',$id);
        $this->db->update('reproduksi_pengeringan',$data);
    }
    public function updatepass()
    {
        $id = $this->input->post('user_id');
        $data = [
            'user_password' => sha1($this->input->post('pass1')),
        ];
        $this->db->where('user_id',$id);
        $this->db->update('reproduksi_pengeringan',$data);
    }
    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('user_id',$id);
        $this->db->delete('reproduksi_pengeringan');
    }
}