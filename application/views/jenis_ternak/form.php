 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
 	<!-- Content Header (Page header) -->
 	<div class="content-header">
 		<div class="container-fluid">
 			<div class="row mb-2">
 				<div class="col-sm-6">
 					<h1 class="m-0 text-dark">Jenis Ternak</h1>
 				</div><!-- /.col -->
 				<div class="col-sm-6">
 					<ol class="breadcrumb float-sm-right">
 						<li class="breadcrumb-item"><a href="#">Home</a></li>
 						<li class="breadcrumb-item active">Jenis Ternak</li>
 					</ol>
 				</div><!-- /.col -->
 			</div><!-- /.row -->
 		</div><!-- /.container-fluid -->
 	</div>
 	<!-- /.content-header -->
 	<!-- Main content -->
 	<section class="content">
 		<div class="row">
 			<div class="col-md-6">
 				<div class="card">
 					<div class="card-header">
 						<div class="card-title">Edit Data Jenis Ternak</div>
 					</div>
 					<form action="/jenis_ternak/update" method="POST"> 
 						<input type="hidden" name='id' value='<?php echo "$id"; ?>'>
						<div class="card-body">
							<div class="form-group">
								<label for="nama">Nama Jenis</label>
								<input type="text" class="form-control" name='nama' value='<?php echo $row->nama; ?>'>
							</div>
						</div>
						<div class="card-footer">
							<input class="btn btn-primary" type='submit' value="Simpan">
							<input class="btn btn-default" onclick="history.back()" type='button' value="Batal">
						</div>

 					</form>
 				</div>
 			</div>
 		</div>
 </div>

 </section>
 <!-- /.content -->
 </div>
