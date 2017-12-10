@extends('layouts.app')

@section('title')
  Penggunaan Bahan Kimia
@endsection

@section('breadcrumb')
   @parent
   <li>pemakaian</li>
   <li>tambah</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
   
      <div class="box-body">

<form class="form form-horizontal form-produk" method="post">
{{ csrf_field() }}  
  <input type="hidden" name="idpemakaian" value="{{ $idpemakaian }}">
  <div class="form-group">
      <label for="kode" class="col-md-2 control-label">Kode Produk</label>
      <div class="col-md-5">
        <div class="input-group">
          <input id="kode" type="text" class="form-control" name="kode" autofocus required>
          <span class="input-group-btn">
            <button onclick="showProduct()" type="button" class="btn btn-info">...</button>
          </span>
        </div>
      </div>
  </div>
</form>

<form class="form-keranjang">
{{ csrf_field() }} {{ method_field('PATCH') }}
<table class="table table-striped tabel-pemakaian">
<thead>
   <tr>
      <th width="30">No</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <th>Jumlah</th>
      <th width="100">Aksi</th>
   </tr>
</thead>
<tbody></tbody>
</table>
</form>

  <div class="col-md-4">
    <form class="form form-horizontal form-pemakaian" method="post" action="penggunaan/simpan">
      {{ csrf_field() }}
      <input type="hidden" name="idpemakaian" value="{{ $idpemakaian }}">
      <input type="hidden" name="total" id="total">
      <input type="hidden" name="totalitem" id="totalitem">
      
      <div class="form-group">
        <label for="tujuan" class="col-md-4 control-label">Jenis Penggunaan</label>
        <div class="col-md-8">
          <div class="input-group">
            <select id="tujuan" type="text" class="form-control" name="tujuan" required>
              <option value="Praktikum laboratorium">Praktikum Laboratorium</option>
              <option value="Penelitian">Penelitian</option>
              <option value="Dan lain-lain">Dll</option>
            </select>
          </div>
        </div>
      </div>

    </form>
  </div>

      </div>
      
      <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
      </div>
    </div>
  </div>
</div>
@include('pemakaian_detail.produk')

@endsection

@section('script')
<script type="text/javascript">
var table;
$(function(){
  $('.tabel-produk').DataTable();

  table = $('.tabel-pemakaian').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('penggunaan.data', $idpemakaian) }}",
       "type" : "GET"
     }
  });

   $('.form-produk').on('submit', function(){
      return false;
   });

   $('body').addClass('sidebar-collapse');

   $('#kode').change(function(){
      addItem();
   });

   $('.form-keranjang').submit(function(){
     return false;
   });

   $('.simpan').click(function(){
      $('.form-pemakaian').submit();
   });

});

function addItem(){
  $.ajax({
    url : "{{ route('penggunaan.store') }}",
    type : "POST",
    data : $('.form-produk').serialize(),
    success : function(data){
      $('#kode').val('').focus();
      table.ajax.reload();
    },
    error : function(){
      alert("Tidak dapat menyimpan data!");
    }   
  });
}

function showProduct(){
  $('#modal-produk').modal('show');
}

function selectItem(kode){
  $('#kode').val(kode);
  $('#modal-produk').modal('hide');
  addItem();
}

function changeCount(id){
     $.ajax({
        url : "penggunaan/"+id,
        type : "POST",
        data : $('.form-keranjang').serialize(),
        success : function(data){
          $('#kode').focus();
          table.ajax.reload();
        },
        error : function(){
          alert("Tidak dapat menyimpan data!");
        }   
     });
}


function deleteItem(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "penggunaan/"+id,
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

function loadForm(){
  $('#total').val($('.total').text());
  $('#totalitem').val($('.totalitem').text());
}

</script>

@endsection