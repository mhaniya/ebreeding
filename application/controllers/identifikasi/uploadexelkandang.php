<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
Class UploadExelKandang extends CI_Controller
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

		$this->session->set_userdata('tanggalinput',$data["tanggalinput"]);
		$this->session->set_userdata('nama_file',"kandang".$data["tanggalinput"]);

		$this->session->set_userdata('kodepropinsi',$data["kodepropinsi"]);
		$this->session->set_userdata('kodekabupaten',$data["kodekabupaten"]);
		$this->session->set_userdata('kodekecamatan',$data["kodekecamatan"]);
		$this->session->set_userdata('idfarm',$data["idfarm"]);

		$this->load->view('identifikasi/kandang/upload_form',$data);
	}
	function do_upload_file()
	{
		$msg = "";
		    $err = "";
			$tanggalinput=$this->session->userdata('tanggalinput');
			
		    if($_FILES['myfile']['size'] >  0 && $_FILES['myfile']['size'] < 100000000)
		{
			$fileName = $_FILES['myfile']['name'];
		$tmpName  = $_FILES['myfile']['tmp_name'];
		
		//echo $_FILES['myfile']['tmp_name'];
		//		exit;
		
		
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
		    
			$target_path = $target_path . basename( "kandang".$tanggalinput).".xls"; 
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
				$msg = "<i>file telah tersimpan (kandang".$tanggalinput.")</i>";
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
		//$this->session->unset_userdata('nama_file');
		$this->load->view('identifikasi/kandang/form_real',$data);
	}
	function do_upload_keterangan()
	{
		$kodepropinsi=$this->input->post('kodepropinsi');
		$kodekabupaten=$this->input->post('kodekabupaten');
		$kodekecamatan=$this->input->post('kodekecamatan');
		$idfarm=$this->input->post('idfarm');
		$tanggalinput=$this->input->post('tanggalinput');

		$filename=$this->input->post('filename');

		 // Load the spreadsheet reader library
			$this->load->library('excel_reader');

                     $file =  $_SERVER['DOCUMENT_ROOT']."/newternak/upload/".$filename.".xls" ;
			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');
			
			
			$this->excel_reader->read($file);

			error_reporting(E_ALL ^ E_NOTICE);

			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
			$nError=0;$nSukses=0;$log="";
			for ($i = 2; $i <= $data['numRows']; $i++) {
                            
                for ($j = 1; $j <= $data['numCols']; $j++) {
					if($j=="1")
						$namakandang = $data['cells'][$i][$j];
                    if($j=="2")
						$lokasi = $data['cells'][$i][$j];
                    if($j=="3")
                    $kapasitas= $data['cells'][$i][$j];
				}
				 
               
				
				$sql="REPLACE INTO kandangsapi SET ";    
                $sql .= " namakandang='$namakandang'
							, lokasikandang='$lokasi'
							, kapasitas='$kapasitas'
							, idfarm='$idfarm'
							";
				$this->db->query($sql);
				$nSukses++;
				$log .= "<font color='blue'>".$kodekandang."Sukses Diupdate</font><br>";
			}					
						
        echo "Update Data Berhasil sebanyak $nSukses Baris, dengan $nError baris dilewati karena data kandang tidak ketemu<br><br>";
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
