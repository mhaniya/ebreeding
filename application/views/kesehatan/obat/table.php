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
                                         <th>Kode</th>
                                         <th>Nama Obat</th>
                                         <th>Kategori</th>
                                         <th>Fungsi</th>
                                         <th>Penggunaan</th>
                                         <th>Stok</th>
                                         <th>Satuan</th>
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
                 <form action="<?=site_url('/kesehatan/obat/hapus'); ?>" method="post">
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
                 <h5 class="modal-title" id="judulmodal">Tambah Data Obat</h5>
             </div>
             <div class="modal-body">
               
                 <form id="frmtambah" action="/kesehatan/obat/save" method="post">
 					<div class="form-group">
 						<label for="kodeobat">Kode Obat</label>
						 <input type="text" name="kodeobat" id="kodeobat" class="form-control">
						 <small id="kodeobaterr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="namaobat">Nama Obat</label>
						 <input type="text" name="namaobat" id="namaobat" class="form-control">
						 <small id="namaobaterr" class="text-danger"></small>
					</div>
                    <div class="form-group">
                    <label for="idkategoriobat">Kategori Obat</label>
 						<?php
                            $sql="SELECT * FROM con_kategoriobat";
                            $rs=$this->db->query($sql);
                            echo $this->simpliparse->build_select_common('idkategoriobat',$rs,'idkategoriobat','nama',':: Pilih Kategori Obat ::','class="form-control"');
                         ?>
						 <small id="idkategoriobaterr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="fungsiobat">Fungsi Obat</label>
						 <input type="text" name="fungsiobat" id="fungsiobat" class="form-control"> 
					</div>
                    
                    <div class="form-group">
 						<label for="penggunaanobat">Penggunaan Obat</label>
						 <input type="text" name="penggunaanobat" id="penggunaanobat" class="form-control">
						 <small id="penggunaanobaterr" class="text-danger"></small>
					</div>
                    <div class="form-group">
 						<label for="stok">Stok</label>
						 <input type="number" name="stok" id="stok" class="form-control text-right">
						 <small id="stokerr" class="text-danger"></small>
					</div>
                    <div class="form-group">
                    <label for="idsatuan">Satuan Obat</label>
 						<?php
                            $sql="SELECT * FROM satuan_obat";
                            $rs=$this->db->query($sql);
                            echo $this->simpliparse->build_select_common('idsatuan',$rs,'idsatuan','nama',':: Pilih Satuan Obat ::','class="form-control"');
                         ?>
						 <small id="idsatuanerr" class="text-danger"></small>
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
                 <h5 class="modal-title" id="judulmodal">Edit Data Obat</h5>
             </div>
             <div class="modal-body">
                 <form id="frmedit" action="/kesehatan/obat/update" method="post">
 					<div class="form-group">
 						<label for="edtkodeobat">Kode Obat</label>
						 <input type="text" name="idobat" id="idobat" >
						 <input type="text" name="kodeobat" id="edtkodeobat" class="form-control">
						 
						 <small id="kodeobaterr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="edtnamaobat">Nama Obat</label>
						 <input type="text" name="namaobat" id="edtnamaobat" class="form-control">
						 <small id="namaobaterr" class="text-danger"></small>
					</div>
                    <div class="form-group">
                    <label for="idkategoriobat">Kategori Obat</label>
 						<?php
                            $sql="SELECT * FROM con_kategoriobat";
                            $rs=$this->db->query($sql);
                            echo $this->simpliparse->build_select_common('edtidkategoriobat',$rs,'idkategoriobat','nama',':: Pilih Kategori Obat ::','class="form-control"');
                         ?>
						 <small id="idkategoriobaterr" class="text-danger"></small>
					</div>
 					<div class="form-group">
 						<label for="edtfungsiobat">Fungsi Obat</label>
						 <input type="text" name="fungsiobat" id="edtfungsiobat" class="form-control"> 
					</div>
                    
                    <div class="form-group">
 						<label for="edtpenggunaanobat">Penggunaan Obat</label>
						 <input type="text" name="penggunaanobat" id="edtpenggunaanobat" class="form-control">
						 <small id="edtpenggunaanobaterr" class="text-danger"></small>
					</div>
                     
                    <div class="form-group">
                    <label for="idsatuan">Satuan Obat</label>
 						<?php
                            $sql="SELECT * FROM satuan_obat";
                            $rs=$this->db->query($sql);
                            echo $this->simpliparse->build_select_common('edtidsatuan',$rs,'idsatuan','nama',':: Pilih Satuan Obat ::','class="form-control"');
                         ?>
						 <small id="idsatuanerr" class="text-danger"></small>
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

