<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>e-Breeding BBPTUHPT Baturraden</title>
    
    <link rel="stylesheet" href="/assets/template/adminlte2/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/template/adminlte2/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/assets/template/adminlte2/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="/assets/template/adminlte2/plugins/datepicker/datepicker3.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/assets/template/adminlte2/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/styles/style.css">
    <!-- <link rel="stylesheet" href="/assets/slider/demo/style.css" type="text/css" media="screen" /> -->
</head>

<body>
    <header>
        <div class="jumbotron">
            <img src="/assets/images/history.jpg" class="featured-image slide" alt="sejarah"
                style="display:inline;border-radius: 5px;">
            <img src="/assets/images/geografis.jpg" class="featured-image slide" alt="sejarah"
                style="display:none;border-radius: 5px;">

        </div>
        <nav>
            <ul style="margin-top:10px;">
                <li><a href="/">Home</a></li>
                <li><a href="/landingpage">Analisa</a></li>
                <li><a href="/login">e-Breeding</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div id="content">
            <div class="card">
                <div class="row">
                    <div class="col-md-2">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Masukan Biodata</h3>
                            </div>

                            <form role="form">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type='text' name='nama' id='nama' class='form-control'>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nomor HP</label>
                                        <input type='text' name='no_hp' id='no_hp' class='form-control'>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama">Tag Sapi</label>
                                        <input type='text' name='tag_sapi' id='tag_sapi' class='form-control'>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama">Laktasi Ke</label>
                                        <input type='text' name='laktasi_ke' id='laktasi_ke' class='form-control'>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" data-provide="datepicker"
                                                name="tgl_lahir" id="tgl_lahir" autocomplete=false>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_laktasi">Tanggal Laktasi</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" data-provide="datepicker"
                                                name="tgl_laktasi" id="tgl_laktasi">
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="button" id="btn_masuk" class="btn btn-primary">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <input type="hidden" id="id_biodata">
                    <div class="col-md-2" id="input-produksi" style="display:none;">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Data Produksi</h3>
                            </div>

                            <form role="form">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="nama">Tanggal Produksi</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" data-provide="datepicker"
                                                name="tgl_produksi" id="tgl_produksi">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Jumlah Produksi</label>
                                        <input type='text' name='jml_produksi' id='jml_produksi' class='form-control'>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="button" id="btn-tambah" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-8" id="hasil-analisa" style="display:none;">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Analisa Produksi</h3>
                            </div>
                            <div class="box-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style='text-align:center;' colspan='3'>LAKTASI</th>
                                            <th style='text-align:center;' rowspan='2'>TGL. UKUR</th>
                                            <th style='text-align:center;' rowspan='2'>JHP</th>
                                            <th style='text-align:center;' rowspan='2'>UMUR</th>
                                            <th style='text-align:center;' rowspan='2'>PROD. SEBELUM</th>
                                            <th style='text-align:center;' rowspan='2'>JML HARI</th>
                                            <th style='text-align:center;' rowspan='2'>PROD. BULANAN</th>
                                            <th style='text-align:center;' rowspan='2'>PROD. NYATA</th>
                                            <th style='text-align:center;' colspan='2'>KOREKSI</th>
                                            <th style='text-align:center;' rowspan='2'>PROD. TERKOREKSI</th>
                                        </tr>
                                        <tr>
                                            <th style='text-align:center;'>KE</th>
                                            <th style='text-align:center;'>BLNKE</th>
                                            <th style='text-align:center;'>JUMLAH</th>
                                            <th style='text-align:center;'>UMUR</th>
                                            <th style='text-align:center;'>JHP</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="box-footer">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <aside>
            <article class="profile card">
                <h2>
                    <header>e-Breeding BBPTUHPT Baturraden</header>
                </h2>
                <p>
                <header>Balai Besar Pembibitan Hijauan Pakan Ternak Baturraden</header>
                </p>
                <header>
                    <figure>
                        <img src="/assets/images/bbptusp.png">
                        <figcaption>BBPTUHPT</figcaption>
                    </figure>
                </header>
                <section>

                </section>

            </article>
        </aside>
    </main>
    <footer>
        <p>e-Breeding &#169; 2020 BBPTUHPT Baturraden </p>
    </footer>
    <script>
    var myVar = setInterval(ganti, 2000);

    function ganti() {

        let slides = document.querySelectorAll(".slide");
        if (slides[0].style.display == "none") {
            slides[0].style.display = "inline";
            slides[1].style.display = "none"
        } else {
            slides[0].style.display = "none";
            slides[1].style.display = "inline"
        }
    }
    </script>
    <script src="/assets/template/adminlte2/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="/assets/template/adminlte2/bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="/assets/template/adminlte2/plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="/assets/template/adminlte2/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/assets/template/adminlte2/plugins/input-mask/jquery.inputmask.date.extensions.js">
    </script>
    <script src="/assets/template/adminlte2/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="/assets/template/adminlte2/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="/assets/template/adminlte2/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- SlimScroll -->
    <script src="/assets/template/adminlte2/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="/assets/template/adminlte2/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/template/adminlte2/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/assets/template/adminlte2/dist/js/demo.js"></script>
    <script>
    $('.datepicker').datepicker({});

    $('#btn_masuk').on('click', function() {
        var nama = $('#nama').val();
        var no_hp = $('#no_hp').val();
        var tag_sapi = $('#tag_sapi').val();
        var laktasi_ke = $('#laktasi_ke').val();
        var tgl_lahir = $('#tgl_lahir').val();
        var tgl_laktasi = $('#tgl_laktasi').val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>index.php/landingpage/simpan_biodata",
            data: {
                nama: nama,
                no_hp: no_hp,
                tag_sapi: tag_sapi,
                laktasi_ke: laktasi_ke,
                tgl_lahir: tgl_lahir,
                tgl_laktasi: tgl_laktasi
            }
        }).done(function(hasil) {
            if (hasil > 0) {
                $('#input-produksi').fadeIn();
                $('#id_biodata').val(hasil);
                $('#nama').attr("disabled", true);
                $('#no_hp').attr("disabled", true);
                $('#tag_sapi').attr("disabled", true);
                $('#laktasi_ke').attr("disabled", true);
                $('#tgl_lahir').attr("disabled", true);
                $('#tgl_laktasi').attr("disabled", true);
                $('#btn_masuk').fadeOut();
            }
        });
    })

    $('#btn-tambah').on('click', function() {
        var id_biodata = $('#id_biodata').val();
        var jml_produksi = $('#jml_produksi').val();
        var tgl_produksi = $('#tgl_produksi').val();
        $('#btn-tambah').fadeOut();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>index.php/landingpage/simpan_produksi",
            data: {
                id_biodata: id_biodata,
                tgl_produksi: tgl_produksi,
                jml_produksi: jml_produksi
            }
        }).done(function(hasil) {
            if (hasil) {
                $('#btn-tambah').fadeIn();
                $('#hasil-analisa').html(hasil);
                $('#tgl_produksi').val('');

                $('#jml_produksi').val('');
                $('#hasil-analisa').fadeIn();
                $('#tgl_produksi').focus();
            }
        });
    })
    </script>
</body>

</html>