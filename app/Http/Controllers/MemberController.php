<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listData()
    {
        $member = Member::orderBy('id_member', 'desc')->get();
        $no = 0;
        $data = array();
        foreach($member as $list){
            $no ++;
            $row = array();
            $row[] = "<input type='checkbox' name='id[]'' value='".$list->id_member."'>";
            $row[] = $no;
            $row[] = $list->nim;
            $row[] = $list->nama;
            $row[] = $list->jurusan;
            $row[] = $list->alamat;
            $row[] = $list->telpon;
            $row[] = '<div class="btn-group">
               <a onclick="editForm('.$list->id_member.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData('.$list->id_member.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
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
    public function store(Request $request)
    {
        $jml = Member::where('nim', '=', $request['kode'])->count();
        if($jml < 1) {
            $member = new Member;
            $member->nim = $request['kode'];
            $member->nama = $request['nama'];
            $member->jurusan = $request['jurusan'];
            $member->alamat = $request['alamat'];
            $member->telpon = $request['telpon'];
            $member->save();
            echo json_encode(array('msg'=>'success'));
        } else{
            echo json_encode(array('msg'=>'error'));
        }
    }

    public function edit($id)
    {
        $member = Member::find($id);
        echo json_encode($member);
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
        $member = Member::find($id);
        $member->nama = $request['nama'];
        $member->jurusan = $request['jurusan'];
        $member->alamat = $request['alamat'];
        $member->telpon = $request['telpon'];
        $member->update();
        echo json_encode(array('msg'=>'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();
    }
}
