<!DOCTYPE html>
<html>
<head>  
  <title>Laporan Penjualan PDF</title>

  <link rel="stylesheet" href="css/app.css">
</head>
<body>
 
<h3 class="text-center">Laporan Transaksi Penjualan Bahan Kimia</h3>
<h4 class="text-center">Tanggal  {{ tanggal_indonesia($tanggal_awal) }} s/d {{ tanggal_indonesia($tanggal_akhir) }} </h4>

         
<table class="table table-striped">
<thead>
   <tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Kode Produk</th>
    <th>Nama Produk</th>
    <th>Harga Jual</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
    <th>Nim</th>
   </tr>
</thead>
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