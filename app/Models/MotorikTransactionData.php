<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorikTransactionData extends Model
{
    use HasFactory;
    protected $table = 't_motorik_dt';
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
    public function motorikTransaction()
    {
        return $this->belongsTo(MotorikTransaction::class, 't_motorik_fk', 'pk');
    }
    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'tingkatfk', ownerKey: 'pk'); 
    }
    public function residen()
    {
        return $this->belongsTo(Residen::class, 'residenfk', 'pk');
    }

    public function motorik()
    {
        return $this->belongsTo(Motorik::class, 'motorikfk', 'pk');
    }
    public function motorikData()
    {
        return $this->belongsTo(MotorikTransaction::class, 't_motorik_fk');
    }
}
