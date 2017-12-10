<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect; 
use Auth;
use App\penerimaan;
use App\Setting;
use App\Produk;
use App\PenerimaanDetail;
use PDF;

class PenerimaanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  index(){
      $produk = Produk::all();
      $setting = Setting::all();
      if(!empty(session('idpenerimaan'))){
       $idpenerimaan = session('idpenerimaan');
       return view('penerimaandetail.index', compact('produk', 'setting', 'idpenerimaan'));
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
   
    $detail = PenerimaanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'detail_penerimaan.kode_produk')
        ->where('id_penerimaan', '=', $id)
        ->get();
     $no = 0;
     $data = array();
     $subtotal = 0;
     $total_item = 0;
     foreach($detail as $list){
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $list->kode_produk;
       $row[] = $list->nama_produk;
       $row[] = "<input type='number' class='form-control' name='volume_$list->id_detail_penerimaan' value='$list->volume' onChange='changeCount($list->id_detail_penerimaan)'>";
       $row[] = "<input type='number' class='form-control' name='jumlah_$list->id_detail_penerimaan' value='$list->jumlah' onChange='changeCount($list->id_detail_penerimaan)'>";
       $row[] = $list->subtotal = $list->volume * $list->jumlah;
       $row[] = '<div class="btn-group">
               <a onclick="deleteItem('.$list->id_detail_penerimaan.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
       $data[] = $row;

       $subtotal += $list->volume * $list->jumlah;
       $total_item += $list->subtotal;
     }

     $data[] = array("<span class='hide total'>$subtotal</span><span class='hide totalitem'>$total_item</span>", "", "", "", "", "", "", "");
    
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

        $detail = new PenerimaanDetail;
        $detail->id_penerimaan = $request['idpenerimaan'];
        $detail->kode_produk = $request['kode'];
        $detail->volume = 1;
        $detail->jumlah = 1;
        
        $detail->subtotal = $detail->volume * $detail->jumlah;
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
        $namainput = "volume_".$id;
        $nama_input = "jumlah_".$id;
        
        $detail = PenerimaanDetail::find($id);
        $detail->volume = $request[$namainput];
        $detail->jumlah = $request[$nama_input];   
        $detail->subtotal = $request[$namainput] * $request[$nama_input];
        
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
        $detail = PenerimaanDetail::find($id);
        $detail->delete();
    }

    public function newSession(){
        $penerimaan = new penerimaan;
        $penerimaan->total_item = 0;
        $penerimaan->save();

        session(['idpenerimaan' => $penerimaan->id_penerimaan]);

        return Redirect::route('terima.index');

    }

   public function saveData(Request $request)
   {
      $penerimaan = penerimaan::find($request['idpenerimaan']);
      $penerimaan->total_item = 0;
      $penerimaan->update();

      $detail = PenerimaanDetail::where('id_penerimaan', '=', $request['idpenerimaan'])->get();
      foreach($detail as $data){
        $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
        $produk->stok += $data->subtotal;
        
        $produk->update();
      }
      return view('penerimaandetail.selesai');
   }

   public function loadForm($total){
        $total = $subtotal;

    }

    public function notaPDf(){
        $detail = PenerimaanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'detail_penerimaan.kode_produk')
        ->where('id_penerimaan', '=', session('idpenerimaan'))
        ->get();

        $penjualan = penerimaan::find(session('idpenerimaan'));
        $setting = Setting::find(1);
        $no = 0;

        $pdf = PDF::loadView('penerimaandetail.notapdf', compact('detail', 'penerimaan', 'setting', 'no'));
        $pdf->setPaper('a4', 'potrait');      
        return $pdf->stream();
    }

}
