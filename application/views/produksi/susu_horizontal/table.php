 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1 class="m-0 text-dark"><?php echo $judul;?></h1>
                 </div><!-- /.col -->
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#"><?php echo ucwords($menu);?></a></li>
                         <li class="breadcrumb-item active"><?php echo ucwords($submenu);?></li>
                     </ol>
                 </div><!-- /.col -->
             </div><!-- /.row -->
         </div><!-- /.container-fluid -->
     </div>
     <!-- /.content-header -->
     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-primary">
                         <div class="card-header">
                             <div class="row">
                                 <div class="col-md-1">
                                     <a href="javascript:" id="tambahdata" class="btn btn-primary">Tambah</a>
                                 </div>
                                 <div class="col-md-2">
                                     <?php //echo $this->session->userdata('kodepropinsi');?>
                                     <?php echo $this->simpliparse->build_select_common_edit('kodepropinsi',$propinsi,'kodepropinsi','namapropinsi',':: Pilih Propinsi ::',$kodepropinsi,"class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <?php echo $this->simpliparse->build_select_common_edit('kodekabupaten',$kabupaten,'kodekabupaten','namakabupaten',':: Pilih Kabupaten ::',$kodekabupaten,"class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <?php echo $this->simpliparse->build_select_common_edit('kodekecamatan',$kecamatan,'kodekecamatan','namakecamatan',':: Pilih Kecamatan ::',$kodekecamatan,"class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <?php echo $this->simpliparse->build_select_common_edit('idfarm',$farm,'idfarm','namafarm',':: Pilih Peternakan ::',$idfarm,"class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-1">
                                     <?php 
                                            $sql="SELECT year(tanggal) tahun FROM pengukuran_produksisusu GROUP BY tahun ORDER BY tahun DESC";
                                            $rstahun=$this->db->query($sql);
                                        ?>
                                     <?php echo $this->simpliparse->build_select_common_edit('tahun',$rstahun,'tahun','tahun',':: Tahun ::',$tahun,"class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <SELECT id='bulan' name='bulan' class='form-control'>
                                         <OPTION value='0'>:: Bulan ::</OPTION>
                                         <?php
                                            for($i=1;$i<=12;$i++){
                                                ?>
                                         <OPTION value='<?php echo $i;?>' <?php echo ($bulan==$i?"SELECTED":"");?>>
                                             <?php echo $this->fungsi->bulan2($i);?></OPTION>
                                         <?php
                                            }
                                        ?>
                                     </SELECT>
                                 </div>
                             </div>

                         </div>
                         <div class="card-body table-responsive">
                             <table width="100%" class="table table-bordered table-striped table-hover" id="data">
                                 <thead>
                                     <tr>
                                         <th rowspan='2' style='text-align:center;' width='50px'>No</th>
                                         <th rowspan='2' style='text-align:center;!width:200px;'>Tag Sapi</th>
                                         <th rowspan='2' style='text-align:center;'>No Register</th>
                                         <th rowspan='2' style='text-align:center;width:100px;'>Tanggal Lahir</th>

                                         <?php
				
				$jumlah_hari=30;
				switch($bulan){
					case 1:
						$jumlah_hari=31;
						break;
					case 2:
						if(($tahun%4)==0)
							$jumlah_hari=29;
						else
							$jumlah_hari=28;
						break;
					case 3:
						$jumlah_hari=31;
						break;
					case 4:
						$jumlah_hari=30;
						break;
					case 5:
						$jumlah_hari=31;
						break;
					case 6:
						$jumlah_hari=30;
						break;
					case 7:
						$jumlah_hari=31;
						break;
					case 8:
						$jumlah_hari=31;
						break;
					case 9:
						$jumlah_hari=30;
						break;
					case 10:
						$jumlah_hari=31;
						break;
					case 11:
						$jumlah_hari=30;
						break;
					case 12:
						$jumlah_hari=31;
						break;
				}
			?>
                                         <?php for($i=1;$i<=$jumlah_hari;$i++){ ?>
                                         <th colspan='3' style='text-align:center;'><?php echo $i;?></th>
                                         <?php } ?>
                                     </tr>
                                     <tr>
                                         <?php for($i=1;$i<=$jumlah_hari;$i++){ ?>
                                         <th style='text-align:center;'>Pagi</th>
                                         <th style='text-align:center;'>Sore</th>
                                         <th style='text-align:center;'>Jumlah</th>
                                         <?php } ?>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
        $i=0;
        $jumlahkolom=4+(3*$jumlah_hari);
		if($rs->num_rows()==0){
            ?>
                                     <tr>
                                         <td colspan='<?php echo $jumlahkolom;?>'>
                                             Belum ada data produksi susu
                                         </td>
                                     </tr>
                                     <?php
        }
		foreach($rs->result() as $row){
			$i++;
	?>
                                     <tr class="<?php echo ($i%2==0?"barisgenap":"");?>">
                                         <td><?php echo $i;?></td>
                                         <td><?php echo $row->tagsapi;?></td>
                                         <td><?php echo $row->nomorregister;?></td>
                                         <td><?php echo substr($row->tgllahir,0,10);?></td>

                                         <?php for($tgl=1;$tgl<=$jumlah_hari;$tgl++){ ?>
                                         <?php
                                        $tanggal=$tahun."-".$bulan."-".$tgl;
                                        $idsapi=$row->idsapi;
                                        $sql="SELECT pagi,sore,(pagi+sore) jumlah from pengukuran_produksisusu WHERE tanggal='$tanggal' AND idsapi='$idsapi'";
                                        $rs_susu=$this->db->query($sql);
                                        if($rs_susu->num_rows()>0){
                                            $row_susu=$rs_susu->row();
                                            $pagi=$row_susu->pagi;
                                            $sore=$row_susu->sore;
                                        }else{
                                            $pagi=0;
                                            $sore=0;
                                        }
                                        $jumlah=$pagi+$sore;
                                        ?>
                                         <td style='text-align:right;'><?php echo $pagi;?></td>
                                         <td style='text-align:right;'><?php echo $sore;?></td>
                                         <td style='text-align:right;'><?php echo ($pagi+$sore);?></td>
                                         <?php } ?>
                                     </tr>
                                     <?php
		}
	?>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- /.content -->
 </div>

 <!-- Modal -->
 <div class="modal fade" id="Modalhapus" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Hapus Data</h5>
             </div>
             <div class="modal-body">
                 <form action="<?=site_url('/produksi/susu_vertikal/hapus'); ?>" method="post">
                     <input type="hidden" name="id" id="id" required>
                     Apakah yakin dihapus?
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-danger">Hapus</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <div class="modal fade" id="Modaltambah" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Tambah Data Produksi Susu</h5>
             </div>
             <div class="modal-body">

                 <form id="frmtambah" action="/produksi/susu_vertikal/save" method="post">
                     <div class="form-group">
                         <label for="tanggal">Tanggal</label>
                         <input type="date" name="tanggal" id="tanggal" class="form-control"
                             value="<?php echo date('Y-m-d');?>">
                         <small id="tanggalerr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="edttagsapi">Tag Sapi</label>
                         <input type="text" name="tagsapi" id="tagsapi" class="form-control">
                         <small id="tagsapierr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="nomorregister">Nomor Register</label>
                         <input type="text" name="nomorregister" id="nomorregister" class="form-control">
                         <input type="hidden" name="idsapi" id="idsapi" class="form-control">
                     </div>
                     <div class="form-group">
                         <label for="pagi">Pagi</label>
                         <input type="number" name="pagi" id="pagi" class="form-control text-right">
                         <small id="pagierr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="sore">Sore</label>
                         <input type="number" name="sore" id="sore" class="form-control text-right">
                         <small id="soreerr" class="text-danger"></small>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade" id="Modaledit" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Edit Data Produksi Susu</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="/produksi/susu_vertikal/update" method="post">
                     <div class="form-group">
                         <label for="tanggal">Tanggal</label>
                         <input type="hidden" name="idpengukuran" id="edtidpengukuran" class="form-control">
                         <input type="date" name="tanggal" id="edttanggal" class="form-control">
                         <small id="tanggalerr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="edttagsapi">Tag Sapi</label>
                         <input type="text" name="tagsapi" id="edttagsapi" class="form-control">
                         <small id="tagsapierr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="nomorregister">Nomor Register</label>
                         <input type="text" name="nomorregister" id="edtnomorregister" class="form-control">
                         <input type="hidden" name="idsapi" id="edtidsapi" class="form-control">
                     </div>
                     <div class="form-group">
                         <label for="pagi">Pagi</label>
                         <input type="number" name="pagi" id="edtpagi" class="form-control text-right">
                         <small id="pagierr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="sore">Sore</label>
                         <input type="number" name="sore" id="edtsore" class="form-control text-right">
                         <small id="soreerr" class="text-danger"></small>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>