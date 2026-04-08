<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function cekLogin(Request $r)
    {
        $user = DB::table('petugas')
            ->where('username', $r->username)
            ->where('password', md5($r->password))
            ->first();

        if($user){
            session(['user' => $user]);

            if($user->level == 'admin'){
                return redirect('/admin/dashboard');
            }else{
                return redirect('/pengaduan');
            }
        }

        return back()->with('error','Login gagal');
    }

    public function logout(){
        session()->flush();
        return redirect('/login');
    }

    public function register(){
        return view('register');
    }

    public function store(Request $r)
    {
        $kode_admin = "ADMIN123";

        if($r->role == 'admin'){
            if(strtoupper($r->kode_admin) != $kode_admin){
                return back()->with('error','Kode admin salah!');
            }
            $level = 'admin';
        }else{
            $level = 'siswa';
        }

        DB::table('petugas')->insert([
            'nis' => $r->nis,
            'nama' => $r->nama,
            'username' => $r->username,
            'password' => md5($r->password),
            'telp' => $r->telp,
            'kelas' => $r->kelas,
            'level' => $level
        ]);

        return redirect('/login');
    }
}