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
                             <div class="row" style="margin-bottom:5px;">
                                 <div class="col-md-6">
                                     <div class="btn-group">
                                         <a href="javascript:" id="tambahdata" class="btn btn-primary"><i
                                                 class="fa fa-plus"></i> Tambah</a>
                                         <?php if(($chktanggal=="true")&&($tanggal<>"")){ ?>
                                         <input type="file" name='filePerTanggal' id='filePerTanggal'
                                             accept=".xlsx,.xls,.csv" style="display:none;">
                                         <button class="btn bg-green" id="kotakUploadPerTanggal"><i
                                                 class="fa fa-upload"></i> Import Per Tanggal</button>
                                         <?php } ?>
                                         <input type="file" name='filePerBulan' id='filePerBulan' accept=".xlsx,.xls,.csv" style="display:none;">
                                         <button class="btn bg-navy" id="kotakUploadPerBulan"><i
                                                 class="fa fa-upload"></i> Import Per Bulan</button>
                                         <button class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i>
                                             Informasi</button>
                                         <button type="button" class="btn btn-secondary" id="btnLaporanImportSusu"><i class="fa fa-list"></i>
                                             Laporan Import Terakhir</button>
                                     </div>
                                 </div>
                             </div>
                             <div class="row" style="margin-bottom:5px;">
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
                             </div>
                             <div class="row">
                                 <div class="col-md-2">
                                     <SELECT id='xlaktasi' name='xlaktasi' class='form-control'>
                                         <OPTION value='0' <?php echo ($xlaktasi==0?"SELECTED":"");?>>Semua Laktasi
                                         </OPTION>
                                         <OPTION value='-1' <?php echo ($xlaktasi==-1?"SELECTED":"");?>>Laktasi Terakhir
                                         </OPTION>
                                         <?php
                                            for($i=1;$i<=12;$i++){
                                                ?>
                                         <OPTION value='<?php echo $i;?>' <?php echo ($xlaktasi==$i?"SELECTED":"");?>>
                                             <?php echo $i;?></OPTION>
                                         <?php
                                            }
                                        ?>
                                     </SELECT>
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
                                 <div class="col-md-3">
                                     <input type='checkbox' id='chktanggal' name='chktanggal'
                                         <?php echo ($chktanggal=="true"?"CHECKED":"");?>>
                                     <?php
                                        if($chktanggal=="true"){
                                    ?>
                                     <input type="date" name="tanggal" id="tanggal" onchange="pilihtanggal()"
                                         autocomplete="off" value="<?php echo $tanggal;?>" class="form-control">
                                     <?php } ?>
                                 </div>

                             </div>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th style='text-align:center;'>Tanggal</th>
                                         <th style='text-align:center;'>No. Tag</th>
                                         <th style='text-align:center;'>No. Register</th>
                                         <th style='text-align:center;'>Kandang</th>
                                         <th style='text-align:center;'>Pagi (Kg)</th>
                                         <th style='text-align:center;'>Sore (Kg)</th>
                                         <th style='text-align:center;'>Jumlah (Kg)</th>
                                         <th style='text-align:center;'>Laktasi Ke</th>
                                         <th style='text-align:center;'>Tgl.Beranak</th>
                                         <th style='width:100px;'>&nbsp;</th>
                                     </tr>
                                 </thead>
                                 <tbody id="show_data">

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
                         <input type="date" name="tanggal" id="idtanggal" class="form-control"
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
                         <label for="kandang">Kandang</label>
                         <input type="text" name="kandang" id="kandang" class="form-control" maxlength="10">
                     </div>
                     <div class="form-group">
                         <label for="pagi">Pagi</label>
                         <input type="number" name="pagi" class='form-control' onchange="setTwoNumberDecimal" min="0" max="50" step="0.1" value="0.0" />
                         <!-- <input type="number" name="pagi" id="pagi" class="form-control text-right"> -->
                         <small id="pagierr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="sore">Sore</label>
                         <input type="number" name="sore" class='form-control' onchange="setTwoNumberDecimal" min="0" max="50" step="0.1" value="0.0" />
                         <!-- <input type="decimal" name="sore" id="sore" class="form-control text-right"> -->
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
                         <label for="edtkandang">Kandang</label>
                         <input type="text" name="kandang" id="edtkandang" class="form-control" maxlength="10">
                     </div>
                     <div class="form-group">
                         <label for="pagi">Pagi</label>
                         <input type="number" name="pagi" id="edtpagi" class='form-control' onchange="setTwoNumberDecimal" min="0" max="50" step="0.1" value="0.0" />
                         <!-- <input type="number" name="pagi" id="edtpagi" class="form-control text-right"> -->
                         <small id="pagierr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="sore">Sore</label>
                         <input type="number" name="sore" id="edtsore" class='form-control' onchange="setTwoNumberDecimal" min="0" max="50" step="0.1" value="0.0" />
                         <!-- <input type="number" name="sore" id="edtsore" class="form-control text-right"> -->
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
 <div class="modal fade" id="Modalinfo" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Informasi</h5>
             </div>
             <div class="modal-body" id="kotakInfo">
                 <p>Gunakan file .xlsx, .xls, atau .csv, maksimal 2 MB. Untuk Excel, gunakan sheet pertama. Baris pertama adalah judul kolom;
                     data dimulai dari baris kedua pada sheet pertama.</p>
                 <p><strong>Import per bulan:</strong><br>
                     tagsapi, tanggal, pagi, sore, kandang</p>
                 <p><strong>Import per tanggal:</strong><br>
                     tagsapi, pagi, sore, kandang<br>
                     Tanggal mengikuti tanggal yang dipilih pada halaman (session).</p>
                 <p>Tanggal pada file dapat berupa tanggal Excel atau teks YYYY-MM-DD,
                     DD/MM/YYYY, atau DD-MM-YYYY. Tag sapi harus sudah terdaftar.
                     Pagi dan sore diisi angka nonnegatif. Kandang maksimal 10 karakter.</p>
                 <p>Laktasi otomatis mengikuti kelahiran terakhir pada atau sebelum tanggal produksi,
                     dengan nilai 1 jika belum ada riwayat kelahiran.
                     Data sapi dan tanggal yang sudah ada akan diperbarui saat import ulang.</p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

             </div>
         </div>
     </div>
 </div>
 <?php
     $laporanImportSusu = $this->session->userdata('susu_last_import_report');
     $tampilkanLaporanSusu = (bool) $this->session->flashdata('susu_show_import_report');
 ?>
 <div class="modal fade" id="ModalLaporanImportSusu" data-auto-show="<?=$tampilkanLaporanSusu ? '1' : '0'; ?>" tabindex="-1" role="dialog" aria-labelledby="judulLaporanImportSusu" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulLaporanImportSusu">Laporan Import Produksi Susu Terakhir</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body" style="max-height:65vh;overflow-y:auto;">
                 <?php if ($laporanImportSusu) { echo $laporanImportSusu; } else { ?>
                 <p>Belum ada laporan import produksi susu dalam sesi ini.</p>
                 <?php } ?>
             </div>
             <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
         </div>
     </div>
 </div>
