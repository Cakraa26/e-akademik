<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMotorik extends Model
{
    use HasFactory;
    protected $table = 'm_group_motorik';
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

    public function motorik()
    {
        return $this->hasMany(Motorik::class, 'groupfk', 'pk');
    }
}
