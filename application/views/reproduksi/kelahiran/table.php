 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1 class="m-0 text-dark"><?php echo $judul; ?></h1>
                 </div><!-- /.col -->
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#"><?php echo ucwords($menu); ?></a></li>
                         <li class="breadcrumb-item active"><?php echo ucwords($submenu); ?></li>
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
                                         <a href="javascript:" id="tambahdata" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                                         <input type="file" name='file' id='fileImportKelahiran' accept=".xlsx,.xls,.csv" style="display:none;">
                                         <button type="button" class="btn bg-navy" id="kotakUpload"><i class="fa fa-upload"></i>
                                             Import</button>
                                         <button type="button" class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i>
                                             Informasi</button>
                                         <button type="button" class="btn btn-secondary" id="btnLaporanImportKelahiran">Laporan Import Terakhir</button>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-2">
                                     <?php //echo $this->session->userdata('kodepropinsi');
                                        ?>
                                     <?php echo $this->simpliparse->build_select_common_edit('kodepropinsi', $propinsi, 'kodepropinsi', 'namapropinsi', ':: Pilih Propinsi ::', $kodepropinsi, "class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <?php echo $this->simpliparse->build_select_common_edit('kodekabupaten', $kabupaten, 'kodekabupaten', 'namakabupaten', ':: Pilih Kabupaten ::', $kodekabupaten, "class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <?php echo $this->simpliparse->build_select_common_edit('kodekecamatan', $kecamatan, 'kodekecamatan', 'namakecamatan', ':: Pilih Kecamatan ::', $kodekecamatan, "class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <?php echo $this->simpliparse->build_select_common_edit('idfarm', $farm, 'idfarm', 'namafarm', ':: Pilih Peternakan ::', $idfarm, "class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <?php
                                        $sql = "SELECT year(tanggal) tahun FROM pengukuran_produksisusu GROUP BY tahun ORDER BY tahun DESC";
                                        $rstahun = $this->db->query($sql);
                                        ?>
                                     <?php echo $this->simpliparse->build_select_common_edit('tahun', $rstahun, 'tahun', 'tahun', ':: Tahun ::', $tahun, "class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <SELECT id='bulan' name='bulan' class='form-control'>
                                         <OPTION value='0'>:: Bulan ::</OPTION>
                                         <?php
                                            for ($i = 1; $i <= 12; $i++) {
                                            ?>
                                             <OPTION value='<?php echo $i; ?>' <?php echo ($bulan == $i ? "SELECTED" : ""); ?>>
                                                 <?php echo $this->fungsi->bulan2($i); ?></OPTION>
                                         <?php
                                            }
                                            ?>
                                     </SELECT>
                                 </div>
                             </div>
                             <div class="row" style='padding-top:10px;'>
                                 <div class="col-md-2">
                                     <input type="date" name="tanggal" id="tanggal" autocomplete="off" class="form-control">
                                 </div>
                                 <div class="col-md-2">
                                     <SELECT id='xlaktasi' name='xlaktasi' class='form-control'>
                                         <OPTION value='0' <?php echo ($xlaktasi == 0 ? "SELECTED" : ""); ?>>Semua Laktasi
                                         </OPTION>
                                         <OPTION value='-1' <?php echo ($xlaktasi == -1 ? "SELECTED" : ""); ?>>Laktasi Terakhir
                                         </OPTION>
                                         <?php
                                            for ($i = 1; $i <= 12; $i++) {
                                            ?>
                                             <OPTION value='<?php echo $i; ?>' <?php echo ($xlaktasi == $i ? "SELECTED" : ""); ?>>
                                                 <?php echo $i; ?></OPTION>
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
                                         <th>Tag Sapi Induk</th>
                                         <th>No. Register Induk</th>
                                         <th>Tgl.IB</th>
                                         <th>Laktasi Ke</th>
                                         <th>Status</th>
                                         <th>Tag Sapi Anak</th>
                                         <th>No. Register Anak</th>
                                         <th>J.Kel. Anak</th>
                                         <th>Keterangan</th>
                                         <th style='width:70px;'>&nbsp;</th>
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
 <div class="modal fade" id="ModalinfoKelahiran" tabindex="-1" role="dialog" aria-labelledby="judulInfoKelahiran" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulInfoKelahiran">Informasi Import Kelahiran</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <p>Gunakan .xlsx, .xls, atau .csv, maksimal 2 MB. Sheet pertama dibaca.
                     Header bertingkat dan baris kosong sebelum data boleh digunakan.</p>
                 <p>Urutan kolom A–P:</p>
                 <ol>
                     <li>No.</li><li>EAR TAG Induk</li><li>Tanggal Beranak</li><li>Ke (laktasi)</li>
                     <li>Tanggal IB Terakhir</li><li>IB Ke</li><li>Nama Bull</li><li>Kode Straw</li>
                     <li>Nomor Pedet</li><li>Bobot Lahir (kg)</li><li>Jam Lahir</li><li>Jenis Kelamin</li>
                     <li>Panjang Badan (cm)</li><li>Lingkar Dada (cm)</li><li>Tinggi Badan (cm)</li>
                     <li>Lingkar Skrotum (cm)</li>
                 </ol>
                 <p>Contoh: 1 | 2594 | 07-Sep-26 | 4 | 26-Nov-25 | 3 |
                     Delicious Doc Holliday-ET TC TR | 551HO04311 | 3260651 | 37 | 08.41 | Betina | 65 | 71 | 73 |</p>
                 <p>Tanggal Excel atau teks seperti 07-Sep-26, 24/Dec/2025, 2/Apr/2026,
                     DD/MM/YYYY, dan YYYY-MM-DD didukung. Jam bisa 08.41, 13,56, 08:41, atau sel waktu Excel.
                     Bobot/jam/ukuran boleh kosong. Jenis kelamin: Jantan atau Betina.</p>
                 <p>Induk harus sudah terdaftar. Pedet bernomor ditambahkan ke tabel sapi dengan farm induk,
                     tanggal lahir, jenis kelamin, bobot, induk dan pejantan; nomor register dibuat otomatis.
                     Ukuran disimpan sebagai pengukuran pada tanggal lahir.</p>
                 <p>Nomor pedet berisi “Lahir Mati” disimpan sebagai kelahiran mati tanpa membuat tag sapi.
                     Nomor pedet kosong juga menyimpan kelahiran tanpa sapi pedet dan dilaporkan sebagai peringatan.
                     Lengkapi nomor pedet lalu import ulang untuk menghubungkannya.</p>
                 <p>IB yang ditemukan dicocokkan dengan IB Ke dan kode straw.
                     Jika IB/pejantan belum tercatat, informasi file tetap disimpan dengan peringatan.
                     Kolom Ke digunakan sebagai laktasi. Setiap baris dianggap kelahiran tunggal;
                     kelahiran kembar pada tanggal sama perlu ditangani melalui form.</p>
                 <p>Import ulang memperbarui data yang sama. Tag pedet yang sudah digunakan untuk
                     induk/tanggal berbeda ditolak. Penyimpanan kelahiran, pedet, register dan ukuran
                     dilakukan bersama; jika gagal, perubahan baris dibatalkan.</p>
             </div>
             <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
         </div>
     </div>
 </div>
 <?php $laporanKelahiran = $this->session->userdata('kelahiran_last_import_report'); ?>
 <div class="modal fade" id="ModalLaporanImportKelahiran" tabindex="-1" role="dialog" aria-labelledby="judulLaporanKelahiran" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document"><div class="modal-content">
         <div class="modal-header"><h5 id="judulLaporanKelahiran" class="modal-title">Laporan Import Kelahiran Terakhir</h5><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button></div>
         <div id="hasilImportKelahiran" class="modal-body" style="max-height:65vh;overflow-y:auto;" aria-live="polite">
             <?php if (is_array($laporanKelahiran)) { ?>
             <p>Import selesai: <?=(int) $laporanKelahiran['success']; ?> baris berhasil, <?=count($laporanKelahiran['errors']); ?> pesan kesalahan; <?=(int) $laporanKelahiran['calves']; ?> pedet baru.</p>
             <?php foreach ($laporanKelahiran['errors'] as $pesan) { ?><div class="text-danger"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php foreach ($laporanKelahiran['warnings'] as $pesan) { ?><div class="text-warning"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php } else { ?><p>Belum ada laporan import kelahiran dalam sesi ini.</p><?php } ?>
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
                 <form action="<?= site_url('/reproduksi/kelahiran/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Kelahiran</h5>
             </div>
             <div class="modal-body">
                 <form id="frmtambah" action="/reproduksi/kelahiran/save" method="post">
                     <div class="row">
                         <div class="col-md-12 col-sm-12">
                             <div class="form-group col-md-6 col-sm-12">
                                 <label for="tanggal">Tanggal</label>
                                 <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                 <small id="tanggalerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="tagsapiInduk">Tag Sapi Induk</label>
                                 <input type="text" name="tagsapiInduk" id="tagsapiInduk" class="form-control">
                                 <small id="tagsapiIndukerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="nomorregisterInduk">Nomor Register Induk</label>
                                 <input type="text" name="nomorregisterInduk" id="nomorregisterInduk" class="form-control">
                                 <input type="hidden" name="idsapiInduk" id="idsapiInduk" class="form-control">
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="pagi">Laktasi Ke</label>
                                 <SELECT class="form-control" name='xlaktasi' id='xlaktasi'>
                                     <?php
                                        for ($i = 1; $i <= 10; $i++) {
                                        ?>
                                         <OPTION value="<?php echo $i; ?>"><?php echo $i; ?></OPTION>
                                     <?php
                                        }
                                        ?>
                                 </SELECT>
                                 <small id="pagierr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="pagi">Status Kelahiran</label>
                                 <SELECT class="form-control" name='status_kelahiran' id='status_kelahiran' onclick="cekstatus1()">
                                     <OPTION value="single">Single</OPTION>
                                     <OPTION value="kembar">Kembar</OPTION>
                                     <OPTION value="Abortus">Abortus</OPTION>
                                 </SELECT>
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="keterangan">Keterangan</label>
                         <input type="text" name="keterangan" id="keterangan" class="form-control">
                         <small id="keteranganerr" class="text-danger"></small>
                     </div>
                     <div class="row">
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="tagsapiPedet">Tag Sapi Pedet</label>
                                 <input type="text" name="tagsapiPedet" id="tagsapiPedet" class="form-control">
                                 <small id="tagsapiPedeterr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="jkelpedet">J.Kel. Pedet</label>
                                 <SELECT class="form-control" name='jkelpedet' id='jkelpedet'>
                                     <OPTION value="">-</OPTION>
                                     <OPTION value="Jantan">Jantan</OPTION>
                                     <OPTION value="Betina">Betina</OPTION>
                                 </SELECT>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="bobotlahir">Bobot Pedet</label>
                                 <input type="text" name="bobotlahir" id="bobotlahir" class="form-control">
                                 <small id="bobotlahirerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="statuspedet">Status Lahir Pedet</label>
                                 <SELECT class="form-control" name='statuspedet' id='statuspedet' onclick="cekstatus()">
                                     <OPTION value="Hidup">Hidup</OPTION>
                                     <OPTION value="Mati">Mati</OPTION>
                                     <OPTION value="Abortus">Abortus</OPTION>
                                 </SELECT>
                             </div>
                         </div>
                     </div>
                     <div id="pedet2" style="display: none;">
                         <div class="row">
                             <div class="col-md-6 col-sm-12">
                                 <div class="form-group">
                                     <label for="tagsapiPedet2">Tag Sapi Pedet 2</label>
                                     <input type="text" name="tagsapiPedet2" id="tagsapiPedet2" class="form-control">
                                     <small id="tagsapiPedet2err" class="text-danger"></small>
                                 </div>
                             </div>
                             <div class="col-md-6 col-sm-12">
                                 <div class="form-group">
                                     <label for="jkelpedet2">J.Kel. Pedet 2</label>
                                     <SELECT class="form-control" name='jkelpedet2' id='jkelpedet2'>
                                         <OPTION value="">-</OPTION>
                                         <OPTION value="Jantan">Jantan</OPTION>
                                         <OPTION value="Betina">Betina</OPTION>
                                     </SELECT>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-6 col-sm-12">
                                 <div class="form-group">
                                     <label for="bobotlahir2">Bobot Pedet 2</label>
                                     <input type="text" name="bobotlahir2" id="bobotlahir2" class="form-control">
                                     <small id="bobotlahir2err" class="text-danger"></small>
                                 </div>
                             </div>
                             <div class="col-md-6 col-sm-12">
                                 <div class="form-group">
                                     <label for="statuspedet2">Status Lahir Pedet 2</label>
                                     <SELECT class="form-control" name='statuspedet2' id='statuspedet2' onclick="cekstatus()">
                                         <OPTION value="Hidup">Hidup</OPTION>
                                         <OPTION value="Mati">Mati</OPTION>
                                         <OPTION value="Abortus">Abortus</OPTION>
                                     </SELECT>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="petugas">Petugas</label>
                         <input type="text" name="petugas" id="petugas" class="form-control">
                         <input type="hidden" name="idpetugas" id="idpetugas">
                         <small id="petugaserr" class="text-danger"></small>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-primary" id='btnsimpan'>Simpan</button>
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
                 <h5 class="modal-title" id="judulmodal">Edit Data Kelahiran</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="/reproduksi/kelahiran/update" method="post">
                     <div class="row">
                         <div class="col-md-12 col-sm-12">
                             <div class="form-group col-md-6 col-sm-12">
                                 <label for="tanggal">Tanggal</label>
                                 <input type="hidden" name="idkelahiran" id="edtidkelahiran">
                                 <input type="date" name="tanggal" id="edttanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                 <small id="tanggalerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="tagsapiInduk">Tag Sapi Induk</label>
                                 <input type="text" name="tagsapiInduk" id="edttagsapiInduk" class="form-control">
                                 <small id="tagsapiIndukerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="nomorregisterInduk">Nomor Register Induk</label>
                                 <input type="text" name="nomorregisterInduk" id="edtnomorregisterInduk" class="form-control">
                                 <input type="hidden" name="idsapiInduk" id="edtidsapiInduk" class="form-control">
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="pagi">Laktasi Ke</label>
                                 <SELECT class="form-control" name='xlaktasi' id='edtxlaktasi'>
                                     <?php
                                        for ($i = 1; $i <= 10; $i++) {
                                        ?>
                                         <OPTION value="<?php echo $i; ?>"><?php echo $i; ?></OPTION>
                                     <?php
                                        }
                                        ?>
                                 </SELECT>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="pagi">Status Kelahiran</label>
                                 <SELECT class="form-control" name='status_kelahiran' id='edtstatus_kelahiran'>
                                     <OPTION value="single">Single</OPTION>
                                     <OPTION value="kembar">Kembar</OPTION>
                                     <!-- <OPTION value="Abortus">Abortus</OPTION> -->
                                 </SELECT>
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="keterangan">Keterangan</label>
                         <input type="text" name="keterangan" id="edtketerangan" class="form-control">
                         <small id="keteranganerr" class="text-danger"></small>
                     </div>
                     <div class="row">
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="tagsapiPedet">Tag Sapi Pedet</label>
                                 <input type="hidden" name="idsapiPedet" id="edtidsapiPedet" class="form-control">
                                 <input type="text" name="tagsapiPedet" id="edttagsapiPedet" class="form-control">
                                 <small id="tagsapiPedeterr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="jkelpedet">J.Kel. Pedet</label>
                                 <SELECT class="form-control" name='jkelpedet' id='edtjkelpedet'>
                                     <OPTION value="Jantan">Jantan</OPTION>
                                     <OPTION value="Betina">Betina</OPTION>
                                 </SELECT>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="bobotlahir">Bobot Pedet</label>
                                 <input type="text" name="bobotlahir" id="edtbobotlahir" class="form-control">
                                 <small id="bobotlahirerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="statuspedet">Status Lahir Pedet</label>
                                 <SELECT class="form-control" name='statuspedet' id='edtstatuspedet'>
                                     <OPTION value="Hidup">Hidup</OPTION>
                                     <OPTION value="Mati">Mati</OPTION>
                                     <OPTION value="Abortus">Abortus</OPTION>
                                 </SELECT>
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="petugas">Petugas</label>
                         <input type="text" name="petugas" id="edtpetugas" class="form-control">
                         <input type="hidden" name="idpetugas" id="edtidpetugas">
                         <small id="petugaserr" class="text-danger"></small>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-primary" id='btnsimpan'>Simpan</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
