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
                    <form action="<?php echo '/identifikasi/pengguna/updatepass';?>" method="post">
                    <input type="hidden" name="user_id" value="<?=$rs->user_id; ?>">
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
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?='/identifikasi/pengguna'; ?>" class="btn btn-danger">Batal</a>
                    </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  

  


