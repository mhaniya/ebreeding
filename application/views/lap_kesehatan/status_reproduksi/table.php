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
                             <!-- <a href="javascript:" id="tambahdata" class="btn btn-primary">Tambah</a> -->
                             &nbsp;
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover">
                                 <tr>
                                     <th style='width:30px;'>NO</th>
                                     <th>ASPEK</th>
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
                                 <tr>
                                     <td style='text-align:right;'>1</td>
                                     <td>Jumlah sapi yang bunting</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                                 <tr>
                                     <td style='text-align:right;'>2</td>
                                     <td>PKB dubius</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                                 <tr>
                                     <td style='text-align:right;'>3</td>
                                     <td>Jumlah sapi sudah IB dan menunggu di PKB</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                                 <tr>
                                     <td style='text-align:right;'>4</td>
                                     <td>Jumlah sapi sudah IB tetapi negatif</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                                 <tr>
                                     <td style='text-align:right;'>5</td>
                                     <td>Jumlah sapi Post Partus > 40 hari belum IB</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                                 <tr>
                                     <td style='text-align:right;'>6</td>
                                     <td>Jumlah sapi Post Partus / abortus < 40 hari</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                             </table>
                                                    &nbsp;<br>
                             <table class="table table-bordered table-striped table-hover" >
                                 <tr>
                                     <th style='width:30px;'>NO</th>
                                     <th>JUMLAH POPULASI</th>
                                     <th style='width:100px;'>JUMLAH</th>
                                 </tr>
                                 <tr>
                                     <td style='text-align:right;'>1</td>
                                     <td>Betina muda &lt; 10 bulan</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                                 <tr>
                                     <td style='text-align:right;'>2</td>
                                     <td>Jantan</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                                 <tr>
                                     <td style='text-align:right;'>3</td>
                                     <td>Induk</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                                 <tr>
                                     <td style='text-align:right;'>4</td>
                                     <td>Dara siap kawin &ge; 15 bulan</td>
                                     <td style='text-align:right;'>0</td>
                                 </tr>
                             </table>

                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- /.content -->
 </div>

 