<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 

class Account extends Authenticatable 
{
    use HasFactory;


    protected $table = 'account';
    protected $primaryKey = 'id'; // Correct typo in 'primaryKey'
    protected $fillable = ['username','name', 'email'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
