<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    protected $table = 'animal';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'age',
        'type',
        'details',
        'client',
    ];

    protected $hidden = [
        'client'
    ];
}
