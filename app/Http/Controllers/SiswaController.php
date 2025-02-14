<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelompok;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = Siswa::where('status', 'siswa');
        return view('admin/siswa/list', [
            'title' => 'Daftar Siswa',
            'res' => $siswa->filter(request(['cari']))->paginate(30)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/siswa/tambah', [
            'title' => 'Tambah Siswa',
            'kelas' => Kelompok::latest()->get(),
            'tahun' => Tahun::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_panggilan' => 'required|max:50',
            'nama_lengkap' => 'required|max:50',
            'nisn' => 'required|max:16|regex:/[0-9]/',
            'noinduk' => 'required|max:16|regex:/[0-9]/',
            'kelompok_id' => 'required',
            'tahun_id' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'nullable|image|file|max:1024',
        ]);
        if ($request->file('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-siswa');
        }
        $siswa = Siswa::create($validated);
        $ayah = $siswa->ayah()->create(['uri' => Str::random(40)]);
        $ibu = $siswa->ibu()->create(['uri' => Str::random(40)]);
        $biodata = $siswa->biodata()->create(['uri' => Str::random(40)]);
        $wali = $siswa->wali()->create(['uri' => Str::random(40)]);
        return redirect('/dashboard')->with('success', 'Siswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa)
    {
        return view('admin/siswa/detail', [
            'title' => $siswa->nama_lengkap,
            'res' => $siswa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        return view('admin/siswa/ubah', [
            'title' => 'Ubah Data Siswa',
            'res' => $siswa,
            'kelas' => Kelompok::latest()->get(),
            'tahun' => Tahun::latest()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|max:50',
            'nisn' => 'required|max:16|regex:/[0-9]/',
            'noinduk' => 'required|max:16|regex:/[0-9]/',
            'jenis_kelamin' => 'required',
            'kelompok_id' => 'required',
            'tahun_id' => 'required',
            'email' => 'required|email:dns',
            'foto' => 'nullable|image|file|max:1024',
        ]);
        if ($request->file('foto')) {
            if ($siswa->foto != null) {
                Storage::delete($siswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto-siswa');
        }

        $siswa->update($validated);
        return redirect('/dashboard')->with('success', 'Data siswa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siswa $siswa)
    {
        Storage::delete($siswa->foto);
        $siswa->biodata()->delete();
        $siswa->ayah()->delete();
        $siswa->ibu()->delete();
        $siswa->wali()->delete();
        $siswa->mutasi()->delete();
        $siswa->delete();
        return redirect('/dashboard')->with('success', 'Data siswa berhasil dihapus');
    }
}
