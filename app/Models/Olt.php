<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'ip_address',
        'type',
        'snmp_community',
        'snmp_port',
        'ssh_username',
        'ssh_password',
        'ssh_port',
        'active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'ssh_password' => 'encrypted',
        'snmp_community' => 'encrypted',
        'type' => 'string',
    ];

    /**
     * Get the validation rules for the OLT type enum.
     *
     * @return array
     */
    public static function getTypeRules()
    {
        return 'in:ZTE,HUAWEI,ALCATEL,OTHER';
    }
}
