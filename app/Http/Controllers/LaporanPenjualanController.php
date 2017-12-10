<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Penjualan;
use App\PenjualanDetail; 

use PDF;

class LaporanPenjualanController extends Controller
{
     public function index()
    {
        $awal = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');
        return view('laporanpenjualan.index', compact('awal', 'akhir'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function getData($awal, $akhir){
     $no = 0;
     $data = array();  
     while(strtotime($awal) <= strtotime($akhir)){
       $tanggal = $awal;
       $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

       $detail = PenjualanDetail::leftJoin('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
       ->leftJoin('produk', 'produk.kode_produk', '=', 'penjualan_detail.kode_produk')
        ->where('penjualan_detail.created_at', 'LIKE', "$tanggal%")
        ->get();
       foreach ($detail as $list) {
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = tanggal_indonesia($tanggal, false);
       $row[] = $list->kode_produk;
       $row[] = $list->nama_produk;
       $row[] = $list->harga_jual;
       $row[] = $list->jumlah;
       $row[] = $list->sub_total;
       $row[] = $list->nim;  
       $data[] = $row;
     }
       }
     return $data;
     
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function listData($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        $output = array("data" => $data);
        return response()->json($output);
    }

     public function refresh(Request $request)
    {
        $awal = $request['awal'];
        $akhir = $request['akhir'];

        return view('laporanpenjualan.index', compact('awal', 'akhir'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportPDF($awal, $akhir){
     $tanggal_awal = $awal;
     $tanggal_akhir = $akhir;
     $data = $this->getData($awal, $akhir);

     $pdf = PDF::loadView('laporanpenjualan.pdf', compact('tanggal_awal', 'tanggal_akhir', 'data'));
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
