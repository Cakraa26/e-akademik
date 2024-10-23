<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryaIlmiahData extends Model
{
    use HasFactory;

    protected $table = 't_karyailmiah';
    protected $primaryKey = 'pk';
    protected $guarded = ['pk'];
    public $timestamps = false;

    public function karyaIlmiah()
    {
        return $this->belongsTo(KaryaIlmiah::class, 'karyailmiahfk', 'pk');
    }

    public function residen()
    {
        return $this->belongsTo(Residen::class, 'residenfk', 'pk');
    }

    public function tingkat()
    {
        return $this->belongsTo(TingkatResiden::class, 'tingkatfk', 'pk');
    }
}
