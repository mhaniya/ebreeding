<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<style>
body {
    background-image: url("<?php echo base_url();?>assets/images/sertificate.jpg");
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
		//$grade = "A";
		
		$sql="SELECT 
		kodedam idinduk,
		tagdam taginduk ,
		namadam namainduk ,
		kodesire idpejantan,
		tagsire tagpejantan,
		namasire namapejantan ,
		(select milkbv from sapi where sapi.idsapi=tetua.kodesire) milkbv,
		(select fatbv from sapi where sapi.idsapi=tetua.kodesire) fatbv,
		(select proteinbv from sapi where sapi.idsapi=tetua.kodesire) proteinbv,
		(select fat from sapi where sapi.idsapi=tetua.kodedam) fat,
		(select protein from sapi where sapi.idsapi=tetua.kodedam) protein
		FROM tetua WHERE idsapi='$idsapi'";
		 $taginduk='';
		 $taginduk1='';
		 $taginduk2='';
		 
		$rs=$this->db->query($sql);
		if($rs->num_rows()>0){
			$row=$rs->row();
			$idindukjantan=$row->idpejantan;
			$tagindukjantan=$row->tagpejantan;
			$namaindukjantan=$row->namapejantan;
			$milkbv=$row->milkbv;
			$fatbv=$row->fatbv;
			$proteinbv=$row->proteinbv;
			
			$idinduk=$row->idinduk;
			$taginduk=$row->taginduk;
			$namainduk=$row->namainduk;
			$produksi="0";
			$fat=$row->fat;
			$protein=$row->protein;
			
			//Tetua dari induk jantan
			$sql="SELECT kodedam idinduk,
			tagdam taginduk ,
			namadam namainduk ,
			kodesire idpejantan,
			tagsire tagpejantan,
			namasire namapejantan ,
			(select milkbv from sapi where sapi.idsapi=tetua.kodesire) milkbv,
			(select fatbv from sapi where sapi.idsapi=tetua.kodesire) fatbv,
			(select proteinbv from sapi where sapi.idsapi=tetua.kodesire) proteinbv,
			(select milk from sapi where sapi.idsapi=tetua.kodedam) milk,
			(select fat from sapi where sapi.idsapi=tetua.kodedam) fat,
			(select protein from sapi where sapi.idsapi=tetua.kodedam) protein
			FROM tetua   WHERE idsapi='$idindukjantan'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()>0){
				$row=$rs->row();
				
				if($row->idpejantan!=null){
					$idindukjantan1=$row->idpejantan;
				}else{	
					$idindukjantan1="";
				}
				if($row->tagpejantan!=null){
					$tagindukjantan1=$row->tagpejantan;
				}else{
					$tagindukjantan1="-";
				}
				if($row->milk!=null){
					$milkbv1=$row->milk;
				}else{
					$milkbv1="-";
				}
				if($row->fat!=null){
					$fatbv1=$row->fat;
				}else{
					$fatbv1="--";
				}
				if($row->protein!=null){
					$proteinbv1=$row->protein;
				}else{
					$proteinbv1="-";
				}
				
				if($row->idinduk!=null){
					$idinduk1=$row->idinduk;
				}else{
					$idinduk1="";
				}
				if($row->taginduk!=null){
					$taginduk1=$row->taginduk;
				}else{
					$taginduk1="";
				}
				$produksi1="0";
				
				if($row->fat!=null){
					$fat1=$row->fat;
				}else{
					$fat1="-";
				}
				
				if($row->protein!=null){
					$protein1=$row->protein;
				}else{
					$protein1="-";
				}
			}else{
				$idindukjantan1="-";
				$milkbv1="-";
				$fatbv1="-";
				$proteinbv1="-";
				
				$idinduk1="-";
				$produksi1="0";
				$fat1="0";
				$protein1="0";
			}
			
			//Tetua dari induk betina
			$sql="SELECT kodedam idinduk,
			tagdam taginduk ,
			namadam namainduk ,
			kodesire idpejantan,
			tagsire tagpejantan,
			namasire namapejantan ,
			(select milkbv from sapi where sapi.idsapi=tetua.kodesire) milkbv,
			(select fatbv from sapi where sapi.idsapi=tetua.kodesire) fatbv,
			(select proteinbv from sapi where sapi.idsapi=tetua.kodesire) proteinbv,
			(select milk from sapi where sapi.idsapi=tetua.kodedam) milk,
			(select fat from sapi where sapi.idsapi=tetua.kodedam) fat,
			(select protein from sapi where sapi.idsapi=tetua.kodedam) protein
			FROM tetua WHERE idsapi='$idinduk'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()>0){
				$row=$rs->row();
				$idindukjantan2=$row->idpejantan;
				$milkbv2=$row->milk;
				$fatbv2=$row->fat;
				$proteinbv2=$row->protein;
				
				$idinduk2=$row->idinduk;
				$taginduk2=$row->taginduk;
				$produksi2="0";
				$fat2=$row->fat;
				$protein2=$row->protein;
			}else{
				$idindukjantan2="-";
				$milkbv2="-";
				$fatbv2="-";
				$proteinbv2="-";
				
				$idinduk2="-";
				$produksi2="0";
				$fat2="0";
				$protein2="0";
			}
		}else{
			$idindukjantan="-";
			$namaindukjantan="-";
			$milkbv="0";
			$fatbv="0";
			$proteinbv="0";
			$idinduk="-";
			$namainduk="-";
			$produksi="0";
			$fat="0";
			$protein="0";
			
			$idindukjantan1="-";
			$milkbv1="0";
			$fatbv1="0";
			$proteinbv1="0";
			
			$idinduk1="-";
			$produksi1="0";
			$fat1="0";
			$protein1="0";
			
			$idindukjantan2="-";
			$milkbv2="0";
			$fatbv2="0";
			$proteinbv2="0";
			
			$idinduk2="-";
			$produksi2="0";
			$fat2="0";
			$protein2="0";
		}
	?>
	<!--div id='noreg' style='position:absolute;left:700px;top:217px;font-size:x-large;'><?php echo $grade;?></div-->
	
	<div id='noreg' style='position:absolute;left:250px;top:240px;'><?php echo $nomorregister;?></div>
	<div id='noreg' style='position:absolute;left:250px;top:260px;'>FRIES HOLLAND</div>
	<div id='noreg' style='position:absolute;left:250px;top:280px;'><?php echo $jkel;?></div>
	
	<div id='noreg' style='position:absolute;left:1010px;top:240px;'><?php echo ($nama<>''?$nama:'-');?></div>
	<div id='noreg' style='position:absolute;left:1010px;top:260px;'><?php echo $tagsapi;?></div>
	<div id='noreg' style='position:absolute;left:1010px;top:280px;'>-</div>
	<div id='noreg' style='position:absolute;left:1010px;top:300px;'><?php echo $tgllahir;?></div>
	
	<div id='noreg' style='position:absolute;left:650px;top:375px;'><?php echo $namaindukjantan;?></div>
	<div id='noreg' style='position:absolute;left:650px;top:390px;'><?php echo (isset($tagindukjantan)?$tagindukjantan:"");?></div>
	<div id='noreg' style='position:absolute;left:650px;top:410px;'><?php echo $milkbv;?></div>
	<div id='noreg' style='position:absolute;left:650px;top:427px;'><?php echo $fatbv;?></div>
	<div id='noreg' style='position:absolute;left:650px;top:445px;'><?php echo $proteinbv;?></div>
	
	<div id='noreg' style='position:absolute;left:650px;top:560px;'><?php echo $namainduk;?></div>
	<div id='noreg' style='position:absolute;left:650px;top:580px;'><?php echo $taginduk;?></div>
	<div id='noreg' style='position:absolute;left:650px;top:600px;'><?php echo $produksi;?></div>
	<div id='noreg' style='position:absolute;left:650px;top:620px;'><?php echo $fat;?></div>
	<div id='noreg' style='position:absolute;left:650px;top:640px;'><?php echo $protein;?></div>

	<div id='noreg' style='position:absolute;left:1100px;top:337px;'><?php echo $idindukjantan1;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:355px;'><?php echo $milkbv1;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:372px;'><?php echo $fatbv1;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:389px;'><?php echo $proteinbv1;?></div>
	
	<div id='noreg' style='position:absolute;left:1100px;top:420px;'><?php echo $taginduk1;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:443px;'><?php echo $produksi1;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:460px;'><?php echo $fat1;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:477px;'><?php echo $protein1;?></div>
	
	<div id='noreg' style='position:absolute;left:1100px;top:517px;'><?php echo $idindukjantan2;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:535px;'><?php echo $milkbv2;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:552px;'><?php echo $fatbv2;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:569px;'><?php echo $proteinbv2;?></div>
	
	<div id='noreg' style='position:absolute;left:1100px;top:600px;'><?php echo $taginduk2;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:617px;'><?php echo $produksi2;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:634px;'><?php echo $fat2;?></div>
	<div id='noreg' style='position:absolute;left:1100px;top:651px;'><?php echo $protein2;?></div>
	
	<div id='noreg' style='position:absolute;left:215px;top:410px;'>
	<img src='<?php echo base_url();?>/assets/images/upload/foto/sapi/<?php echo $idsapi;?>.jpg' width='230px;' height='170px'>
	</div>
</body>
</html>

<script>
	window.print();
	//window.close();
</script>