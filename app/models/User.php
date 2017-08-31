<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $fillable = [
        'id',
        'name'
    ];

    public $timestamps = false;
}
