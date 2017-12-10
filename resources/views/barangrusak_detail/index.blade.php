@extends('layouts.app')

@section('title')
  Bahan Kimia Yang Rusak 
@endsection

@section('breadcrumb')
   @parent
   <li>bahan rusak</li>
   <li>tambah</li>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">
   
      <div class="box-body">

<form class="form form-horizontal form-produk" method="post">
{{ csrf_field() }}  
  <input type="hidden" name="idbarangrusak" value="{{ $idbarangrusak }}">
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
<table class="table table-striped tabel-rusak">
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
    <form class="form form-horizontal form-rusak" method="post" action="rusak/simpan">
      {{ csrf_field() }}
      <input type="hidden" name="idbarangrusak" value="{{ $idbarangrusak }}">
      <input type="hidden" name="total" id="total">
      <input type="hidden" name="totalitem" id="totalitem">
      
      <div class="form-group">
        <label for="sebab" class="col-md-4 control-label">Keterangan</label>
        <div class="col-md-8">
          <div class="input-group">
            <select id="sebab" type="text" class="form-control" name="sebab" required>
              <option value="Bahan hilang">-- Pilih Keterangan --</option>
              <option value="Bahan sudah kadaluarsa">Bahan sudah kadaluarsa</option>
              <option value="Bahan tumpah">Bahan tumpah</option>
              <option value="Bahan hilang">Bahan hilang</option>
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
@include('barangrusak_detail.produk')

@endsection

@section('script')
<script type="text/javascript">
var table;
$(function(){
  $('.tabel-produk').DataTable();

  table = $('.tabel-rusak').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('rusak.data', $idbarangrusak) }}",
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
      $('.form-rusak').submit();
   });

});

function addItem(){
  $.ajax({
    url : "{{ route('rusak.store') }}",
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
        url : "rusak/"+id,
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
       url : "rusak/"+id,
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