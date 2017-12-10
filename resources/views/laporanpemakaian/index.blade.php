@extends('layouts.app')

@section('title')
  Laporan Penggunaan Bahan Kimia {{ tanggal_indonesia($awal, false) }} s/d {{ tanggal_indonesia($akhir, false) }}
@endsection

@section('breadcrumb')
   @parent
   <li>laporan penggunaan</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="periodeForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Ubah Periode</a>
        <a href="laporanpemakaian/pdf/{{$awal}}/{{$akhir}}" target="_blank" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
      </div>
      <div class="box-body">  

<table class="table table-striped tabel-laporanpemakaian">
<thead>
   <tr>
      <th width="30">No</th>
      <th>Tanggal</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <th>Jumlah</th>
   </tr>
</thead>
<tbody></tbody>
</table>

      </div>
    </div>
  </div>
</div>

@include('laporanpemakaian.form')
@endsection

@section('script')
<script type="text/javascript">
var table, awal, akhir;
$(function(){
   $('#awal, #akhir').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

   table = $('.tabel-laporanpemakaian').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "bPaginate" : false,
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "laporanpemakaian/data/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   }); 

});

function periodeForm(){
   $('#modal-form').modal('show');        
}

</script>
@endsection