<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\penerimaan;
use App\PenerimaanDetail;
use App\Produk;

class PenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penerimaan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listData()
    {
       $penerimaan = penerimaan::orderBy('id_penerimaan', 'desc')->get();
       $no = 0;
       $data = array();
       foreach ($penerimaan as $list) {
           $no ++;
           $row = array();
           $row[] = $no;
           $row[] = tanggal_indonesia(substr($list->created_at, 0, 10), false);
           $row[] = $list->penerimaanDetails->count();
           $row[] = '<div class="btn-group">
               <a onclick="showDetail('.$list->id_penerimaan.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
               <a onclick="deleteData('.$list->id_penerimaan.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
              </div>';
            $data[] = $row;
       }
       $output = array("data" => $data);
        return response()->json($output);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function show($id)
   {
   
     $detail = PenerimaanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'detail_penerimaan.kode_produk')
        ->where('id_penerimaan', '=', $id)
        ->get();
     $no = 0;
     $data = array();
     foreach($detail as $list){
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $list->kode_produk;
       $row[] = $list->nama_produk;
       $row[] = $list->volume;
       $row[] = $list->jumlah;
       $row[] = $list->subtotal = $list->volume * $list->jumlah;
       $row[] = '<div class="btn-group">
               <a onclick="showItem('.$list->id_produk.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
              </div>';
       $data[] = $row;
     }
    
     $output = array("data" => $data);
     return response()->json($output);
   }
   
public function showItem($id)
   {
   
     $detail = PenerimaanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'detail_penerimaan.kode_produk')
        ->where('id_penerimaan', '=', $id)
        ->get();
     $no = 0;
     $data = array();
     foreach($detail as $list){
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $list->kode_produk;
       $row[] = $list->nama_produk;
       $row[] = $list->volume;
       $row[] = $list->jumlah;
       $row[] = $list->subtotal = $list->volume * $list->jumlah;
       $row[] = '<div class="btn-group">
               <a onclick="showItem('.$list->id_produk.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
              </div>';
       $data[] = $row;
     }
    
     $output = array("data" => $data);
     return response()->json($output);
   }


   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penerimaan = penerimaan::find($id);
      $penerimaan->delete();

      $detail = PenerimaanDetail::where('id_penerimaan', '=', $id)->get();
      foreach($detail as $data){
        $produk = Produk::where('kode_produk', '=', $data->kode_produk)->first();
        $produk->stok -= $data->subtotal;
        $produk->update();
        $data->delete();
      }
    }


}
