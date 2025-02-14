<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Ayah;
use App\Models\Ibu;
use App\Models\Wali;
use App\Models\Biodata;

class Siswa extends Controller
{
    public function index()
    {
        return view('siswa/home', [
            'title' => 'Beranda',
        ]);
    }

    public function bio_form(Biodata $biodata)
    {
        return view('siswa.biodata', [
            'title' => 'Biodata Siswa',
            'res' => $biodata,
        ]);
    }

    public function edit_bio(Request $request, Biodata $biodata)
    {
        $validated = $request->validate([
            'alamat' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required',
            'anak_ke' => 'required|gt:0',
            'jlh_saudara' => 'nullable|gt:0',
            'saudara_tiri' => 'nullable|gt:0',
            'saudara_angkat' => 'nullable|gt:0',
            'bahasa' => 'required',
            'agama' => 'required',
            'jarak' => 'required|gt:0',
            'nomor_hp' => 'nullable|string|max:13|regex:/[0-9]/',
            'goldar' => 'required',
            'tinggi' => 'required|gt:50',
            'berat' => 'required|gt:20',
            'penyakit' => 'nullable|string',
            'hobi' => 'nullable|string',
            'kewarganegaraan' => 'required|string',
            'sekolah_asal' => 'required',
        ]);

        Biodata::where('uri', $biodata->uri)->update($validated);
        return redirect('/home')->with('Updated', 'Biodata berhasil diperbarui!');
    }

    public function dad_form(Ayah $dad)
    {
        return view('siswa.ayah', [
            'title' => 'Data Ayah Siswa',
            'res' => $dad
        ]);
    }

    public function edit_dad(Request $request, Ayah $dad)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'agama' => 'required',
            'kewarganegaraan' => 'required|string',
            'pekerjaan' => 'required|string',
            'pendidikan' => 'required',
            'penghasilan' => 'required|numeric',
            'alamat' => 'required|string|max:200',
            'nomor_hp' => 'required|string|max:13|regex:/[0-9]/',
            'status' => 'required',
        ]);
        Ayah::where('uri', $dad->uri)->update($validated);
        return redirect('/home')->with('Updated', 'Data ayah siswa berhasil diperbarui');
    }

    public function ibu_form(Ibu $ibu)
    {
        return view('siswa.ibu', [
            'title' => 'Data Ibu Siswa',
            'res' => $ibu
        ]);
    }

    public function edit_ibu(Request $request, Ibu $ibu)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'agama' => 'required',
            'kewarganegaraan' => 'required|string',
            'pekerjaan' => 'required|string',
            'pendidikan' => 'required',
            'penghasilan' => 'nullable|numeric',
            'alamat' => 'required|string|max:200',
            'nomor_hp' => 'required|string|max:13|regex:/[0-9]/',
            'status' => 'required',
        ]);
        Ibu::where('uri', $ibu->uri)->update($validated);
        return redirect('/home')->with('Updated', 'Data ibu siswa berhasil diperbarui');
    }

    public function wali_form(Wali $wali)
    {
        return view('siswa.wali', [
            'title' => 'Data Wali Siswa',
            'res' => $wali,
        ]);
    }

    public function edit_wali(Request $request, Wali $wali)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'agama' => 'required',
            'kewarganegaraan' => 'required|string',
            'pekerjaan' => 'required|string',
            'pendidikan' => 'required',
            'penghasilan' => 'required|numeric',
            'alamat' => 'required|string|max:200',
            'nomor_hp' => 'required|string|max:13|regex:/[0-9]/',
        ]);
        Wali::where('uri', $wali->uri)->update($validated);
        return redirect('/home')->with('Updated', 'Data wali siswa berhasil diperbarui');
    }

    public function password_form(Siswa $siswa)
    {
        return view('siswa.password', [
            'title' => 'Ubah Password',
        ]);
    }
}
