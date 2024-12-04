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
    public function residen()
    {
        return $this->belongsTo(Residen::class, 'residenfk', 'pk');
    }
    protected $casts = [
        'dateadded' => 'datetime',
    ];
}
