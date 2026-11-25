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
                                         <input type="file" name='file' id='fileImportKualitasSusu' accept=".xls,.xlsx,.csv" style="display:none;">
                                         <button class="btn bg-navy" id="kotakUpload"><i class="fa fa-upload"></i>
                                             Import</button>
                                         <button class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i>
                                             Informasi</button>
                                         <button type="button" class="btn btn-secondary" id="btnLaporanKualitasSusu">Laporan Import Terakhir</button>
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
                                            $sql="SELECT year(tanggal) tahun FROM pengukuran_kualitassusu GROUP BY tahun ORDER BY tahun DESC";
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
                         </div>

                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Tanggal</th>
                                         <th>No. Tag</th>
                                         <th>No. Register</th>
                                         <th>Kadar Lemak</th>
                                         <th>Kadar Air</th>
                                         <th>Kadar BK</th>
                                         <th>Protein</th>
                                         <th>BKTL</th>
                                         <th>Berat Jenis</th>
                                         <th>Laktosa</th>
                                         <th style='width:80px;'>&nbsp;</th>
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

 <div class="modal fade" id="ModalPanduanKualitasSusu" tabindex="-1" role="dialog" aria-labelledby="judulPanduanKualitasSusu" aria-hidden="true">
     <div class="modal-dialog modal-xl" role="document"><div class="modal-content">
         <div class="modal-header"><h5 id="judulPanduanKualitasSusu" class="modal-title">Panduan Import Kualitas Susu</h5><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button></div>
         <div class="modal-body" style="max-height:65vh;overflow-y:auto;">
             <p>Gunakan sheet pertama file .xls, .xlsx, atau .csv, maksimal 2 MB. Sembilan kolom harus berurutan, tanpa nomor urut maupun No. Register. Baris judul dan baris kosong boleh disertakan.</p>
             <div class="table-responsive"><table class="table table-bordered table-sm">
                 <thead><tr><th>Tanggal</th><th>No. Tag</th><th>Kadar Lemak</th><th>Kadar Air</th><th>Kadar BK</th><th>Protein</th><th>BKTL</th><th>Berat Jenis</th><th>Laktosa</th></tr></thead>
                 <tbody><tr><td>2026-10-01</td><td>0624</td><td>3.50</td><td>87.00</td><td>13.00</td><td>3.20</td><td>9.50</td><td>1.03</td><td>4.80</td></tr></tbody>
             </table></div>
             <ul>
                 <li>Tanggal berasal dari file, bukan session. Gunakan tanggal Excel, YYYY-MM-DD, DD/MM/YYYY, atau DD-Mon-YY (01-Okt-26).</li>
                 <li>No. Tag harus terdaftar dan sesuai akses/peternakan yang dipilih. Format tag sebagai teks untuk mempertahankan nol di depan.</li>
                 <li>Nilai kualitas harus angka nonnegatif tanpa pemisah ribuan, memakai titik atau koma desimal. Nilai disimpan dengan pembulatan dua desimal sesuai struktur database saat ini, termasuk Berat Jenis. Kolom kosong disimpan NULL; minimal satu nilai kualitas wajib diisi.</li>
                 <li>Import ulang sapi dan tanggal yang sama memperbarui seluruh nilai kualitas pada baris tersebut, termasuk mengosongkan nilai jika sel kosong. Data ganda pada tanggal yang sama ditolak. Baris valid tetap disimpan walaupun baris lain gagal.</li>
             </ul>
         </div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
     </div></div>
 </div>
 <?php $laporanKualitas = $this->session->userdata('kualitas_susu_last_import_report'); ?>
 <div class="modal fade" id="ModalLaporanKualitasSusu" tabindex="-1" role="dialog" aria-labelledby="judulLaporanKualitasSusu" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document"><div class="modal-content">
         <div class="modal-header"><h5 id="judulLaporanKualitasSusu" class="modal-title">Laporan Import Kualitas Susu Terakhir</h5><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button></div>
         <div id="hasilImportKualitasSusu" class="modal-body" style="max-height:65vh;overflow-y:auto;" aria-live="polite">
             <?php if (is_array($laporanKualitas)) { ?>
             <p>Import selesai: <?=(int) $laporanKualitas['success']; ?> baris berhasil, <?=count($laporanKualitas['errors']); ?> pesan kesalahan.</p>
             <?php foreach ($laporanKualitas['errors'] as $pesan) { ?><div class="text-danger"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php foreach ($laporanKualitas['warnings'] as $pesan) { ?><div class="text-warning"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php } else { ?><p>Belum ada laporan import kualitas susu dalam sesi ini.</p><?php } ?>
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
                 <form action="<?=site_url('/produksi/kualitas_susu/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Kualitas Susu</h5>
             </div>
             <div class="modal-body">

                 <form id="frmtambah" action="/produksi/kualitas_susu/save" method="post">

                     <div class="row">
                         <div class="col-md-12 col-sm-12">
                             <div class="form-group col-md-6">
                                 <label for="tanggal">Tanggal</label>

                                 <input type="date" name="tanggal" id="tanggal" class="form-control"
                                     value="<?php echo date('Y-m-d');?>">
                                 <small id="tanggalerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="edttagsapi">Tag Sapi</label>
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
                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="kadarlemak">Kadar Lemak</label>
                                 <input type="text" name="kadarlemak" id="kadarlemak" class="form-control text-right">
                                 <small id="kadarlemakerr" class="text-danger"></small>
                             </div>

                         </div>
                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="kadarair">Kadar Air</label>
                                 <input type="text" name="kadarair" id="kadarair" class="form-control text-right">
                                 <small id="kadarairerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="kadarbk">Kadar BK</label>
                                 <input type="text" name="kadarbk" id="kadarbk" class="form-control text-right">
                                 <small id="kadarbkerr" class="text-danger"></small>
                             </div>
                         </div>

                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="protein">Protein</label>
                                 <input type="text" name="protein" id="protein" class="form-control text-right">
                                 <small id="proteinerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="bktl">BKTL</label>
                                 <input type="text" name="bahankeringtanpalemak" id="bktl"
                                     class="form-control text-right">
                                 <small id="bktlerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="beratjenis">Berat Jenis</label>
                                 <input type="text" name="beratjenis" id="beratjenis" class="form-control text-right">
                                 <small id="beratjeniserr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-12 col-sm-12">
                             <div class="form-group col-md-4">
                                 <label for="laktosa">Laktosa</label>
                                 <input type="text" name="laktosa" id="laktosa" class="form-control text-right">
                                 <small id="laktosaerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="modal-footer">
                             <input type="hidden" name="idpengukuran" id="idpengukuran">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                             <button type="submit" class="btn btn-primary">Simpan</button>
                         </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
