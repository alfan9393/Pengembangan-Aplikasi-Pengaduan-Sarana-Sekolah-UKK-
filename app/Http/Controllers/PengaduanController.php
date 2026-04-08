<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    // Menampilkan semua pengaduan siswa
    public function index()
    {
        // Cek session user
        if(!session('user')){
            return redirect('/login');
        }

        // Ambil data pengaduan beserta kategori
        $data = DB::table('pengaduan')
            ->leftJoin('kategori', 'pengaduan.idkategori', '=', 'kategori.idkategori')
            ->select('pengaduan.*', 'kategori.ketkategori')
            ->get();

        return view('pengaduan.index', compact('data')); // tampilkan view pengaduan.index
    }

    // Menampilkan form tambah pengaduan baru
    public function add()
    {
        if(!session('user')){
            return redirect('/login');
        }

        $kategori = DB::table('kategori')->get(); // ambil semua kategori
        return view('pengaduan.add', compact('kategori'));
    }

    // Menyimpan pengaduan baru ke database
    public function store(Request $r)
    {
        // Hanya siswa yang bisa menambahkan pengaduan
        if (!session()->has('user') || session('user')->level != 'siswa') {
            return redirect('/login');
        }

        // Validasi inputan
        $r->validate([
            'isi_laporan' => 'required',
            'idkategori' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = null;

        // Jika ada file foto, simpan ke public/img
        if ($r->file('foto')) {
            $file = $r->file('foto');
            $namaFile = time().'_'.uniqid().'.'.$file->extension();
            $file->move(public_path('img'), $namaFile);
        }

        // Insert data pengaduan
        DB::table('pengaduan')->insert([
            'tg_pengaduan' => now(),
            'isi_laporan' => $r->isi_laporan,
            'idkategori' => $r->idkategori,
            'foto' => $namaFile,
            'status' => '0' // default status belum diproses
        ]);

        return redirect('/pengaduan');
    }

    // Menampilkan form edit pengaduan
    public function edit($id)
    {
        if(!session('user')){
            return redirect('/login');
        }

        // Ambil data pengaduan sesuai id
        $data = DB::table('pengaduan')->where('id',$id)->first();

        if(!$data){
            return redirect('/pengaduan'); // jika data tidak ada, kembali
        }

        $kategori = DB::table('kategori')->get(); // ambil kategori untuk select
        return view('pengaduan.edit', compact('data','kategori'));
    }

    // Update pengaduan yang sudah ada
    public function update(Request $r, $id)
    {
        if(!session('user')){
            return redirect('/login');
        }

        $dataLama = DB::table('pengaduan')->where('id',$id)->first();
        if(!$dataLama){
            return back();
        }

        // Data yang akan diupdate
        $dataUpdate = [
            'isi_laporan' => $r->isi_laporan,
            'idkategori' => $r->idkategori
        ];

        // Jika ada foto baru, hapus foto lama dan simpan yang baru
        if ($r->file('foto')) {
            if($dataLama->foto && file_exists(public_path('img/'.$dataLama->foto))){
                unlink(public_path('img/'.$dataLama->foto));
            }

            $file = $r->file('foto');
            $namaFile = time().'_'.uniqid().'.'.$file->extension();
            $file->move(public_path('img'), $namaFile);
            $dataUpdate['foto'] = $namaFile;
        }

        DB::table('pengaduan')->where('id',$id)->update($dataUpdate);
        return redirect('/pengaduan');
    }

    // Hapus pengaduan
    public function delete($id)
    {
        $data = DB::table('pengaduan')->where('id',$id)->first();

        if($data){
            // Hapus file foto jika ada
            if($data->foto && file_exists(public_path('img/'.$data->foto))){
                unlink(public_path('img/'.$data->foto));
            }

            DB::table('pengaduan')->where('id',$id)->delete(); // hapus data
        }

        return back();
    }

    // Dashboard admin menampilkan jumlah status pengaduan
    public function adminDashboard()
    {
        if (!session()->has('user') || session('user')->level != 'admin') {
            return redirect('/login');
        }

        $belum = DB::table('pengaduan')->where('status','0')->count(); // pengaduan baru
        $proses = DB::table('pengaduan')->where('status','proses')->count(); // sedang diproses
        $selesai = DB::table('pengaduan')->where('status','selesai')->count(); // selesai

        return view('admin.dashboard', compact('belum','proses','selesai'));
    }

    // Menampilkan semua laporan pengaduan (admin)
    public function adminLaporan()
    {
        $data = DB::table('pengaduan')->get();
        return view('admin.laporan', compact('data'));
    }

    // Ubah status pengaduan menjadi "proses" (admin)
    public function acc($id)
    {
        DB::table('pengaduan')
            ->where('id', $id)
            ->update(['status' => 'proses']);

        return back();
    }

    // Ubah status pengaduan menjadi "selesai" (admin)
    public function selesai($id)
    {
        DB::table('pengaduan')
            ->where('id', $id)
            ->update(['status' => 'selesai']);

        return back();
    }
}