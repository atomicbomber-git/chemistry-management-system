<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use PDF;
use App\pemakaian;
use App\Produk;
use App\PemakaianDetail;
use App\Setting;

class PemakaianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all();
        $setting = Setting::first();

        if(!empty(session('idpemakaian'))){
            $idpemakaian = session('idpemakaian');
            return view('pemakaian_detail.index', compact('produk', 'setting', 'idpemakaian'));
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
   
     $detail = PemakaianDetail::leftJoin('produk', 'produk.kode_produk', '=', 'pemakaian_detail.kode_produk')
        ->where('id_pemakaian', '=', $id)
        ->get();
     $no = 0;
     $data = array();
     $total = 0;
     $total_item = 0;
     foreach($detail as $list){
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $list->kode_produk;
       $row[] = $list->nama_produk;    
       $row[] = "<input type='number' class='form-control' name='jumlah_$list->id_pemakaian_detail' value='$list->jumlah' onChange='changeCount($list->id_pemakaian_detail)'>";
       $row[] = '<div class="btn-group">
               <a onclick="deleteItem('.$list->id_pemakaian_detail.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
       $data[] = $row;

       $total += $list->jumlah * 1;
       $total_item += $list->jumlah;
     }

     $data[] = array("<span class='hide total'>$total</span><span class='hide totalitem'>$total_item</span>", "", "", "", "", "", "", "");
    
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

        $detail = new PemakaianDetail;
        $detail->id_pemakaian = $request['idpemakaian'];
        $detail->kode_produk = $request['kode'];
        $detail->jumlah = 1;
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
      $detail = PemakaianDetail::find($id);
      $detail->jumlah = $request[$nama_input];
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
        $detail = PemakaianDetail::find($id);
        $detail->delete();
    }

    public function newSession(){
        $pemakaian = new pemakaian;
        $pemakaian->total_item = 0;
        $pemakaian->tujuan = 'praktik laboratorium';
        $pemakaian->id_user = Auth::user()->id;
        $pemakaian->save();

        session(['idpemakaian' => $pemakaian->id_pemakaian]);

        return Redirect::route('penggunaan.index');

    }

    public function saveData(Request $request){
        $pemakaian = pemakaian::find($request['idpemakaian']);
        $pemakaian->total_item = 0;
        $pemakaian->tujuan = $request['tujuan'];
        $pemakaian->update();

        $detail = PemakaianDetail::where('id_pemakaian', '=', $request['idpemakaian'])->get();
        foreach ($detail as $data) {
            $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
            $produk->stok -= $data->jumlah;
            $produk->update();
        }
        return view('pemakaian_detail.selesai');
    }

    public function loadForm($total){
        $subtotal = $total;

    }

    public function notaPDf(){
        $detail = PemakaianDetail::leftJoin('produk', 'produk.kode_produk', '=', 'pemakaian_detail.kode_produk')
        ->where('id_pemakaian', '=', session('idpemakaian'))
        ->get();

        $pemakaian = pemakaian::find(session('idpemakaian'));
        $setting = Setting::find(1);
        $no = 0;

        $pdf = PDF::loadView('pemakaian_detail.notapdf', compact('detail', 'pemakaian', 'setting', 'no'));
        $pdf->setPaper('a4', 'potrait');      
        return $pdf->stream();
    }
}
