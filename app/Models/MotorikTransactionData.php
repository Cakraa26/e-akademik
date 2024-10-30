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
    public function motorikTransaction()
    {
        return $this->belongsTo(MotorikTransaction::class, 't_motorik_fk', 'pk');
    }
}
