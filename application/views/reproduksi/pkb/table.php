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
                                         <input type="file" name='file' id='fileImportPkb' accept=".xlsx,.xls,.csv" style="display:none;">
                                         <button type="button" class="btn bg-navy" id="kotakUpload"><i class="fa fa-upload"></i>
                                             Import</button>
                                         <button type="button" class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i>
                                             Informasi</button>
                                         <button type="button" class="btn btn-secondary" id="btnLaporanImportPkb">Laporan Import Terakhir</button>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
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
                             </div>
                             <div class="row" style='padding-top:10px;'>
                                 <div class="col-md-1">&nbsp;</div>
                                 <div class="col-md-2">
                                     <input type="date" name="tanggal" id="tanggal" autocomplete="off"
                                         class="form-control">
                                 </div>
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
                             </div>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Tanggal PKB</th>
                                         <th>No. Tag</th>
                                         <th>No. Register</th>
                                         <th>Hasil</th>
                                         <th>Petugas</th>
                                         <th>HPL</th>
                                         <th>Keterangan</th>
                                         <th style='width:100px;'>&nbsp;</th>
                                     </tr>
                                 </thead>

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
 <div class="modal fade" id="ModalinfoPkb" tabindex="-1" role="dialog" aria-labelledby="judulInfoPkb" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulInfoPkb">Informasi Import Pemeriksaan Kebuntingan</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <p>Gunakan .xlsx, .xls, atau .csv, maksimal 2 MB. Sheet pertama dibaca.
                     Header bertingkat dan baris kosong sebelum data boleh digunakan.</p>
                 <p>Urutan kolom A–L sesuai contoh:</p>
                 <ol>
                     <li>No. (angka)</li><li>EAR TAG</li><li>Tanggal PKB</li><li>Tanggal IB terakhir</li>
                     <li>IB Ke</li><li>Nama Straw</li><li>Kode Straw</li><li>Petugas IB</li>
                     <li>Hasil PKB</li><li>Petugas PKB</li><li>HPL (boleh kosong)</li><li>Keterangan (boleh kosong)</li>
                 </ol>
                 <p>Contoh: 14 | 2696 IM | 24-Sep-26 | 07-Okt-25 | 1 | VF Boltz X |
                     322126 | Wahyono | pkb (-) | Wahyono | | PKB ULANG</p>
                 <p>Tanggal dapat berupa tanggal Excel, YYYY-MM-DD, DD-MMM-YY, DD-MMM-YYYY,
                     DD/MM/YYYY, atau DD-MM-YYYY. Nama bulan Indonesia seperti Agu, Okt, dan Mei didukung.
                     Simpan EAR TAG dan kode straw sebagai teks untuk menjaga nol di awal.</p>
                 <p>Hasil: positif / P / pkb (+), negatif / N / pkb (-), atau Dubius.
                     HPL hanya diisi untuk hasil positif dan harus setelah tanggal PKB;
                     HPL kosong tetap disimpan kosong. Petugas PKB dan keterangan maksimal 30 karakter.</p>
                 <p>Sapi dan IB pada tanggal di kolom D harus sudah tercatat. IB Ke dan kode straw
                     dicocokkan dengan data IB; import IB terlebih dahulu jika belum ada.
                     Nama straw mengikuti master semen. Nama petugas PKB yang belum terdaftar tetap
                     disimpan dengan peringatan. Import ulang memperbarui sapi/tanggal PKB yang sama.</p>
             </div>
             <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
         </div>
     </div>
 </div>
 <?php $laporanPkb = $this->session->userdata('pkb_last_import_report'); ?>
 <div class="modal fade" id="ModalLaporanImportPkb" tabindex="-1" role="dialog" aria-labelledby="judulLaporanPkb" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document"><div class="modal-content">
         <div class="modal-header"><h5 id="judulLaporanPkb" class="modal-title">Laporan Import PKB Terakhir</h5><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button></div>
         <div id="hasilImportPkb" class="modal-body" style="max-height:65vh;overflow-y:auto;" aria-live="polite">
             <?php if (is_array($laporanPkb)) { ?>
             <p>Import selesai: <?=(int) $laporanPkb['success']; ?> baris berhasil, <?=count($laporanPkb['errors']); ?> pesan kesalahan.</p>
             <?php foreach ($laporanPkb['errors'] as $pesan) { ?><div class="text-danger"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php foreach ($laporanPkb['warnings'] as $pesan) { ?><div class="text-warning"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php } else { ?><p>Belum ada laporan import PKB dalam sesi ini.</p><?php } ?>
         </div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
     </div></div>
 </div>
 <div class="modal fade" id="Modalhapus" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Hapus Data</h5>
             </div>
             <div class="modal-body">
                 <form action="<?=site_url('/reproduksi/pkb/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data reproduksi Susu</h5>
             </div>
             <div class="modal-body">

                 <form id="frmtambah" action="/reproduksi/pkb/save" method="post">
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
                     <div class="row">
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="hasil">Hasil</label>
                                 <div class="custom-control custom-radio">
                                     <input class="custom-control-input" type="radio" id="hasil_p" value='P'
                                         name="hasil" checked>
                                     <label for="hasil_p" class="custom-control-label">Positif</label>
                                 </div>
                                 <div class="custom-control custom-radio">
                                     <input class="custom-control-input" type="radio" id="hasil_n" value='N'
                                         name="hasil">
                                     <label for="hasil_n" class="custom-control-label">Negatif</label>
                                 </div>
                                 <div class="custom-control custom-radio">
                                     <input class="custom-control-input" type="radio" id="hasil_d" value='Dubius'
                                         name="hasil">
                                     <label for="hasil_d" class="custom-control-label">Dubius</label>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="nomorregister">Petugas</label>
                                 <input type="text" name="petugas" id="petugas" class="form-control">
                                 <input type="hidden" name="idpetugas" id="idpetugas" class="form-control">
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="keterangan">Keterangan</label>
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
                 <h5 class="modal-title" id="judulmodal">Edit Data reproduksi Susu</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="/reproduksi/pkb/update" method="post">
                     <div class="row">
                         <div class="col-md-12 col-sm-12">
                             <div class="form-group col-md-6 col-sm-12">
                                 <label for="edttanggal">Tanggal</label>
                                 <input type="date" name="tanggal" id="edttanggal" class="form-control"
                                     value="<?php echo date('Y-m-d');?>">
                                 <small id="edttanggalerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="edttagsapi">Tag Sapi</label>
                                 <input type="text" name="tagsapi" id="edttagsapi" class="form-control">
                                 <small id="edttagsapierr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="edtnomorregister">Nomor Register</label>
                                 <input type="text" name="nomorregister" id="edtnomorregister" class="form-control">
                                 <input type="hidden" name="idsapi" id="edtidsapi" class="form-control">
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="hasil">Hasil</label>
                                 <div class="custom-control custom-radio">
                                     <input class="custom-control-input" type="radio" id="edthasil_p" name="hasil"
                                         value='P'>
                                     <label for="edthasil_p" class="custom-control-label">Positif</label>
                                 </div>
                                 <div class="custom-control custom-radio">
                                     <input class="custom-control-input" type="radio" id="edthasil_n" name="hasil"
                                         value='N'>
                                     <label for="edthasil_n" class="custom-control-label">Negatif</label>
                                 </div>
                                 <div class="custom-control custom-radio">
                                     <input class="custom-control-input" type="radio" id="edthasil_d" name="hasil"
                                         value='Dubius'>
                                     <label for="edthasil_d" class="custom-control-label">Dubius</label>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="edtpetugas">Petugas</label>
                                 <input type="text" name="petugas" id="edtpetugas" class="form-control">
                                 <input type="hidden" name="idpetugas" id="edtidpetugas" class="form-control">
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="edtketerangan">Keterangan</label>
                         <input type="text" name="keterangan" id="edtketerangan" class="form-control">
                         <small id="edtketeranganerr" class="text-danger"></small>
                     </div>
                     <div class="modal-footer">
                         <input type="hidden" name="id" id="edtid">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
