<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residen extends Model
{
    use HasFactory;
    protected $fillable = [
        'nim',
        'nm',
        'nickname',
        'inisialresiden',
        'ktp',
        'email',
        'hp',
        'password',
        'tempatlahir',
        'tgllahir',
        'alamatktp',
        'alamattinggal',
        'agama',
        'goldarah',
        'thnmasuk',
        'thnlulus',
        'asalfk',
        'statusresiden',
        'statuskawin',
        'nmpasangan',
        'alamatpasangan',
        'hppasangan',
        'anak',
        'nmayah',
        'nmibu',
        'alamatortu',
        'anakke',
        'jmlsaudara',
        'nmkontak',
        'hpkontak',
        'hubkontak',
        'addedbyfk',
        'lastuserfk',
        'datemodified',
        'angkatanfk',
        'kelasfk',
        'otp',
        'waktu',
        'is_verified',
    ];
    protected $table = 'm_residen';
    protected $primaryKey = 'pk';
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
    // protected $attributes = [
    //     'datemodified' => null,
    // ];
}
