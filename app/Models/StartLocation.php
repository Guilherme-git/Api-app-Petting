<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartLocation extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    protected $table = 'start_location';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'latitude',
        'longitude',
        'tour',
        'tours',
        'tours_log',
    ];

    protected $hidden = [
        'tour','tours_log','tours','id'
    ];
}
