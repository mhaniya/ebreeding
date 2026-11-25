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
        $idsapi=$data->idsapi;
        $tagsapi=$data->tagsapi;
        $nomorregister=$data->nomorregister;
        $kelamin=$data->kelamin;
        $tipesapi=$data->tipesapi;
        $is_balai=$data->is_balai;
        $is_uzur=$data->is_uzur;
        $is_vbc=$data->is_vbc;
        $namasapi=$data->namasapi;
        $status=$data->status;
        $tgllahir=substr($data->tgllahir,0,10);
        $bobotlahir=$data->bobotlahir;
        $namaasal=$data->namaasal;
        $kodepropinsi=$data->kodepropinsi;
        $kodekabupaten=$data->kodekabupaten;
        $kodekecamatan=$data->kodekecamatan;
        $idasal=$data->idasal;
        $idfarm=$data->idfarm;
      }else{
        $idsapi="";
        $tagsapi="";
        $nomorregister="AUTO";
        $kelamin="";
        $tipesapi="";
        $is_balai="";
        $is_uzur="";
        $is_vbc="";
        $namasapi="";
        $status="";
        $tgllahir="";
        $bobotlahir="";
        $namaasal="";
        $kodepropinsi="";
        $kodekabupaten="";
        $kodekecamatan="";
        $idasal="";
        $idfarm="";
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
                                            <label for="tagsapi">No. Tag</label>
                                            <input type="hidden" name="idsapi" id="idsapi" value="<?php echo $idsapi;?>">
                                            <input type="text" name="tagsapi" id="tagsapi" class="form-control"
                                                value="<?=$tagsapi; ?>">
                                            <?= form_error('tagsapi','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="nomorregister">Nomor Register</label>
                                            <input type="text" name="nomorregister" id="nomorregister"
                                                class="form-control" value="<?php echo $nomorregister;?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tipesapi">Hasil Perkawinan</label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="hasilIB"
                                                    name="tipesapi" value='IB' <?php echo ($tipesapi=="IB"?"CHECKED":"");?>>
                                                <label for="hasilIB" class="custom-control-label">IB</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="hasilET"
                                                    name="tipesapi" value='ET' <?php echo ($tipesapi=="ET"?"CHECKED":"");?>>
                                                <label for="hasilET" class="custom-control-label">ET</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="hasilAlam"
                                                    name="tipesapi" value='Alam' <?php echo ($tipesapi=="Alam"?"CHECKED":"");?>>
                                                <label for="hasilAlam" class="custom-control-label">Alam</label>
                                            </div>
                                            <?= form_error('tipesapi','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="kategorisapi">Kategori</label>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" name="sapibalai" type="checkbox"
                                                    id="kategoriBalai" value="Balai" <?php echo ($is_balai?"CHECKED":"");?>>
                                                <label for="kategoriBalai" class="custom-control-label">Balai</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" name="sapiuzur" type="checkbox"
                                                    id="kategoriUzur" value="Uzur" <?php echo ($is_uzur?"CHECKED":"");?>>
                                                <label for="kategoriUzur" class="custom-control-label">Uzur</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" name="sapivbc" type="checkbox"
                                                    id="kategoriVBC" value="VBC" <?php echo ($is_vbc?"CHECKED":"");?>>
                                                <label for="kategoriVBC" class="custom-control-label">VBC</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="kategorisapi">Status</label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" name="status" type="radio"
                                                    id="statushidup" value="hidup" <?php echo ($status=="hidup"?"CHECKED":"");?>>
                                                <label for="statushidup" class="custom-control-label">Hidup</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" name="status" type="radio"
                                                    id="statusmati" value="Mati" <?php echo ($status=="Mati"?"CHECKED":"");?>>
                                                <label for="statusmati" class="custom-control-label">Mati</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" name="status" type="radio"
                                                    id="statusafkir" value="afkir" <?php echo ($status=="afkir"?"CHECKED":"");?>>
                                                <label for="statusafkir" class="custom-control-label">Afkir</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" name="status" type="radio"
                                                    id="statusdijual" value="dijual" <?php echo ($status=="dijual"?"CHECKED":"");?>>
                                                <label for="statusdijual" class="custom-control-label">Dijual</label>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namasapi">Nama</label>
                                    <input type="text" name="namasapi" id="namasapi" class="form-control"
                                        value="<?=$namasapi; ?>">
                                    <?= form_error('namasapi','<small class="text-danger">','</small>'); ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tgllahir">Tgl. Lahir</label>
                                            <input type="date" name="tgllahir" id="tgllahir" class="form-control"
                                                value="<?=$tgllahir; ?>">
                                            <?= form_error('tgllahir','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bobotlahir">Bobot Lahir</label>
                                            <input type="text" name="bobotlahir" id="bobotlahir" class="form-control"
                                                value="<?=$bobotlahir; ?>">
                                            <?= form_error('bobotlahir','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bobotlahir">Asal Ternak</label>
                                            <?php
                                              echo $this->simpliparse->build_select_common_edit('idasal',$asal,'idasal','namaasal',':: Pilih Asal ::',$idasal,"class='form-control'");
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