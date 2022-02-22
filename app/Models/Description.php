<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    protected $table = 'description';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'description',
        'address',
        'latitude',
        'longitude',
        'date',
        'hour',
        'tours_log',
        'tours'
    ];

    protected $hidden = [
        'tours','tours_log',
    ];
}
