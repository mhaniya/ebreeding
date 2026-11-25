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
          <?php
            if($this->session->userdata('sesi_aktif')=='sapi') {
          ?>
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
                <a href="/identifikasi/pengguna" class="nav-link <?php echo ($submenu=="pengguna"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengguna</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/identifikasi/peternakan" class="nav-link <?php echo ($submenu=="peternakan"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Peternak/Peternakan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/identifikasi/kandang" class="nav-link <?php echo ($submenu=="kandang"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kandang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/identifikasi/sapi" class="nav-link <?php echo ($submenu=="sapi"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sapi</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="/identifikasi/kambing" class="nav-link < ?php echo ($submenu=="kambing"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kambing</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="/identifikasi/semen" class="nav-link <?php echo ($submenu=="semen"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Semen</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/identifikasi/petugas" class="nav-link <?php echo ($submenu=="petugas"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Petugas</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu=="produksi"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="produksi"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-edit"></i>
              <p>
               Produksi
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">4</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/produksi/susu_vertikal" class="nav-link <?php echo ($submenu=="susu_vertikal"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Susu (Vertikal)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/produksi/susu_horizontal" class="nav-link <?php echo ($submenu=="susu_horizontal"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Susu (Horizontal)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/produksi/kualitas_susu" class="nav-link <?php echo ($submenu=="kualitas_susu"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kualitas Susu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/produksi/pertumbuhan" class="nav-link <?php echo ($submenu=="pertumbuhan"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pertumbuhan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu=="reproduksi"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="reproduksi"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-edit"></i>
              <p>
               Reproduksi
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">5</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/reproduksi/ib" class="nav-link <?php echo ($submenu=="ib"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>IB </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/reproduksi/et" class="nav-link <?php echo ($submenu=="et"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ET </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/reproduksi/pkb" class="nav-link <?php echo ($submenu=="pkb"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PKB</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/reproduksi/kelahiran" class="nav-link <?php echo ($submenu=="kelahiran"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelahiran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/reproduksi/pengeringan" class="nav-link <?php echo ($submenu=="pengeringan"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeringan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu=="kesehatan"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="kesehatan"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-edit"></i>
              <p>
               Kesehatan
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">5</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/kesehatan/satuan_obat" class="nav-link <?php echo ($submenu=="satuan_obat"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Satuan Obat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/kesehatan/obat" class="nav-link <?php echo ($submenu=="obat"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Obat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/kesehatan/pemasukan_obat" class="nav-link <?php echo ($submenu=="pemasukan_obat"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan Obat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/kesehatan/pemeriksaan_keswan" class="nav-link <?php echo ($submenu=="pemeriksaan_keswan"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemeriksaan Keswan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/kesehatan/pemeriksaan_reproduksi" class="nav-link <?php echo ($submenu=="pemeriksaan_reproduksi"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemeriksaan Reproduksi</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu=="lap_produktifitas"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="lap_produktifitas"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-table"></i>
              <p>
               Lap. Produktifitas
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">3</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/lap_produktifitas/produksi_susu" class="nav-link <?php echo ($submenu=="produksi_susu"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produksi Susu</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="/lap_produktifitas/produksi_susu_305_terkoreksi" class="nav-link <?php echo ($submenu=="produksi_susu_305_terkoreksi"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produksi Susu 305 Terkoreksi</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="/lap_produktifitas/produksi_dan_tetua" class="nav-link <?php echo ($submenu=="produksi_dan_tetua"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produksi dan Tetua</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/lap_produktifitas/pertumbuhan_bobot_badan" class="nav-link <?php echo ($submenu=="pertumbuhan_bobot_badan"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pertumbuhan Bobot Badan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu=="lap_populasi"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="lap_populasi"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-table"></i>
              <p>
               Lap. Populasi
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">3</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/lap_populasi/populasi_peternakan" class="nav-link <?php echo ($submenu=="populasi_peternakan"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Populasi Peternakan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/lap_populasi/populasi_sapi" class="nav-link <?php echo ($submenu=="populasi_sapi"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Populasi Sapi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/lap_populasi/populasi_sapi_berdasarkan_umur" class="nav-link <?php echo ($submenu=="populasi_sapi_berdasarkan_umur"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Populasi Sapi Berdasarkan Umur</p>
                </a>
              </li>               
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu=="lap_reproduksi"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="lap_reproduksi"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-table"></i>
              <p>
               Lap. Reproduksi
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">4</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/lap_reproduksi/sapi_dara_belum_ib" class="nav-link <?php echo ($submenu=="sapi_dara_belum_ib"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sapi Dara Belum IB</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/lap_reproduksi/sapi_belum_ib" class="nav-link <?php echo ($submenu=="sapi_belum_ib"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sapi Belum IB</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/lap_reproduksi/sapi_belum_pkb" class="nav-link <?php echo ($submenu=="sapi_belum_pkb"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sapi Belum PKB</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/lap_reproduksi/penggunaan_straw" class="nav-link <?php echo ($submenu=="penggunaan_straw"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penggunaan Straw</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/lap_reproduksi/prediksi_birahi" class="nav-link <?php echo ($submenu=="prediksi_birahi"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prediksi Birahi</p>
                </a>
              </li>               
              <li class="nav-item">
                <a href="/lap_reproduksi/prediksi_kelahiran" class="nav-link <?php echo ($submenu=="prediksi_kelahiran"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prediksi Kelahiran</p>
                </a>
              </li>               
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu=="lap_kesehatan"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="lap_kesehatan"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-table"></i>
              <p>
               Lap. Kesehatan
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">3</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/lap_kesehatan/kasus_keswan" class="nav-link <?php echo ($submenu=="kasus_keswan"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kasus Keswan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/lap_kesehatan/kasus_reproduksi" class="nav-link <?php echo ($submenu=="kasus_reproduksi"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kasus Reproduksi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/lap_kesehatan/status_reproduksi" class="nav-link <?php echo ($submenu=="status_reproduksi"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status Reproduksi</p>
                </a>
              </li>                     
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu=="analisa"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="analisa"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-table"></i>
              <p>
               Analisa
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">5</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/analisa/produksi" class="nav-link <?php echo ($submenu=="produksi"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produksi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/analisa/service_per_conception" class="nav-link <?php echo ($submenu=="service_per_conception"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>S / C</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/analisa/calving_interval" class="nav-link <?php echo ($submenu=="calving_interval"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CI</p>
                </a>
              </li>                     
              <li class="nav-item">
                <a href="/analisa/days_open" class="nav-link <?php echo ($submenu=="days_open"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DO</p>
                </a>
              </li>                     
              <li class="nav-item">
                <a href="/analisa/first_insemination_post_partus" class="nav-link <?php echo ($submenu=="first_insemination_post_partus"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>FIPP</p>
                </a>
              </li>                     
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($menu=="data_ref"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="data_ref"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-copy"></i>
              <p>
               Data Referensi
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/jenis_ternak" class="nav-link <?php echo ($submenu=="jenis_ternak"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Ternak</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/bangsa_ternak" class="nav-link <?php echo ($submenu=="bangsa_ternak"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bangsa Ternak</p>
                </a>
              </li>
            </ul>
          </li>
          <?php }else
          if($this->session->userdata('sesi_aktif')=='kambing') {
          ?>
          <li class="nav-item has-treeview <?php echo ($menu=="identifikasi"?"menu-open":"");?>">
            <a href="#" class="nav-link <?php echo ($menu=="identifikasi"?"active":"");?>">
            <!-- <a href="#" class="nav-link active"> -->
              <i class="nav-icon fas fa-edit"></i>
              <p>
               Identifikasi
                <i class="fas fa-angle-left right"></i> 
              </p>
            </a>
            <ul class="nav nav-treeview"> 
              <li class="nav-item">
                <a href="/identifikasi/kambing" class="nav-link <?php echo ($submenu=="kambing"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kambing</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="/identifikasi/kelahirankambing" class="nav-link <?php echo ($submenu=="kelahirankambing"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelahiran</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="/identifikasi/produksisusukambing" class="nav-link <?php echo ($submenu=="produksisusukambing"?"active":"");?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produksi Susu</p>
                </a>
              </li>
              
            </ul>
          </li>
          <?php } ?>
           
           
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
