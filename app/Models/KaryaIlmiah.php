<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryaIlmiah extends Model
{
    use HasFactory;
    protected $table = 'm_karyailmiah';
    protected $primaryKey = 'pk';
    protected $guarded = ['pk'];
    public $timestamps = false;
}
