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
                             <div class="row" style='margin-bottom:5px;'>
                                 <div class="col-md-2">
                                     <div class="btn-group">
                                         <a href="<?php echo "/identifikasi/produksisusukambing/add";?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                                         <input type="file" name='file' id='file' style="display:none;">
                                         
                                     </div>
                                 </div>
                                  
                             </div>
                              
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th>#</th> 
                                         <th>Tanggal</th>
                                         <th>EarTag</th>
                                         <th>Pagi</th>
                                         <th>Sore</th> 
                                         <th style='width:100px;'>Aksi</th>
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
             <form action="<?=site_url('/identifikasi/produksisusukambing/hapus'); ?>" method="post">
                 <div class="modal-header">
                     <h5 class="modal-title" id="judulmodal">Hapus Data</h5>
                 </div>
                 <div class="modal-body">
                     <input type="hidden" name="id" id="id" required>
                     Apakah data Produksi Susu Kambing terpilih yakin
                     akan dihapus?
                      
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                     <button type="submit" class="btn btn-danger">Hapus</button>

                 </div>
             </form>
         </div>
     </div>
 </div>