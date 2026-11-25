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
            <form action="<?php echo '/kambing/save';?>" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="eartag">Eartag. Tag</label>
                                            <input type="text" name="eartag" id="eartag" class="form-control"
                                                value="<?=set_value('eartag'); ?>">
                                            <?= form_error('eartag','<small class="text-danger">','</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="rumpun">Rumpun</label>
                                            <SELECT name='rumpun' class='form-control'>
                                                <OPTION value='-'>:: Pilih Rumpun ::</OPTION>
                                                <OPTION value='PE'>PE</OPTION>
                                                <OPTION value='SAANEN'>SAANEN</OPTION>
                                            </SELECT>
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
                                            <input type="text" name='taginduk' id='taginduk' class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tagindukjantan">Tag Induk Jantan</label>
                                            <input type="text" name='tagindukjantan' id='tagindukjantan' class="form-control">
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