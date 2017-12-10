@extends('layouts.app')

@section('title')
	Daftar Produk
@endsection

@section('breadcrumb')
	@parent
	<li>produk</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i>Tambah</a>
					<a onclick="deleteAll()" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</a>
					<a onclick="printBarcode()" class="btn btn-info"><i class="fa fa-barcode"></i> Cetak Barcode</a>
				</div>
				<div class="box-body">

					<form class="form form-horizontal" data-toggle="validator" method="post" id="form-produk" enctype="multipart/form-data">
						{{ csrf_field() }} {{ method_field('PATCH') }}
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="20"><input type="checkbox" value="1" id="select-all"></th>
									<th width="20">No</th>
									<th>Kode Produk</th>
									<th>Nama Produk</th>
									<th>Tanggal kadaluarsa</th>							
									<th>Stok</th>
									<th>Satuan</th>
									
									<th width="150">Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
	@include('produk.detail')
	@include('produk.form')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method, table1;
$(function(){
	
	 $('#tgl_kadaluarsa').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose:true
                });
   table = $('.table').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "{{ route('produk.data') }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false,

      }],
      'order': [1, 'asc']
   }); 

   
   table1 = $('.tabel-detail').DataTable({
			"dom" : 'Brt',
			"bSort" : false,
			"processing" : true,
			"destroy": true,
    		"searching": false

		});

   $('#select-all').click(function(){
      $('input[type="checkbox"]').prop('checked', this.checked);
   });

  $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if(save_method == "add") url = "{{ route('produk.store') }}";
         else url = "produk/"+id;
         
         $.ajax({
           url : url,
           type : "POST",
           data : new FormData($("#modal-form form")[0]),
           dataType : 'JSON',
           async: false,
           processData: false,
           contentType: false,
           success : function(data){
             if(data.msg=="error"){
                alert('Kode produk sudah digunakan!');
                $('#kode').focus().select();
             }else{
                $('#modal-form').modal('hide');
                table.ajax.reload();
             }            
           },
           error : function(){
           	$('#modal-form').modal('hide');
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });
});
	function addForm(){
   save_method = "add";
   $('input[name=_method]').val('POST');
   $('#modal-form').modal('show');
   $('#modal-form form')[0].reset();            
   $('.modal-title').text('Tambah Produk');
   $('#kode').attr('readonly', false);
}

	function editForm(id){
		save_method = "edit";
		$('input[name=_method]').val('PATCH');
		$('#modal-form form')[0].reset();
		$.ajax({
			url : "produk/"+id+"/edit",
			type : "GET",
			dataType : "JSON",
			success : function(data){
				$('#modal-form').modal('show');
				$('.modal-title').text('Edit Produk');

				$('#id').val(data.id_produk);
				$('#kode').val(data.kode_produk).attr('readonly', true);
				$('#nama').val(data.nama_produk);
				$('#kategori').val(data.id_kategori);
				$('#satuan').val(data.satuan);
				$('#tgl_kadaluarsa').val(data.tgl_kadaluarsa);				
				$('#harga_jual').val(data.harga_jual);
				$('#stok').val(data.stok);
				d = new Date();
      			$('.tampil-foto').html('<img src="images/'+data.foto+'?'+d.getTime()+'" width="200">');
				$('#ket').val(data.ket);
			},

			error : function(){
				alert("Tidak dapat menampilkan data!");
			}
		});
	}

	function showDetail(id){
    $('#modal-detail').modal('show');

    table1.ajax.url("produk/"+id+"/lihat");
    table1.ajax.reload();
	}

	function deleteData(id){
		if (confirm("Apakah data akan dihapus?")) {
			$.ajax({
				url : "produk/"+id,
				type : "POST",
				data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
				success : function(data){
					table.ajax.reload();
				},
				error : function(){
					alert("Tidak dapat menghapus data!");
				}
			});
		}
	}

	function deleteAll(){
		if($('input:checked').length < 1){
			alert('Pilih data yang akan dihapus!');
		} else if(confirm("Apakah yakin akan menghapus semua data terpilih?")){
			$.ajax({
				url : "produk/hapus",
				type : "POST",
				data : $('#form-produk'),
				success : function(data){
					table.ajax.reload();
					table1.ajax.reload();
				},
				error : function(){
					alert("Tidak dapat menghapus data!");
				}
			});
		}
	}

	

	function printBarcode(){
  if($('input:checked').length < 1){
    alert('Pilih data yang akan dicetak!');
  }else{
    $('#form-produk').attr('target', '_blank').attr('action', "produk/cetak").submit();
  }
}

</script>

@endsection
