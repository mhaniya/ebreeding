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
                         &nbsp;    <!-- <a href="javascript:" id="tambahdata" class="btn btn-primary">Tambah</a> -->
                         </div>
                         <div class="card-body table-responsive">


                             <h2 align='left'>Populasi Peternakan Per Propinsi</h2>
                             <table class="data">
                                 <thead>
                                     <tr>
                                         <th width='50px'>No</th>
                                         <th>Nama</th>
                                         <th>Populasi Peternakan</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                $i=0;
                                foreach($propinsi->result() as $row){$i++;
                            ?>
                                     <tr class='<?php echo $i%2==0?"barisgenap":"";?>'>
                                         <td><?=$i;?>.</td>
                                         <td><?=$row->namapropinsi;?></td>

                                         <td style='text-align:right'><?=number_format($row->n);?></td>
                                     </tr>
                                     <?php
                                }
                            ?>
                                 </tbody>
                             </table>

                             <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

                             <h2 align='left'>Populasi Peternakan Per Kabupaten</h2>
                             <table class="data">
                                 <thead>
                                     <tr>
                                         <th width='50px'>No</th>
                                         <th>Nama Propinsi</th>
                                         <th>Nama Kabupaten</th>
                                         <th>Populasi Peternakan</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
				$i=0;
				foreach($kabupaten->result() as $row){$i++;
			?>
                                     <tr class='<?php echo $i%2==0?"barisgenap":"";?>'>
                                         <td><?=$i;?>.</td>
                                         <td><?=$row->namapropinsi;?></td>
                                         <td><?=$row->namakabupaten;?></td>

                                         <td style='text-align:right'><?=number_format($row->n);?></td>
                                     </tr>
                                     <?php
				}
			?>
                                 </tbody>
                             </table>
                             <div id="kabupatenContainer" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

                             <h2 align='left'>Populasi Peternakan Per Koperasi</h2>
                             <table class="data">
                                 <thead>
                                     <tr>
                                         <th width='50px'>No</th>
                                         <th>Nama Propinsi</th>
                                         <th>Nama Kabupaten</th>
                                         <th>Nama Koperasi</th>
                                         <th>Populasi Peternakan</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
				$i=0;
				foreach($koperasi->result() as $row){$i++;
			?>
                                     <tr class='<?php echo $i%2==0?"barisgenap":"";?>'>
                                         <td><?=$i;?>.</td>
                                         <td><?=$row->namapropinsi;?></td>
                                         <td><?=$row->namakabupaten;?></td>
                                         <td><?=$row->namakoperasi;?></td>

                                         <td style='text-align:right'><?=number_format($row->n);?></td>
                                     </tr>
                                     <?php
				}
			?>
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
  