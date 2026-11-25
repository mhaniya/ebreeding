<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->

  </ul>
  <h4>Breeding Online</h4>
  &nbsp;
  <?php if($this->uri->segment(1)=="dashboard"){?>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
    <label class="btn bg-olive  <?php echo ($this->session->userdata('sesi_aktif')=='sapi'?"active":"");?>">
      <input type="radio" name="options" id="optSapi" value='sapi' autocomplete="off" <?php echo ($this->session->userdata('sesi_aktif')=='sapi'?"checked":"");?>> Sapi
    </label>
    <label class="btn bg-olive <?php echo ($this->session->userdata('sesi_aktif')=='kambing'?"active":"");?>">
      <input type="radio" name="options" id="optKambing" value='kambing' autocomplete="off" <?php echo ($this->session->userdata('sesi_aktif')=='kambing'?"checked":"");?>> Kambing
    </label>
  </div>
  <?php } ?>
   
  
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="dropdown-divider"></div>
        <p class="text-center pt-2">
          <i class="far fa-user fa-2x"></i>
        </p>
        <p class="text-center">
          <?= $user->user_nama; ?>
        </p>
        <p class="text-center">
          <?= $user->level_nama; ?>
        </p>
        <div class="dropdown-divider"></div> 
        <a href="<?php echo site_url('/Login/logout'); ?>" class="dropdown-item dropdown-footer bg-primary text-white">Logout</a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->