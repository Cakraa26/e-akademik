<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'm_kelas';
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

    public function thnajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'thnajaranfk', 'pk');
    }
    public function residen()
    {
        return $this->belongsTo(Residen::class, 'residenfk', 'pk'); 
    }
    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'tingkatfk', ownerKey: 'pk'); 
    }
}
