<!DOCTYPE html>
<html>
<head>
   <title>Nota PDF</title>
   <style type="text/css">
      table td{font: arial 12px;}
      table.data td,
      table.data th{
         border: 1px solid #ccc;
         padding: 5px;
      }
      table.data th{
         text-align: center;
      }
      table.data{ border-collapse: collapse }
   </style>
</head>
<body>

<table width="100%">
  <tr>
     <td width="10%"><img src="images/{{$setting->logo}}" width="100">   
     </td>
     <td align="center"><h3>Laboratorium Biologi MIPA Universitas Tanjungpura</h3>
      <h6>{{ $setting->alamat }}</h6>
      <h6>{{ $setting->telepon}}</h6>
     </td>
  </tr>     
</table>
{{ tanggal_indonesia(date('Y-m-d')) }}
<hr>

<h3 align="center"><b>Laporan Penerimaan Bahan Kimia</b></h3>
         
<table width="100%" class="data">
<thead>
   <tr>
    <th>No</th>
    <th>Kode Produk</th>
    <th>Nama Produk</th>
    <th>Volume</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
   </tr>

   <tbody>
    @foreach($detail as $data)
      
    <tr>
       <td>{{ ++$no }}</td>
       <td>{{ $data->kode_produk }}</td>
       <td>{{ $data->nama_produk }}</td>
       <td align="right">{{ $data->volume}}</td>
       <td>{{ $data->jumlah }}</td>
       <td align="right">{{ $data->subtotal }}</td>
    </tr>
    @endforeach
   
   </tbody>

</table>
<table width="100%">
  <tr>
    <td></td>
    <td align="right">{{ tanggal_indonesia(date('Y-m-d')) }}<br>
      Penanggung Jawab<br><br><br> {{Auth::user()->name}}
    </td>
  </tr>
</table>
</body>
</html>