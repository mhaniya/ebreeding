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
                    <form action="<?php echo '/identifikasi/pengguna/update';?>" method="post">
                    <input type="hidden" name="user_id" value="<?=$rs->user_id; ?>">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="user_nama" id="user_nama" class="form-control" value="<?php echo $rs->user_nama; ?>">
                            <?= form_error('user_nama','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="user_username" id="user_username" class="form-control" value="<?php echo $rs->user_username; ?>">
                            <?= form_error('user_username','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <?php echo $this->simpliparse->build_select_common_edit('level_id',$level,'level_id','level_nama',':: Pilih Level Pengguna ::',$rs->level_id,'class=form-control');?>
                        </div>
                        <div class="form-group">
                            <label for="level">Pemilik</label>
                            <?php echo $this->simpliparse->build_select_common_edit('kodekoperasi',$koperasi,'kodekoperasi','namakoperasi',':: Pilih Pemilik ::',$rs->kodekoperasi,'class=form-control');?>
                        </div>
                        <div class="form-group">
                            <label for="level">Status</label>
                            <input type='radio' name='status_user' value='1' checked>Aktif
                            <input type='radio' name='status_user' value='0'>Tidak Aktif
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?=site_url('/identifikasi/Petugas'); ?>" class="btn btn-danger">Batal</a>
                    </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  

  


