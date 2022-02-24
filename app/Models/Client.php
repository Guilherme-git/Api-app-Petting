<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    protected $table = 'client';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'expire',
        'amount',
        'image',
        'paid',
        "birth",
        "image",
        'user',
    ];

    protected $hidden = [
        'user'
    ];

    public function animal()
    {
        return $this->hasMany(Animal::class,'client','id');
    }
}
