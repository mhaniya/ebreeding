<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<style>
body {
    background-image: url("<?php echo base_url();?>assets/images/sertificatekambing.jpg");
    background-repeat: no-repeat;
	height:900px;
} 
</style>
<html>
<head>
</head>
<body >
	<?php
		
		 
		$sql="SELECT * FROM kambing WHERE eartag='$eartag'";
		
		$rs=$this->db->query($sql);
		if($rs->num_rows()>0){
			$row=$rs->row();
			$jkel=$row->kelamin;
			$bangsa=$row->rumpun;
			$taginduk=$row->taginduk;
			$tagindukjantan=$row->tagindukjantan;
			$tgllahir=$this->fungsi->date_to_tanggal($row->tgllahir);
			$tglsertifikat=$this->fungsi->date_to_tanggal(date('Y-m-d'));
		}else{
			$jkel="-";
			$bangsasapi="";
			$tgllahir="-";
			$taginduk="-";
			$tagindukjantan="-";
			$tglsertifikat="";
		}
		
		   
	?>
	
	<div id='noreg' style='position:absolute;left:420px;top:150px;' ><h1>SERTIFIKAT KAMBING PERAH</h1></div>
	<div id='noreg' style='position:absolute;left:500px;top:230px;'>Bangsa</div>
	<div id='noreg' style='position:absolute;left:700px;top:230px;'>: <?php echo $bangsa;?></div>
	<div id='noreg' style='position:absolute;left:500px;top:270px;'>Kelamin</div>
	<div id='noreg' style='position:absolute;left:700px;top:270px;'>: <?php echo $jkel;?></div>
	<div id='noreg' style='position:absolute;left:500px;top:310px;'>Tanggal Lahir</div>
	<div id='noreg' style='position:absolute;left:700px;top:310px;'>: <?php echo $tgllahir;?></div>
	
	
	<div id='noreg' style='position:absolute;left:303px;top:490px;border:2px solid;padding:10px;'><strong>No. Tag : <?php echo $eartag;?></strong></div>
	<div id='noreg' style='position:absolute;left:550px;top:390px;border:0;padding:10px;'><strong> <?php echo $taginduk;?></strong></div>
	<div id='noreg' style='position:absolute;left:550px;top:580px;border:0;padding:10px;'><strong> <?php echo $tagindukjantan;?></strong></div>
	 

	<div id='noreg' style='position:absolute;left:977px;top:717px;'>Baturraden, <?php echo $tglsertifikat;?></div>
	<div id='noreg' style='position:absolute;left:977px;top:737px;'>KEPALA BALAI</div>

	<?php
		$sql="SELECT * FROM settingbalai WHERE a_aktif='1'";
		$row_balai=$this->db->query($sql)->row();
		$nama_kabalai = $row_balai->namakepala;
		$nip_kabalai = $row_balai->nipkepala;
	?>
	<div id='noreg' style='position:absolute;left:977px;top:850px;'><u><?php echo $nama_kabalai;?></u></div>
	<div id='noreg' style='position:absolute;left:977px;top:870px;'>NIP. <?php echo $nip_kabalai;?></div>


	<div id='noreg' style='position:absolute;left:70px;top:410px;'>
	<img src='<?php echo base_url();?>assets/images/upload/foto/kambing/<?php echo $eartag;?>.jpg' width='230px;' height='170px'>
	</div>
</body>
</html>

<script>
	window.print();
	//window.close();
</script>