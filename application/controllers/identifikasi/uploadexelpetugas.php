<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
Class UploadExelPetugas extends CI_Controller
{
	function __construct ()
	{
		parent::__construct();	
		$this->load->model('petugasmodel');
		$this->load->library(array('simpliauth','simplival','fungsi','pquery','excel_reader'));
		$this->auth->restrict();

	}
	function index()
	{
		$this->start();
	}
	function start()
	{
		$data["tanggalinput"]=date('dmY');
		

		$this->session->set_userdata('tanggalinput',$data["tanggalinput"]);
		$this->session->set_userdata('nama_file',"petugas".$data["tanggalinput"]);

				
		$this->load->view('identifikasi/petugas/upload_form',$data);
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
		
		$allowed = array( array('application/excel', 'application/vnd.ms-excel'));
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
		    
			$target_path = $target_path . basename( "petugas".$tanggalinput).".xls"; 
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
		                              		
				$this->session->set_userdata('nama_file',"petugas".$tanggalinput);
				    //$msg = "<i>file telah tersimpan </i>";
				$msg = "<i>file telah tersimpan (petugas".$tanggalinput.".xls)</i>";
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
		$data['tanggalinput'] = $this->session->userdata('tanggalinput');
		//$this->session->unset_userdata('nama_file');
		$this->load->view('identifikasi/petugas/form_real',$data);
	}
	function do_upload_keterangan()
	{
		$tanggalinput=$this->session->userdata('tanggalinput');

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
			for ($i = 2; $i < $data['numRows']; $i++) {
                            
				for ($j = 1; $j <= $data['numCols']; $j++) {
						if($j=="1")
							$nama = $data['cells'][$i][$j];
						if($j=="2")
							$jabatan = $data['cells'][$i][$j];
						if($j=="3")
							$nip = $data['cells'][$i][$j];
				}
				$sql1="SELECT * from petugas where nama='$nama' AND jabatan='$jabatan'";
				
				$rs=$this->db->query($sql1);
				$row=$rs->row();
				if($rs->num_rows()>0){
					if(($nama<>"")){
						$sql="REPLACE INTO petugas SET nama='$nama',jabatan='$jabatan',nip='$nip'";
						$this->db->query($sql);
						
						$nSukses++;
						$log.="<font color='blue'>".$kodesapi." Sukses Diupdate</font><br>";
					}
				}else{
					if(($nama<>"")AND($idpetugas<>"")){
						$sql="INSERT INTO petugas SET nama='$nama',jabatan='$jabatan',nip='$nip'";
						$this->db->query($sql);
						$nSukses++;
						$log.="<font color='blue'>".$kodesapi." Sukses Ditambah</font><br>";
					}
				}			
			}
					
			
                                echo "Update Data Berhasil sebanyak $nSukses Baris, dengan $nError baris dilewati karena data tagsapi tidak ketemu<br><br>";
	echo $log;
		//$this->start();
	
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
}