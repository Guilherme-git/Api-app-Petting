<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToursLog extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    protected $table = 'tours_log';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'animal',
        'tutor',
        'endHour',
        'startAddress',
        'startHour',
        'startLocationLatitude',
        'startLocationLongitude',
        'endLocationLatitude',
        'endLocationLongitude',
        'markers',
    ];

    public function animal(){
        return $this->hasOne(Animal::class,'id','animal');
    }

    public function tutor(){
        return $this->hasOne(Client::class,'id','tutor');
    }

    public function description(){
        return $this->hasMany(Description::class,'tours_log','id');
    }

    public function endLocation()
    {
        return $this->hasOne(EndLocation::class,'tours_log','id');
    }

    public function startLocation()
    {
        return $this->hasOne(StartLocation::class,'tours_log','id');
    }
}
