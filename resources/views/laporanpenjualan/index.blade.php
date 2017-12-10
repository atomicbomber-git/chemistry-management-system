@extends('layouts.app')

@section('title')
  Laporan Penjualan Bahan Kimia {{ tanggal_indonesia($awal, false) }} s/d {{ tanggal_indonesia($akhir, false) }}
@endsection

@section('breadcrumb')
   @parent
   <li>laporan penjualan</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="periodeForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Ubah Periode</a>
        <a href="laporanpenjualan/pdf/{{$awal}}/{{$akhir}}" target="_blank" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
      </div>
      <div class="box-body">  

<table class="table table-striped tabel-laporanpenjualan">
<thead>
   <tr>
      <th width="30">No</th>
      <th>Tanggal</th>
      <th>Kode Produk</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>
      <th>Subtotal</th>      
      <th>Kode Member</th>
      <th>Nama Produk</th>
   </tr>
</thead>
<tbody></tbody>
</table>

      </div>
    </div>
  </div>
</div>

@include('laporanpenjualan.form')
@endsection

@section('script')
<script type="text/javascript">
var table, awal, akhir;
$(function(){
   $('#awal, #akhir').datepicker({
     format: 'yyyy-mm-dd',
     autoclose: true
   });

   table = $('.tabel-laporanpenjualan').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "bPaginate" : false,
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "laporanpenjualan/data/{{ $awal }}/{{ $akhir }}",
       "type" : "GET"
     }
   }); 

});

function periodeForm(){
   $('#modal-form').modal('show');        
}

</script>
@endsection