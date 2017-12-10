<div class="modal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form class="form-horizontal" data-toggle="validator" method="post" enctype="multipart/form-data">
				{{ csrf_field() }} {{ method_field('POST') }}

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span></button>
					<h3 class="modal-title"></h3>
				</div>

				<div class="modal-body">

					<input type="hidden" id="id" name="id">
					<div class="form-group">
						<label for="kode" class="col-md-3 control-label">Kode Produk</label>
						<div class="col-md-6">
							<input id="kode" type="number" class="form-control" name="kode" autofocus required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Nama Produk</label>
						<div class="col-md-6">
							<input id="nama" type="text" class="form-control" name="nama" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="kategori" class="col-md-3 control-label">Kategori</label>
						<div class="col-md-6">
							<select id="kategori" type="text" class="form-control" name="kategori" required>
								@foreach($kategori as $list)
								<option value="{{ $list->id_kategori }}">{{ $list->nama_kategori }}</option>
								@endforeach
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="satuan" class="col-md-3 control-label">Satuan</label>
						<div class="col-md-6">
							<select id="satuan" type="text" class="form-control" name="satuan" required>
								<option value="">--Pilih Satuan--</option>
								<option value="ml">ml</option>
								<option value="mg">mg</option>
								<option value="item">Pcs</option>
								<option value="item">Dll</option>
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
						<label for="tgl_kadaluarsa" class="col-md-3 control-label">Tanggal Kadaluarsa</label>
						<div class="col-md-3"><i class="glyphicon glyphicon-calendar"></i>
							<input id="tgl_kadaluarsa" type="text" class="form-control" name="tgl_kadaluarsa" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>


					<div class="form-group">
						<label for="harga_jual" class="col-md-3 control-label">Harga Jual</label>
						<div class="col-md-3">
							<input id="harga_jual" type="text" class="form-control" name="harga_jual" required>
							<span class="help-block with-errors"></span>
						</div> 
					</div>

					<div class="form-group">
						<label for="stok" class="col-md-3 control-label">Stok</label>
						<div class="col-md-2">
							<input id="stok" type="text" class="form-control" name="stok" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

					<div class="form-group">
							<label for="foto" class="col-md-3 control-label">Foto Produk</label>
							<div class="col-md-3">
								<input id="foto" type="file" class="form-control" name="foto"><br>
								<div class="tampil-foto"></div>
							</div>
						</div>
						

					<div class="form-group">
						<label for="ket" class="col-md-3 control-label">Keterangan</label>
						<div class="col-md-3">
							<input id="ket" type="text" class="form-control" name="ket" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floppy-o"></i>Simpan</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>Batal</button>
				</div>

			</form>

		</div>
	</div>
</div>