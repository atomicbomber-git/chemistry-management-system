@extends('layouts.app')

@section('title')
	Daftar Pemakaian
@endsection

@section('breadcrumb')
	@parent
	<li>Pemakaian</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-body">

        <div class="box-header">
          <a href="{{ route('penggunaan.new') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i>Pengunaan Baru</a>
           @if(!empty(session('idpemakaian')))
        <a href="{{ route('penggunaan.index') }}" class="btn btn-info"><i class="fa fa-plus-circle"></i> Penggunaan Aktif</a>
        @endif
        </div>

				<table class="table table-striped tabel-pemakaian">
					<thead>
						<tr>
							<th width="30">No</th>
							<th>Tanggal</th>
							<th>Tujuan</th>
							<th>Total Item</th>
							<th>Admin</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@include('pemakaian.detail')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method, table1;
$(function(){
   table = $('.tabel-pemakaian').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "{{ route('pemakaian.data') }}",
       "type" : "GET"
     }
   }); 
   
   table1 = $('.tabel-detail').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true
    });

  
});


function showDetail(id){
    $('#modal-detail').modal('show');

    table1.ajax.url("pemakaian/"+id+"/lihat");
    table1.ajax.reload();
}

function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "pemakaian/"+id,
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