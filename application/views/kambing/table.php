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
                                         <a href="<?php echo "/kambing/add";?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                                         <input type="file" name='file' id='file' style="display:none;">
                                         
                                         <?php
                                            // if(($idfarm<>"")&&($idfarm<>"0")){
                                         ?>
                                         <!-- <button class="btn bg-green" id="kotakUpload"><i class="fa fa-upload"></i> Import</button>
                                            <?php //} ?>
                                         <button class="btn btn-info" id="btnInfo"><i class="fa fa-info"></i> Informasi</button> -->
                                     </div>
                                 </div>
                                 <div class="col-md-2">
                                        <?php
                                            $status= $this->session->userdata('status');
                                        ?>
                                        <select name="status" id="status" class='form-control'>
                                            <option value="hidup" <?php echo ($status=="hidup"?"SELECTED":"");?>>Hidup</option>
                                            <option value="mati"  <?php echo ($status=="mati"?"SELECTED":"");?>>Kematian</option>
                                            <option value="dijual"  <?php echo ($status=="dijual"?"SELECTED":"");?>>Jual</option>
                                            <option value="afkir"  <?php echo ($status=="afkir"?"SELECTED":"");?>>Afkir</option>
                                            <option value="hibah"  <?php echo ($status=="hibah"?"SELECTED":"");?>>Hibah</option>
                                        </select>
                                 </div>
                                 <div class="col-md-8">
                                 <?php
                                     $sql = "SELECT count(eartag) n FROM kambing WHERE status='hidup' AND rumpun='SAANEN' AND kelamin='Jantan'";
                                     $rs= $this->db->query($sql);
                                     if($rs->num_rows()>0){
                                         $row=$rs->row();
                                         $sanen_jantan = $row->n;
                                     }

                                     $sql = "SELECT count(eartag) n FROM kambing WHERE status='hidup' AND rumpun='SAANEN' AND kelamin='Betina'";
                                     $rs= $this->db->query($sql);
                                     if($rs->num_rows()>0){
                                         $row=$rs->row();
                                         $sanen_betina = $row->n;
                                     }

                                     $sql = "SELECT count(eartag) n FROM kambing WHERE status='hidup' AND rumpun='PE' AND kelamin='Jantan'";
                                     $rs= $this->db->query($sql);
                                     if($rs->num_rows()>0){
                                         $row=$rs->row();
                                         $pe_jantan = $row->n;
                                     }

                                     $sql = "SELECT count(eartag) n FROM kambing WHERE status='hidup' AND rumpun='PE' AND kelamin='Betina'";
                                     $rs= $this->db->query($sql);
                                     if($rs->num_rows()>0){
                                         $row=$rs->row();
                                         $pe_betina = $row->n;
                                     }
                                 ?>
                                    <table >
                                        <tr>
                                            <td style='width:150px;'>SAANEN Jantan </td>
                                            <td style='width:200px;'>: <strong><?php echo $sanen_jantan; ?></strong></td>
                                            <td style='width:150px;'>PE Jantan </td>
                                            <td style='width:200px;'>: <strong><?php echo $pe_jantan; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>SAANEN Betina </td>
                                            <td>: <strong><?php echo $sanen_betina; ?></strong></td>
                                            <td>PE Betina </td>
                                            <td>: <strong><?php echo $pe_betina; ?></strong></td>
                                        </tr>
                                    </table>
                                        
                                 </div>
                             </div>
                              
                         </div>
                         <div class="card-body table-responsive">
                                                
                             <table class="table table-bordered table-striped table-hover" id="tbldata">
                                 <thead>
                                     <tr>
                                         <th>#</th> 
                                         <th>EarTag</th>
                                         <th>Rumpun</th>
                                         <th>J.Kel</th>
                                         <th>Tgl.Lahir</th>
                                         <th>Bobot Lahir</th>
                                         <th>Tag Induk</th>
                                         <th>Tag Jantan</th>
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
             <form action="<?=site_url('/kambing/hapus'); ?>" method="post">
                 <div class="modal-header">
                     <h5 class="modal-title" id="judulmodal">Hapus Data</h5>
                 </div>
                 <div class="modal-body">
                     <input type="hidden" name="id" id="id" required>
                     Apakah data Kambing dengan nomor tag <span id='tagsapi'></span> yakin
                     akan dihapus?
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="alasanmenghapus">Alasan dihapus</label>
                                 <select name="alasan" id="alasan" class='form-control'>
                                     <option value="0">Data Salah</option>
                                     <option value="1">Kematian</option>
                                     <option value="2">Jual</option>
                                     <option value="3">Afkir</option>
                                     <option value="4">Hibah</option>
                                 </select>
                             </div>
                         </div>
                         <!-- <div class="col-md-6" style='display:none;' id='tanggalmati'>
                             <div class="form-group">
                                 <label for="alasanmenghapus">Tanggal Mati</label>
                                 <input type="date" name="tglmati" id="tglmati" class='form-control'
                                     value='< ?php echo date('Y-m-d');?>'>
                             </div>
                         </div> -->
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                     <button type="submit" class="btn btn-danger">Hapus</button>

                 </div>
             </form>
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
                    if($info_log<>""){
                        echo $info_log;
                    }else{
                        echo "Untuk melakukan import <br>
                        Baris Pertama : Judul Kolom, dan Mulai Baris Kedua : Data
                        
                        <p>Urutan kolom dalam file excel :
                        <ol>
                        <li>No Tag</li>
                        <li>Jns. Kelamin (JANTAN/BETINA) </li>
                        <li>Hasil Perkawinan (IB/ET/Alam) </li>
                        <li>Nama Sapi</li>
                        <li>Tgl. Lahir (dd/mm/YYYY)</li>
                        <li>Bobot Lahir</li>
                        <li>Status (Hidup/Mati/Afkir/Mutasi)</li>
                        <!--li>8. PC/DC/-</li-->
                        <li>UZUR, 1 -> Jika Uzur, 0 ->Jika Bukan Uzur </li>
                        <li>VBC, 1 -> Jika VBC, 0 ->Jika Bukan VBC</li>
                        <li>KSO, 1 -> Jika KSO, 0 ->Jika Bukan </li>
                        <li>Balai, 1 -> Jika Balai, 0 ->Jika Bukan </li>
                        
                        </ol>
                        </p>";
                    }
            ?>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                 
             </div>
         </div>
     </div>
 </div>