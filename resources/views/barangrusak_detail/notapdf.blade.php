<!DOCTYPE html>
<html>
<head>
   <title>Laporan Bahan Kimia Rusak</title>
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
     <td rowspan="3" width="40%"><img src="images/{{$setting->logo}}" width="80"><br>
     {{ $setting->alamat }}<br><br>
     </td>
     <td>Tanggal</td>
     <td>: {{ tanggal_indonesia(date('Y-m-d')) }}</td>
  </tr>     
  <tr>
     <td>Keterangan</td>
     <td>: {{ $barangrusak->sebab }}</td>
  </tr>
</table>
         
<table width="100%" class="data">
<thead>
   <tr>
    <th>No</th>
    <th>Kode Produk</th>
    <th>Nama Produk</th>
    <th>Jumlah</th>
   </tr>

   <tbody>
    @foreach($detail as $data)
      
    <tr>
       <td>{{ ++$no }}</td>
       <td>{{ $data->kode_produk }}</td>
       <td>{{ $data->nama_produk }}</td>
       <td>{{ $data->jumlah }}</td>
    </tr>
    @endforeach
   
   </tbody>
   
</table>

<table width="100%">
  <tr>
    <td>
      <b>Laboratorium Biologi MIPA</b>
      <b>Universitas Tanjungpura</b>
    </td>
    <td align="center">{{ tanggal_indonesia(date('Y-m-d')) }}<br>
      Penanggung Jawab<br><br><br> {{Auth::user()->name}}
    </td>
  </tr>
</table>
</body>
</html>