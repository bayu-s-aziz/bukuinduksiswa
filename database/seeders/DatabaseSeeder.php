<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Biodata;
use App\Models\Ayah;
use App\Models\Ibu;
use App\Models\Wali;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nama_lengkap' => 'RA Al-Islam',
            'foto' => NULL,
            'status' => 'admin',
            'email' => 'alislam.gncupu@gmail.com',
            'password' => Hash::make('alislam1234'),
            'jenis_kelamin' => 'L',
        ]);

        DB::table('siswa')->insert([
            'tahun_id' => 0,
            'kelompok_id' => 0,
            'nama_panggilan' => 'Emod',
            'nama_lengkap' => 'Ahmad Madyan',
            'foto' => NULL,
            'nisn' => '1233123341',
            'noinduk' => '1233123',
            'jenis_kelamin' => 'L',
        ]);

        DB::table('biodata')->insert([
            'siswa_id' => 1,
            'uri' => Str::random(50),
        ]);

        DB::table('ayah')->insert([
            'siswa_id' => 1,
            'uri' => Str::random(50)
        ]);

        DB::table('ibu')->insert([
            'siswa_id' => 1,
            'uri' => Str::random(50)
        ]);

        DB::table('wali')->insert([
            'siswa_id' => 1,
            'uri' => Str::random(50)
        ]);

        
        DB::table('Kelompok')->insert([
            'kelompok' => 'A',
            'uri' => Str::random(50),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('Kelompok')->insert([
            'kelompok' => 'B',
            'uri' => Str::random(50),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tahun')->insert([
            'tahun_ajaran' => '2024/2025',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Siswa::factory(19)
            ->has(Biodata::factory()->count(1), 'biodata')
            ->has(Ayah::factory()->count(1),'ayah')
            ->has(Ibu::factory()->count(1),'ibu')
            ->has(Wali::factory()->count(1),'wali')
            ->create();
    }
}
