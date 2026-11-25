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
                                         <input type="file" name='file' id='fileImportPertumbuhan' accept=".xlsx,.xls,.csv" style="display:none;">
                                         <button type="button" class="btn bg-navy" id="kotakUpload"><i class="fa fa-upload"></i>
                                             Import</button>
                                         <button type="button" class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i>
                                             Informasi</button>
                                         <button type="button" class="btn btn-secondary" id="btnLaporanImportPertumbuhan">Laporan Import Terakhir</button>
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
                                            $sql="SELECT year(tanggal) tahun FROM pengukuran_bobotsapi GROUP BY tahun ORDER BY tahun DESC";
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
                             <table class="table table-bordered table-striped table-hover" id="tblpertumbuhan">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Tanggal</th>
                                         <th>No. Tag</th>
                                         <th>No. Register</th>
                                         <th>Umur</th>
                                         <th>BB (Kg)</th>
                                         <th>LD (cm)</th>
                                         <th>Prediksi BB (Kg)</th>
                                         <th>PB (cm)</th>
                                         <th>TG (cm)</th>
                                         <th>LS (cm)</th>
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

 <div class="modal fade" id="ModalinfoPertumbuhan" tabindex="-1" role="dialog" aria-labelledby="judulInfoPertumbuhan" aria-hidden="true">
     <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulInfoPertumbuhan">Format Import Pertumbuhan</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body" style="max-height:65vh;overflow-y:auto;">
                 <p>Gunakan sheet pertama file .xlsx, .xls, atau .csv (maksimal 2 MB). Urutan kolom wajib seperti berikut, tanpa No. Register, kolom #/nomor urut maupun aksi. Baris judul boleh disertakan.</p>
                 <div class="table-responsive">
                     <table class="table table-bordered table-sm">
                         <thead><tr><th>Tanggal</th><th>No. Tag</th><th>Umur</th><th>BB (Kg)</th><th>LD (cm)</th><th>Prediksi BB (Kg)</th><th>PB (cm)</th><th>TG (cm)</th><th>LS (cm)</th></tr></thead>
                         <tbody><tr><td>2026-05-07</td><td>2512-IM</td><td>5.5</td><td>140.00</td><td>111.00</td><td>166.41</td><td>108.00</td><td>110.00</td><td>0.00</td></tr></tbody>
                     </table>
                 </div>
                 <ul>
                     <li>Tanggal diambil dari file, bukan session/filter halaman. Gunakan tanggal Excel, YYYY-MM-DD, DD/MM/YYYY, atau DD-Mon-YY (contoh 07-Mei-26).</li>
                     <li>No. Tag harus terdaftar dan sesuai akses/peternakan yang dipilih. Simpan tag sebagai teks agar angka nol di depan tidak hilang. No. Register tidak disertakan pada file import.</li>
                     <li>BB = bobot badan; LD = lingkar dada; PB = panjang badan; TG = tinggi gumba; LS = lingkar skrotum. BB dan LD wajib angka, PB/TG/LS boleh kosong. Rentang 0–999,99 dengan maksimal dua desimal, tanpa pemisah ribuan. Gunakan titik atau koma desimal; CSV dengan koma desimal harus memakai pemisah titik koma atau nilai berpetik.</li>
                     <li>Kolom Umur dan Prediksi BB tetap disertakan tetapi boleh kosong. Nilainya tidak disimpan dari file: Umur dihitung dari tanggal lahir sesuai perhitungan halaman saat ini; Prediksi BB = (LD + 18)² / 100.</li>
                     <li>Import ulang sapi pada tanggal yang sama memperbarui pengukuran, bukan menambah duplikat. Jika sudah ada beberapa pengukuran pada tanggal itu, baris ditolak. Baris valid tetap disimpan meskipun baris lain bermasalah.</li>
                 </ul>
             </div>
             <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
         </div>
     </div>
 </div>

 <?php $laporanPertumbuhan = $this->session->userdata('pertumbuhan_last_import_report'); ?>
 <div class="modal fade" id="ModalLaporanImportPertumbuhan" tabindex="-1" role="dialog" aria-labelledby="judulLaporanPertumbuhan" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulLaporanPertumbuhan">Laporan Import Pertumbuhan Terakhir</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body" style="max-height:65vh;overflow-y:auto;" id="hasilImportPertumbuhan" aria-live="polite">
                 <?php if (is_array($laporanPertumbuhan)) { ?>
                 <p>Import selesai: <?=(int) $laporanPertumbuhan['success']; ?> baris berhasil, <?=count($laporanPertumbuhan['errors']); ?> pesan kesalahan.</p>
                 <?php foreach ($laporanPertumbuhan['errors'] as $pesan) { ?><div class="text-danger"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
                 <?php foreach ($laporanPertumbuhan['warnings'] as $pesan) { ?><div class="text-warning"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
                 <?php } else { ?><p>Belum ada laporan import pertumbuhan dalam sesi ini.</p><?php } ?>
             </div>
             <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
         </div>
     </div>
 </div>

 <!-- Modal -->
 <div class="modal fade" id="Modalhapus" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Hapus Data</h5>
             </div>
             <div class="modal-body">
                 <form action="<?=site_url('/produksi/pertumbuhan/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Pertumbuhan Bobot Badan</h5>
             </div>
             <div class="modal-body">

                 <form id="frmtambah" action="/produksi/pertumbuhan/save" method="post">
                     <div class="row">
                         <div class="col-md-12 col-sm-12">
                             <div class="form-group col-md-6">
                                 <label for="tanggal">Tanggal</label>

                                 <input type="date" name="tanggal" id="tanggal1" class="form-control"
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
                                 <label for="bobotkg">Bobot (Kg)</label>
                                 <input type="text" name="bobotkg" id="bobotkg" class="form-control text-right">
                                 <small id="bobotkgerr" class="text-danger"></small>
                             </div>

                         </div>
                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="lingkar_dada">Lingkar Dada</label>
                                 <input type="text" name="lingkar_dada" id="lingkar_dada"
                                     class="form-control text-right">
                                 <small id="lingkar_dadaerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="panjang_badan">Panjang Badan</label>
                                 <input type="text" name="panjang_badan" id="panjang_badan"
                                     class="form-control text-right">
                                 <small id="panjang_badanerr" class="text-danger"></small>
                             </div>
                         </div>

                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="tinggi_gumba">Tinggi Gumba</label>
                                 <input type="text" name="tinggi_gumba" id="tinggi_gumba"
                                     class="form-control text-right">
                                 <small id="tinggi_gumbaerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-4 col-sm-6">
                             <div class="form-group">
                                 <label for="lingkar_skrotum">Lingkar Skrotum</label>
                                 <input type="text" name="lingkar_skrotum" id="lingkar_skrotum"
                                     class="form-control text-right">
                                 <small id="lingkar_skrotumerr" class="text-danger"></small>
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
