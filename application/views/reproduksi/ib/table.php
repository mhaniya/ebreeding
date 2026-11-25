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
                                         <input type="file" name='file' id='fileImportIb' accept=".xlsx,.xls,.csv" style="display:none;">
                                         <button type="button" class="btn bg-navy" id="kotakUpload"><i class="fa fa-upload"></i>
                                             Import</button>
                                         <button type="button" class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i>
                                             Informasi</button>
                                         <button type="button" class="btn btn-secondary" id="btnLaporanImportIb">Laporan Import Terakhir</button>
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
                                            $sql="SELECT year(tanggal) tahun FROM reproduksi_ib GROUP BY tahun ORDER BY tahun DESC";
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
                                         <th>Tanggal</th>
                                         <th>No. Tag</th>
                                         <th>No. Register</th>
                                         <th>IB Ke</th>
                                         <th>Laktasi ke</th>
                                         <th style='text-align:center;'>Nama Bull</th>
                                         <th style='text-align:center;'>Petugas</th>
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
 <div class="modal fade" id="ModalinfoIb" tabindex="-1" role="dialog" aria-labelledby="judulInfoIb" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulInfoIb">Informasi Import Inseminasi Buatan</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body" style="max-height:65vh;overflow-y:auto;">
                 <p>Gunakan file .xlsx, .xls, atau .csv, maksimal 2 MB. Sheet pertama dibaca.
                     Header bertingkat dan baris kosong sebelum data boleh digunakan.</p>
                 <p>Urutan kolom A–I:</p>
                 <ol>
                     <li>No. (angka)</li><li>EAR TAG</li><li>Tanggal</li><li>IB Ke</li>
                     <li>Nama Straw</li><li>Kode Straw</li><li>Petugas IB</li>
                     <li>Keterangan (boleh kosong)</li><li>Intensitas Birahi (angka, boleh kosong)</li>
                 </ol>
                 <p>Contoh: 1 | 8670 | 01-Sep-26 | 1 | CS Lavan | 316123 | Wahyono | |</p>
                 <p>Tanggal dapat berupa tanggal Excel, YYYY-MM-DD, DD-MMM-YY (01-Sep-26),
                     DD-MMM-YYYY, DD/MM/YYYY, atau DD-MM-YYYY. Simpan EAR TAG dan kode straw sebagai teks
                     agar angka nol di awal tetap terbaca.</p>
                 <p>EAR TAG dan kode straw harus terdaftar di master. Nama straw mengikuti master semen
                     berdasarkan kode straw. Nama petugas dicocokkan dengan master petugas;
                     jika belum ditemukan, nama tetap disimpan dan dilaporkan sebagai peringatan.</p>
                 <p>Laktasi mengikuti kelahiran terakhir pada/sebelum tanggal IB, atau 0 jika belum ada.
                     Import ulang memperbarui IB untuk sapi dan tanggal yang sama.</p>
             </div>
             <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
         </div>
     </div>
 </div>
 <?php $laporanIb = $this->session->userdata('ib_last_import_report'); ?>
 <div class="modal fade" id="ModalLaporanImportIb" tabindex="-1" role="dialog" aria-labelledby="judulLaporanIb" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document"><div class="modal-content">
         <div class="modal-header"><h5 id="judulLaporanIb" class="modal-title">Laporan Import IB Terakhir</h5><button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button></div>
         <div id="hasilImportIb" class="modal-body" style="max-height:65vh;overflow-y:auto;" aria-live="polite">
             <?php if (is_array($laporanIb)) { ?>
             <p>Import selesai: <?=(int) $laporanIb['success']; ?> baris berhasil, <?=count($laporanIb['errors']); ?> pesan kesalahan.</p>
             <?php foreach ($laporanIb['errors'] as $pesan) { ?><div class="text-danger"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php foreach ($laporanIb['warnings'] as $pesan) { ?><div class="text-warning"><?=htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
             <?php } else { ?><p>Belum ada laporan import IB dalam sesi ini.</p><?php } ?>
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
                 <form action="<?=site_url('/reproduksi/ib/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data IB</h5>
             </div>
             <div class="modal-body">

                 <form id="frmtambah" action="/reproduksi/ib/save" method="post">
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
                     </div>
                     <div class="row">
                         <div class="form-group col-md-6 col-sm-12">
                             <label for="pagi">Kode Semen</label>
                             <input type="text" name="kodesemen" id="kodesemen" class="form-control">
                         </div>
                         <div class="form-group col-md-6 col-sm-12">
                             <label for="pagi">Nama Semen</label>
                             <input type="text" name="namasemen" id="namasemen" class="form-control">
                             <small id="kodesemenerr" class="text-danger"></small>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-md-6 col-sm-12">
                             <label for="ibke">IB Ke</label>
                             <SELECT name='ibke' id='ibke' class='form-control'>
                                 <OPTION>:: Pilih IB Ke ::</OPTION>
                                 <?php 
                            for($i=1;$i<=7;$i++){
                                echo "<OPTION value='$i'>$i</OPTION>";
                            }
                            ?>
                             </SELECT>
                         </div>
                         <div class="form-group col-md-6 col-sm-12">
                             <label for="petugas">Petugas</label>
                             <input type="text" name="petugas" id="namapetugas" class="form-control">
                             <input type="hidden" name="idpetugas" id="idpetugas">
                             <small id="petugaserr" class="text-danger"></small>
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
                 <h5 class="modal-title" id="judulmodal">Edit Data IB</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="/reproduksi/ib/update" method="post">
                     <div class="row">
                         <div class="col-md-12 col-sm-12">
                             <div class="form-group col-md-6 col-sm-12">
                                 <label for="tanggal">Tanggal</label>
                                 <input type="hidden" name="idib" id="idib">
                                 <input type="date" name="tanggal" id="edttanggal" class="form-control"
                                     value="<?php echo date('Y-m-d');?>">
                                 <small id="tanggalerr" class="text-danger"></small>
                             </div>
                         </div>
                         <div class="col-md-6 col-sm-12">
                             <div class="form-group">
                                 <label for="edttagsapi">Tag Sapi</label>
                                 <input type="text" name="tagsapi" id="edttagsapi" class="form-control">
                                 <small id="tagsapierr" class="text-danger"></small>
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
                         <div class="form-group col-md-6 col-sm-12">
                             <label for="edtkodesemen">Kode Semen</label>
                             <input type="text" name="kodesemen" id="edtkodesemen" class="form-control">
                         </div>
                         <div class="form-group col-md-6 col-sm-12">
                             <label for="edtnamasemen">Nama Semen</label>
                             <input type="text" name="namasemen" id="edtnamasemen" class="form-control">
                             <small id="kodesemenerr" class="text-danger"></small>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-md-6 col-sm-12">
                             <label for="ibke">IB Ke</label>
                             <SELECT name='ibke' id='edtibke' class='form-control'>
                                 <OPTION>:: Pilih IB Ke ::</OPTION>
                                 <?php 
                            for($i=1;$i<=7;$i++){
                                echo "<OPTION value='$i'>$i</OPTION>";
                            }
                            ?>
                             </SELECT>
                         </div>
                         <div class="form-group col-md-6 col-sm-12">
                             <label for="keterangan">Petugas</label>
                             <input type="text" name="petugas" id="edtnamapetugas" class="form-control">
                             <input type="hidden" name="idpetugas" id="edtidpetugas">
                             <small id="petugaserr" class="text-danger"></small>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="keterangan">Keterangan</label>
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
