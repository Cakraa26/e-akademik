<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorik extends Model
{
    use HasFactory;
    protected $table = 'm_motorik';
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
        return $this->hasMany(MotorikTransaction::class, 'motorikfk', 'pk');
    }

    public function motorikGroup()
    {
        return $this->belongsTo(GroupMotorik::class, 'groupfk', 'pk');
    }

    public function category()
    {
        return $this->belongsTo(KategoriMotorik::class, 'kategorifk', 'pk');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubKategoriMotorik::class, 'subkategorifk', 'pk');
    }
}
