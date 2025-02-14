<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Siswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_panggilan',
        'nama_lengkap',
        'nisn',
        'noinduk',
        'foto',
        'jenis_kelamin',
        'tahun_id',
        'kelompok_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $with = [
        'ayah',
        'ibu',
        'biodata',
        'wali',
        'kelas',
        'mutasi',
        'tahun_ajar',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function ayah(){
        return $this->hasOne(Ayah::class);
    }

    public function ibu(){
        return $this->hasOne(Ibu::class);
    }

    public function biodata(){
        return $this->hasOne(Biodata::class);
    }

    public function wali(){
        return $this->hasOne(Wali::class);
    }

    public function kelas(){
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    public function tahun_ajar(){
        return $this->belongsTo(Tahun::class, 'tahun_id');
    }

    public function mutasi(){
        return $this->hasOne(Mutasi::class);
    }

    public function getRouteKeyName(){
        return 'nisn';
    }

    public function scopeFilter($query, array $filters){
        if(isset($filters['cari'])? $filters['cari']: false){
             return $query->where('nama_lengkap', 'like', '%'.$filters['cari'].'%');
        }
    }
}
