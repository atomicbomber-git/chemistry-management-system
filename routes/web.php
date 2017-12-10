<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get("/testing", function() {
	$items = \App\penerimaan::all();

	$items->each(function($item) {
		$item->total = $item->penerimaanDetails->count();
	});

	return $items;
});

Route::get("/test", function(){
	$stoks = \App\Produk::all();

	$stoks->each(function($stok){
		$stok->total = $stok->penerimaanDetails;
	});
	return $stoks;
});

Route::get('/', 'HomeController@index')->name('home');


Route::group(['middleware' => ['web', 'cekuser:1']], function(){
	Route::get('kategori/data', 'KategoriController@listData')->name('kategori.data');
	Route::resource('kategori', 'KategoriController');

	Route::get('user/profil', 'UserController@profil')->name('user.profil');
	Route::patch('user/{id}/change', 'UserController@changeProfil');

	Route::get('produk/data', 'ProdukController@listData')->name('produk.data');
	Route::get('produk/{id}/lihat', 'ProdukController@show');
	Route::post('produk/hapus', 'ProdukController@deleteSelected');
	Route::post('produk/cetak', 'ProdukController@printBarcode');
	Route::resource('produk', 'ProdukController');

	Route::get('member/data', 'MemberController@listData')->name('member.data');
	Route::resource('member', 'MemberController');

	Route::get('penerimaan/data', 'PenerimaanController@listData')->name('penerimaan.data');
	Route::get('penerimaan/{id}/lihat', 'PenerimaanController@show');
	Route::resource('penerimaan', 'PenerimaanController');

	Route::get('terima/baru', 'PenerimaanDetailController@newSession')->name('terima.new');
	Route::get('terima/{id}/data', 'PenerimaanDetailController@listData')->name('terima.data');
	Route::post('terima/simpan', 'PenerimaanDetailController@saveData');
	Route::get('terima/notapdf', 'PenerimaanDetailController@notaPDF')->name('terima.pdf');
	Route::get('terima/loadform/{subtotal}', 'PenerimaanDetailController@loadForm');
	Route::resource('terima', 'PenerimaanDetailController');  

   Route::get('penjualan/data', 'PenjualanController@listData')->name('penjualan.data');
   Route::get('penjualan/{id}/lihat', 'PenjualanController@show');
   Route::resource('penjualan', 'PenjualanController');

   Route::get('pemakaian/data', 'PemakaianController@listData')->name('pemakaian.data');
   Route::get('pemakaian/{id}/lihat', 'PemakaianController@show');
   Route::resource('pemakaian', 'PemakaianController');

   Route::get('penggunaan/baru', 'PemakaianDetailController@newSession')->name('penggunaan.new');
   Route::get('penggunaan/{id}/data', 'PemakaianDetailController@listData')->name('penggunaan.data');
   Route::get('penggunaan/notapdf', 'PemakaianDetailController@notaPDF')->name('penggunaan.pdf');
   Route::post('penggunaan/simpan', 'PemakaianDetailController@saveData');
   Route::get('penggunaan/loadform/{total}', 'PemakaianDetailController@loadForm');
   Route::resource('penggunaan', 'PemakaianDetailController');

   Route::get('barangrusak/data', 'BarangrusakController@listData')->name('barangrusak.data');
   Route::get('barangrusak/{id}/lihat', 'BarangrusakController@show');
   Route::resource('barangrusak', 'BarangrusakController');

   Route::get('rusak/baru', 'BarangrusakDetailController@newSession')->name('rusak.new');
   Route::get('rusak/{id}/data', 'BarangrusakDetailController@listData')->name('rusak.data');
   Route::get('rusak/notapdf', 'BarangrusakDetailController@notaPDF')->name('rusak.pdf');
   Route::post('rusak/simpan', 'BarangrusakDetailController@saveData');
   Route::get('rusak/loadform/{total}', 'BarangrusakDetailController@loadForm');
   Route::resource('rusak', 'BarangrusakDetailController');

   Route::get('transaksi/baru', 'PenjualanDetailController@newSession')->name('transaksi.new');
	Route::get('transaksi/{id}/data', 'PenjualanDetailController@listData')->name('transaksi.data');
	Route::get('transaksi/notapdf', 'PenjualanDetailController@notaPDF')->name('transaksi.pdf');
	Route::post('transaksi/simpan', 'PenjualanDetailController@saveData');
	Route::get('transaksi/loadform/{total}/{diterima}', 'PenjualanDetailController@loadForm');
	Route::resource('transaksi', 'PenjualanDetailController');

	Route::get('pengeluaran/data', 'PengeluaranController@listData')->name('pengeluaran.data');
	Route::resource('pengeluaran', 'PengeluaranController');

	Route::get('laporan', 'LaporanController@index')->name('laporan.index');
   Route::post('laporan', 'LaporanController@refresh')->name('laporan.refresh');
   Route::get('laporan/data/{awal}/{akhir}', 'LaporanController@listData')->name('laporan.data'); 
   Route::get('laporan/pdf/{awal}/{akhir}', 'LaporanController@exportPDF');

   Route::get('laporanstok', 'LaporanStokController@index')->name('laporanstok.index');
   Route::get('laporanstok/data', 'LaporanStokController@listData')->name('laporanstok.data'); 
   Route::get('laporanstok/pdf', 'LaporanStokController@exportPDF');

  
});

	Route::group(['middleware' => 'web'], function(){
	Route::get('user/data', 'UserController@listData')->name('user.data');
	Route::resource('user', 'UserController');
	Route::get('user/profil', 'UserController@profil')->name('user.profil');
	Route::patch('user/{id}/change', 'UserController@changeProfil');

	Route::get('laporan', 'LaporanController@index')->name('laporan.index');
   Route::post('laporan', 'LaporanController@refresh')->name('laporan.refresh');
   Route::get('laporan/data/{awal}/{akhir}', 'LaporanController@listData')->name('laporan.data'); 
   Route::get('laporan/pdf/{awal}/{akhir}', 'LaporanController@exportPDF');

   Route::get('laporanpenerimaan', 'LaporanPenerimaanController@index')->name('laporanpenerimaan.index');
   Route::post('laporanpenerimaan', 'LaporanPenerimaanController@refresh')->name('laporanpenerimaan.refresh');
   Route::get('laporanpenerimaan/data/{awal}/{akhir}', 'LaporanPenerimaanController@listData')->name('laporanpenerimaan.data'); 
   Route::get('laporanpenerimaan/pdf/{awal}/{akhir}', 'LaporanPenerimaanController@exportPDF');

   Route::get('laporanpenjualan', 'LaporanPenjualanController@index')->name('laporanpenjualan.index');
   Route::post('laporanpenjualan', 'LaporanPenjualanController@refresh')->name('laporanpenjualan.refresh');
   Route::get('laporanpenjualan/data/{awal}/{akhir}', 'LaporanPenjualanController@listData')->name('laporanpenjualan.data'); 
   Route::get('laporanpenjualan/pdf/{awal}/{akhir}', 'LaporanPenjualanController@exportPDF');

   Route::get('laporanpemakaian', 'LaporanPemakaianController@index')->name('laporanpemakaian.index');
   Route::post('laporanpemakaian', 'LaporanPemakaianController@refresh')->name('laporanpemakaian.refresh');
   Route::get('laporanpemakaian/data/{awal}/{akhir}', 'LaporanPemakaianController@listData')->name('laporanpemakaian.data'); 
   Route::get('laporanpemakaian/pdf/{awal}/{akhir}', 'LaporanPemakaianController@exportPDF');

   Route::get('laporanrusak', 'LaporanRusakController@index')->name('laporanrusak.index');
   Route::post('laporanrusak', 'LaporanRusakController@refresh')->name('laporanrusak.refresh');
   Route::get('laporanrusak/data/{awal}/{akhir}', 'LaporanRusakController@listData')->name('laporanrusak.data'); 
   Route::get('laporanrusak/pdf/{awal}/{akhir}', 'LaporanRusakController@exportPDF');

   Route::get('kadaluarsa', 'KadaluarsaController@index')->name('kadaluarsa.index');
   Route::get('kadaluarsa/data', 'KadaluarsaController@listData')->name('kadaluarsa.data'); 
   Route::resource('kadaluarsa', 'KadaluarsaController');

	Route::resource('setting', 'SettingController');

	
});