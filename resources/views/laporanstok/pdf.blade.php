<!DOCTYPE html>
<html>
<head>  
  <title>Laporan Stok Produk PDF</title>
  <link rel="stylesheet" href="{{ asset('adminLTE/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
 
<h3 class="text-center">Laporan Stok</h3>
<h4 class="text-center">{{ tanggal_indonesia(date('Y-m-d')) }}</h4>

         
<table class="table table-striped">
<thead>
   <tr>
    <th>No</th>
    <th>Kode Produk</th>
    <th>Nama Produk</th>
    <th>Stok</th>
    <th>Satuan</th>
    <th>Tanggal Kadaluarsa</th>
   </tr>

   <tbody>
    @foreach($data as $row)    
    <tr>
    @foreach($row as $col)
     <td>{{ $col }}</td>
    @endforeach
    </tr>
    @endforeach
   </tbody>
</table>

</body>
</html>