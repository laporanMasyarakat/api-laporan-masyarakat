<?php

namespace App\Http\Controllers;

use App\Pengaduans;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
  public function __construct()
  {
    // $this->middleware('auth');
  }

  public function getPengaduan()
  {
    $data = Pengaduans::all();
    if ($data) {
      return response()->json([
        'success' =>  true,
        'code'    =>  200,
        'message' =>  'Success get Pengaduan',
        'data'    =>  $data
      ], 200);
    } else {
      return response()->json([
        'success' =>  true,
        'code'    =>  400,
        'message' =>  'Failed Get Pengaduan',
        'data'    =>  ''
      ], 400);
    }
  }

  public function createPengaduan(Request $request)
  {
    $user = User::where('api_token', explode(' ', $request->header('Authorization'))[1])->first();
    //get image
    if ($request->hasFile('foto')) {
      $original_filename  = $request
        ->file('foto')
        ->getClientOriginalName();
      $original_filename_arr  = explode('.', $original_filename);
      $file_ext = end($original_filename_arr);
      $destination_path = './upload/fotopengaduan';
      $image  = 'A-' . time() . '.' . $file_ext;
      $request->file('foto')->move($destination_path, $image);
      $fotopengaduan = 'http://localhost:8000/upload/fotopengaduan/' . $image;
    }


    $judul_laporan  = $request->input('judul_laporan');
    $tgl_pengaduan  = $request->input('tgl_pengaduan');
    $isi_laporan    = $request->input('isi_laporan');
    $kota           = $request->input('kota');
    $longtitude     = $request->input('longtitude');
    $latitude       = $request->input('latitude');
    //get data
    $data = [
      'judul_laporan' =>  $judul_laporan,
      'tgl_pengaduan' =>  $tgl_pengaduan,
      'username'      =>  $user->username,
      'isi_laporan'   =>  $isi_laporan,
      'kota'          =>  $kota,
      'longtitude'    =>  $longtitude,
      'latitude'      =>  $latitude,
      'foto'          =>  $fotopengaduan,
      'status'        =>  'Belum Proses'
    ];

    if (Pengaduans::create($data)) {
      return response()->json([
        'success' =>  true,
        'code'    =>  200,
        'message' =>  'Pengaduan was Created',
        'data'    =>  $data
      ], 200);
    } else {
      return response()->json([
        'success' =>  false,
        'code'    =>  400,
        'message' =>  'Pengaduan created failed',
        'data'    =>  ''
      ], 400);
    }
  }

  //get per id
  public function getPengaduanId($id)
  {
    $data = Pengaduans::where('id_pengaduan', $id)->get();

    return response()->json([
      'success' => true,
      'code'    =>  200,
      'message' =>  'success get pengaduan by id',
      'data'    =>  $data
    ], 200);
  }

  //update status
  public function updateStatus(Request $request, $id)
  {
    $data = Pengaduans::find($id);

    $data->update([
      'status'  =>  $request->status
    ]);

    if ($data) {
      return response()->json([
        'success' =>  true,
        'code'    =>  200,
        'message' =>  'success update status',
        'data'    =>  $data
      ], 200);
    }
  }
}
