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
                             &nbsp;
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th style='text-align:center;' rowspan='2'>#</th>
                                         <th style='text-align:center;' rowspan='2'>Peternakan</th>
                                         <th style='text-align:center;' rowspan='2'>Kecamatan</th>
                                         <th style='text-align:center;' rowspan='2'>Total Sapi Hidup</th>
                                         <th style='text-align:center;' colspan='8'>Sapi Betina</th>
                                         <th style='text-align:center;' colspan='8'>Sapi Jantan</th>
                                     </tr>
                                     <tr>
                                        <th style='text-align:center;' >Tanpa Tgl Lahir</th>
                                        <th style='text-align:center;' >0 - 4 bulan</th>
                                        <th style='text-align:center;' >5 -12 bulan</th>
                                        <th style='text-align:center;' >12 bulan</th>
                                        <th style='text-align:center;' >Total</th>
                                        <th style='text-align:center;' >Afkir</th>
                                        <th style='text-align:center;' >Mati</th>
                                        <th style='text-align:center;' >Tanpa Tgl Lahir</th>
                                        <th style='text-align:center;' >0 - 4 bulan</th>
                                        <th style='text-align:center;' >5 -12 bulan</th>
                                        <th style='text-align:center;' >12 bulan</th>
                                        <th style='text-align:center;' >Total</th>
                                        <th style='text-align:center;' >Afkir</th>
                                        <th style='text-align:center;' >Mati</th>
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

 