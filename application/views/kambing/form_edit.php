<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?=$judul;?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?=$judul; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php
      if($rs->num_rows()>0){
        $data=$rs->row();
        $eartag=$data->eartag;
        $rumpun=$data->rumpun;
        $kelamin=$data->kelamin;
        $tgllahir=$data->tgllahir;
        $bobotlahir=$data->bobotlahir;
        $taginduk=$data->taginduk;
        $tagindukjantan=$data->tagindukjantan;
        
      }else{
        $eartag="";
        $rumpun="";
        $kelamin="";
        $tgllahir="";
        $bobotlahir ="";
        $taginduk   ="";
        $tagindukjantan ="";
      }
    
    ?>
    <div class="content">
        <div class="container-fluid">
            <form action="<?php echo '/kambing/update';?>" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="eartag">No. Tag</label>
                                            <input type="hidden" name="id" id="id" value="<?=$eartag; ?>">
                                            <input type="text" name="eartag" id="eartag" class="form-control" value="<?=$eartag; ?>">
                                            <?= form_error('tagsapi','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipesapi">Rumpun</label>
                                            <?php
                                                $sql="SELECT rumpun FROM kambing GROUP BY rumpun";
                                                $rs_rumpun=$this->db->query($sql);
                                                echo $this->simpliparse->build_select_common_edit('rumpun',$rs_rumpun,'rumpun','rumpun',':: Pilih Rumpun ::',$rumpun,'class="form-control"');
                                            ?>
                                            <?= form_error('tipesapi','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="kelamin">Jenis Kelamin</label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kelaminBetina"
                                                    name="kelamin" value='Betina' <?php echo ($kelamin=="Betina"?"CHECKED":"");?>>
                                                <label for="kelaminBetina" class="custom-control-label">Betina</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kelaminJantan"
                                                    name="kelamin" value='Jantan' <?php echo ($kelamin=="Jantan"?"CHECKED":"");?>>
                                                <label for="kelaminJantan" class="custom-control-label">Jantan</label>
                                            </div>
                                            <?= form_error('kelamin','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tgllahir">Tgl. Lahir</label>
                                        <input type="date" name="tgllahir" id="tgllahir" class="form-control" value="<?=$tgllahir; ?>">
                                        <?= form_error('tgllahir','<small class="text-danger">','</small>'); ?>
                                    </div>
                                    </div>
                                    <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tgllahir">Bobot Lahir</label>
                                        <input type="number" name="bobotlahir" id="bobotlahir" class="form-control" value="<?=$bobotlahir; ?>">
                                        <?= form_error('bobotlahir','<small class="text-danger">','</small>'); ?>
                                    </div>
                                    </div>
                                </div>
                                  
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="taginduk">Tag Induk</label>
                                            <input type="text" name='taginduk' id='taginduk' class="form-control" value="<?=$taginduk; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tagindukjantan">Tag Induk Jantan</label>
                                            <input type="text" name='tagindukjantan' id='tagindukjantan' class="form-control"
                                            value="<?=$tagindukjantan?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="taginduk">Foto</label>
                                            <img src="<?php echo base_url();?>assets/images/upload/foto/kambing/<?= $eartag;?>.jpg" name="foto" id="foto" alt="" style="width:100%;height:200px;">
                                            <div id="kotakUpload"></div>
                                            <div style="padding:10px;">
                                            <a class="btn btn-warning" id='btnupload'>Upload</a>
                                            <input type="file" name="file" id="file" onchange="preview_image(event)" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?=site_url('/kambing'); ?>" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</div>