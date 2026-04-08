<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    public function index()
    {
        if(!session('user')){
            return redirect('/login');
        }

        $data = DB::table('pengaduan')
            ->leftJoin('kategori', 'pengaduan.idkategori', '=', 'kategori.idkategori')
            ->select('pengaduan.*', 'kategori.ketkategori')
            ->get();

        return view('pengaduan.index', compact('data'));
    }

    public function add()
    {
        if(!session('user')){
            return redirect('/login');
        }

        $kategori = DB::table('kategori')->get();

        return view('pengaduan.add', compact('kategori'));
    }

    public function store(Request $r)
    {
        if (!session()->has('user') || session('user')->level != 'siswa') {
            return redirect('/login');
        }

        $r->validate([
            'isi_laporan' => 'required',
            'idkategori' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = null;

        if ($r->file('foto')) {
            $file = $r->file('foto');
            $namaFile = time().'_'.uniqid().'.'.$file->extension();
            $file->move(public_path('img'), $namaFile);
        }

        DB::table('pengaduan')->insert([
            'tg_pengaduan' => now(),
            'isi_laporan' => $r->isi_laporan,
            'idkategori' => $r->idkategori,
            'foto' => $namaFile,
            'status' => '0'
        ]);

        return redirect('/pengaduan');
    }

    public function edit($id)
    {
        if(!session('user')){
            return redirect('/login');
        }

        $data = DB::table('pengaduan')->where('id',$id)->first();

        if(!$data){
            return redirect('/pengaduan');
        }

        $kategori = DB::table('kategori')->get();

        return view('pengaduan.edit', compact('data','kategori'));
    }

    public function update(Request $r, $id)
    {
        if(!session('user')){
            return redirect('/login');
        }

        $dataLama = DB::table('pengaduan')->where('id',$id)->first();

        if(!$dataLama){
            return back();
        }

        $dataUpdate = [
            'isi_laporan' => $r->isi_laporan,
            'idkategori' => $r->idkategori
        ];

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

    public function delete($id)
    {
        $data = DB::table('pengaduan')->where('id',$id)->first();

        if($data){
            if($data->foto && file_exists(public_path('img/'.$data->foto))){
                unlink(public_path('img/'.$data->foto));
            }

            DB::table('pengaduan')->where('id',$id)->delete();
        }

        return back();
    }
    public function adminDashboard()
{
    if (!session()->has('user') || session('user')->level != 'admin') {
        return redirect('/login');
    }

    $belum = DB::table('pengaduan')->where('status','0')->count();
    $proses = DB::table('pengaduan')->where('status','proses')->count();
    $selesai = DB::table('pengaduan')->where('status','selesai')->count();

    return view('admin.dashboard', compact('belum','proses','selesai'));
}
    public function adminLaporan()
    {
        $data = DB::table('pengaduan')->get();

        return view('admin.laporan', compact('data'));
    }

    public function acc($id)
    {
        DB::table('pengaduan')
            ->where('id', $id)
            ->update(['status' => 'proses']);

        return back();
    }

    public function selesai($id)
    {
        DB::table('pengaduan')
            ->where('id', $id)
            ->update(['status' => 'selesai']);

        return back();
    }
}