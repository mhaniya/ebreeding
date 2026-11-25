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
                    <form action="<?php echo '/identifikasi/peternakan/update';?>" method="post">
                    <input type="hidden" name="user_id" value="<?=$rs->user_id; ?>">
                        <div class="form-group">
                            <label for="nama">ID Farm</label>
                            <input type="text" name="idfarm" id="idfarm" class="form-control" value="<?php echo $rs->idfarm; ?>" readonly>
                            <?= form_error('idfarm','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Farm</label>
                            <input type="text" name="namafarm" id="namafarm" class="form-control" value="<?php echo $rs->namafarm; ?>">
                            <?= form_error('namafarm','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="username">Nama Peternak</label>
                            <input type="text" name="namapeternak" id="namapeternak" class="form-control" value="<?php echo $rs->namapeternak; ?>">
                            <?= form_error('namapeternak','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="username">Alamat Peternak</label>
                            <input type="text" name="alamatfarm" id="alamatfarm" class="form-control" value="<?php echo $rs->alamatfarm; ?>">
                            <?= form_error('alamatfarm','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="level">Propinsi</label>
                            <?php echo $this->simpliparse->build_select_common_edit('kodepropinsi',$propinsi,'kodepropinsi','namapropinsi',':: Pilih Propinsi ::',$rs->kodepropinsi,'class=form-control');?>
                        </div>
                        <div class="form-group">
                            <label for="level">Kabupaten</label>
                            <?php echo $this->simpliparse->build_select_common_edit('kodekabupaten',$kabupaten,'kodekabupaten','namakabupaten',':: Pilih Kabupaten ::',$rs->kodekabupaten,'class=form-control');?>
                        </div>
                        <div class="form-group">
                            <label for="level">Kabupaten</label>
                            <?php echo $this->simpliparse->build_select_common_edit('kodekecamatan',$kecamatan,'kodekecamatan','namakecamatan',':: Pilih Kecamatan ::',$rs->kodekecamatan,'class=form-control');?>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?='/identifikasi/peternakan'; ?>" class="btn btn-danger">Batal</a>
                    </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  

  


