<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/kelompok/list', [
            'title' => 'Daftar Kelompok',
            'res' => Kelompok::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/kelompok/tambah', [
            'title' => 'Tambah Kelas',
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
            'nama' => 'required|string|min:3|max:30',
        ]);
        $validated['uri'] = Str::random(35);

        Kelompok::create($validated);
        return redirect('/dashboard')->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelompok  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Kelompok $kelompok)
    {
        return view('admin/kelas/detail', [
            'title' => $kelompok->nama,
            'res' => $kelompok,
            'kelas' => Kelompok::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelompok  $kelompok
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelompok $kelompok)
    {
        return view('admin/kelas/ubah', [
            'title' => 'Ubah Siswa',
            'res' => $kelompok,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelompok  $kelompoks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelompok $kelompok)
    {
        $validated = $request->validate([
            'nama' => 'required|string|min:3|max:30',
        ]);
        $kelompok->update($validated);
        return redirect('/dashboard')->with('success', 'data kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelompok  $kelompok
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelompok $kelompok)
    {
        foreach ($kelompok->siswa as $item) {
            $item->update(['group_id' => NULL]);
        }
        $kelompok->delete();
        return redirect('/dashboard')->with('success', 'Kelas berhasil dihapus');
    }
}
