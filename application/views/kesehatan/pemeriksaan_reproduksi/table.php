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
                                         <input type="file" name='file' id='fileImportPemeriksaanReproduksi' accept=".xls,.xlsx,.csv" style="display:none;">
                                         <button class="btn bg-navy" id="kotakUpload"><i class="fa fa-upload"></i>
                                             Import</button>
                                         <button class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i>
                                             Informasi</button>
                                         <button type="button" class="btn btn-secondary" id="btnLaporanPemeriksaanReproduksi">Laporan Import Terakhir</button>
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

 <div class="modal fade" id="ModalPanduanPemeriksaanReproduksi" tabindex="-1" role="dialog" aria-labelledby="judulPanduanPemeriksaanReproduksi" aria-hidden="true">
     <div class="modal-dialog modal-xl" role="document"><div class="modal-content">
         <div class="modal-header"><h5 class="modal-title" id="judulPanduanPemeriksaanReproduksi">Panduan Import Pemeriksaan Reproduksi</h5><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button></div>
         <div class="modal-body" style="max-height:65vh;overflow-y:auto;">
             <p>Gunakan sheet pertama file .xls, .xlsx, atau .csv, maksimal 2 MB. Urutan enam kolom berikut wajib dipertahankan. Header dan baris kosong boleh disertakan, tanpa nomor urut maupun No. Register.</p>
             <div class="table-responsive"><table class="table table-bordered table-sm"><thead><tr><th>Tanggal</th><th>No. Tag</th><th>Diagnosa</th><th>Pengobatan</th><th>Petugas</th><th>Keterangan</th></tr></thead><tbody><tr><td>01-Okt-26</td><td>0624</td><td>Pemeriksaan reproduksi</td><td></td><td>Tim reproduksi</td><td>Pemeriksaan lanjutan</td></tr></tbody></table></div>
             <ul>
                 <li>Tanggal dari file, bukan session: tanggal Excel, YYYY-MM-DD, DD/MM/YYYY, atau DD-Mon-YY (01-Okt-26).</li>
                 <li>No. Tag harus terdaftar dan sesuai peternakan/akses pengguna. Format sebagai teks untuk menjaga nol di depan.</li>
                 <li>Diagnosa dan petugas wajib diisi. Pengobatan dan keterangan boleh kosong, dan disimpan sebagai teks lengkap. Nama petugas belum terdaftar tetap tersimpan dengan peringatan.</li>
                 <li>CSV dengan pemisah titik koma harus mengapit teks obat yang mengandung titik koma dengan tanda petik ganda.</li>
                 <li>Data disimpan sebagai kategori Reproduksi, terpisah dari Keswan. Baris identik (sapi, tanggal, diagnosa, pengobatan, petugas, keterangan) dilewati saat import ulang. Data berbeda disimpan terpisah, tanpa menimpa pemeriksaan lama. Baris valid tetap disimpan meskipun baris lain gagal.</li>
             </ul>
         </div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
     </div></div>
 </div>
 <?php $laporanReproduksi = $this->session->userdata('pemeriksaan_reproduksi_last_report'); ?>
 <div class="modal fade" id="ModalLaporanPemeriksaanReproduksi" tabindex="-1" role="dialog" aria-labelledby="judulLaporanPemeriksaanReproduksi" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document"><div class="modal-content">
         <div class="modal-header"><h5 class="modal-title" id="judulLaporanPemeriksaanReproduksi">Laporan Import Pemeriksaan Reproduksi Terakhir</h5><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button></div>
         <div id="hasilImportPemeriksaanReproduksi" class="modal-body" style="max-height:65vh;overflow-y:auto;" aria-live="polite">
             <?php if (is_array($laporanReproduksi)) { ?>
             <p>Import selesai: <?=(int) $laporanReproduksi['success']; ?> baris tersimpan, <?=(int) $laporanReproduksi['skipped']; ?> baris identik dilewati, <?=count($laporanReproduksi['errors']); ?> pesan kesalahan.</p>
             <?php foreach ($laporanReproduksi['errors'] as $pesan) { ?><div class="text-danger"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php foreach ($laporanReproduksi['warnings'] as $pesan) { ?><div class="text-warning"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php } else { ?><p>Belum ada laporan import pemeriksaan reproduksi dalam sesi ini.</p><?php } ?>
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
                 <form action="<?=site_url('/kesehatan/pemeriksaan_reproduksi/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Pemeriksaan reproduksi</h5>
             </div>
             <div class="modal-body">

                 <form id="frmtambah" action="/kesehatan/pemeriksaan_reproduksi/save" method="post">
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
                                 <input type="hidden" name="kategori" id="kategori" value="reproduksi">
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
                 <h5 class="modal-title" id="judulmodal">Edit Data Pemeriksaan reproduksi</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="/kesehatan/pemeriksaan_reproduksi/update" method="post">
                     <div class="form-group">
                         <input type="hidden" name="kategori" id="kategori" value="reproduksi">
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
