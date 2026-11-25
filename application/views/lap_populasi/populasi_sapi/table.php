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
                             <h2 align='left'>Populasi Sapi Per Propinsi</h2>
                             <table class="table table-hover">
                                 <thead>
                                     <tr>
                                         <th width='30px' rowspan='2'>No</th>
                                         <th rowspan='2'>Nama</th>
                                         <th colspan='3'>Sapi Hidup</th>
                                         <th colspan='3'>Sapi Afkir</th>
                                         <th colspan='3'>Sapi Mati</th>
                                     </tr>
                                     <tr>
                                         <th>Jantan</th>
                                         <th>Betina</th>
                                         <th>Total</th>
                                         <th>Jantan</th>
                                         <th>Betina</th>
                                         <th>Total</th>
                                         <th>Jantan</th>
                                         <th>Betina</th>
                                         <th>Total</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $i=0;
                                        foreach($propinsi->result() as $row){$i++;
                                            $nJantanHidup=$row->nJantanHidup;
                                            $nBetinaHidup=$row->nBetinaHidup;
                                            $nJantanAfkir=$row->nJantanAfkir;
                                            $nBetinaAfkir=$row->nBetinaAfkir;
                                            $nJantanMati=$row->nJantanMati;
                                            $nBetinaMati=$row->nBetinaMati;
                                    ?>
                                     <tr class='<?php echo $i%2==0?"barisgenap":"";?>'>
                                         <td style='text-align:right'><?=$i;?>.</td>
                                         <td><?=$row->namapropinsi;?></td>

                                         <td style='text-align:right'><?=number_format($row->nJantanHidup);?></td>
                                         <td style='text-align:right'><?=number_format($row->nBetinaHidup);?></td>
                                         <td style='text-align:right'>
                                             <?=number_format($row->nBetinaHidup+$row->nJantanHidup);?></td>
                                         <td style='text-align:right'><?=number_format($row->nJantanAfkir);?></td>
                                         <td style='text-align:right'><?=number_format($row->nBetinaAfkir);?></td>
                                         <td style='text-align:right'>
                                             <?=number_format($row->nJantanAfkir+$row->nBetinaAfkir);?>
                                         <td style='text-align:right'><?=number_format($row->nJantanMati);?></td>
                                         <td style='text-align:right'><?=number_format($row->nBetinaMati);?></td>
                                         <td style='text-align:right'>
                                             <?=number_format($row->nJantanMati+$row->nBetinaMati);?></td>
                                     </tr>
                                     <?php
				}
			?>
                                 </tbody>
                             </table>

                             <!--div id="container1" style="min-width: 400px; height: 400px; margin: 0 auto"></div-->

                             <h2 align='left'>Populasi Sapi Per Kabupaten</h2>
                             <table class="table table-hover">
                                 <thead>
                                     <tr>
                                         <th width='30px' rowspan='2'>No</th>
                                         <th rowspan='2'>Nama Propinsi</th>
                                         <th rowspan='2'>Nama Kabupaten</th>
                                         <th colspan='3'>Sapi Hidup</th>
                                         <th colspan='3'>Sapi Afkir</th>
                                         <th colspan='3'>Sapi Mati</th>
                                     </tr>
                                     <tr>
                                         <th>Jantan</th>
                                         <th>Betina</th>
                                         <th>Total</th>
                                         <th>Jantan</th>
                                         <th>Betina</th>
                                         <th>Total</th>
                                         <th>Jantan</th>
                                         <th>Betina</th>
                                         <th>Total</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
				$i=0;
				foreach($kabupaten->result() as $row){$i++;
			?>
                                     <tr class='<?php echo $i%2==0?"barisgenap":"";?>'>
                                         <td style='text-align:right'><?=$i;?>.</td>
                                         <td><?=$row->namapropinsi;?></td>
                                         <td><?=$row->namakabupaten;?></td>

                                         <td style='text-align:right'><?=number_format($row->nJantanHidup);?></td>
                                         <td style='text-align:right'><?=number_format($row->nBetinaHidup);?></td>
                                         <td style='text-align:right'>
                                             <?=number_format($row->nJantanHidup+$row->nBetinaHidup);?></td>
                                         <td style='text-align:right'><?=number_format($row->nJantanAfkir);?></td>
                                         <td style='text-align:right'><?=number_format($row->nBetinaAfkir);?></td>
                                         <td style='text-align:right'>
                                             <?=number_format($row->nJantanAfkir+$row->nBetinaAfkir);?></td>
                                         <td style='text-align:right'><?=number_format($row->nJantanMati);?></td>
                                         <td style='text-align:right'><?=number_format($row->nBetinaMati);?></td>
                                         <td style='text-align:right'>
                                             <?=number_format($row->nJantanMati+$row->nBetinaMati);?></td>
                                     </tr>
                                     <?php
				}
			?>
                                 </tbody>
                             </table>

                             <h2 align='left'>Populasi Sapi Per Kecamatan</h2>
                             <table class="table table-hover">
                                 <thead>
                                     <tr>
                                         <th width='30px' rowspan='2'>No</th>
                                         <th rowspan='2'>Nama Propinsi</th>
                                         <th rowspan='2'>Nama Kabupaten</th>
                                         <th rowspan='2'>Nama Kecamatan</th>
                                         <th rowspan='2'>Nama Peternakan</th>
                                         <th colspan='3'>Sapi Hidup</th>
                                         <th colspan='3'>Sapi Afkir</th>
                                         <th colspan='3'>Sapi Mati</th>
                                     </tr>
                                     <tr>
                                         <th>Jantan</th>
                                         <th>Betina</th>
                                         <th>Total</th>
                                         <th>Jantan</th>
                                         <th>Betina</th>
                                         <th>Total</th>
                                         <th>Jantan</th>
                                         <th>Betina</th>
                                         <th>Total</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
				$i=0;
				foreach($kecamatan->result() as $row){$i++;
			?>
                                     <tr class='<?php echo $i%2==0?"barisgenap":"";?>'>
                                         <td style='text-align:right'><?=$i;?>.</td>
                                         <td><?=$row->namapropinsi;?></td>
                                         <td><?=$row->namakabupaten;?></td>
                                         <td><?=$row->namakecamatan;?></td>
                                         <td><?=$row->namafarm;?></td>

                                         <td style='text-align:right'><?=number_format($row->nJantanHidup);?></td>
                                         <td style='text-align:right'><?=number_format($row->nBetinaHidup);?></td>
                                         <td style='text-align:right'>
                                             <?=number_format($row->nJantanHidup+$row->nBetinaHidup);?></td>
                                         <td style='text-align:right'><?=number_format($row->nJantanAfkir);?></td>
                                         <td style='text-align:right'><?=number_format($row->nBetinaAfkir);?></td>
                                         <td style='text-align:right'>
                                             <?=number_format($row->nJantanAfkir+$row->nBetinaAfkir);?></td>
                                         <td style='text-align:right'><?=number_format($row->nJantanMati);?></td>
                                         <td style='text-align:right'><?=number_format($row->nBetinaMati);?></td>
                                         <td style='text-align:right'>
                                             <?=number_format($row->nJantanMati+$row->nBetinaMati);?></td>
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

 