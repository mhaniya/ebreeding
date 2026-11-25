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
      }else{
        $eartag="";
        $rumpun="";
        $kelamin="";
        $tgllahir="";
        
      }
    
    ?>
    <div class="content">
        <div class="container-fluid">
            <form action="<?php echo '/identifikasi/sapi/update';?>" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="eartag">No. Tag</label>
                                            <input type="text" name="eartag" id="eartag" class="form-control" value="<?=$eartag; ?>">
                                            <?= form_error('tagsapi','<small class="text-danger">','</small>'); ?>
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
                                    <div class="col-md-4">
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
                                    <div class="form-group">
                                        <label for="tgllahir">Tgl. Lahir</label>
                                        <input type="date" name="tgllahir" id="tgllahir" class="form-control" value="<?=$tgllahir; ?>">
                                        <?= form_error('tgllahir','<small class="text-danger">','</small>'); ?>
                                    </div>
                                </div>
                                  
                            </div>
                        </div>
                    </div>
                    
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?=site_url('/identifikasi/kambing'); ?>" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</div>