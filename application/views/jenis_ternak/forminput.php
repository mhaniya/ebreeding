<div class="modal fade" id="modal-primary">
	<div class="modal-dialog">
		<div class="modal-content bg-default">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Data Jenis Ternak</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
			</div>
			<form method="POST" action="jenis_ternak/simpan">
				<div class="modal-body">
					<div class="form-group">
						<label for="nama">Nama Jenis</label>
						<input type="hidden" id='edt_id' name='id' class="form-control">
						<input type="text" id='edt_nama' name='nama' class="form-control">
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
