<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\penerimaan;
use App\PenerimaanDetail; 

use PDF;

class LaporanPenerimaanController extends Controller
{
    public function index()
    {
        $awal = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');
        return view('laporanpenerimaan.index', compact('awal', 'akhir'));
    }

    protected function getData($awal, $akhir){
     $no = 0;
     $data = array();  
     while(strtotime($awal) <= strtotime($akhir)){
       $tanggal = $awal;
       $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

       $detail = PenerimaanDetail::leftJoin('produk', 'produk.kode_produk', '=', 'detail_penerimaan.kode_produk')
        ->where('detail_penerimaan.created_at', 'LIKE', "$tanggal%")
        ->get();
       foreach ($detail as $list) {
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = tanggal_indonesia($tanggal, false);
       $row[] = $list->kode_produk;
       $row[] = $list->nama_produk;
       $row[] = $list->subtotal;       
       $data[] = $row;
     }
       }
     return $data;
	 
   }

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

        return view('laporanpenerimaan.index', compact('awal', 'akhir'));
    }

   public function exportPDF($awal, $akhir){
     $tanggal_awal = $awal;
     $tanggal_akhir = $akhir;
     $data = $this->getData($awal, $akhir);

     $pdf = PDF::loadView('laporanpenerimaan.pdf', compact('tanggal_awal', 'tanggal_akhir', 'data'));
     $pdf->setPaper('a4', 'potrait');
     
     return $pdf->stream();
   }

}
