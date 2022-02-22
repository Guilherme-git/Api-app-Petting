<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Markers extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    protected $table = 'markers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'title',
        'endHour',
        'iconType',
        'latitude',
        'longitude',
        'startAddress',
        'startHour',
        'tour'
    ];

    protected $hidden = [
        'tour',
    ];

    public function toursLog()
    {
        return $this->hasMany(ToursLog::class,'markers','id');
    }
}
