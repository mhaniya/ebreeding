<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landingpage extends CI_Controller {
	public function __construct()
	{
		parent::__construct(); 
		$this->session->set_userdata('menu','dashboard');
		$this->session->set_userdata('submenu','');
	 
	}
	public function index()
	{
		//Seharusnya ada di model
		//Sementara di controller
		$data['user'] = $this->utility->user_login(); 
		$data['judul']="Dashboard";
		$this->load->view('landingpage');
	}

	public function analisa()
	{
		
		$this->load->view('dashboard');
	}
	public function simpan_biodata(){
		$data=$_POST;
		$tgl=explode("/",$_POST['tgl_lahir']);
		$data['tgl_lahir']=$tgl[2]."-".$tgl[1]."-".$tgl[0];

		$tgl=explode("/",$_POST['tgl_laktasi']);
		$data['tgl_laktasi']=$tgl[2]."-".$tgl[1]."-".$tgl[0];
		$sql="SELECT * FROM biodata WHERE no_hp='$data[no_hp]' AND tag_sapi='$data[tag_sapi]' AND laktasi_ke='$data[laktasi_ke]'";
		$rs=$this->db->query($sql); 
		if($rs->num_rows()==0){
			$rs=$this->db->insert('biodata',$data);  
			echo $this->db->insert_id();
		}else{
			$row=$rs->row();
			echo $row->id_biodata;
		}
	}
	public function simpan_produksi(){
		$data=$_POST;
		$tgl=explode("/",$_POST['tgl_produksi']);
		if(sizeof($tgl)==3){
			$data['tgl_produksi']=$tgl[2]."-".$tgl[1]."-".$tgl[0];
			$rs=$this->db->insert('produksi',$data); 
		}
		$id_biodata=$data['id_biodata'];
		echo "<div class='box box-primary'>
                <div class='box-header with-border'>
                    <h3 class='box-title'>Analisa Produksi</h3>
                </div> 
                <div class='box-body'>
                    <table class='table'>
                      <thead>
                        <tr>
                            <th style='text-align:center;' colspan='3'>LAKTASI</th>
                            <th  style='text-align:center;' rowspan='2'>TGL. UKUR</th>
                            <th  style='text-align:center;' rowspan='2'>JHP</th>
                            <th  style='text-align:center;' rowspan='2'>UMUR</th>
                            <th  style='text-align:center;' rowspan='2'>PROD. SEBELUM</th>
                            <th  style='text-align:center;' rowspan='2'>JML HARI</th>
                            <th  style='text-align:center;' rowspan='2'>PROD. BULANAN</th>
                            <th  style='text-align:center;' rowspan='2'>PROD. NYATA</th>
                            <th  style='text-align:center;' colspan='2'>KOREKSI</th>
                            <th  style='text-align:center;' rowspan='2'>PROD. TERKOREKSI</th>
                        </tr> 
                        <tr>
                          <th style='text-align:center;' >KE</th>
                          <th style='text-align:center;' >BLNKE</th>
                          <th style='text-align:center;' >JUMLAH</th>
                          <th style='text-align:center;' >UMUR</th>
                          <th style='text-align:center;' >JHP</th>
                        </tr>
					  </thead>";
		$sql="SELECT biodata.*,produksi.jml_produksi,produksi.tgl_produksi
			   ,datediff(tgl_produksi,tgl_laktasi) jhp 
			   ,datediff(tgl_produksi,tgl_lahir)/365 umur 
			   ,floor(datediff(tgl_produksi,tgl_lahir)/365)+((datediff(tgl_produksi,tgl_lahir)/365)-floor(datediff(tgl_produksi,tgl_lahir)/365)) umur_hitung 
			   ,month(tgl_produksi) bln_produksi
			   ,year(tgl_produksi) thn_produksi
			   FROM produksi 
			  JOIN biodata USING(id_biodata) 
			  WHERE produksi.id_biodata='$id_biodata'
			  ORDER BY tgl_produksi";
		$rs=$this->db->query($sql);
		$i=0;
		$prod_sebelum=0;
		foreach($rs->result() as $row){
			$i++;
			echo "<tr>";
				echo "<td style='text-align:center;'>".$row->laktasi_ke."</td>";
				echo "<td style='text-align:center;'>".$i."</td>";
				echo "<td style='text-align:right'>".$row->jml_produksi."</td>";
				echo "<td style='text-align:right;width:100px;'>".$this->fungsi->date_to_tanggal3($row->tgl_produksi)."</td>";
				echo "<td style='text-align:right'>".$row->jhp."</td>";
				echo "<td style='text-align:right'>".number_format($row->umur_hitung,2,",",".")."</td>";
				echo "<td style='text-align:right'>".$prod_sebelum."</td>";
				$prod_sebelum=$row->jml_produksi;
				switch($row->bln_produksi){
					case 2:
						if($row->thn_produksi%4==0){
							$jml_hari=29;
						}else{
							$jml_hari=28;	
						}
						break;
					case 4:
						$jml_hari=30;
						break;
					case 6:
						$jml_hari=30;
						break;
					case 9:
						$jml_hari=30;
						break;
					case 11:
						$jml_hari=30;
						break;
					default:
						$jml_hari=31;
				}
				echo "<td style='text-align:right'>".$jml_hari."</td>";
				echo "<td style='text-align:right'>".$row->jml_produksi*$jml_hari."</td>";
				$prod_nyata=(($row->jml_produksi*$jml_hari)+$prod_sebelum);
				echo "<td style='text-align:right'>".$prod_nyata."</td>";
				$umur_hitung=str_replace(",",".",number_format($row->umur_hitung,2,",","."));
				$sql="SELECT koreksi FROM con_koreksiumur WHERE umur='$umur_hitung'";
				$rs_umur=$this->db->query($sql);
				if($rs_umur->num_rows()>0){
					$row_umur=$rs_umur->row();
					$koreksi_umur=$row_umur->koreksi;
				}else
					$koreksi_umur=1;
				
				
				echo "<td style='text-align:right'>".$koreksi_umur."</td>";
				$jhp=$row->jhp;
				$sql="SELECT koreksi FROM con_koreksijhp WHERE jhp='$jhp'";
				$rs_jhp=$this->db->query($sql);
				if($rs_jhp->num_rows()>0){
					$row_jhp=$rs_jhp->row();
					$koreksi_jhp=$row_jhp->koreksi;
				}else
					$koreksi_jhp=1;
				echo "<td style='text-align:right'>".$koreksi_jhp."</td>";
				$prod_terkoreksi=$prod_nyata*$koreksi_umur*$koreksi_jhp;
				echo "<td style='text-align:right'>".number_format($prod_terkoreksi,2,",",".")."</td>";
			echo "</tr>";
		}
		
        echo "</table>
                </div>
              <div class='box-footer'>
			  </div>
			</div>";
	}
	 
}
