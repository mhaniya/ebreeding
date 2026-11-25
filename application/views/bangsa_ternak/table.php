 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
 	<!-- Content Header (Page header) -->
 	<div class="content-header">
 		<div class="container-fluid">
 			<div class="row mb-2">
 				<div class="col-sm-6">
 					<h1 class="m-0 text-dark">Bangsa Ternak</h1>
 				</div><!-- /.col -->
 				<div class="col-sm-6">
 					<ol class="breadcrumb float-sm-right">
 						<li class="breadcrumb-item"><a href="#">Home</a></li>
 						<li class="breadcrumb-item active">Bangsa Ternak</li>
 					</ol>
 				</div><!-- /.col -->
 			</div><!-- /.row -->
 		</div><!-- /.container-fluid -->
 	</div>
 	<!-- /.content-header -->
 	<!-- Main content -->
 	<section class="content">
 		<div class="card">
 			<div class="card-header">
 				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary">Tambah
 				</button>
 				<!-- <a href="Bangsa_ternak/form" class="btn btn-primary">Tambah</a> -->
 			</div>
 			<div id="form">
 				<div class="modal fade" id="modal-primary">
 					<div class="modal-dialog">
 						<div class="modal-content bg-default">
 							<div class="modal-header">
 								<h4 class="modal-title">Input Bangsa Ternak</h4>
 								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 									<span aria-hidden="true">&times;</span></button>
 							</div>
 							<form method="POST" action="Bangsa_ternak/simpan">
 								<div class="modal-body">
 									<div class="form-group">
 										<label for="nama">Nama Bangsa</label>
 										<input type="hidden" id='edt_id' name='id' class="form-control">
 										<input type="text" id='edt_nama' name='nama' class="form-control">
 									</div>
									 <div class="form-group">
 										<label for="nama">Jenis Ternak</label>
 										<SELECT name='id_jenis_ternak' id='edt_id_jenis' class="form-control">
 												<?php
												foreach($rs_jenis_ternak->result() as $row){
													echo "<OPTION value='$row->id'>$row->nama</OPTION>";
												}
											 ?>
										</SELECT>
 									</div>
 								</div>
 								<div class="modal-footer justify-content-between">
 									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 									<button type="submit" class="btn btn-primary">Simpan</button>
 								</div>
 							</form>
 						</div>
 						<!-- /.modal-content -->
 					</div>
 					<!-- /.modal-dialog -->
 				</div>
 				<!-- /.modal -->
 			</div>
 			<div class="card-body table-responsive">
 				<table class="table table-hover">
 					<thead>
 						<tr>
 							<th>Nama Bangsa</th>
 							<th>Jenis Ternak</th>
 							<th colspan='3'>&nbsp;</th>
 						</tr>
 					</thead>
 					<tbody>
 						<?php
							foreach ($rs->result() as $row) {
								echo "<tr>";
								echo "<td>$row->nama</td>";
								echo "<td>$row->nama_jenis_ternak</td>";
								echo "<td style='width:130px;'><button class='btn btn-warning' onclick=\"edit('/bangsa_ternak/dataedit','$row->id')\" data-toggle='modal' data-target='#modal-primary'>Edit Modal</button></td>";
								echo "<td style='width:60px;'><a href='/Bangsa_ternak/edit/$row->id' class='btn btn-warning' id='btn_edit' >Edit</a></td>";
								echo "<td style='width:60px;'>
											<form id='frmHapus$row->id' method='POST' action='/Bangsa_ternak/hapus'>
											<input type='hidden' name='id' value='$row->id'>
											<input type='button' onclick='hapus($row->id)' value='Hapus' class='btn btn-danger'>
											</form>
											</td>";
								echo "</tr>";
							}
							?>
 					</tbody>
 				</table>
 			</div>
 		</div>
 	</section>
 	<!-- /.content -->
 </div>
