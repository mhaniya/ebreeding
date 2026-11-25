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
                                         <th style='width:50px;'>#</th>
                                         <th>Kasus Penyakit</th>
                                         <?php
                                            $user_id=$this->session->userdata('user_id');
                                            $sql="SELECT * FROM farm JOIN koperasi ON koperasi.kodekoperasi=farm.kodekoperasi 
                                                JOIN `web_user` on web_user.kodekoperasi=koperasi.kodekoperasi
                                                WHERE `web_user`.user_id='$user_id'";
                                            $rs=$this->db->query($sql);
                                                foreach($rs->result() as $row){
                                                    ?>
                                                    <th style='width:100px;'><?php echo $row->namafarm;?></th>

                                                    <?php
                                                }
                                         ?> 
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

 