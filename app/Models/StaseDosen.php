<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaseDosen extends Model
{
    use HasFactory;
    protected $table = 'm_stase_dosen';
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
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosenfk', 'pk');
    }
}
