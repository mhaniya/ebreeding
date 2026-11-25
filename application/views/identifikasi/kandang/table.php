 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
 	<!-- Content Header (Page header) -->
 	<div class="content-header">
 		<div class="container-fluid">
 			<div class="row mb-2">
 				<div class="col-sm-6">
 					<h1 class="m-0 text-dark"><?php echo $judul;?></h1>
 				</div><!-- /.col -->
 				<div class="col-sm-6">
 					<ol class="breadcrumb float-sm-right">
 						<li class="breadcrumb-item"><a href="#"><?php echo ucwords($menu);?></a></li>
 						<li class="breadcrumb-item active"><?php echo ucwords($submenu);?></li>
 					</ol>
 				</div><!-- /.col -->
 			</div><!-- /.row -->
 		</div><!-- /.container-fluid -->
 	</div>
 	<!-- /.content-header -->
 	<!-- Main content -->
 	<section class="content">
 		 <div class="container-fluid">
			  <div class="row">
				  <div class="col-md-12">
					  <div class="card card-primary">
						  <div class="card-header">
						  <a href="<?php echo "/identifikasi/kandang/add";?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
						  </div>
						  <div class="card-body table-responsive">
							  <table class="table table-bordered table-striped table-hover" id="tblkandang">
								<thead>
									<tr>
										<th>#</th>
										<th>Propinsi</th>
										<th>Kabupaten</th>
										<th>Kecamatan</th>
										<th>Peternakan</th>
										<th>Nama Kandang</th>
										<th>Lokasi</th>
										<th>Kapasitas</th>
										<th style='width:100px;'>&nbsp;</th>
									</tr>
								</thead>	 
								 
							  </table>
						  </div>
					  </div>
				  </div>
			  </div>
		  </div>
 	</section>
 	<!-- /.content -->
 </div>

 <!-- Modal -->
<div class="modal fade" id="Modalhapus" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judulmodal">Hapus Data</h5>
      </div>
      <div class="modal-body">
        <form action="<?=site_url('/identifikasi/kandang/hapus'); ?>" method="post">
          <input type="hidden" name="id" id="id" required>
          Apakah yakin dihapus?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>