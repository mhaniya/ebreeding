<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= $judul; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $judul; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <form action="<?php echo '/identifikasi/produksisusukambing/save'; ?>" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= set_value('tanggal'); ?>">
                                            <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="eartag">Eartag.</label>
                                            <input type="text" name="eartag" id="eartag" class="form-control" value="<?= set_value('eartag'); ?>">
                                            <input type="hidden" name="rumpun" id="rumpun" class="form-control" value="<?= set_value('rumpun'); ?>">
                                            <?= form_error('eartag', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>

                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="pagi">Pagi</label>
                                            <input type="text" name="pagi" id="pagi" style="text-align:right;" class="form-control" value="<?= set_value('pagi'); ?>">
                                            <?= form_error('pagi', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="sore">Sore</label>
                                            <input type="text" name="sore" id="sore" style="text-align:right;" class="form-control" value="<?= set_value('sore'); ?>">
                                            <?= form_error('sore', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="petugas">Petugas</label>
                                            <input type="text" name="petugas" id="petugas" class="form-control" value="<?= set_value('petugas'); ?>">
                                            <input type="hidden" name="idpetugas" id="idpetugas" >
                                            <?= form_error('petugas', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                 
                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?= site_url('/kambing'); ?>" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</div>