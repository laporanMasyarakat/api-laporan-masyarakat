<?php

namespace App\Http\Controllers;

use App\Masyarakat;
use App\Masyarakats;
use App\Petugas;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Environment\Console;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $nik            = $request->input('nik');
        $nama_lengkap   = $request->input('nama_lengkap');
        $nama_petugas   = $request->input('nama_petugas');
        $tanggal_lahir  = $request->input('tanggal_lahir');
        $jenis_kelamin  = $request->input('jenis_kelamin');
        $no_telp        = $request->input('no_telp');
        $username       = $request->input('username');
        $email          = $request->input('email');
        $password       = Hash::make($request->input('password'));

        $register = User::create([
          'username'  =>  $username,
          'email'     =>  $email,
          'password'  =>  $password,
          'role' =>  'Masyarakat' 
        ]);

        $masyarakat = Masyarakats::create([
          'nik'           =>  $nik,
          'nama_lengkap'  =>  $nama_lengkap,
          'tanggal_lahir' =>  $tanggal_lahir,
          'jenis_kelamin' =>  $jenis_kelamin,
          'no_telp'       =>  $no_telp,
          'email'         =>  $email
        ]);

        if ($register) {
          return response()->json([
            'success' =>  true,
            'code'    =>  201,
            'message' =>  'Register Users Success',
            'dataUser'    =>  $register,
            'dataMasyarakat'  => $masyarakat
          ],201);
        } else{
          return response()->json([
            'success' =>  false,
            'code'    =>  400,
            'message' =>  'register Failed',
            'data'    =>  ''
          ],400);
        }
    }

    // public function generaterandomString($length = 80)
    // {
    //   $karakter = '012345678dssd9abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //   $panjang_karakter =  strlen($karakter);
    //   $str = '';
    //   for ($i=0; $i < $length; $i++) { 
    //     $str = $karakter[rand(0, $panjang_karakter - 1)];
    //   }
    //   return $str;
    // }

    public function login(Request $request)
    {

      $this->validate($request, [
        'email' => 'required',
        'password' => 'required|min:6'
    ]);

      $email          = $request->input("email");
      $password       = $request->input("password");

      $user = User::where("email", $email)->first();

      if (!$user) {
        $res  = [
          "message" =>  "Login Failed",
          "code"    =>  401,
          "result"  =>  [
              "api_token" => null, 
          ]
          ];
          return response()->json($res, $res['code']);
      }

      if (Hash::check($password, $user->password)) {  
        $apiToken = base64_encode(str_random(60));

        $user->update([
          'api_token' =>  $apiToken
        ]);

        return response()->json([
          'success' =>  true,
          'code'    =>  201,
          'message' =>  'Login Success',
          'data'    =>  [
            'username'  =>  $user->username,
            'email'     =>  $user->email,
            'role'      =>  $user->role,
            'api_token' =>  $apiToken,
            'id_user'   =>  $user->id
          ]
          ], 201);
      }else {
        return response()->json([
          'success'   =>  false,
          'code'      =>  401,
          'massage'   =>  'Login Failed',
          'data'      =>  ''
        ], 401);
      }  
    }

    //logout
    public function logout(Request $data)
    {
      $apiToken = explode(' ', $data->header('Authorization'));
      $user = User::where('api_token', $apiToken[0])->first();

      if ($user) {
        $user->api_token  = null;
        $user->save();

        return response()->json([
          'success' =>  true,
          'status'  =>  200,
          'message' =>  'Success Logout',
          'data'    =>  $user
        ], 200);
      } 
      return response()->json([
          'success' =>  false,
          'status'  =>  400,
          'message' =>  'Failed Logout',
          'data'    =>  ''
      ], 400);
    }

    //get all user
    public function getUser()
    {
      $data = User::all();
      if ($data) {
        return response()->json([
          'success' =>  true,
          'code'    =>  200,
          'message' =>  'Success Get User',
          'data'    =>  $data
        ], 200);
      } else {
        return response()->json([
          'success' =>  false,
          'code'    =>  400,
          'message' =>  'Failed Get User',
          'data'    =>  ''
        ], 400);
      }
      
    }
}
