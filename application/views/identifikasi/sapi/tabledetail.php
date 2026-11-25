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
                         <li class="breadcrumb-item"><?php echo ucwords($submenu);?></li>
                         <li class="breadcrumb-item active">Detail</li>
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
                             <h5 class="m-0 text-dark">A. Data Sapi </h5>
                             <input type='date' name='tglsertifikat' id='tglsertifikat'
                                 value="<?php echo date('Y-m-d');?>">
                             <input type='button' class='btn bg-navy'
                                 onclick="cetakSertifikat('<?php echo $idsapi; ?>')" value='Cetak Sertifikat'>
                             <input type='button' class='btn bg-navy'
                                 onclick="cetakSertifikatlspro('<?php echo $idsapi; ?>')"
                                 value='Cetak Sertifikat LSPRO'>
                         </div>
                         <div class="card-body table-responsive">
                             <div class="row">
                                 <div class="col-md-6">
                                     <table class="table table-stripped table-bordered">
                                         <thead>
                                             <tr>
                                                 <td style='width:200px;'>Nomor Tag</td>
                                                 <td>: <?php echo $sapi->tagsapi;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Nomor Registrasi</td>
                                                 <td>: <?php echo $sapi->nomorregister;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Jenis Kelamin</td>
                                                 <td>: <?php echo $sapi->kelamin;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Hasil Perkawinan</td>
                                                 <td>: <?php echo $sapi->tipesapi;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Kategori Sapi</td>
                                                 <?php
                                                    $kategori=($sapi->is_balai==1?"Balai":"");

                                                    if($sapi->is_uzur==1){
                                                        if($kategori<>"") $kategori .= ", ";
                                                        $kategori .= "Uzur";
                                                    }
                                                    
                                                    if($sapi->is_vbc==1){
                                                        if($kategori<>"") $kategori .= ", ";
                                                        $kategori .= "VBC";
                                                    }

                                                 ?>
                                                 <td>: <?php echo $kategori;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Nama</td>
                                                 <td>: <?php echo $sapi->namasapi;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Tgl. Lahir</td>
                                                 <td>: <?php echo $this->fungsi->date_to_tanggal3($sapi->tgllahir);?>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Bobot Lahir</td>
                                                 <td>: <?php echo $sapi->bobotlahir;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Peternakan/Peternak</td>
                                                 <td>: <?php echo $sapi->namafarm;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Kecamatan</td>
                                                 <td>: <?php echo $sapi->namakecamatan;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Kabupaten</td>
                                                 <td>: <?php echo $sapi->namakabupaten;?></td>
                                             </tr>
                                             <tr>
                                                 <td>Propinsi</td>
                                                 <td>: <?php echo $sapi->namapropinsi;?></td>
                                             </tr>
                                         </thead>
                                     </table>
                                     <input type="hidden" name="idsapi" id="idsapi" value="<?php echo $idsapi;?>">
                                 </div>
                                 <div class="col-md-6">
                                     <div id='gambar' align='center'>
                                         <img src='<?php 
                                                if (file_exists('/var/www/html/assets/images/upload/foto/sapi/'.$idsapi.'.jpg'))
                                                    echo "/assets/images/upload/foto/sapi/".$idsapi;
                                                else
                                                    echo "/assets/images/upload/foto/sapi/sapikosong"                                       
                                                ?>.jpg' width='100%' style='max-width:400px;border-radius:10px' />
                                     </div>
                                     <input type="file" name='filefoto' id='filefoto' style="display:none;">

                                     <div class="row clearfix col-md-12">
                                         <button class="btn btn-primary col-md-12" id="kotakUpload">Pilih File untuk
                                             diupload</button>

                                     </div>

                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-primary">
                         <div class="card-header">
                             <h5 class="m-0 text-dark">B. Data Tetua </h5>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-stripped table-bordered" id="tbltetua">
                                 <thead>
                                     <tr>
                                         <th class="text-center" width='30px'>#</th>
                                         <th class="text-center" width='50px'>Individu</th>
                                         <th class="text-center" width='100px'>No. Register</th>
                                         <th class="text-center" width='100px'>No. Tag/No.ID</th>
                                         <th class="text-center" width='160px'>Nama Tetua</th>
                                         <th class="text-center" width='70px'>Tgl. Lahir</th>
                                         <th class="text-center" width='50px'>Milk</th>
                                         <th class="text-center" width='50px'>Fat</th>
                                         <th class="text-center" width='50px'>Protein</th>
                                         <th class="text-center" width='30px'>&nbsp;</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $set=TRUE;
                                         
                                        if($dataTetua->num_rows()>0){
                                            $rowInduk=$dataTetua->row();
                                            $iddam=$rowInduk->iddam;
                                            $kodedam=$rowInduk->kodedam;
                                            $nomorregisterdam=$rowInduk->nomorregisterdam;
                                            $tagdam=$rowInduk->tagdam;
                                            $namadam=$rowInduk->namadam;

                                            if($rowInduk->tgllahirdam<>null)
                                                $tgllahirdam=$this->fungsi->date_to_tanggal3($rowInduk->tgllahirdam);
                                            else
                                                $tgllahirdam="";

                                            $milkdam = $rowInduk->milkdam;
                                            $fatdam = $rowInduk->fatdam;
                                            $proteindam = $rowInduk->proteindam;
                                            if ($rowInduk->idsire!=null){
                                                $idsire=$rowInduk->idsire;
                                                $nomorregistersire=$rowInduk->nomorregistersire;
                                                $tagsire=$rowInduk->tagsire;
                                                $namasire=$rowInduk->namasire;
                                                if($rowInduk->tgllahirsire<>null)
                                                    $tgllahirsire=$this->fungsi->date_to_tanggal3($rowInduk->tgllahirsire);
                                                else
                                                    $tgllahirsire="";
                                            }else{
                                                $sql="SELECT idsire 
                                                        ,kodesire
                                                        ,(SELECT nomorregister FROM register where register.idsapi=sapi.idsire) nomorregistersire
                                                        ,(SELECT tagsapi FROM sapi dam where dam.idsapi=sapi.idsire) tagsire
                                                        ,(SELECT tgllahir FROM sapi dam where dam.idsapi=sapi.idsire) tgllahirsire
                                                        ,(SELECT namasapi FROM sapi dam where dam.idsapi=sapi.idsire) namasire
                                                        ,(SELECT milk FROM sapi dam where dam.idsapi=sapi.idsire) milksire
                                                        ,(SELECT fat FROM sapi dam where dam.idsapi=sapi.idsire) fatsire
                                                        ,(SELECT protein FROM sapi dam where dam.idsapi=sapi.idsire) proteinsire
                                                        FROM sapi
                                                        WHERE idsapi='$idsapi'";
                                                $rssire=$this->db->query($sql);
                                                if($rssire->num_rows()>0){
                                                    $rowsire=$rssire->row();
                                                    $idsire=$rowsire->idsire;
                                                    $nomorregistersire=$rowsire->nomorregistersire;
                                                    $tagsire=$rowsire->tagsire;
                                                    $namasire=$rowsire->namasire;
                                                    if($rowsire->tgllahirsire<>null)
                                                        $tgllahirsire=$this->fungsi->date_to_tanggal3($rowsire->tgllahirsire);
                                                    else
                                                        $tgllahirsire="";
                                                }
                                            }
                                            $milksire = $rowInduk->milksire;
                                            $fatsire = $rowInduk->fatsire;
                                            $proteinsire = $rowInduk->proteinsire;
                                        }else{
                                            $iddam="";
                                            $kodedam="";
                                            $nomorregisterinduk="";
                                            $tagdam="";
                                            $namadam="";
                                            $tgllahirdam="";
                                            $idsire="";
                                            $nomorregistersire="";
                                            $tagsire="";
                                            $namasire="";
                                            $tgllahirsire="";
                                            $milkdam ="";
                                            $fatdam ="";
                                            $proteindam ="";
                                            $milksire ="";
                                            $fatsire ="";
                                            $proteinsire ="";
                                        }
                                    ?>
                                     <!-- ========================================= SIRE ================================================================== -->
                                     <tr>
                                         <td class="text-right">1.</td>
                                         <td>Sire</td>
                                         <td><?php echo $nomorregistersire;?></td>
                                         <td><?php echo ($tagsire!=""?$tagsire:$idsire);?></td>
                                         <td><?php echo $namasire;?></td>
                                         <td class="text-center"><?php echo $tgllahirsire;?></td>
                                         <td class="text-center"><?php echo $milksire;?></td>
                                         <td class="text-center"><?php echo $fatsire;?></td>
                                         <td class="text-center"><?php echo $proteinsire;?></td>
                                         <td class='text-center'><button class="btn btn-sm btn-warning"
                                                 onclick="settetua('Sire','<?php echo $idsapi;?>')"><i
                                                     class="fas fa-pen"></i></button></td>
                                     </tr>
                                     <!-- ========================================= DAM ================================================================== -->
                                     <tr>
                                         <td class="text-right">2.</td>
                                         <td>Dam</td>
                                         <td><?php echo ($nomorregisterdam==""?$iddam:$nomorregisterdam);?></td>
                                         <td><?php echo ($tagdam!=""?$tagdam:$kodedam);?></td>
                                         <td><?php echo $namadam;?></td>
                                         <td class="text-center"><?php echo $tgllahirdam;?></td>
                                         <td class="text-center"><?php echo $milkdam;?></td>
                                         <td class="text-center"><?php echo $fatdam;?></td>
                                         <td class="text-center"><?php echo $proteindam;?></td>
                                         <td class='text-center'><button class="btn btn-sm btn-warning"
                                                 onclick="settetua('Dam','<?php echo $idsapi;?>')"><i
                                                     class="fas fa-pen"></i></button></td>
                                     </tr>

                                     <?php
                                    $dataTetua=$this->M_sapi->getInduk($idsire);
                                    //  echo "Query:".$this->db->last_query();

                                    if($dataTetua->num_rows()>0){
                                        $set=TRUE;
                                        $rowInduk=$dataTetua->row();
                                        $iddam1=$rowInduk->iddam;
                                        $nomorregisterinduk1=$rowInduk->nomorregisterdam;
                                        $tagdam1=$rowInduk->tagdam;
                                        $namadam1=$rowInduk->namadam;
                                        if($rowInduk->tgllahirdam<>null)
                                            $tgllahirdam1=$this->fungsi->date_to_tanggal3($rowInduk->tgllahirdam);
                                        else{
                                            $tgllahirdam1="";
                                        }
                                        $nomorregistersire1=$rowInduk->nomorregistersire;
                                        $idsire1=$rowInduk->idsire;
                                        $tagsire1=$rowInduk->tagsire;
                                        $namasire1=$rowInduk->namasire;
                                        if($rowInduk->tgllahirsire<>null)
                                            $tgllahirsire1=$this->fungsi->date_to_tanggal3($rowInduk->tgllahirsire);
                                        else    
                                            $tgllahirsire1="";
                                        $milk1 ="";
                                        $fat1 ="";
                                        $protein1 ="";
                                    }else{
                                        $set=TRUE;
                                        $iddam1="";
                                        $nomorregisterinduk1="";
                                        $tagdam1="";
                                        $namadam1="";
                                        $tgllahirdam1="";
                                        $idsire1="";
                                        $nomorregistersire1="";
                                        $tagsire1="";
                                        $namasire1="";
                                        $tgllahirsire1="";
                                        $milk1 ="";
                                        $fat1 ="";
                                        $protein1 ="";
                                    }
                                ?>

                                     <tr>
                                         <td style='text-align:right'>3.</td>
                                         <td> PGS</td>
                                         <td><?php echo $nomorregistersire1;?></td>
                                         <td><span id='idsire1' style='display:none'><?php echo $idsire1;?></span>
                                             <span id='tagsire1'><?php echo ($tagsire1!=""?$tagsire1:$idsire1);?></span>
                                         </td>
                                         <td id='namasire1'><?php echo $namasire1;?></td>
                                         <td id='tgllahirsire1' style='text-align:center'>
                                             <?php echo $tgllahirsire1;?></td>
                                         <td class="text-center"><?php echo $milk1;?></td>
                                         <td class="text-center"><?php echo $fat1;?></td>
                                         <td class="text-center"><?php echo $protein1;?></td>
                                         <td class='text-center'><button class="btn btn-sm btn-warning"
                                                 onclick="settetua('PGS','<?php echo $idsire;?>')"><i
                                                     class="fas fa-pen"></i></button></td>
                                     </tr>
                                     <tr>
                                         <td style='text-align:right'>4.</td>
                                         <td> PGD</td>
                                         <td><?php echo $nomorregisterinduk1;?></td>
                                         <td id='tagdam1'><?php echo ($tagdam1!=""?$tagdam1:$iddam1);?></td>
                                         <td id='namadam1'><?php echo $namadam1;?></td>
                                         <td id='tgllahirdam1' style='text-align:center'><?php echo $tgllahirdam1;?>
                                         </td>
                                         <td class="text-center"><?php echo $milk1;?></td>
                                         <td class="text-center"><?php echo $fat1;?></td>
                                         <td class="text-center"><?php echo $protein1;?></td>
                                         <td class='text-center'><button class="btn btn-sm btn-warning"
                                                 onclick="settetua('PGD','<?php echo $idsire;?>')"><i
                                                     class="fas fa-pen"></i></button></td>
                                     </tr>
                                     <?php
                                    // MGS dan MGD
                                    $dataTetua2=$this->M_sapi->getInduk($iddam);
                                    
                                    // echo $this->db->last_query();
                                    if($dataTetua2->num_rows()>0){
                                        $set=TRUE;
                                        $rowInduk=$dataTetua2->row();
                                        // var_dump($rowInduk);
                                        $iddam2=$rowInduk->iddam;
                                        $nomorregisterdam2=$rowInduk->nomorregisterdam;
                                        $tagdam2=$rowInduk->tagdam;
                                        $namadam2=$rowInduk->namadam;
                                        
                                        if($rowInduk->tgllahirdam<>null)
                                            $tgllahirdam2=$this->fungsi->date_to_tanggal3($rowInduk->tgllahirdam);
                                        else
                                            $tgllahirdam2="";
                                        $nomorregistersire2=$rowInduk->nomorregistersire;
                                        $idsire2=$rowInduk->idsire;
                                        $tagsire2=$rowInduk->tagsire;
                                        $namasire2=$rowInduk->namasire;
                                        if($rowInduk->tgllahirsire<>null)
                                            $tgllahirsire2=$this->fungsi->date_to_tanggal3($rowInduk->tgllahirsire);
                                        else
                                            $tgllahirsire2="";
                                        $milk2 ="";
                                        $fat2 ="";
                                        $protein2 ="";
                                    }else{
                                        $set=TRUE;
                                        $iddam2="";
                                        $nomorregisterdam2="";
                                        $tagdam2="";
                                        $namadam2="";
                                        $tgllahirdam2="";
                                        $idsire2="";
                                        $nomorregistersire2="";
                                        $tagsire2="";
                                        $namasire2="";
                                        $tgllahirsire2="";
                                        $milk2 ="";
                                        $fat2 ="";
                                        $protein2 ="";
                                    }
                                ?>

                                     <tr>
                                         <td style='text-align:right'>5.</td>
                                         <td> MGS</td>
                                         <td><?php echo $nomorregistersire2;?></td>
                                         <td><span id='idsire2' style='display:none'><?php echo $idsire2;?></span>
                                             <span id='tagsire2'><?php echo ($tagsire2!=""?$tagsire2:$idsire2);?></span>
                                         </td>
                                         <td id='namasire2'><?php echo $namasire2;?></td>
                                         <td id='tgllahirsire2' style='text-align:center'>
                                             <?php echo $tgllahirsire2;?></td>
                                         <td class="text-center"><?php echo $milk2;?></td>
                                         <td class="text-center"><?php echo $fat2;?></td>
                                         <td class="text-center"><?php echo $protein2;?></td>
                                         <td class='text-center'><button class="btn btn-sm btn-warning"
                                                 onclick="settetua('MGS','<?php echo $iddam;?>')"><i
                                                     class="fas fa-pen"></i></button></td>
                                     </tr>
                                     <tr>
                                         <td style='text-align:right'>6.</td>
                                         <td> MGD</td>
                                         <td><?php echo $nomorregisterdam2;?></td>
                                         <td id='tagdam2'><?php echo ($tagdam2!=""?$tagdam2:$iddam2);?></td>
                                         <td id='namadam2'><?php echo $namadam2;?></td>
                                         <td id='tgllahirdam2' style='text-align:center'><?php echo $tgllahirdam2;?>
                                         </td>
                                         <td class="text-center"><?php echo $milk2;?></td>
                                         <td class="text-center"><?php echo $fat2;?></td>
                                         <td class="text-center"><?php echo $protein2;?></td>
                                         <td class='text-center'><button class="btn btn-sm btn-warning"
                                                 onclick="settetua('MGD','<?php echo $iddam;?>')"><i
                                                     class="fas fa-pen"></i></button></td>
                                     </tr>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-primary">
                         <div class="card-header">
                             <h5 class="m-0 text-dark">C. Pertumbuhan Bobot Badan (kg)</h5>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-stripped table-bordered" id='tblpertumbuhan'>
                                 <thead>
                                     <tr>
                                         <th style='width:50px;'>#</th>
                                         <th style='text-align:center;'>Tgl. Penimbangan</th>
                                         <th style='text-align:center;'>Bobot (Kg)</th>
                                     </tr>
                                 </thead>

                                 <tbody>
                                     <?php
                                            $i=0;
                                            foreach($pertumbuhan->result() as $row){
                                                $i++;
                                                ?>
                                     <tr>
                                         <td class='text-right'><?php echo $i;?></td>
                                         <td class='text-center'><?php echo substr($row->tanggal,0,10);?></td>
                                         <td class='text-right'><?php echo $row->bobotkg;?></td>
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
             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-primary card-outline">
                         <div class="card-header">
                             <h3 class="card-title">
                                 <i class="far fa-chart-bar"></i>
                                 Grafik Pertumbuhan
                             </h3>

                             <div class="card-tools">

                             </div>
                         </div>
                         <div class="card-body">
                             <!-- <div id="line-chart" style="height: 300px;"></div> -->
                             <div id="pertumbuhancontainer" style="min-width:100%; height: 400px; margin: 0 auto"></div>
                         </div>
                         <!-- /.card-body-->
                     </div>
                 </div>
             </div>

             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-primary">
                         <div class="card-header">
                             <h5 class="m-0 text-dark">D. Data Kesehatan</h5>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-stripped table-bordered" id="tblkesehatan">
                                 <thead>
                                     <tr>
                                         <th style='width:50px;'>#</th>
                                         <th style='text-align:center;'>Tanggal</th>
                                         <th style='text-align:center;'>Kategori Penyakit</th>
                                         <th style='text-align:center;'>Diagnosa</th>
                                         <th style='text-align:center;'>Keterangan</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                            $i=0;
                                            foreach($kesehatan->result() as $row){
                                                $i++;
                                                ?>
                                     <tr>
                                         <td class='text-right'><?php echo $i;?></td>
                                         <td class='text-center'><?php echo substr($row->tanggal,0,10);?></td>
                                         <td><?php echo $row->kategori;?></td>
                                         <td><?php echo $row->diagnosa;?></td>
                                         <td><?php echo $row->keterangan;?></td>
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

             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-primary">
                         <div class="card-header">
                             <h5 class="m-0 text-dark">E. Data Reproduksi</h5>
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-stripped table-bordered" id="tblreproduksi">
                                 <thead>
                                     <tr>
                                         <th style='width:50px;'>#</th>
                                         <th style='text-align:center;'>Tanggal</th>
                                         <th style='text-align:center;'>Laktasi Ke</th>
                                         <th style='text-align:center;'>IB Ke</th>
                                         <th style='text-align:center;'>Kode Semen</th>
                                         <th style='text-align:center;'>Tgl. PKB</th>
                                         <th style='text-align:center;'>Tgl. Melahirkan</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                            $i=0;
                                            foreach($reproduksi->result() as $row){
                                                $i++;
                                                ?>
                                     <tr>
                                         <td class='text-right'><?php echo $i;?></td>
                                         <td class='text-center'><?php echo substr($row->tanggal,0,10);?></td>
                                         <td class='text-center'><?php echo $row->xlaktasi;?></td>
                                         <td class='text-center'><?php echo $row->ibke;?></td>
                                         <td><?php echo $row->kodesemen;?></td>
                                         <td class='text-center'><?php echo $row->tglpkb;?></td>
                                         <td class='text-center'><?php echo $row->tglmelahirkan;?></td>
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

             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-primary">
                         <div class="card-header">
                             <h5 class="m-0 text-dark">F. Data Produksi Susu</h5>
                         </div>
                         <div class="card-body table-responsive">
                             <h5>Analisa Produksi</h5>
                             <table class="table table-stripped table-bordered" id="tblanalisaproduksi">
                                 <thead>
                                 <tr>
                                         <th style='text-align:center;width:20px;'>#</th>
                                         <th style='text-align:center;' >XLaktasi</th> 
                                         <th style='text-align:center;' >Bulan Ke</th> 
                                         <th style='text-align:center;' >Jml Susu</th> 
                                         <th style='text-align:center;' >Tanggal Produksi</th>
                                         <th style='text-align:center;' >Produksi Nyata</th>
                                         <th style='text-align:center;' >JHP</th> 
                                         
                                         <th style='text-align:center;'  >Prod. Terkoreksi</th>
                                         
                                     </tr>
                                    
                                 </thead>
                                 <tbody>

                                 </tbody>
                             </table>
                             
                             <h5>Per Laktasi</h5>
                             <table class="table table-stripped table-bordered" id="tblproduksiperlaktasi">
                                 <thead>
                                     <tr>
                                         <th style='width:50px;'>#</th>
                                         <th style='text-align:center;'>Laktasi Ke</th>
                                         <!-- <th style='text-align:center;'>Jml. Produksi</th> -->
                                         <th style='text-align:center;'>Min. Produksi</th>
                                         <th style='text-align:center;'>Max. Produksi</th>
                                         <th style='text-align:center;'>Produksi Nyata</th>
                                         <th style='text-align:center;'>JHP</th>
                                         <th style='text-align:center;'>Terkoreksi</th>
                                     </tr>
                                 </thead>
                                 <tbody>

                                 </tbody>
                             </table>

                             <h5>Per Tanggal Produksi</h5>
                             <table class="table table-stripped table-bordered" id="tblproduksipertanggal">
                                 <thead>
                                     <tr>
                                         <th style='width:50px;'>#</th>
                                         <th style='text-align:center;'>Tanggal</th>
                                         <th style='text-align:center;'>Pagi</th>
                                         <th style='text-align:center;'>Sore</th>
                                     </tr>
                                 </thead>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-primary card-outline">
                         <div class="card-header">
                             <h3 class="card-title">
                                 <i class="far fa-chart-bar"></i>
                                 Grafik Produksi Susu Per Laktasi
                             </h3>

                             <div class="card-tools">

                             </div>
                         </div>
                         <div class="card-body">
                             <!-- <div id="line-chart" style="height: 300px;"></div> -->
                             <div id="susucontainer" style="min-width:100%; height: 400px; margin: 0 auto"></div>
                         </div>
                         <!-- /.card-body-->
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-primary card-outline">
                         <div class="card-header">
                             <h3 class="card-title">
                                 <i class="far fa-chart-bar"></i>
                                 Grafik Produksi Susu Per Tanggal
                             </h3>

                             <div class="card-tools">

                             </div>
                         </div>
                         <div class="card-body">
                             <!-- <div id="line-chart" style="height: 300px;"></div> -->
                             <div id="susucontainer1" style="min-width:100%; height: 400px; margin: 0 auto"></div>
                         </div>
                         <!-- /.card-body-->
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
                 <form action="<?=site_url('/identifikasi/sapi/hapus'); ?>" method="post">
                     <input type="hidden" name="id" id="idHapus" required>
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


 <div class="modal fade" id="Modaltetuajantan" tabindex="-1" role="dialog" aria-labelledby="judulmodal"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Set Tetua (<span id='jenistetuajantan'></span>)</h5>
             </div>
             <form action="<?=site_url('/identifikasi/sapi/simpantetua'); ?>" method="post">
                 <div class="modal-body">
                     <input type="hidden" name="id" id="idTetuaJantan" required>
                     <input type="hidden" name='idsapi' id='idsapitetuajantan'>
                     <div class="row">
                         <div class="col-md-8">

                             <input type="hidden" name="jenis" value="Sire" required>

                             <div class="form-group">
                                 <label for="nomorregister">No. Register</label>
                                 <input type="text" name='nomorregister' id='nomorregistertetuajantan'
                                     class='form-control'>
                             </div>

                             <div class="form-group">
                                 <label for="tagsapi">No. Tag</label>
                                 <input type="text" name='tagsapi' id='tagsapitetuajantan' class='form-control'>

                             </div>
                             <div class="form-group">
                                 <label for="namasapi">Nama Tetua</label>
                                 <input type="text" name='namasapi' id='namasapitetuajantan' class='form-control'>
                             </div>
                             <div class="form-group">
                                 <label for="tgllahir">Tanggal Lahir</label>
                                 <input type="date" name='tgllahir' id='tgllahirtetuajantan' class='form-control'>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label for="milk">Milk</label>
                                 <input type="text" name='milk' id='milksire' class='form-control'>
                             </div>
                             <div class="form-group">
                                 <label for="fat">Fat</label>
                                 <input type="text" name='fat' id='fatsire' class='form-control'>
                             </div>
                             <div class="form-group">
                                 <label for="protein">Protein</label>
                                 <input type="text" name='protein' id='proteinsire' class='form-control'>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                     <button type="submit" class="btn btn-primary">Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <div class="modal fade" id="Modaltetuainduk" tabindex="-1" role="dialog" aria-labelledby="judulmodal"
     aria-hidden="true">

     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="judulmodal">Set Tetua (<span id='jenistetuainduk'></span>)</h5>
             </div>
             <form action="<?=site_url('/identifikasi/sapi/simpantetua'); ?>" method="post">
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-8">
                             <input type="hidden" name="id" id="idTetuaBetina" required>
                             <input type="hidden" name="jenis" value="Dam" required>

                             <div class="form-group">
                                 <label for="nomorregister">No. Register</label>
                                 <input type="text" name='nomorregister' id='nomorregistertetuainduk'
                                     class='form-control'>
                             </div>

                             <div class="form-group">
                                 <label for="tagsapi">No. Tag</label>
                                 <input type="text" name='tagsapi' id='tagsapitetuainduk' class='form-control'>
                                 <input type="hidden" name='idsapi' id='idsapitetuainduk' class='form-control'>
                             </div>
                             <div class="form-group">
                                 <label for="namasapi">Nama Tetua</label>
                                 <input type="text" name='namasapi' id='namasapitetuainduk' class='form-control'>
                             </div>
                             <div class="form-group">
                                 <label for="tgllahir">Tanggal Lahir</label>
                                 <input type="date" name='tgllahir' id='tgllahirtetuainduk' class='form-control'>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-group">
                                 <label for="milk">Milk</label>
                                 <input type="text" name='milk' id='milkdam' class='form-control'>
                             </div>
                             <div class="form-group">
                                 <label for="fat">Fat</label>
                                 <input type="text" name='fat' id='fatdam' class='form-control'>
                             </div>
                             <div class="form-group">
                                 <label for="protein">Protein</label>
                                 <input type="text" name='protein' id='proteindam' class='form-control'>
                             </div>
                         </div>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                     <button type="submit" class="btn btn-primary">Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>