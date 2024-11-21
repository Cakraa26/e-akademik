<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTransactionNilai extends Model
{
    use HasFactory;
    protected $table = 't_jadwal_nilai';
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
    public function jadwal()
    {
        return $this->belongsTo(JadwalTransaction::class, 'jadwalfk');
    }
    public function residen()
    {
        return $this->jadwal->residen(); 
    }
    public function stase()
    {
        return $this->belongsTo(Stase::class, 'stasefk');
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosenfk');
    }
}
