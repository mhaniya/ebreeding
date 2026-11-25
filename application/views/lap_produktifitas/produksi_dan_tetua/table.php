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
                             <!-- <a href="javascript:" id="tambahdata" class="btn btn-primary">Tambah</a>  -->
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
                                
                             </div>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th style='text-align:center;'  rowspan='3'>#</th>
                                         <th style='text-align:center;'  rowspan='3'>No.Tag</th>
                                         <th style='text-align:center;'  rowspan='3'>No.Register</th>
                                         <th style='text-align:center;'  rowspan='3'>Tgl.Lahir</th>
                                         <th style='text-align:center;'  rowspan='2' colspan='2'>Laktasi</th>
                                         <th style='text-align:center;'  rowspan='2' colspan='3'>IB Terakhir</th>
                                         <th style='text-align:center;'  rowspan='2' colspan='3'>Pedet</th>
                                         <th style='text-align:center;'  rowspan='3'>Produksi Susu 305 Terkoreksi</th>
                                         <th style='text-align:center;'  rowspan='2' colspan='2'>Bapak</th>
                                         <th style='text-align:center;'  rowspan='2' colspan='2'>Induk</th>
                                         <th style='text-align:center;' colspan='4'>Tetua Bapak</th>
                                         <th style='text-align:center;' colspan='4'>Tetua Induk</th>
                                     </tr>
                                     <tr>
                                        <th style='text-align:center;' colspan='2'>Bapak</th>
                                        <th style='text-align:center;' colspan='2'>Induk</th>
                                        <th style='text-align:center;' colspan='2'>Bapak</th>
                                        <th style='text-align:center;' colspan='2'>Induk</th>
                                     </tr>
                                     <tr>
                                        <th style='text-align:center;' >Tgl.Laktasi</th>
                                        <th style='text-align:center;'>Laktasi.Ke</th>
                                        <th style='text-align:center;'>Tanggal.IB</th>
                                        <th style='text-align:center;'>Kode Straw</th>
                                        <th style='text-align:center;'>Nama Pejantan</th>
                                        <th style='text-align:center;'>No.Tag</th>
                                        <th style='text-align:center;'>J.Kel</th>
                                        <th style='text-align:center;'>Berat Lahir</th>
                                        <th style='text-align:center;'>Kode Straw</th>
                                        <th style='text-align:center;'>Nama</th>
                                        <th style='text-align:center;'>No.Tag</th>
                                        <th style='text-align:center;'>Nama</th>
                                        <th style='text-align:center;'>Kode Straw</th>
                                        <th style='text-align:center;'>Nama</th>
                                        <th style='text-align:center;'>No.Tag</th>
                                        <th style='text-align:center;'>Nama</th>
                                        <th style='text-align:center;'>Kode Straw</th>
                                        <th style='text-align:center;'>Nama</th>
                                        <th style='text-align:center;'>No.Tag</th>
                                        <th style='text-align:center;'>Nama</th>
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
						 <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d');?>">
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

