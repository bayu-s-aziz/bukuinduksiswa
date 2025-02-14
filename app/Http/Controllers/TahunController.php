<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use Illuminate\Http\Request;

class TahunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/admin/tahun_ajaran/list', [
            'title' => 'Daftar Tahun Ajaran',
            'res' => Tahun::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/admin/tahun_ajaran/tambah', [
            'title' => 'Tambah Tahun Ajaran',
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
            'tahun_ajaran' => 'required|min:9|max:9',
            'status' => 'required',
        ]);

        if ($validated['status'] == 'aktif') {
            $set_off = Tahun::where('status', 'aktif')->get();
            $set_off->update(['status' => 'tidak aktif']);
        }

        Tahun::create($validated);
        return redirect('/dashboard')->with('success', 'Tahun ajaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function show(Tahun $tahun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function edit(Tahun $tahun)
    {
        return view('admin/tahun_ajaran/ubah', [
            'title' => 'Ubah tahun ajaran',
            'res' => $tahun,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tahun $tahun)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|min:9|max:9',
            'status' => 'required',
        ]);

        if ($validated['status'] == 'aktif') {
            $set_off = Tahun::where('status', 'aktif')->get();
            $set_off->update(['status' => 'tidak aktif']);
        }

        $tahun->update($validated);
        return redirect('/dashboard')->with('success', 'Tahun ajaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tahun $tahun)
    {
        $tahun->delete();
        return redirect('/dashboard')->with('success', 'tahun ajaran berhasil dihapus!');
    }
}
