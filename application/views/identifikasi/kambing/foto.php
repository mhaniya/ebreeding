<?php
	$nama=explode('#',$this->session->userdata('idfoto'));
	$namafile=$nama[0];
	
?>
<img src='<?php echo base_url();?>upload/foto/sapi/<?php echo $namafile;?>.jpg'  width='400px' style='border-radius:10px'>