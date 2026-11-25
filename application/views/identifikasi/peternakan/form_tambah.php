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
                    <form action="<?php echo '/identifikasi/peternakan/save';?>" method="post">
                        <div class="form-group">
                            <label for="nama">Nama Farm/Peternakan</label>
                            <input type="text" name="namafarm" id="namafarm" class="form-control" value="<?=set_value('namafarm'); ?>">
                            <?= form_error('namafarm','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="username">Nama Peternak</label>
                            <input type="text" name="namapeternak" id="namapeternak" class="form-control" value="<?=set_value('namapeternak'); ?>">
                            <?= form_error('namapeternak','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="alamatfarm">Alamat Farm/Peternakan</label>
                            <input type="alamatfarm" name="alamatfarm" id="alamatfarm" class="form-control" value="<?=set_value('alamatfarm'); ?>">
                            <?= form_error('alamatfarm','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="kodepropinsi">Propinsi</label>
                            <input type='hidden' name='kodepropinsi' value='<?php echo $kodepropinsi;?>'>
                            <?php echo $this->simpliparse->build_select_common_edit('kdpropinsi',$propinsi,'kodepropinsi','namapropinsi',':: Pilih Propinsi ::',$kodepropinsi,'class=form-control disabled');?>
                        </div>
                        <div class="form-group">
                            <label for="kodekabupaten">Kabupaten</label>
                            <input type='hidden' name='kodekabupaten' value='<?php echo $kodekabupaten;?>'>
                            <?php echo $this->simpliparse->build_select_common_edit('kdkabupaten',$kabupaten,'kodekabupaten','namakabupaten',':: Pilih Kabupaten ::',$kodekabupaten,'class=form-control disabled');?>
                        </div>
                        <div class="form-group">
                            <label for="level">Kecamatan</label>
                            <input type='hidden' name='kodekecamatan' value='<?php echo $kodekecamatan;?>'>
                            <?php echo $this->simpliparse->build_select_common_edit('kdkecamatan',$kecamatan,'kodekecamatan','namakecamatan',':: Pilih Kecamatan ::',$kodekecamatan,'class=form-control disabled');?>
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
  

  


