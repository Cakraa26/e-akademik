<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psikomotorik extends Model
{
    use HasFactory;
    protected $table = 'm_motorik';
    protected $primaryKey = 'pk';
    protected $guarded = ['pk'];
    public $timestamps = false;
    public function group()
    {
        return $this->belongsTo(GroupMotorik::class, 'groupfk', 'pk');
    }
    public function kategori()
    {
        return $this->belongsTo(KategoriMotorik::class, 'kategorifk', 'pk');
    }
    public function subkategori()
    {
        return $this->belongsTo(SubKategoriMotorik::class, 'subkategorifk', 'pk');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester', 'pk');
    }
    public function t_motorik()
    {
        return $this->hasMany(MotorikTransaction::class, 'motorikfk', 'pk')
        ->where('residenfk', auth()->user()->pk);
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
