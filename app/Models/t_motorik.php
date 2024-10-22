<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_motorik extends Model
{
    use HasFactory;
    protected $table = 't_motorik';
    protected $primaryKey = 'pk';
    protected $guarded = ['pk'];
    public $timestamps = false;
    public function residen()
    {
        return $this->belongsTo(Residen::class, 'residenfk', 'pk');
    }
    public function motorik()
    {
        return $this->belongsTo(Psikomotorik::class, 'motorikfk', 'pk');
    }
    public function motorikDetails()
    {
        return $this->hasMany(t_motorik_dt::class, 't_motorik_fk');
    }
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
}
