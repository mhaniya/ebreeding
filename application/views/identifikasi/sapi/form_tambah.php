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
            <form action="<?php echo '/identifikasi/sapi/save';?>" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="tagsapi">No. Tag</label>
                                            <input type="text" name="tagsapi" id="tagsapi" class="form-control"
                                                value="<?=set_value('tagsapi'); ?>">
                                            <?= form_error('tagsapi','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="nomorregister">Nomor Register</label>
                                            <input type="text" name="nomorregister" id="nomorregister"
                                                class="form-control" value="AUTO">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="kelamin">Jenis Kelamin</label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kelaminBetina"
                                                    name="kelamin" value='Betina' checked>
                                                <label for="kelaminBetina" class="custom-control-label">Betina</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kelaminJantan"
                                                    name="kelamin" value='Jantan'>
                                                <label for="kelaminJantan" class="custom-control-label">Jantan</label>
                                            </div>
                                            <?= form_error('kelamin','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipesapi">Hasil Perkawinan</label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="hasilIB"
                                                    name="tipesapi" value='IB' checked>
                                                <label for="hasilIB" class="custom-control-label">IB</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="hasilET"
                                                    name="tipesapi" value='ET'>
                                                <label for="hasilET" class="custom-control-label">ET</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="hasilAlam"
                                                    name="tipesapi" value='Alam'>
                                                <label for="hasilAlam" class="custom-control-label">Alam</label>
                                            </div>
                                            <?= form_error('tipesapi','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="kategorisapi">Kategori Sapi</label>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" name="sapibalai" type="checkbox"
                                                    id="kategoriBalai" value="Balai" checked>
                                                <label for="kategoriBalai" class="custom-control-label">Balai</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" name="sapiuzur" type="checkbox"
                                                    id="kategoriUzur" value="Uzur">
                                                <label for="kategoriUzur" class="custom-control-label">Uzur</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" name="sapivbc" type="checkbox"
                                                    id="kategoriVBC" value="VBC">
                                                <label for="kategoriVBC" class="custom-control-label">VBC</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namasapi">Nama</label>
                                    <input type="text" name="namasapi" id="namasapi" class="form-control"
                                        value="<?=set_value('namasapi'); ?>">
                                    <?= form_error('namasapi','<small class="text-danger">','</small>'); ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tgllahir">Tgl. Lahir</label>
                                            <input type="date" name="tgllahir" id="tgllahir" class="form-control"
                                                value="<?=set_value('tgllahir'); ?>">
                                            <?= form_error('tgllahir','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bobotlahir">Bobot Lahir</label>
                                            <input type="text" name="bobotlahir" id="bobotlahir" class="form-control"
                                                value="<?=set_value('bobotlahir'); ?>">
                                            <?= form_error('bobotlahir','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bobotlahir">Asal Ternak</label>
                                            <?php
                                              echo $this->simpliparse->build_select_common_edit('idasal',$asal,'idasal','namaasal',':: Pilih Asal ::',set_value('idasal'),"class='form-control'");
                                            ?>
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
                                <div class="form-group">
                                    <label for="kodepropinsi">Propinsi</label>
                                    <?php echo $this->simpliparse->build_select_common_edit('kodepropinsi',$propinsi,'kodepropinsi','namapropinsi',':: Pilih Propinsi ::',$kodepropinsi,"class='form-control'"); ?>
                                    <?= form_error('kodepropinsi','<small class="text-danger">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="kodekabupaten">Kabupaten</label>
                                    <?php echo $this->simpliparse->build_select_common_edit('kodekabupaten',$kabupaten,'kodekabupaten','namakabupaten',':: Pilih Kabupaten ::',$kodekabupaten,"class='form-control'"); ?>
                                    <?= form_error('kodekabupaten','<small class="text-danger">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="kodekecamatan">Kecamatan</label>
                                    <?php echo $this->simpliparse->build_select_common_edit('kodekecamatan',$kecamatan,'kodekecamatan','namakecamatan',':: Pilih Kecamatan ::',$kodekecamatan,"class='form-control'"); ?>
                                    <?= form_error('kodekecamatan','<small class="text-danger">','</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="idfarm">Peternakan</label>
                                    <?php echo $this->simpliparse->build_select_common_edit('idfarm',$farm,'idfarm','namafarm',':: Pilih Peternakan ::',$idfarm,"class='form-control'"); ?>
                                    <?= form_error('idfarm','<small class="text-danger">','</small>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="<?=site_url('/identifikasi/sapi'); ?>" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</div>