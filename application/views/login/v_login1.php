<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Standarisasi Breeding Sapi Perah | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/template/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/assets/template/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/template/adminlte/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="justify-content-center">
        <div style="display:flex;align-items: center;justify-content: center;">
            <div class="" >
            <img class='rounded-lg' src="/assets/images/bg_cheader.jpg">
            </div>
        </div>

        <div class="display:flex;align-items: center;justify-content: center;login-box">
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg"><b>Login</b></p>
                    <?php echo $this->session->flashdata('pesan'); ?>

                    <form action="<?php echo site_url('/login/proses'); ?>" method="post">
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Username" name="username">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <?= form_error('username','<small class="text-danger">','</small>'); ?>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <?= form_error('password','<small class="text-danger">','</small>'); ?>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-5" name="login">Masuk</button>
                        <hr>
                        <!-- <small class="mx-auto">belum punya akun?</small><br>
                        <a href="<?php echo site_url('/Login/register');?>" class="btn btn-info btn-block mt-2">Buat
                            Akun</a> -->
                            <a href="<?php echo site_url('/');?>" class="btn btn-info btn-block mt-2">Home</a>
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/assets/template/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/template/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/template/adminlte/dist/js/adminlte.min.js"></script>

</body>

</html>