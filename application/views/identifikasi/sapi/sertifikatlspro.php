<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<style>
body {
    background-image: url("<?php echo base_url();?>assets/images/sertifikatlspro.jpg");
    background-repeat: no-repeat;
	height:900px;
} 
</style>
<html>
<head>
</head>
<body >
	<?php
		
		$sql="SELECT nomorregister FROM register WHERE idsapi='$idsapi'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()>0){
			$row=$rs->row();
			$nomorregister=$row->nomorregister;
		}else{
			$nomorregister='-';
		}
		
		$sql="SELECT * FROM sapi WHERE idsapi='$idsapi'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()>0){
			$row=$rs->row();
			$jkel=$row->kelamin;
			$nama=$row->namasapi;
			$tagsapi=$row->tagsapi;
			$tgllahir=$this->fungsi->date_to_tanggal($row->tgllahir);
		}else{
			$jkel="-";
			$nama="-";
			$tagsapi="-";
			$tgllahir="-";
		}
		
		//Membaca Grade
		//Untuk sementara di set A dulu :D
		 
		$rs=$this->M_sapi->getInduk($idsapi);
		if($rs->num_rows()>0){
			$row=$rs->row();
			$kodedamjantan=$row->kodesire;
			$tagindukjantan=$row->tagpejantan;
			$namaindukjantan=$row->namapejantan;
			$milkbv=$row->milksire;
			$fatbv=$row->fatsire;
			$proteinbv=$row->proteinsire;
			
			$kodedam=$row->kodedam;
			$taginduk=$row->taginduk;
			$namainduk=$row->namainduk;
			$produksi="0";
			$fat=$row->fatdam;
			$protein=$row->proteindam;
			
			//Tetua dari induk jantan
			$rs=$this->M_sapi->getInduk($kodedamjantan);
			if($rs->num_rows()>0){
				$row=$rs->row();
				
				if($row->kodesire!=null){
					$kodedamjantan1=$row->kodesire;
				}else{	
					$kodedamjantan1="";
				}
				if($row->tagpejantan!=null){
					$tagindukjantan1=$row->tagpejantan;
				}else{
					$tagindukjantan1="-";
				}
				if($row->milksire!=null){
					$milkbv1=$row->milksire;
				}else{
					$milkbv1="-";
				}
				if($row->fatsire!=null){
					$fatbv1=$row->fatsire;
				}else{
					$fatbv1="--";
				}
				if($row->proteinsire!=null){
					$proteinbv1=$row->proteinsire;
				}else{
					$proteinbv1="-";
				}
				
				if($row->kodedam!=null){
					$kodedam1=$row->kodedam;
				}else{
					$kodedam1="";
				}
				if($row->tagdam!=null){
					$taginduk1=$row->tagdam;
				}else{
					$taginduk1="";
				}
				$produksi1="0";
				
				if($row->fatdam!=null){
					$fat1=$row->fatdam;
				}else{
					$fat1="-";
				}
				
				if($row->proteindam!=null){
					$protein1=$row->proteindam;
				}else{
					$protein1="-";
				}
			}else{
				$kodedamjantan1="-";
				$milkbv1="-";
				$fatbv1="-";
				$proteinbv1="-";
				
				$kodedam1="-";
				$produksi1="0";
				$fat1="0";
				$protein1="0";
			}
			
			//Tetua dari induk betina
			// $sql="SELECT * FROM tetua WHERE idsapi='$kodedam'";
			$rs=$this->M_sapi->getInduk($kodedam);
			if($rs->num_rows()>0){
				$row=$rs->row();
				$kodedamjantan2=$row->kodesire;
				$milkbv2=$row->milksire;
				$fatbv2=$row->fatsire;
				$proteinbv2=$row->proteinsire;
				
				$kodedam2=$row->kodedam;
				$taginduk2=$row->tagdam;
				$produksi2="0";
				$fat2=$row->fatdam;
				$protein2=$row->proteindam;
			}else{
				$kodedamjantan2="-";
				$milkbv2="-";
				$fatbv2="-";
				$proteinbv2="-";
				
				$kodedam2="-";
				$produksi2="0";
				$fat2="0";
				$protein2="0";
			}
		}else{
			$kodedamjantan="-";
			$namaindukjantan="-";
			$milkbv="0";
			$fatbv="0";
			$proteinbv="0";
			$kodedam="-";
			$namainduk="-";
			$produksi="0";
			$fat="0";
			$protein="0";
			
			$kodedamjantan1="-";
			$milkbv1="0";
			$fatbv1="0";
			$proteinbv1="0";
			
			$kodedam1="-";
			$produksi1="0";
			$fat1="0";
			$protein1="0";
			
			$kodedamjantan2="-";
			$milkbv2="0";
			$fatbv2="0";
			$proteinbv2="0";
			
			$kodedam2="-";
			$produksi2="0";
			$fat2="0";
			$protein2="0";
		}
	?>
	 
	
	<!--div id='noreg' style='position:absolute;left:250px;top:240px;'><?php echo $nomorregister;?></div>
	<div id='noreg' style='position:absolute;left:250px;top:260px;'>FRIES HOLLAND</div>
	<div id='noreg' style='position:absolute;left:250px;top:280px;'><?php echo $jkel;?></div-->
	
	<div id='noreg' style='position:absolute;left:970px;top:295px;font-size:16px;'><strong>FRIES HOLLAND</strong></div>
	<div id='noreg' style='position:absolute;left:970;top:315px;font-size:16px;'><strong><?php echo $nomorregister;?></strong></div>
	<div id='noreg' style='position:absolute;left:970px;top:335;font-size:16px;'><strong><?php echo $jkel;?></strong></div>
	<div id='noreg' style='position:absolute;left:970px;top:355px;font-size:16px;'><strong><?php echo (isset($tagindukjantan)?$tagindukjantan:"");?></strong></div>
	<div id='noreg' style='position:absolute;left:970px;top:375px;font-size:16px;'><strong><?php echo (isset($tagindukjantan)?$tagindukjantan:"");?></strong></div>
	<div id='noreg' style='position:absolute;left:970px;top:395px;font-size:16px;'><strong><?php echo (isset($tagindukbetina)?$tagindukbetina:"");?></strong></div>
	
	
	<div id='noreg' style='position:absolute;left:300px;top:525px;font-size:16px;'><strong><?php echo 10;?></strong></div>
	
	<div id='noreg' style='position:absolute;left:200px;top:625px;font-size:16px;'><strong><?php echo 100;?></strong></div>
	
	<div id='noreg' style='position:absolute;left:290px;top:625px;font-size:16px;'><strong><?php echo 100;?></strong></div>
	
	<div id='noreg' style='position:absolute;left:380px;top:625px;font-size:16px;'><strong><?php echo 100;?></strong></div>
	
	<div id='noreg' style='position:absolute;left:500px;top:625px;font-size:16px;'><strong><?php echo 100;?></strong></div>
	
	<div id='noreg' style='position:absolute;left:630px;top:625px;font-size:16px;'><strong><?php echo 100;?></strong></div>
	
	<div id='noreg' style='position:absolute;left:240px;top:680px;font-size:16px;'><strong><?php echo $nama;?></strong></div>
	
	<div id='noreg' style='position:absolute;left:240px;top:725px;font-size:16px;'><strong><?php echo $nama;?></strong></div>
	
	<div id='noreg' style='position:absolute;left:215px;top:300px;'>
	<img src='<?php echo base_url();?>assets/images/upload/foto/sapi/<?php echo $idsapi;?>.jpg' width='230px;' height='170px'>
	<?php
		$sql="SELECT * FROM settingbalai WHERE a_aktif='1'";
		$row_balai=$this->db->query($sql)->row();
		$nama_kabalai = $row_balai->namakepala;
		$nip_kabalai = $row_balai->nipkepala;
	?>
	</div>
	<div id='noreg' style='position:absolute;left:915px;top:790px;font-size:16px;'><strong><?php echo $nama_kabalai;?></strong></div>
	<div id='noreg' style='position:absolute;left:945px;top:820px;font-size:16px;'><strong>NIP. <?php echo $nip_kabalai;?></strong></div>
</body>
</html>

<script>
	window.print();
	// window.close();
</script>