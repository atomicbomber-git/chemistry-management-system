@extends('layouts.app')

@section('title')
	Daftar Penerimaan
@endsection

@section('breadcrumb')
	@parent
	<li>penerimaan</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body">
				<div class="box-header">
					<a href="{{ route('terima.new') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i>Penerimaan Baru</a>
					 @if(!empty(session('idpenerimaan')))
        			<a href="{{ route('terima.index') }}" class="btn btn-info"><i class="fa fa-plus-circle"></i> Penerimaan Aktif</a>
       				@endif
				</div>
				
					<table class="table table-striped tabel-penerimaan">
						<thead>
							<tr>
								<th width="30">No</th>
								<th>Tanggal</th>
								<th>Total Item</th>
								<th width="100">Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
	@include('penerimaan.detail')
	@include('penerimaan.item')

@endsection

@section('script')
	<script type="text/javascript">
	var table, save_method, table1, table2;
	$(function(){
		table = $('.tabel-penerimaan').DataTable({
			"processing" : true,
			"serverside" : true,
			"ajax" : {
				"url" : "{{ route('penerimaan.data') }}",
				"type" : "GET"
			}
		});

		table1 = $('.tabel-detail').DataTable({
			"dom" : 'Brt',
			"bSort" : false,
			"processing" : true
		});

		table2 = $('.tabel-item').DataTable({
			"dom" : 'Brt',
			"bSort" : false,
			"processing" : true
		});

		$('tabel-tahun').DataTable();
	});


	function showDetail(id){
    $('#modal-detail').modal('show');

    table1.ajax.url("penerimaan/"+id+"/lihat");
    table1.ajax.reload();
	}

	function showItem(id){
		$('#modal-item').modal('show');
		$('#modal-detail').modal('hide');
		table2.ajax.url("penerimaan/"+id+"/lihat");
    table1.ajax.reload();
	}

	function deleteData(id){
		if(confirm("Apakah yakin data akan dihapus?")){
			$.ajax({
				url : "penerimaan/"+id,
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
	</script>
@endsection

	