<?php

namespace App\Http\Controllers;

use App\Petugas;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class PetugasController extends Controller
{
  public function createPetugas(Request $request)
  {
    $nama_petugas   = $request->input('nama_petugas');
    $tanggal_lahir  = $request->input('tanggal_lahir');
    $jenis_kelamin  = $request->input('jenis_kelamin');
    $no_telp        = $request->input('no_telp');
    $username       = $request->input('username');
    $email          = $request->input('email');
    $role           = $request->input('role');
    $password       = Hash::make($request->input('password'));

    $register = User::create([
      'username'  =>  $username,
      'email'     =>  $email,
      'password'  =>  $password,
      'role'      =>  $role 
    ]);

    

    $petugas = Petugas::create([
      'nama_petugas'  =>  $nama_petugas,
      'tanggal_lahir' =>  $tanggal_lahir,
      'jenis_kelamin' =>  $jenis_kelamin,
      'no_telp'       =>  $no_telp,
      'email'         =>  $email,
      'role'          =>  $role
    ]);

    if ($petugas) {
      return response()->json([
        'success' =>  true,
        'status'  =>  '200',
        'message' =>  'Success create Petugas',
        'data'    =>  $petugas
        ], 200);
    } else {
      return response()->json([
        'success' =>  false,
        'status'  =>  400,
        'message' =>  'Failed create petugas',
        'data'    =>  ''
      ], 400);
    }
  }

  public function getPetugas()
  {
    $data = Petugas::all();
    if ($data) {
      return response()->json([
        'success'   =>  true,
        'code'      =>  200,
        'message'   =>  'Success Get all Petugas',
        'data'      =>  $data
      ], 200);
    } else {
      return response()->json([
        'success' =>  true,
        'code'    =>  400,
        'message' =>  'Failed Get All User',
        'data'    =>  ''
      ], 400);
    }
  }

  public function deletePetugas($id)
  {
    $data = Petugas::destroy($id);
    if ($data) {
      return response()->json([
        'success' =>  true,
        'code'    =>  200,
        'message' =>  'Success Delete petugas'
      ],200);
    } else {
      return response()->json([
        'success' =>  false,
        'code'    =>  400,
        'message' =>  'Failed delete petugas',
      ],400);
    }
    
  }
}
