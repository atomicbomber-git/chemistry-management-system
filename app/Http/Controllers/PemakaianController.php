<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\pemakaian;
use App\Produk;
use App\PemakaianDetail;

class PemakaianController extends Controller
{
    public function index(){
    	return view('pemakaian.index');
    }

    public function listData(){
    	$pemakaian = pemakaian::leftJoin('users', 'users.id', '=', 'pemakaian.id_user')
        ->select('users.*', 'pemakaian.*', 'pemakaian.created_at as tanggal')
        ->orderBy('pemakaian.id_pemakaian', 'desc')
        ->get();
    	$no = 0;
    	$data = array();

    	foreach ($pemakaian as $list) {
    		$no ++;
    		$row = array();
    		$row[] = $no;
    		$row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
    		$row[] = $list->tujuan;
    		$row[] = $list->pemakaianDetails->count();
    		$row[] = $list->name;
    		$row[] = '<div class="btn-group">
               <a onclick="showDetail('.$list->id_pemakaian.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
               <a onclick="deleteData('.$list->id_pemakaian.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
              </div>';
             $data[] = $row;
    	}
    	$output = array("data" => $data);
    	return response()->json($output);
    }

    public function show($id){
    	$detail = PemakaianDetail::leftJoin('produk', 'produk.kode_produk', '=', 'pemakaian_detail.kode_produk')
    	->where('id_pemakaian', '=', $id)
    	->get();

    	$no = 0;
    	$data = array();
    	foreach ($detail as $list) {
    		$no ++;
    		$row = array();
    		$row[] = $no;
    		$row[] = $list->kode_produk;
    		$row[] = $list->nama_produk;
    		$row[] = $list->jumlah;
    		$data[] = $row;
    	}
    	$output = array("data" => $data);
    	return response()->json($output);
    }

    public function destroy($id){
    	 $pemakaian = pemakaian::find($id);
      $pemakaian->delete();

      $detail = PemakaianDetail::where('id_pemakaian', '=', $id)->get();
      foreach($detail as $data){
        $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
        $produk->stok += $data->jumlah;
        $produk->update();
        $data->delete();
      }
    }
}
