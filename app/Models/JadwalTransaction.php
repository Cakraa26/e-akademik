<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTransaction extends Model
{
    use HasFactory;
    protected $table = 't_jadwal';
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
    public function stase()
    {
        return $this->belongsTo(Stase::class, 'stasefk', 'pk');
    }
    public function residen()
    {
        return $this->belongsTo(Residen::class, 'residenfk', 'pk');
    }
    public function jadwalNilai()
    {
        return $this->hasOne(JadwalTransactionNilai::class, 'jadwalfk');
    }
    public function nilai()
    {
        return $this->hasMany(JadwalTransactionNilai::class, 'jadwalfk');
    }
}
