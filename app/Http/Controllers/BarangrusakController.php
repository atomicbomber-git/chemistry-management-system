<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Barangrusak;
use App\Produk;
use App\BarangrusakDetail;

class BarangrusakController extends Controller
{
    public function index(){
    	return view('barangrusak.index');
    }

    public function listData(){
    	$barangrusak = Barangrusak::leftJoin('users', 'users.id', '=', 'barangrusak.id_user')
        ->select('users.*', 'barangrusak.*', 'barangrusak.created_at as tanggal')
        ->orderBy('barangrusak.id_rusak', 'desc')
        ->get();
    	$no = 0;
    	$data = array();

    	foreach ($barangrusak as $list) {
    		$no ++;
    		$row = array();
    		$row[] = $no;
    		$row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
    		$row[] = $list->sebab;
    		$row[] = $list->rusakDetails->count();
    		$row[] = $list->name;
    		$row[] = '<div class="btn-group">
               <a onclick="showDetail('.$list->id_rusak.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
               <a onclick="deleteData('.$list->id_rusak.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
              </div>';
             $data[] = $row;
    	}
    	$output = array("data" => $data);
    	return response()->json($output);
    }

    public function show($id){
    	$detail = BarangrusakDetail::leftJoin('produk', 'produk.kode_produk', '=', 'barangrusak_detail.kode_produk')
    	->where('id_rusak', '=', $id)
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
    	 $barangrusak = Barangrusak::find($id);
      $barangrusak->delete();

      $detail = BarangrusakDetail::where('id_rusak', '=', $id)->get();
      foreach($detail as $data){
        $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
        $produk->stok += $data->jumlah;
        $produk->update();
        $data->delete();
      }
    }
}
