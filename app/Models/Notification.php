<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 't_notifications';
    protected $primaryKey = 'pk';
    protected $guarded = ['pk'];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->dateadded = now();
            $model->addedbyfk = auth()->user()->pk;
            $model->datemodified = now();
            $model->lastuserfk = auth()->user()->pk;
        });

        static::updating(function ($model) {
            $model->datemodified = now();
            $model->lastuserfk = auth()->user()->pk;
        });
    }

    public function residen()
    {
        return $this->belongsTo(Residen::class, 'residenfk', 'pk');
    }

    public function pengumuman()
    {
        return $this->belongsTo(Pengumuman::class, 'pengumumanfk', 'pk');
    }
}
