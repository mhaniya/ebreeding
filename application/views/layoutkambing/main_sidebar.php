<?php 
		$menu = $this->session->userdata('menu');
		$submenu = $this->session->userdata('submenu');
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="/assets/images/bbptusp.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">e-Breeding</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/assets/images/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Staf Informasi</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="/dashboard" class="nav-link <?php echo ($menu=="dashboard"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>
           
          <li class="nav-item has-treeview <?php echo ($menu=="identifikasi"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="identifikasi"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-edit"></i>
              <p>
               Identifikasi
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/identifikasi/kambing" class="nav-link <?php echo ($submenu=="kambing"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kambing</p>
                </a>
              </li>
          </li>
                     
           
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
