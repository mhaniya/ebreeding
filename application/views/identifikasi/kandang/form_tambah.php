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

    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                    <form action="<?php echo '/identifikasi/kandang/save';?>" method="post">
                        <div class="form-group">
                            <label for="nama">Nama Kandang</label>
                            <input type="text" name="namakandang" id="namakandang" class="form-control" value="<?=set_value('namakandang'); ?>">
                            <?= form_error('namakandang','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="username">Lokasi Kandang</label>
                            <input type="text" name="lokasikandang" id="lokasikandang" class="form-control" value="<?=set_value('lokasikandang'); ?>">
                            <?= form_error('lokasikandang','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="kapasitas">Kapasitas</label>
                            <input type="kapasitas" name="kapasitas" id="kapasitas" class="form-control" value="<?=set_value('kapasitas'); ?>">
                            <?= form_error('kapasitas','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="kodepropinsi">Nama Farm/Peternakan</label> 
                            <?php echo $this->simpliparse->build_select_common_edit('idfarm',$farm,'idfarm','namafarm',':: Pilih Farm/Peternakan ::',$idfarm,'class=form-control');?>
                            <?= form_error('idfarm','<small class="text-danger">','</small>'); ?>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?=site_url('/identifikasi/kandang'); ?>" class="btn btn-danger">Batal</a>
                    </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  

  


