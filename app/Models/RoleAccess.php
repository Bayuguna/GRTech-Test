<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    protected $table = 'role_accesses';
    protected $fillable = [
        'role_uuid',
        'access_uuid'
    ];

    public function access()
    {
        return $this->belongsTo(Access::class, 'access_uuid', 'uuid');
    }

    public $timestamps = false;
}
