<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
        'username',
        'password',
        'port',
        'ssl',
        'legacy_login'
    ];

    protected $casts = [
        'password' => 'encrypted',
        'ssl' => 'boolean',
        'legacy_login' => 'boolean',
        'port' => 'integer'
    ];
}
