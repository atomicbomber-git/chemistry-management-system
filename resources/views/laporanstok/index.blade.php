@extends('layouts.app')

@section('title')
  Laporan Stok Bahan Kimia {{ tanggal_indonesia(date('Y-m-d')) }}
@endsection

@section('breadcrumb')
   @parent
   <li>laporan</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a href="laporan/pdf" target="_blank" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
      </div>
  
      <div class="box-body">  

<table class="table table-striped tabel-laporan">
<thead>
   <tr>
      <th width="30">No</th>
      <th>Stok Awal</th>
      <th>Stok Masuk</th>
      <th>Stok Keluar</th>
      <th>akhir</th>
   </tr>
</thead>
<tbody></tbody>
</table>

      </div>
    </div>
  </div>
</div>


@endsection

@section('script')
<script type="text/javascript">
var table;
$(function(){

   table = $('.tabel-laporan').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "bPaginate" : false,
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "{{ route('laporanstok.data') }}",
       "type" : "GET"
     }
   }); 

});


</script>
@endsection