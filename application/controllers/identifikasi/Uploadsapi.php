<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
Class Uploadsapi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library(array('simpliauth','simplival','fungsi','pquery'));
		$this->auth->restrict();
		$this->simplival->cek(8);
	}
	function index()
	{
		$this->start();
	}
	function start()
	{
		$data["idsapi"]=$this->uri->segment(4);
		//$data["nomorregister"]=$this->uri->segment(4);
		//$data["tagsapi"]=$this->uri->segment(5);
		$this->session->set_userdata('idsapi',$data["idsapi"]);
		$this->load->view('data/sapi/upload_form',$data);
	}
	function do_upload_file()
	{
		$msg = "";
		$err = "";
		$idsapi=$this->session->userdata('idfoto');
		if($_FILES['myfile']['size'] >  0 && $_FILES['myfile']['size'] < 100000000)
		{
			$fileName = $_FILES['myfile']['name'];
			$tmpName  = $_FILES['myfile']['tmp_name'];
			
			//echo $_FILES['myfile']['tmp_name'];
			//		exit;
			
			
			$fileSize = $_FILES['myfile']['size'];
			$fileType = $_FILES['myfile']['type'];
			
			$allowed = array(array('application/jpg', 'application/jpg'),
					array('application/png', 'application/png')
					);
			$is_allowed = $this->fungsi->is_allowed_filetype($fileType,$allowed);
			if($is_allowed==false)
			{
			$err = "<div class=\'blok\'><font color=#FF0000>Anda hanya diperbolehkan mengunggah file ber-ekstensi .jpg, .png, atau .gif, </font></div><br />";
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
				$target_path = "./upload/foto/sapi/";                
				
				$target_path = $target_path . basename( $idsapi).".jpg"; 
				
				$full_path = ""; 
				if (function_exists('realpath') AND @realpath($full_path) !== FALSE)
					{
						$full_path = str_replace("\\", "/", realpath($full_path));
					}        
					$full_path = preg_replace("/(.+?)\/*$/", "\\1/",  $full_path);   
				$full_path = $full_path.'upload/foto/'.$_FILES['myfile']['name'];
				if(file_exists($target_path)){
					echo "Udah ada";
					unlink($target_path);
				}
				if(move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) 
				{
					$uploader=$this->session->userdata('nama');
					$data['full_path'] = $full_path;
					$data['file_name'] = $fileName;
					$data['file_type'] = $fileType;
					$data['file_size'] = floor($fileSize/1000);                        		
					$this->session->set_userdata('nama_file',$fileName);
						//$msg = "<i>file telah tersimpan ($rawname$ext)</i>";
						$msg = "<i>file telah tersimpan </i>";
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
		$this->session->unset_userdata('nama_file');
		//$this->load->view('data/sapi/form_real',$data);
	}
	function do_upload_keterangan()
	{
		$judul=$this->input->post('judul');
		$desc=$this->input->post('deskripsi');
		$filename=$this->input->post('filename');
		$this->downloadmodel->updateDownloadData($judul,$desc,$filename);
		$this->start();
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