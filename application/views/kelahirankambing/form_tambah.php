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
            <form action="<?php echo '/identifikasi/kelahirankambing/save'; ?>" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgllahir">Tanggal</label>
                                            <input type="date" name="tgllahir" id="tgllahir" class="form-control" value="<?= set_value('tgllahir'); ?>">
                                            <?= form_error('tgllahir', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="eartag">Eartag. Induk</label>
                                            <input type="text" name="eartag_induk" id="eartag_induk" class="form-control" value="<?= set_value('eartag_induk'); ?>">
                                            <input type="hidden" name="rumpun" id="rumpun" class="form-control" value="<?= set_value('rumpun'); ?>">
                                            <?= form_error('eartag_induk', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="eartag">Eartag. Anak</label>
                                            <input type="text" name="eartag_anak" id="eartag_anak" class="form-control" value="<?= set_value('eartag_anak'); ?>">
                                            <?= form_error('eartag_anak', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="eartag">J.Kel.</label>
                                            <SELECT class="form-control" name='kelamin' id='kelamin' >
                                                <OPTION value="Jantan">Jantan</OPTION>
                                                <OPTION value="Betina">Betina</OPTION> 
                                            </SELECT>
                                            <?= form_error('kelamin', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="eartag">Status Kelahiran</label>
                                            <SELECT class="form-control" name='status_kelahiran' id='status_kelahiran' onclick="cekstatus1()">
                                                <OPTION value="single">Single</OPTION>
                                                <OPTION value="kembar">Kembar</OPTION>
                                                <OPTION value="Abortus">Abortus</OPTION>
                                            </SELECT>
                                            <?= form_error('status_kelahiran', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="eartag">Status Kondisi</label>
                                            <SELECT class="form-control" name='statuslahiranak' id='statuslahiranak' onclick="cekstatus1()">
                                                <OPTION value="Hidup">Hidup</OPTION>
                                                <OPTION value="Mati">Mati</OPTION>
                                                <OPTION value="Abortus">Abortus</OPTION>
                                            </SELECT>
                                            <?= form_error('statuslahiranak', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="bobotlahir">Bobot Lahir</label>
                                            <input type="text" name="bobotlahir" id="bobotlahir" style="text-align:right;" class="form-control" value="<?= set_value('bobotlahir'); ?>">
                                            <?= form_error('bobotlahir', '<small class="text-danger">', '</small>'); ?>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <input type="text" name="keterangan" id="keterangan" class="form-control" value="<?= set_value('keterangan'); ?>">
                                            <?= form_error('keterangan', '<small class="text-danger">', '</small>'); ?>
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