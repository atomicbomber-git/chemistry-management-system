<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listData(){
       $user = User::where('level', '!=', 1)->orderBy('id', 'desc')->get();
     $no = 0;
     $data = array();
     foreach($user as $list){
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $list->name;
       $row[] = $list->email;
       $row[] = '<div class="btn-group">
               <a onclick="editForm('.$list->id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData('.$list->id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
       $data[] = $row;
     }

     $output = array("data" => $data);
     return response()->json($output);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request['nama'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->level = 1;
        $user->foto = "user.png";
        $user->save();
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
        $user = User::find($id);
     echo json_encode($user);
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
      $user = User::find($id);
      $user->name = $request['nama'];
      $user->email = $request['email'];
      if(!empty($request['password'])) $user->password = bcrypt($request['password']);
      $user->update();
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

       
    }

    public function profil(){
        $user = Auth::user();
      return view('user.profil', compact('user')); 
    }

    public function changeProfil(Request $request, $id){
         $msg = "succcess";
      $user = User::find($id);
      if(!empty($request['password'])){
        if(Hash::check($request['passwordlama'], $user->password)){
         $user->password = bcrypt($request['password']);
        }else{
         $msg = 'error';
        }
      } 

      if ($request->hasFile('foto')) {
         $file = $request->file('foto');
         $nama_gambar = "fotouser_".$id.".".$file->getClientOriginalExtension();
         $lokasi = public_path('images');

         $file->move($lokasi, $nama_gambar);
         $user->foto         = $nama_gambar;  
         
         $datagambar = $nama_gambar;
      }else{
         $datagambar = $user->foto; 
      }

      $user->update();
      echo json_encode(array('msg'=>$msg, 'url'=> asset('public/images/'.$datagambar))); 
   }
}