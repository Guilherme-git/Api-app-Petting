<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    protected $table = 'tours';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'animal',
        'tutor',
        'endHour',
        'startAddress',
        'startHour',
        "endHours",
        'tour',
    ];

    protected $hidden = [
        'tour'
    ];

    public function animal(){
        return $this->hasOne(Animal::class,'id','animal');
    }

    public function tutor(){
        return $this->hasOne(Client::class,'id','tutor');
    }

    public function description(){
        return $this->hasMany(Description::class,'tours','id');
    }

    public function endLocation()
    {
        return $this->hasOne(EndLocation::class,'tours','id');
    }

    public function startLocation()
    {
        return $this->hasOne(StartLocation::class,'tours','id');
    }
}
