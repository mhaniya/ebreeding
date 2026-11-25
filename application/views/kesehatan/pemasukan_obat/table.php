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
                             <a href="javascript:" id="tambahdata" class="btn btn-primary">Tambah</a> 
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th style='text-align:center;'>Tanggal</th>
                                         <th style='text-align:center;'>Nama Obat</th>
                                         <th style='text-align:center;'>Jumlah</th>
                                         <th style='text-align:center;'>Satuan</th>
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
 <div class="modal fade" id="Modalhapus" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Hapus Data</h5>
             </div>
             <div class="modal-body">
                 <form action="<?=site_url('/kesehatan/pemasukan_obat/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Pemasukan Obat</h5>
             </div>
             <div class="modal-body">
               
                 <form id="frmtambah" action="/kesehatan/pemasukan_obat/save" method="post">
 					<div class="form-group">
 						<label for="tanggal">Tanggal</label>
						 <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d');?>">
						 <small id="tanggalerr" class="text-danger"></small>
					</div>
                    <div class="form-group">
 						<label for="edtnamaobat">Nama Obat</label>
						 <input type="text" name="namaobat" id="namaobat" class="form-control">
                         <input type="hidden" name="idobat" id="idobat" class="form-control">
						 <small id="namaobaterr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="jumlah">Jumlah</label>
						 <input type="number" name="jumlah" id="jumlah" class="form-control text-right"> 
					</div>
                    
                    <div class="form-group">
 						<label for="petugas">Petugas</label>
						 <input type="text" name="petugas" id="petugas" class="form-control">
						 <input type="hidden" name="idpetugas" id="idpetugas" class="form-control text-right">
						 <small id="petugaserr" class="text-danger"></small>
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
                 <h5 class="modal-title" id="judulmodal">Edit Data Pemasukan Obat</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="/kesehatan/pemasukan_obat/update" method="post">
 					<div class="form-group">
 						<label for="tanggal">Tanggal</label>
						 <input type="hidden" name="idpemasukan" id="edtidpemasukan" class="form-control">
						 <input type="date" name="tanggal" id="edttanggal" class="form-control">
						 <small id="tanggalerr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="edtnamaobat">Nama Obat</label>
						 <input type="text" name="namaobat" id="edtnamaobat" class="form-control">
						 <input type="hidden" name="idobat" id="edtidobat" class="form-control">
						 <small id="namaobaterr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="jumlah">Jumlah</label>
						 <input type="text" name="jumlah" id="edtjumlah" class="form-control">
						 <input type="hidden" name="idsapi" id="edtidsapi" class="form-control">
					</div>
                     
                    <div class="form-group">
 						<label for="petugas">Petugas</label>
						 <input type="text" name="petugas" id="edtpetugas" class="form-control ">
						 <input type="hidden" name="idpetugas" id="edtidpetugas" class="form-control text-right">
						 <small id="petugaserr" class="text-danger"></small>
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

