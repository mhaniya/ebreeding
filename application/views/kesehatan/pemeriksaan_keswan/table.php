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
                                         <input type="file" name='file' id='fileImportKeswan' accept=".xlsx,.xls,.csv" style="display:none;">
                                         <button type="button" class="btn bg-navy" id="kotakUpload"><i class="fa fa-upload"></i>
                                             Import</button>
                                         <button type="button" class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i>
                                             Informasi</button>
                                         <button type="button" class="btn btn-secondary" id="btnLaporanImportKeswan">Laporan Import Terakhir</button>
                                     </div>
                                 </div>
                             </div>
                             <div class="row" style="margin-top:5px;">
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
                                            $sql="SELECT year(tanggal) tahun FROM pemeriksaankesehatan WHERE kategori='Keswan' GROUP BY tahun ORDER BY tahun DESC";
                                            $rstahun=$this->db->query($sql);
                                        ?>
                                     <?php echo $this->simpliparse->build_select_common_edit('tahun',$rstahun,'tahun','tahun',':: Tahun ::',$tahun,"class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-1">
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
                                 <div class="col-md-2">
                                     <input type="date" name="tanggal" id="tanggal" autocomplete="off"
                                         class="form-control">
                                 </div>
                             </div>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Tanggal</th>
                                         <th>No. Tag</th>
                                         <th>No. Register</th>
                                         <th>Diagnosa</th>
                                         <th>Pengobatan</th>
                                         <th>Petugas</th>
                                         <th>Keterangan</th>
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

 <div class="modal fade" id="ModalinfoKeswan" tabindex="-1" role="dialog" aria-labelledby="judulInfoKeswan" aria-hidden="true">
     <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulInfoKeswan">Format Import Pemeriksaan Keswan</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <p>Gunakan sheet pertama file .xlsx, .xls, atau .csv, maksimal 2 MB. Urutan kolom harus tepat seperti berikut, tanpa kolom nomor urut. Baris judul dan baris kosong boleh disertakan.</p>
                 <div class="table-responsive">
                     <table class="table table-bordered table-sm">
                         <thead><tr><th>TANGGAL</th><th>EARTAG</th><th>DIAGNOSA</th><th>PENGGUNAAN OBAT</th><th>PETUGAS</th></tr></thead>
                         <tbody>
                             <tr><td>01-Sep-26</td><td>2823</td><td>Luka lanj</td><td>Metoxy</td><td>Tim keswan</td></tr>
                             <tr><td>01-Sep-26</td><td>6553</td><td>Suportif post partus</td><td>Sulprodon 15 ml; life vut 15 ml</td><td>Tim keswan</td></tr>
                             <tr><td>01-Sep-26</td><td>0624</td><td>Suportif</td><td>Life vit 2 ml</td><td>Tim keswan</td></tr>
                         </tbody>
                     </table>
                 </div>
                 <ul>
                     <li>Tanggal berasal dari file, bukan session/filter. Format tanggal Excel, DD-Mon-YY (01-Sep-26), YYYY-MM-DD, atau DD/MM/YYYY diterima.</li>
                     <li>Eartag harus terdaftar dan sesuai peternakan yang dipilih serta akses pengguna. Format kolom sebagai teks agar 0624 tidak berubah menjadi 624. Eartag nama seperti Guava dan Chemist juga diterima; tag tidak diubah atau ditambah nol otomatis.</li>
                     <li>Diagnosa dan petugas wajib diisi. Penggunaan obat disimpan utuh sebagai teks, termasuk beberapa obat, titik koma, dan dosis berkoma; kolom obat boleh kosong.</li>
                     <li>Untuk CSV, gunakan pemisah koma atau tab. Jika pemisahnya titik koma, bungkus teks obat yang mengandung titik koma dengan tanda petik ganda.</li>
                     <li>Petugas dicocokkan dengan master petugas. Jika belum terdaftar, namanya tetap disimpan dan ditampilkan dengan peringatan; master petugas tidak dibuat otomatis.</li>
                     <li>Baris identik (sapi, tanggal, diagnosa, obat, petugas) dilewati saat import ulang. Diagnosa atau obat berbeda pada sapi dan tanggal yang sama disimpan sebagai pemeriksaan tersendiri. Import tidak menimpa pemeriksaan lama; baris valid tetap disimpan walaupun baris lain bermasalah.</li>
                 </ul>
             </div>
             <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
         </div>
     </div>
 </div>

 <?php $laporanKeswan = $this->session->userdata('keswan_last_import_report'); ?>
 <div class="modal fade" id="ModalLaporanImportKeswan" tabindex="-1" role="dialog" aria-labelledby="judulLaporanKeswan" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document"><div class="modal-content">
         <div class="modal-header"><h5 id="judulLaporanKeswan" class="modal-title">Laporan Import Keswan Terakhir</h5><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button></div>
         <div id="hasilImportKeswan" class="modal-body" style="max-height:65vh;overflow-y:auto;" aria-live="polite">
             <?php if (is_array($laporanKeswan)) { ?>
             <p>Import selesai: <?=(int) $laporanKeswan['success']; ?> baris tersimpan, <?=(int) $laporanKeswan['skipped']; ?> baris identik dilewati, <?=count($laporanKeswan['errors']); ?> pesan kesalahan.</p>
             <?php foreach ($laporanKeswan['errors'] as $pesan) { ?><div class="text-danger"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php foreach ($laporanKeswan['warnings'] as $pesan) { ?><div class="text-warning"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php } else { ?><p>Belum ada laporan import Keswan dalam sesi ini.</p><?php } ?>
         </div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
     </div></div>
 </div>

 <!-- Modal -->
 <div class="modal fade" id="Modalhapus" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Hapus Data</h5>
             </div>
             <div class="modal-body">
                 <form action="<?=site_url('/kesehatan/pemeriksaan_keswan/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Pemeriksaan Keswan</h5>
             </div>
             <div class="modal-body">

                 <form id="frmtambah" action="/kesehatan/pemeriksaan_keswan/save" method="post">
                     <div class="row">
                         <div class="col-md-12 col-sm-12">
                             <div class="form-group col-md-6 col-sm-12">
                                 <label for="tanggal">Tanggal</label>
                                 <input type="date" name="tanggal" id="tanggal" class="form-control"
                                     value="<?php echo date('Y-m-d');?>">
                                 <small id="tanggalerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="tagsapi">Tag Sapi</label>
                                 <input type="text" name="tagsapi" id="tagsapi" class="form-control">
                                 <input type="hidden" name="kategori" id="kategori" value="Keswan">
                                 <small id="tagsapierr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="nomorregister">Nomor Register</label>
                                 <input type="text" name="nomorregister" id="nomorregister" class="form-control">
                                 <input type="hidden" name="idsapi" id="idsapi" class="form-control">
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="diagnosa">Diagnosa</label>
                         <input type="text" name="diagnosa" id="diagnosa" class="form-control">
                         <small id="diagnosaerr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="pengobatan">Pengobatan</label>
                         <input type="text" name="pengobatan" id="pengobatan" class="form-control">
                         <small id="pengobatanerr" class="text-danger"></small>
                     </div>
                     <div class="form-group col-md-12 col-sm-12">
                         <label for="petugas">Petugas</label>
                         <input type="text" name="petugas" id="namapetugas" class="form-control">
                         <input type="hidden" name="idpetugas" id="idpetugas">
                         <small id="petugaserr" class="text-danger"></small>
                     </div>
                     <div class="form-group col-md-12 col-sm-12">
                         <label for="keterangan">keterangan</label>
                         <input type="text" name="keterangan" id="keterangan" class="form-control">
                         <small id="keteranganerr" class="text-danger"></small>
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
                 <h5 class="modal-title" id="judulmodal">Edit Data Pemeriksaan Keswan</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="/kesehatan/pemeriksaan_keswan/update" method="post">
                     <div class="form-group">
                         <input type="hidden" name="kategori" id="kategori" value="Keswan">
                         <label for="tanggal">Tanggal</label>
                         <input type="hidden" name="idpemeriksaan" id="edtidpemeriksaan" class="form-control">
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
                         <label for="edtdiagnosa">Diagnosa</label>
                         <input type="text" name="diagnosa" id="edtdiagnosa" class="form-control">
                         <small id="edtdiagnosaerr" class="text-danger"></small>
                     </div>

                     <div class="form-group">
                         <label for="pengobatan">Pengobatan</label>
                         <input type="text" name="pengobatan" id="edtpengobatan" class="form-control">
                         <small id="pengobatanerr" class="text-danger"></small>
                     </div>
                     <div class="form-group col-md-12 col-sm-12">
                         <label for="petugas">Petugas</label>
                         <input type="text" name="petugas" id="edtnamapetugas" class="form-control">
                         <input type="hidden" name="idpetugas" id="edtidpetugas">
                         <small id="petugaserr" class="text-danger"></small>
                     </div>
                     <div class="form-group col-md-12 col-sm-12">
                         <label for="keterangan">keterangan</label>
                         <input type="text" name="keterangan" id="edtketerangan" class="form-control">
                         <small id="keteranganerr" class="text-danger"></small>
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
