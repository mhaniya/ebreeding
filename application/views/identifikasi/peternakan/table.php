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
                             <div class="row">
                                 <?php if(($level_id==2)||($level_id==3)){ ?>
                                 <div class="col-md-3">
                                     <div class="btn-group">
                                         <a href="<?php echo "/identifikasi/peternakan/add";?>"
                                             class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                                         <input type="file" name='file' id='file' style="display:none;">
                                         <button class="btn bg-green" id="kotakUpload"><i class="fa fa-upload"></i> Import</button>
                                         <button class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i> Informasi</button>
                                     </div>
                                 </div>
                                 <div class="col-md-2">
                                     <?php echo $this->simpliparse->build_select_common_edit('kodepropinsi',$propinsi,'kodepropinsi','namapropinsi',':: Pilih Propinsi ::',$kodepropinsi,"class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <?php echo $this->simpliparse->build_select_common_edit('kodekabupaten',$kabupaten,'kodekabupaten','namakabupaten',':: Pilih Kabupaten ::',$kodekabupaten,"class='form-control'"); ?>
                                 </div>
                                 <div class="col-md-2">
                                     <?php echo $this->simpliparse->build_select_common_edit('kodekecamatan',$kecamatan,'kodekecamatan','namakecamatan',':: Pilih Kecamatan ::',$kodekecamatan,"class='form-control'"); ?>
                                 </div>
                                 <?php }else echo "&nbsp;"; ?>
                             </div>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>IDFarm</th>
                                         <th>Nama Peternakan/Farm</th>
                                         <th>Nama Peternak</th>
                                         <th>Alamat</th>
                                         <th>Kecamatan</th>
                                         <th>Kabupaten</th>
                                         <th>Propinsi</th>
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
                 <form action="<?=site_url('/identifikasi/peternakan/hapus'); ?>" method="post">
                     <input type="hidden" name="id" id="id" required>
                     Apakah yakin dihapus?
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                 <button type="submit" class="btn btn-danger">Hapus</button>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade" id="Modalinfo" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Informasi</h5>
             </div>
             <div class="modal-body" id="kotakInfo">
             <?php
                    $info_log=$this->session->flashdata('info_log');
                    echo $info_log;
            ?>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                 
             </div>
         </div>
     </div>
 </div>