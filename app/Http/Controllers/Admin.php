<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Ayah;
use App\Models\Mutasi;
use App\Models\Ibu;
use App\Models\Kelompok;
use App\Models\Wali;
use App\Models\Tahun;
use App\Models\Biodata;

class Admin extends Controller
{
    public function index()
    {
        $mutasi = Mutasi::latest()->get();
        $murid = Siswa::where('status', 'siswa')->get();
        $tahun = Tahun::all();
        $siswa_yatim_piatu = $murid->filter(function ($val) {
            if ($val->ayah->status === 'Telah Meninggal' || $val->ibu->status === 'Telah Meninggal') {
                return $val;
            }
        });

        $siswa = Biodata::latest()->get();
        $kelas = Kelompok::latest()->get();
        return view('admin/dashboard', [
            'title' => 'Dashboard',
            'jumlah_siswa' => $siswa->count(),
            'siswa' => $siswa,
            'jumlah_kelas' => $kelas->count(),
            'kelas' => $kelas,
            'jumlah_mutasi' => $mutasi->count(),
            'mutasi' => $mutasi,
            'murid_perempuan' => $murid->where('jenis_kelamin', 'P')->count(),
            'murid_laki' => $murid->where('jenis_kelamin', 'L')->count(),
            'siswa_yatim_piatu' => $siswa_yatim_piatu->count(),
            'tahun' => $tahun->filter(function ($value) {
                return $value->status === 'aktif';
            }),
        ]);
    }

    public function move_students(Request $request)
    {
        foreach ($request['daftar'] as $item) {
            Siswa::where('id', $item)->update(['group_id' => $request['group_id']]);
        }
        return redirect('/admin/grup');
    }

    public function ayah_form(Ayah $ayah)
    {
        return view('admin/info_siswa/ayah', [
            'title' => 'Data Ayah Siswa',
            'res' => $ayah
        ]);
    }

    public function edit_ayah(Request $request, Ayah $ayah)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'agama' => 'required',
            'kewarganegaraan' => 'required|string',
            'pekerjaan' => 'required|string',
            'pendidikan' => 'required',
            'alamat' => 'required|string|max:200',
            'nomor_hp' => 'required|string|max:13|regex:/[0-9]/',
            'status' => 'required',
        ]);
        Ayah::where('uri', $ayah->uri)->update($validated);
        return redirect('/dashboard')->with('success', 'Data ayah siswa berhasil diperbarui');
    }

    public function ibu_form(Ibu $ibu)
    {
        return view('admin/info_siswa/ibu', [
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
            'alamat' => 'required|string|max:200',
            'nomor_hp' => 'required|string|max:13|regex:/[0-9]/',
            'status' => 'required',
        ]);
        Ibu::where('uri', $ibu->uri)->update($validated);
        return redirect('/dashboard')->with('success', 'Data ibu siswa berhasil diperbarui');
    }

    public function wali_form(Wali $wali)
    {
        return view('admin/info_siswa/wali', [
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
            'alamat' => 'required|string|max:200',
            'nomor_hp' => 'required|string|max:13|regex:/[0-9]/',
        ]);
        Wali::where('uri', $wali->uri)->update($validated);
        return redirect('/dashboard')->with('success', 'Data wali siswa berhasil diperbarui');
    }

    public function bio_form(Biodata $biodata)
    {
        return view('admin/info_siswa/biodata', [
            'title' => 'Biodata Siswa',
            'res' => $biodata,
        ]);
    }

    public function edit_bio(Request $request, Biodata $biodata)
    {
        $validated = $request->validate([
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'propinsi' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required',
            'anak_ke' => 'required|gt:0',
            'jmlh_saudara' => 'nullable|gt:0',
            'saudara_tiri' => 'nullable|gt:0',
            'saudara_angkat' => 'nullable|gt:0',
            'bahasa' => 'required',
            'agama' => 'required',
            'penyakit' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'ciri' => 'required|string',
        ]);

        Biodata::where('uri', $biodata->uri)->update($validated);
        return redirect('/dashboard')->with('success', 'Biodata berhasil diperbarui!');
    }

    public function mutasi_form(Siswa $siswa)
    {
        return view('admin/info_siswa/mutasi', [
            'title' => 'Mutasi Siswa',
            'res' => $siswa,
        ]);
    }

    public function edit_mutasi(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'tujuan' => 'required|string|min:8',
            'alasan' => 'required',
            'tanggal_pindah' => 'required'
        ]);
        Mutasi::updateOrCreate(
            ['user_id' => $siswa->id],
            $validated
        );

        return redirect('/dashboard')->with('success', 'Siswa berhasil dimutasi');
    }

    public function list_mutasi()
    {
        return view('admin/info_siswa/list_mutasi', [
            'title' => 'Daftar Mutasi Siswa',
            'res' => Mutasi::all(),
            'siswa' => Siswa::all()
        ]);
    }
}
