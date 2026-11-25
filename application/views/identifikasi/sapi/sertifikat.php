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
		
		$sql="SELECT sapi.*,b.namabangsa FROM sapi JOIN bangsasapi b ON b.idbangsa=sapi.idbangsa WHERE idsapi='$idsapi'";
		
		$rs=$this->db->query($sql);
		if($rs->num_rows()>0){
			$row=$rs->row();
			$jkel=$row->kelamin;
			$nama=$row->namasapi;
			$tagsapi=$row->tagsapi;
			$bangsasapi=$row->namabangsa;
			$tgllahir=$this->fungsi->date_to_tanggal($row->tgllahir);
			$tglsertifikat=$this->fungsi->date_to_tanggal($row->tglsertifikat);
		}else{
			$jkel="-";
			$nama="-";
			$tagsapi="-";
			$bangsasapi="";
			$tgllahir="-";
			$tglsertifikat="............................";
		}
		
		//Membaca Grade
		//Untuk sementara di set A dulu :D
		//$grade = "A";
		
// 		$sql="SELECT *,(SELECT tagsapi FROM sapi WHERE  sapi.idsapi=tetua.idinduk) taginduk 
// ,(SELECT tagsapi FROM sapi WHERE  sapi.idsapi=tetua.idinduk1) taginduk1 
// ,(SELECT tagsapi FROM sapi WHERE  sapi.idsapi=tetua.idinduk2) taginduk2 
// ,(SELECT tagsapi FROM sapi WHERE  sapi.idsapi=tetua.idpejantan) tagpejantan 
// FROM tetua WHERE idanak='$idsapi'";
		 $taginduk='';
		 $taginduk1='';
		 $taginduk2='';
		 
		// $rs=$this->db->query($sql);
		$rs=$this->M_sapi->getInduk($idsapi);
		
		if($rs->num_rows()>0){
			$rowInduk=$rs->row();
			
			$kodedam=$rowInduk->kodedam;
			$noregdam="";
			$tagdam=$rowInduk->tagdam;
			$namadam=$rowInduk->namadam;
			if($rowInduk->tgllahirdam<>null)
				$tgllahirdam=$this->fungsi->date_to_tanggal3($rowInduk->tgllahirdam);
			else
				$tgllahirdam="";
			$idsire=$rowInduk->idsire;
			$iddam=$rowInduk->iddam;
			$kodesire=$rowInduk->kodesire;
			$noregsire="";
			$tagsire=$rowInduk->tagsire;
			$namasire=$rowInduk->namasire;
			$milksire=$rowInduk->milksire;
			$fatsire=$rowInduk->fatsire;
			$proteinsire=$rowInduk->proteinsire;
			if($rowInduk->tgllahirsire<>null)
				$tgllahirsire=$this->fungsi->date_to_tanggal3($rowInduk->tgllahirsire);
			else
				$tgllahirsire="";
			$milkdam=$rowInduk->milkdam;
			$fatdam=$rowInduk->fatdam;
			$proteindam=$rowInduk->proteindam;
		}else{
			$idsire="";
			$kodesire="";
			$noregsire="";
			$tagsire="";
			$namasire="";
			$milksire="";
			$fatsire="";
			$proteinsire="";
			$tgllahirsire="";
			$iddam="";
			$kodedam="";
			$noregdam="";
			$tagdam="";
			$namadam="";
			$milkdam="";
			$fatdam="";
			$proteindam="";
			$tgllahirdam="";
		}
	?>
	
	<div id='noreg' style='position:absolute;left:150px;top:240px;'>No. Register</div>
	<div id='noreg' style='position:absolute;left:150px;top:260px;'>Bangsa</div>
	<div id='noreg' style='position:absolute;left:150px;top:280px;'>Kelamin</div>
	
	<div id='noreg' style='position:absolute;left:250px;top:240px;'>: <?php echo $nomorregister;?></div>
	<div id='noreg' style='position:absolute;left:250px;top:260px;'>: <?php echo strtoupper($bangsasapi);?></div>
	<div id='noreg' style='position:absolute;left:250px;top:280px;'>: <?php echo $jkel;?></div>
	
	<div id='noreg' style='font-size:10pt;position:absolute;left:910px;top:240px;'>Nama</div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:910px;top:260px;'>No. Ident.</div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:910px;top:280px;'>Tgl. Lahir</div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:1010px;top:240px;'>: <?php echo ($nama<>''?$nama:'-');?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:1010px;top:260px;'>: <?php echo $tagsapi;?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:1010px;top:280px;'>: <?php echo $tgllahir;?></div>
	
	<div id='noreg' style='position:absolute;left:550px;top:375px;'>Nama</div>
	<div id='noreg' style='position:absolute;left:550px;top:390px;'>No. Ident.</div>
	<div id='noreg' style='position:absolute;left:550px;top:410px;'>Milk</div>
	<div id='noreg' style='position:absolute;left:550px;top:427px;'>Fat</div>
	<div id='noreg' style='position:absolute;left:550px;top:445px;'>Protein</div>

	<div id='noreg' style='font-size:10pt;position:absolute;left:625px;top:375px;'>: <?php echo $namasire;?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:625px;top:390px;'>: <?php echo $tagsire;?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:625px;top:410px;'>: <?php echo ($milksire>0?$milksire:"-");?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:625px;top:427px;'>: <?php echo ($fatsire>0?$fatsire:"-");?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:625px;top:445px;'>: <?php echo ($proteinsire>0?$proteinsire:"-");?></div>
	
	<div id='noreg' style='position:absolute;left:550px;top:580px;'>No Ident</div>
	<div id='noreg' style='position:absolute;left:550px;top:600px;'>Milk</div>
	<div id='noreg' style='position:absolute;left:550px;top:620px;'>Fat</div>
	<div id='noreg' style='position:absolute;left:550px;top:640px;'>Protein</div>

	<div id='noreg' style='font-size:10pt;position:absolute;left:625px;top:580px;'>: <?php echo $tagdam;?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:625px;top:600px;'>: <?php echo ($milkdam>0?$milkdam:"-");?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:625px;top:620px;'>: <?php echo ($fatdam>0?$fatdam:"-");?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:625px;top:640px;'>: <?php echo ($proteindam>0?$proteindam:"-");?></div>
	<?php
	$rspg=$this->M_sapi->getinduk($idsire);
	// echo $this->db->last_query()."<br>======================<br>";
	
	$rsmg=$this->M_sapi->getinduk($iddam);
	// echo $this->db->last_query()."<br>======================<br>";
	if($rspg->num_rows()>0){
		$rowInduk=$rspg->row();
		$namapgsire=$rowInduk->namasire;
		$tagpgsire=$rowInduk->tagsire;
		$namapgdam=$rowInduk->namadam;
		$tagpgdam=$rowInduk->tagdam;
	}else{
		$namapgsire="";
		$tagpgsire="";
		$namapgdam="";
		$tagpgdam="";
	}

	if($rsmg->num_rows()>0){
		$rowInduk=$rsmg->row();
		$namamgsire=$rowInduk->namasire;
		$tagmgsire=$rowInduk->tagsire;
		$namamgdam=$rowInduk->namadam;
		$tagmgdam=$rowInduk->tagdam;
	}else{
		$namamgsire="";
		$tagmgsire="";
		$namamgdam="";
		$tagmgdam="";
	}
	?>

	<div id='noreg' style='font-size:10pt;position:absolute;left:930px;top:360px;'><?php echo ($namapgsire<>""?$namapgsire:$tagpgsire);?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:930px;top:445px;'><?php echo ($namapgdam<>""?$namapgdam:$tagpgdam);?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:930px;top:538px;'><?php echo ($namamgsire<>""?$namamgsire:$tagmgsire);?></div>
	<div id='noreg' style='font-size:10pt;position:absolute;left:930px;top:625px;'><?php echo ($namamgdam<>""?$namamgdam:$tagmgdam);?></div>
	

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


	<div id='noreg' style='position:absolute;left:215px;top:410px;'>
	<img src='<?php echo base_url();?>assets/images/upload/foto/sapi/<?php echo $idsapi;?>.jpg' width='230px;' height='170px'>
	</div>
</body>
</html>

<script>
	window.print();
	//window.close();
</script>