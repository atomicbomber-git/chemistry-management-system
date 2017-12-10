<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tahunmasuk;

class TahunmasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tahunmasuk.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listData()
   {
   
     $tahunmasuk = Tahunmasuk::orderBy('id_tahun', 'desc')->get();
     $no = 0; 
     $data = array();
     foreach($tahunmasuk as $list){
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $list->tahun;
       $row[] = tanggal_indonesia(substr($list->created_at, 0, 10), false);
       $row[] = '<div class="btn-group">
               <a onclick="editForm('.$list->id_tahun.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData('.$list->id_tahun.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
       $data[] = $row;
     }

     $output = array("data" => $data);
     return response()->json($output);
   }
    public function store(Request $request)
    {
        $tahunmasuk = new Tahunmasuk;
        $tahunmasuk->tahun = $request['nama'];
        $tahunmasuk->save();
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
        $tahunmasuk = Tahunmasuk::find($id);
        echo json_encode($tahunmasuk);

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
        $tahunmasuk = Tahunmasuk::find($id);
      $tahunmasuk->tahun = $request['nama'];
      $tahunmasuk->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tahunmasuk = Tahunmasuk::find($id);
        $tahunmasuk->delete();
    }
}
