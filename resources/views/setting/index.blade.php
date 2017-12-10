@extends('layouts.app')

@section('title')
	Pengaturan
@endsection

@section('breadcrumb')
	@parent
	<li>Pengaturan</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<form class="form form-horizontal" data-toggle="validator" method="post" enctype="multipart/form-data">
					{{ csrf_field() }} {{ method_field('PATCH') }}
					<div class="box-body">

						<div class="alert alert-info alert-dismissible" style="display:none">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="icon fa fa-check"></i>
							Perubahan Berhasil Disimpan
						</div>

						<div class="form-group">
							<label for="nama" class="col-md-2 control-label">Nama Laboratorium</label>
							<div class="col-md-6">
							<input id="nama" type="text" class="form-control" name="nama" required>
							<span class="help-block with-errors"></span> 
							</div>
						</div>

						<div class="form-group">
							<label forn="nama" class="col-md-2 control-label">Alamat</label>
							<div class="col-md-10">
								<input id="alamat" type="text" class="form-control" name="alamat" required>
								<span class="help-block with-errors"></span>
							</div>
						</div>

						<div class="form-group">
							<label for="telepon" class="col-md-2 control-label">Telepon</label>
							<div class="col-md-4">
								<input id="telepon" type="text" class="form-control" name="telepon" required>
								<span class="help-block with-errors"></span>
							</div>
						</div>

						<div class="form-group">
							<label for="logo" class="col-md-2 control-label">Logo Laboratorium</label>
							<div class="col-md-4">
								<input id="logo" type="file" class="form-control" name="logo"><br>
								<div class="tampil-logo"></div>
							</div>
						</div>

						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o">Simpan Perubahan</i></button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		$(function(){
    showData();
   $('.form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){ 

         $.ajax({
           url : "setting/1",
           type : "POST",
           data : new FormData($(".form")[0]),
           async: false,
           processData: false,
           contentType: false,
           success : function(data){
             showData();
             $('.alert').css('display', 'block').delay(2000).fadeOut();
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });

});

		function showData(){
			$.ajax({
				url : "setting/1/edit",
				type : "GET",
				dataType : "JSON",
				success : function(data){
					$('#nama').val(data.nama_lab);
					$('#alamat').val(data.alamat);
					$('#telepon').val(data.telepon);

					d = new Date();
					$('.tampil-logo').html('<img src="images/'+data.logo+'?'+d.getTime()+'" width="200">');
				},
				error : function(){
					alert("Tidak dapat menyimpan data!");
				}
			});
		}
	</script>
@endsection