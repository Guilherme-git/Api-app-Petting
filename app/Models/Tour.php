<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    protected $table = 'tour';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'startAddress',
        'startDate',
        'startHour',
        'endAddress',
        'endDate',
        'endHour',
        'sent',
        'status',
        'user',
        "nameUser",
        'emailUser'
    ];

    public function tours(){
        return $this->hasMany(Tours::class,'tour','id');
    }

    public function markers(){
        return $this->hasMany(Markers::class,'tour','id');
    }

    public function endLocation()
    {
        return $this->hasOne(EndLocation::class,'tour','id');
    }

    public function startLocation()
    {
        return $this->hasOne(StartLocation::class,'tour','id');
    }
}
