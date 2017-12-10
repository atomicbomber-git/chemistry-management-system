@extends('layouts.app')

@section('title')
  Selesai Transaksi
@endsection

@section('breadcrumb')
   @parent  
   <li>Transaksi</li>
   <li>Selesai</li>
@endsection

@section('content') 
<div class="row">
  <div class="col-xs-12">
    <div class="box">
       <div class="box-body">
          <div class="alert alert-success alert-dismissible">
            <i class="icon fa fa-check"></i>
            Data Transaksi telah disimpan.
          </div>

          <br><br>
          <a class="btn btn-primary btn-lg" href="{{ route('penjualan.index') }}">Kembali</a>
          <a class="btn btn-primary btn-lg" href="{{ route('transaksi.new') }}">Transaksi Baru</a>
          <a class="btn btn-warning btn-lg" onclick="tampilNota()">Export PDF</a>
            <script type="text/javascript">
              tampilNota();
              function tampilNota(){
                window.open("{{ route('transaksi.pdf') }}", "Nota PDF", "height=650,width=1024,left=150,scrollbars=yes");
              }              
            </script>
          <br><br><br><br>
      </div>
   </div>
  </div>
</div>
@endsection