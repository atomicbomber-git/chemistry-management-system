@extends('layouts.app')

@section('title')
  Laporan Exp Date 
@endsection

@section('breadcrumb')
   @parent
   <li>laporan Kadaluarsa</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      
      <div class="box-body">  

<table class="table table-striped tabel-kadaluarsa">
<thead>
   <tr>
      <th width="30">No</th>
      <th>Tanggal Kadaluarsa</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
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

   table = $('.tabel-kadaluarsa').DataTable({
     "processing" : true,
        "ajax" : {
          "url" : "{{ route('kadaluarsa.data') }}",
          "type" : "GET"
     }
   }); 

});

</script>
@endsection