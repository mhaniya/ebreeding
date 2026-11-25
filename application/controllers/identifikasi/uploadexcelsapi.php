<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
Class UploadExcelSapi extends CI_Controller
{
	function __construct ()
	{
		parent::__construct();		
		$this->load->library(array('simpliauth','simplival','fungsi','pquery','excel_reader'));
		$this->auth->restrict();

	}
	function index()
	{
		$this->start();
	}
	function start()
	{
		$data["tanggalinput"]=$this->uri->segment(4);
		$data["kodepropinsi"]=$this->uri->segment(5);
		$data["kodekabupaten"]=$this->uri->segment(6);
		$data["kodekecamatan"]=$this->uri->segment(7);
		$data["idfarm"]=$this->uri->segment(8);
		if($data["kodepropinsi"]==""){
			echo "Propinsi Belum di pilih";
			exit;
		}
		
		$this->session->set_userdata('nama_file',"sapi".$data["kodepropinsi"].$data["kodekabupaten"].$data["kodekecamatan"].date('Ymd'));
		$this->session->set_userdata('tanggalinput',$data["tanggalinput"]);

		$this->session->set_userdata('kodepropinsi',$data["kodepropinsi"]);
		$this->session->set_userdata('kodekabupaten',$data["kodekabupaten"]);
		$this->session->set_userdata('kodekecamatan',$data["kodekecamatan"]);
		$this->session->set_userdata('idfarm',$data["idfarm"]);

		$this->load->view('identifikasi/sapi/upload_form',$data);
	}
	function do_upload_file()
	{
		$msg = "";
		$err = "";
					
		if($_FILES['myfile']['size'] >  0 && $_FILES['myfile']['size'] < 100000000)
		{
			$fileName = $_FILES['myfile']['name'];
			$tmpName  = $_FILES['myfile']['tmp_name'];
		
				
		$fileSize = $_FILES['myfile']['size'];
		$fileType = $_FILES['myfile']['type'];
		
		$allowed = array( array('application/excel', 'application/vnd.ms-excel','application/octet-stream'));
		$is_allowed = $this->fungsi->is_allowed_filetype($fileType,$allowed);
		if($is_allowed==false)
		{
		    $err = "<div class=\'blok\'><font color=#FF0000>Anda hanya diperbolehkan mengunggah file ber-ekstensi .xls </font></div><br />";
		}
		else
		{   
		    if(!get_magic_quotes_gpc())
		    {
			$fileName = addslashes($fileName);
		    }
		    // get extension
		    $x = explode('.', $fileName);
			$ext = '.'.end($x);
			// get raw name
			$rawname = str_replace($ext, '', $fileName);
			$fileName = $rawname."_".time().$ext;
			// move file to upload folder
			$target_path = "./upload/";                
		    $kodepropinsi=$this->session->userdata('kodepropinsi');
			$namafile=$this->session->userdata('nama_file');

			$target_path = $target_path . basename( $namafile).".xls"; 
		    $full_path = ""; 
		    if (function_exists('realpath') AND @realpath($full_path) !== FALSE)
			    {
				    $full_path = str_replace("\\", "/", realpath($full_path));
			    }        
			    $full_path = preg_replace("/(.+?)\/*$/", "\\1/",  $full_path);   
		    $full_path = $full_path.'upload/'.$_FILES['myfile']['name'];
			   
		    if(move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) 
		    {
				
			$uploader=$this->session->userdata('nama');
				$data['full_path'] = $full_path;
				$data['file_name'] = $fileName;
				$data['file_type'] = $fileType;
				$data['file_size'] = floor($fileSize/1000);
		                              		
			//$this->session->set_userdata('nama_file',$fileName);
				    //$msg = "<i>file telah tersimpan </i>";
				$msg = "<i>file telah tersimpan (".$namafile.".xls) di $target_path</i>";
		    } 
		    else
		    {
			$err = "<p class='warning'><font color=#FF0000>Pengunggahan file gagal dilakukan</font></p><br />";
		    }
			
		    }
		    }
		    else
		    {
			$err = "<p class='warning'><font color=#FF0000>Pengunggahan file gagal dilakukan</font></p><br />";
		    }       
		echo "{";
		echo	   "error: '" . $err . "',\n";
		echo	   "msg: '" . $msg . "'\n";
		echo "}"; 
	}
	function show_form_real()
	{
		$data['filename'] = $this->session->userdata('nama_file');
		$data['kodepropinsi'] = $this->session->userdata('kodepropinsi');
		$data['kodekabupaten'] = $this->session->userdata('kodekabupaten');
		$data['kodekecamatan'] = $this->session->userdata('kodekecamatan');
		$data['idfarm'] = $this->session->userdata('idfarm');
		$data['tanggalinput'] = $this->session->userdata('tanggalinput');
		$this->session->unset_userdata('kodepropinsi');
		$this->session->unset_userdata('kodekabupaten');
		$this->session->unset_userdata('kodekecamatan');
		$this->session->unset_userdata('idfarm');
		$this->session->unset_userdata('nama_file');

		$this->load->view('identifikasi/sapi/form_real',$data);
	}
	function do_upload_keterangan()
	{
		$idfarm=$this->input->post('idfarm');
		$tanggalinput=$this->input->post('tanggalinput');

		$filename=$this->input->post('filename');

		 // Load the spreadsheet reader library
			$this->load->library('excel_reader');

            $file =  $_SERVER['DOCUMENT_ROOT']."/upload/".$filename.".xls" ;

			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');
			
			
			$this->excel_reader->read($file);

			error_reporting(E_ALL ^ E_NOTICE);

			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
			$nError=0;$nSukses=0;$log="";
			
			for ($i = 2; $i <= $data['numRows']; $i++) {
				$status='hidup';
				$status_pc='';
				for ($j = 1; $j <= $data['numCols']; $j++) {				
					if($j=="1")
						$tagsapi = $data['cells'][$i][$j];
					if($j=="2")
						$kelamin = $data['cells'][$i][$j];
					if($j=="3")
						$tipesapi = $data['cells'][$i][$j];
					    
					if($j=="4")
                                        $namasapi = $data['cells'][$i][$j];
					if($j=="5")
                                        $tgllahir = $data['cells'][$i][$j];
					
					if($j=="6")
                                        $bobotlahir = $data['cells'][$i][$j];
					if($j=="7")
                                        $status = $data['cells'][$i][$j]; 
					if($j=="8")
                                        $is_uzur = $data['cells'][$i][$j];
					if($j=="9")
                                        $is_vbc = $data['cells'][$i][$j];
					if ($j=="10")
                                        $is_kso = $data['cells'][$i][$j];
					if ($j=="11")
                                        $is_balai = $data['cells'][$i][$j];
				}   
			
					$sql="SELECT idsapi,tagsapi FROM sapi WHERE tagsapi='$tagsapi' AND idfarm='$idfarm'";
					$rs=$this->db->query($sql);
					$row=$rs->row();
					$idsapi=$row->idsapi;
					
					$ada=($rs->num_rows>0);
					
					if($tgllahir=='')$tgllahir='00/00/0000';
					
					$tgl = explode('/',$tgllahir);
					
					$tanggal=str_pad($tgl[0],2,"0",STR_PAD_LEFT);
					$bulan=str_pad($tgl[1],2,"0",STR_PAD_LEFT);
					$tahun=$tgl[2];
					
					$tgllahir=$tahun."-".$bulan."-".$tanggal;
										
					if($ada)
						$sql="UPDATE sapi ";
					else
						$sql="INSERT INTO sapi ";
                    
					$sql .= " SET `idfarm` ='$idfarm',
						   `tagsapi`='$tagsapi',
						   `idbangsa`='1',
						   `kelamin`='$kelamin',
						   `tipesapi`='$tipesapi',
						   `namasapi`='$namasapi',
						   `tgllahir`=SUBDATE('$tgllahir',INTERVAL 1 day),
						   `bobotlahir`='$bobotlahir',
			  			   `status` ='$status',
					  	   `is_uzur`='$is_uzur',
						   `is_kso`='$is_kso',
  						   `is_balai`='$is_balai',
						   `is_vbc`='$is_vbc',
						   `tglinput`=CURRENT_DATE";
					//`statuspc`='$status_pc',
					if($ada){
						$sql.=" WHERE tagsapi='$tagsapi' AND idfarm='$idfarm'";
					}
					
					$this->db->query($sql);     
					
					if(!$ada){	
						if(checkdate($bulan,$tanggal,$tahun))
							$sql="SELECT count(*)+1 as n,date_format(SUBDATE('$tgllahir',INTERVAL 1 day),'%d%m%y') tgl FROM sapi WHERE idfarm LIKE '".substr($idfarm,0,3)."%"."' AND tgllahir=SUBDATE('$tgllahir',INTERVAL 1 day)";
						else
							$sql="SELECT count(*)+1 as n FROM sapi WHERE idfarm like '".substr($idfarm,0,3)."%"."' AND tgllahir='0000-00-00'";

						$rs=$this->db->query($sql);
						$row=$rs->row();
						if(checkdate($bulan,$tanggal,$tahun)){
							$n=str_pad($row->n,2,"0",STR_PAD_LEFT);
							$tgl=$row->tgl;
							$kodefikasi=substr($idfarm,0,3).$n.$tgl.($tipesapi=="IB");
						}else{
							$n=str_pad($row->n,8,"0",STR_PAD_LEFT);
							$kodefikasi=substr($idfarm,0,3).$n.($tipesapi=="IB");
						}	
						
						$sql="SELECT idsapi,tagsapi FROM sapi WHERE tagsapi='$tagsapi' AND idfarm='$idfarm'";
						$rs=$this->db->query($sql);
						$row=$rs->row();
						$idsapi=$row->idsapi;
					}else{			
						if(checkdate($bulan,$tanggal,$tahun))
							$sql="SELECT count(*)+1 as n,date_format(SUBDATE('$tgllahir',INTERVAL 1 day),'%d%m%y') tgl FROM sapi WHERE idfarm LIKE '".substr($idfarm,0,3)."%"."' AND tgllahir=SUBDATE('$tgllahir',INTERVAL 1 day) AND idsapi<>'$idsapi'";
						else
							$sql="SELECT count(*)+1 as n FROM sapi WHERE idfarm like '".substr($idfarm,0,3)."%"."' AND tgllahir='0000-00-00'  AND idsapi<>'$idsapi'";

						$rs=$this->db->query($sql);
						$row=$rs->row();
						if(checkdate($bulan,$tanggal,$tahun)){
							$n=str_pad($row->n,2,"0",STR_PAD_LEFT);
							$tgl=$row->tgl;
							$kodefikasi=substr($idfarm,0,3).$n.$tgl.($tipesapi=="IB");
						}else{
							$n=str_pad($row->n,8,"0",STR_PAD_LEFT);
							$kodefikasi=substr($idfarm,0,3).$n.($tipesapi=="IB");
						}
					}
					if($kodefikasi<>""){	
						$sql="REPLACE INTO register SET
							nomorregister='$kodefikasi'
							,idsapi='$idsapi'
							,tanggal=CURRENT_DATE
							,status='Aktif'";
						$this->db->query($sql);
						
					}	
					//if($rs){
						$nSukses++;
						$log .= "<font color='blue'>".$tagsapi." Sukses Diinputkan/Diupdate</font><br>";
				    //}else{$nError++;$log .= "<font color='red'>".$peternakan." Belum terregistrasi</font><br>";}
			}
            echo "Update Data Berhasil sebanyak $nSukses Baris, dengan $nError baris dilewati karena data farm tidak ketemu<br><br>";
			echo $log;
		//$this->start();
	}
	function deleteFile()
	{
		$id=$this->uri->segment(3,FALSE);
		if($id==FALSE){ die();}
		if(is_numeric($id)==FALSE) {die();}
		if($this->downloadmodel->cekFile($id)==FALSE) { die();}
		$this->downloadmodel->deleteFile($id);
		$kegiatan='Menghapus file dengan id '.$id;
		//$this->fungsi->catat($kegiatan);
		$pesan='File sudah dihapus';
		$this->start($pesan);			
	}
}
