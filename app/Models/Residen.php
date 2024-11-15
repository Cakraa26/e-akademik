<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Residen extends Authenticatable
{
    use HasFactory;
    protected $table = 'm_residen';
    protected $primaryKey = 'pk';
    protected $guarded = ['pk'];
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->pk = $model->generatePk();
        });
    }
    protected function generatePk()
    {
        $last = self::orderBy('pk', 'desc')->first();
        $nextPk = $last ? $last->pk + 1 : 1;

        return $nextPk;
    }

    public function tingkat()
    {
        return $this->belongsTo(TingkatResiden::class, 'tingkatfk', 'pk');
    }
    public function karyailmiah()
    {
        return $this->belongsTo(KaryaIlmiah::class, 'karyailmiahfk', 'pk');
    }
    public function tkaryailmiah()
    {
        return $this->hasOne(KaryaIlmiahData::class, 'residenfk', 'pk');
    }
    public function tmotorik()
    {
        return $this->hasMany(MotorikTransaction::class, 'residenfk', 'pk');
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'residenfk', 'pk');
    }
    public function jadwal()
    {
        return $this->hasMany(JadwalTransaction::class, 'residenfk', 'pk');
    }
    public function tahunajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'thnajaranfk', 'pk');
    }
}
