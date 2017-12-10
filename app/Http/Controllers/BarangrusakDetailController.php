<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use PDF;
use App\Barangrusak;
use App\Produk;
use App\BarangrusakDetail;
use App\Setting;

class BarangrusakDetailController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        $setting = Setting::first();

        if(!empty(session('idbarangrusak'))){
            $idbarangrusak = session('idbarangrusak');
            return view('barangrusak_detail.index', compact('produk', 'setting', 'idbarangrusak'));
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
   
     $detail = BarangrusakDetail::leftJoin('produk', 'produk.kode_produk', '=', 'barangrusak_detail.kode_produk')
        ->where('id_rusak', '=', $id)
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
       $row[] = "<input type='number' class='form-control' name='jumlah_$list->id_barangrusak_detail' value='$list->jumlah' onChange='changeCount($list->id_barangrusak_detail)'>";
       $row[] = '<div class="btn-group">
               <a onclick="deleteItem('.$list->id_barangrusak_detail.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
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

        $detail = new BarangrusakDetail;
        $detail->id_rusak = $request['idbarangrusak'];
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
      $detail = BarangrusakDetail::find($id);
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
        $detail = BarangrusakDetail::find($id);
        $detail->delete();
    }

    public function newSession(){
        $barangrusak = new Barangrusak;
        $barangrusak->total_item = 0;
        $barangrusak->sebab = 'Kadaluarsa';
        $barangrusak->id_user = Auth::user()->id;
        $barangrusak->save();

        session(['idbarangrusak' => $barangrusak->id_rusak]);

        return Redirect::route('rusak.index');

    }

    public function saveData(Request $request){
        $barangrusak = Barangrusak::find($request['idbarangrusak']);
        $barangrusak->total_item = 0;
        $barangrusak->sebab = $request['sebab'];
        $barangrusak->update();

        $detail = BarangrusakDetail::where('id_rusak', '=', $request['idbarangrusak'])->get();
        foreach ($detail as $data) {
            $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
            $produk->stok -= $data->jumlah;
            $produk->update();
        }
        return view('barangrusak_detail.selesai');
    }

    public function loadForm($total){
        $subtotal = $total;

    }

    public function notaPDf(){
        $detail = BarangrusakDetail::leftJoin('produk', 'produk.kode_produk', '=', 'barangrusak_detail.kode_produk')
        ->where('id_rusak', '=', session('idbarangrusak'))
        ->get();

        $barangrusak = Barangrusak::find(session('idbarangrusak'));
        $setting = Setting::find(1);
        $no = 0;

        $pdf = PDF::loadView('barangrusak_detail.notapdf', compact('detail', 'barangrusak', 'setting', 'no'));
        $pdf->setPaper('a4', 'potrait');      
        return $pdf->stream();
    }
}
