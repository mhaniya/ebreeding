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
                             <a href="javascript:" id="tambahdata" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tblsemen">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Kode Semen</th>
                                         <th>Nama Semen</th>
                                         <th>Tgl. Lahir</th>
                                         <th>Kode Sire</th>
                                         <th>Nama Sire</th>
                                         <th>Kode Dam</th>
                                         <th>Nama Dam</th>
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
 <div class="modal fade" id="Modalhapus" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Hapus Data</h5>
             </div>
             <div class="modal-body">
                 <form action="<?=site_url('/identifikasi/semen/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Semen</h5>
             </div>
             <div class="modal-body">
                 <form id="frmtambah" action="<?=site_url('/identifikasi/semen/save'); ?>" method="post">
                    <input type="hidden" name="idsire" id="idsire">
                    <input type="hidden" name="iddam" id="iddam">
                    <div class="form-group">
 						<label for="kodesemen">Kode Semen</label>
						 <input type="text" name="kodesemen" id="kodesemen" class="form-control">
						 <small id="kodesemenerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="namasemen">Nama Semen</label>
						 <input type="text" name="namasemen" id="namasemen" class="form-control">
						 <small id="namasemenerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="tanggallahir">Tanggal Lahir</label>
						 <input type="date" name="tanggallahir" id="tanggallahir" class="form-control">
						 <small id="tanggallahirerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="kodesire">Kode Sire</label>
						 <input type="text" name="kodesire" id="kodesire" class="form-control">
						 <small id="kodesireerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="noregsire">No. Register Sire</label>
						 <input type="text" name="noregsire" id="noregsire" class="form-control">
						 <small id="noregsireerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="namasire">Nama Sire</label>
						 <input type="text" name="namasire" id="namasire" class="form-control">
						 <small id="namasireerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="kodedam">Kode Dam</label>
						 <input type="text" name="kodedam" id="kodedam" class="form-control">
                         
						 <small id="kodedamerr" class="text-danger"></small>
					</div>
                    <div class="form-group">
 						<label for="noregdam">No. Register Dam</label>
						 <input type="text" name="noregdam" id="noregdam" class="form-control">
						 <small id="noregdamerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="namadam">Nama Dam</label>
						 <input type="text" name="namadam" id="namadam" class="form-control">
						 <small id="namadamerr" class="text-danger"></small>
					</div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                         <button type="submit" class="btn btn-primary" id="btnsimpan">Simpan</button>
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
                 <h5 class="modal-title" id="judulmodal">Edit Data Semen</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="<?=site_url('/identifikasi/semen/update'); ?>" method="post">
                    <input type="hidden" name="idsire" id="edtidsire">
                    <input type="hidden" name="iddam" id="edtiddam">
                    <div class="form-group">
 						<label for="edtkodesemen">Kode Semen</label>
						 <input type="hidden" name="kode" id="edtkode" class="form-control">
						 <input type="text" name="kodesemen" id="edtkodesemen" class="form-control">
						 <small id="edtkodesemenerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="edtnamasemen">Nama Semen</label>
						 <input type="text" name="namasemen" id="edtnamasemen" class="form-control">
						 <small id="edtnamasemenerr" class="text-danger"></small>
					</div>
                    <div class="form-group">
 						<label for="edttanggallahir">Tanggal Lahir</label>
						 <input type="date" name="tanggallahir" id="edttanggallahir" class="form-control">
						 <small id="edttanggallahirerr" class="text-danger"></small>
					</div>
                    <div class="form-group">
 						<label for="edtkodesire">Kode Sire</label>
						 <input type="text" name="kodesire" id="edtkodesire" class="form-control">
						 <small id="edtkodesireerr" class="text-danger"></small>
					</div>
                    <div class="form-group">
 						<label for="edtnoregsire">No. Register Sire</label>
						 <input type="text" name="noregsire" id="edtnoregsire" class="form-control">
						 <small id="edtnoregsireerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="edtnamasire">Nama Sire</label>
						 <input type="text" name="namasire" id="edtnamasire" class="form-control">
						 <small id="edtnamasireerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="edtkodedam">Kode Dam</label>
						 <input type="text" name="kodedam" id="edtkodedam" class="form-control">
						 <small id="edtkodedamerr" class="text-danger"></small>
					</div>
                    <div class="form-group">
 						<label for="edtnoregdam">No. Register Dam</label>
						 <input type="text" name="noregdam" id="edtnoregdam" class="form-control">
						 <small id="edtnoregdamerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="edtnamadam">Nama Dam</label>
						 <input type="text" name="namadam" id="edtnamadam" class="form-control">
						 <small id="edtnamadamerr" class="text-danger"></small>
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

