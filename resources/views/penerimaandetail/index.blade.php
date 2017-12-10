@extends('layouts.app')

@section('title')
  Penerimaan Bahan kimia
@endsection

@section('breadcrumb')
   @parent
   <li>penerimaan</li>
   <li>tambah</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
   
      <div class="box-body">

<form class="form form-horizontal form-produk" method="post">
{{ csrf_field() }}  
  <input type="hidden" name="idpenerimaan" value="{{ $idpenerimaan }}">
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
<table class="table table-striped tabel-penerimaan">
<thead>
   <tr>
      <th width="30">No</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <th align="right">Volume</th>
      <th>Jumlah</th>
      <th align="right">Sub Total</th>
      
      <th width="100">Aksi</th>
   </tr>
</thead>
<tbody></tbody>
</table>
</form>

  <div class="col-md-4">
    <form class="form form-horizontal form-penerimaan" method="post" action="terima/simpan">
      {{ csrf_field() }}
      <input type="hidden" name="idpenerimaan" value="{{ $idpenerimaan }}">
      <input type="hidden" name="subtotal" id="subtotal">
      <input type="hidden" name="totalitem" id="totalitem">
     
    </form>
  </div>

      </div>
      
      <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right simpan"><i class="fa fa-floppy-o"></i> Simpan </button>
      </div>
    </div>
  </div>
</div>
@include('penerimaandetail.produk')

@endsection

@section('script')

<script type="text/javascript">
var table;
$(function(){
  $('.tabel-produk').DataTable();
  

  table = $('.tabel-penerimaan').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('terima.data', $idpenerimaan) }}",
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
      $('.form-penerimaan').submit();
   });

});

function addItem(){
  $.ajax({
    url : "{{ route('terima.store') }}",
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
        url : "terima/"+id,
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
       url : "terima/"+id,
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
  $('#subtotal').val($('.subtotal').text());
  $('#totalitem').val($('.totalitem').text());
}

</script>

@endsection