<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;


class KadaluarsaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('kadaluarsa.index');
    }

    public function listData() {
        $produk = Produk::orderBy('id_produk', 'desc')->get();
        $no = 0;
        $data = array();
        foreach ($produk as $list) {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = tanggal_indonesia($list->tgl_kadaluarsa);
            $row[] = $list->kode_produk;
            $row[] = $list->nama_produk;
            $data[] = $row;
        }
        return $data;
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
