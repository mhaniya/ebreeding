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
                             <table class="table table-bordered table-striped table-hover" id="tblpetugas">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Nama Petugas</th>
                                         <th>Jabatan</th>
                                         <th>NIP</th>
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
                 <form action="<?php echo "/identifikasi/petugas/hapus"; ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Petugas</h5>
             </div>
             <div class="modal-body">
                 <form id="frmtambah" action="<?=site_url('/identifikasi/petugas/save'); ?>" method="post">

                     <div class="form-group">
                         <label for="nama">Nama Petugas</label>
                         <input type="text" name="nama" id="nama" class="form-control">
                         <small id="namaerr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="nama">Jabatan</label>
                         <input type="text" name="jabatan" id="jabatan" class="form-control">
                         <small id="jabatanerr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="nip">NIP</label>
                         <input type="text" name="nip" id="nip" class="form-control">
                         <small id="niperr" class="text-danger"></small>
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Petugas</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="<?=site_url('/identifikasi/petugas/update'); ?>" method="post">

                     <input type="text" name="idpetugas" id="idpetugas" class="form-control">

                     <div class="form-group">
                         <label for="nama">Nama Petugas</label>
                         <input type="text" name="nama" id="edtnama" class="form-control">
                         <small id="namaerr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="nama">Jabatan</label>
                         <input type="text" name="jabatan" id="edtjabatan" class="form-control">
                         <small id="jabatanerr" class="text-danger"></small>
                     </div>
                     <div class="form-group">
                         <label for="nip">NIP</label>
                         <input type="text" name="nip" id="edtnip" class="form-control">
                         <small id="niperr" class="text-danger"></small>
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