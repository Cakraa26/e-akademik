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
        return $this->belongsTo(Kategori::class, 'kategorifk', 'pk');
    }
    public function subkategori()
    {
        return $this->belongsTo(SubKategori::class, 'subkategorifk', 'pk');
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
