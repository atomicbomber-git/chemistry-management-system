<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Produk;
use PDF;
class LaporanStokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $awal = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');
        return view('laporanstok.index', compact('awal', 'akhir'));
    }

    protected function getData($awal, $akhir){
     $no = 0;
     $data = array();
     
     while(strtotime($awal) <= strtotime($akhir)){
       $tanggal = $awal;
       $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
       $produk = Produk::where('kode_produk', 'LIKE', "$tanggal%")->sum('subtotal');
       $total_penerimaan = PenerimaanDetail::where('kode_produk', 'LIKE', "$tanggal%")->sum('subtotal');
       $total_penjualan = PenjualanDetail::where('kode_produk', 'LIKE', "$tanggal%")->sum('jumlah');
       $total_pemakaian = PemakaianDetail::where('kode_produk', 'LIKE', "$tanggal%")->sum('jumlah');

       $penerimaan = $total_penerimaan - $total_penjualan - $total_pengeluaran;

       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $total_penerimaan;
       $row[] = $total_penjualan;
       $row[] = $total_pemakaian;
       $row[] = $penerimaan;
       $data[] = $row;
     }
     return $data;
   }


    public function listData($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

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
        //
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
    public function exportPDF(){
    $produk = Produk::orderBy('id_produk', 'desc')->get();
     
     $pdf = PDF::loadView('laporanstok.pdf', compact('produk'));
     $pdf->setPaper('a4', 'potrait');
     
     return $pdf->stream();
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
        //
    }
}
