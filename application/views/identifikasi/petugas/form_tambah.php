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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <form action="<?php echo '/identifikasi/pengguna/save';?>" method="post">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="user_nama" id="user_nama" class="form-control" value="<?=set_value('user_nama'); ?>">
                            <?= form_error('user_nama','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="user_username" id="user_username" class="form-control" value="<?=set_value('user_username'); ?>">
                            <?= form_error('user_username','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="pass1">Password</label>
                            <input type="password" name="pass1" id="pass1" class="form-control" value="<?=set_value('pass1'); ?>">
                            <?= form_error('pass1','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="pass2">Retype Password</label>
                            <input type="password" name="pass2" id="pass2" class="form-control">
                            <?= form_error('pass2','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <?php echo $this->simpliparse->build_select_common_edit('level_id',$level,'level_id','level_nama',':: Pilih Level Pengguna ::',set_value('level_id'),'class=form-control');?>
                        </div>
                        <div class="form-group">
                            <label for="level">Pemilik</label>
                            <?php echo $this->simpliparse->build_select_common_edit('kodekoperasi',$koperasi,'kodekoperasi','namakoperasi',':: Pilih Pemilik ::',set_value('kodekoperasi'),'class=form-control');?>
                        </div>
                        <div class="form-group">
                            <label for="level">Status</label>
                            <input type='radio' name='status_user' value='1' <?php echo (set_value('status_user')=='1'?'checked':'');?>>Aktif
                            <input type='radio' name='status_user' value='0' <?php echo (set_value('status_user')=='0'?'checked':'');?>>Tidak Aktif
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?=site_url('/Pengguna'); ?>" class="btn btn-danger">Batal</a>
                    </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  

  


