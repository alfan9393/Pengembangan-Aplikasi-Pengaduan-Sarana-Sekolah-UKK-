<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login(){
        return view('login'); // return view login.blade.php
    }

    // Proses login user (siswa atau admin)
    public function cekLogin(Request $r)
    {
        // Ambil data user dari tabel petugas berdasarkan username & password (di-hash MD5)
        $user = DB::table('petugas')
            ->where('username', $r->username)
            ->where('password', md5($r->password))
            ->first();

        if($user){
            // Simpan data user ke session
            session(['user' => $user]);

            // Redirect ke dashboard sesuai level user
            if($user->level == 'admin'){
                return redirect('/admin/dashboard'); // jika admin
            }else{
                return redirect('/pengaduan'); // jika siswa
            }
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->with('error','Login gagal');
    }

    // Logout user
    public function logout(){
        session()->flush(); // hapus semua session
        return redirect('/login'); // kembali ke halaman login
    }

    // Menampilkan halaman registrasi
    public function register(){
        return view('register'); // return view register.blade.php
    }

    // Proses registrasi user baru (siswa atau admin)
    public function store(Request $r)
    {
        $kode_admin = "ADMIN123"; // kode khusus untuk registrasi admin

        // Tentukan level user berdasarkan input role
        if($r->role == 'admin'){
            // Jika role admin, cek kode admin
            if(strtoupper($r->kode_admin) != $kode_admin){
                return back()->with('error','Kode admin salah!'); // kode salah → error
            }
            $level = 'admin';
        }else{
            $level = 'siswa'; // default untuk siswa
        }

        // Simpan data user baru ke tabel petugas
        DB::table('petugas')->insert([
            'nis' => $r->nis, // nomor induk siswa 
            'nama' => $r->nama, //nama siswa/admin
            'username' => $r->username, //username siswa/admin
            'password' => md5($r->password), // password di-hash MD5
            'telp' => $r->telp, //nomor telpon siswa/admin
            'kelas' => $r->kelas, //untuk siswa jika admin kosongi saja
            'level' => $level //role untuk siswa/admin
        ]);

        // Setelah registrasi berhasil, redirect ke halaman login
        return redirect('/login');
    }
}