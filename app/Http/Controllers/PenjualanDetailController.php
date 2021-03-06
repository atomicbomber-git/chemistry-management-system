<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use PDF;
use App\Penjualan; 
use App\Produk;
use App\Member; 
use App\Setting;
use App\PenjualanDetail;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all();
      $member = Member::all();
      $setting = Setting::first();

        if(!empty(session('idpenjualan'))){
            $idpenjualan = session('idpenjualan');
            return view('penjualan_detail.index', compact('produk','member', 'setting', 'idpenjualan'));

        }else{
            return Redirect::route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listData($id)
    {
        $detail = PenjualanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
        ->where('id_penjualan', '=', $id)
        ->get();
        $no = 0;
        $data = array();
        $total = 0;
        $total_item = 0;
        foreach ($detail as $list) {
               $no ++;
               $row = array();
               $row[] = $no;
               $row[] = $list->kode_produk;
               $row[] = $list->nama_produk;
               $row[] = "Rp. ".format_uang($list->harga_jual);
               $row[] = "<input type='number' class='form-control' name='jumlah_$list->id_penjualan_detail' value='$list->jumlah' onChange='changeCount($list->id_penjualan_detail)'>";
               $row[] = "Rp. ".format_uang($list->sub_total);
               $row[] = '<div class="btn-group">
               <a onclick="deleteItem('.$list->id_penjualan_detail.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
               $data[] = $row;

               $total += $list->harga_jual * $list->jumlah;
               $total_item += $list->jumlah;
           }  
           $data[] = array("<span class='hide total'>$total</span><span class='hide totalitem'>$total_item</span>", "", "", "", "", "", "");
    
            $output = array("data" => $data);
            return response()->json($output); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $produk = Produk::where('kode_produk', '=', $request['kode'])->first();
        $detail = new PenjualanDetail;
        $detail->id_penjualan = $request['idpenjualan'];
        $detail->kode_produk = $request['kode'];
        $detail->harga_jual = $produk->harga_jual;
        $detail->jumlah = 1;
        $detail->sub_total = $produk->harga_jual * $detail->jumlah;
        $detail->save();
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nama_input = "jumlah_".$id;
        $detail = PenjualanDetail::find($id);
        $total_harga = $request[$nama_input] * $detail->harga_jual;

        $detail->jumlah = $request[$nama_input];
        $detail->sub_total = $total_harga;
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();
    }

    public function newSession(){
        $penjualan = new Penjualan;
        $penjualan->nim = 0;
        $penjualan->total_item =0;
        $penjualan->total_harga = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = Auth::user()->id;
        $penjualan->save();

        session(['idpenjualan' => $penjualan->id_penjualan]);
        return Redirect::route('transaksi.index');
    }

     public function saveData(Request $request)
   {
      $penjualan = Penjualan::find($request['idpenjualan']);
      $penjualan->nim = $request['member'];
      $penjualan->total_item = $request['totalitem'];
      $penjualan->total_harga = $request['total'];
      $penjualan->bayar = $request['bayar'];
      $penjualan->diterima = $request['diterima'];
      $penjualan->update();

      $detail = PenjualanDetail::where('id_penjualan', '=', $request['idpenjualan'])->get();
      foreach($detail as $data){
        $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
        $produk->stok -= $data->jumlah;
        $produk->update();
      }
      return view('penjualan_detail.selesai');
   }

    public function loadForm($total, $diterima){
        $bayar = $total;
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;

        $data = array(
            "totalrp" => format_uang($total),
            "bayar" => $bayar,
            "bayarrp" => format_uang($bayar),
            "terbilang" => ucwords(terbilang($bayar))." Rupiah",
            "kembalirp" => format_uang($kembali),
            "kembaliterbilang" =>ucwords(terbilang($kembali))." Rupiah"

            );
        return response()->json($data);
    }

     public function notaPDf(){
        $detail = PenjualanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
        ->where('id_penjualan', '=', session('idpenjualan'))
        ->get();

        $penjualan = Penjualan::find(session('idpenjualan'));
        $setting = Setting::find(1);
        $no = 0;

        $pdf = PDF::loadView('penjualan_detail.notapdf', compact('detail', 'penjualan', 'setting', 'no'));
     $pdf->setPaper('a4', 'potrait');      
      return $pdf->stream();
    }

   
}
