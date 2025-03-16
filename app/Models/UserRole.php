<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid as Generator;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class UserRole extends Model
{
    use SoftDeletes;
    protected $table = 'user_roles';
    protected $fillable = [
        'role_uuid',
        'user_uuid'
    ];
    protected $hidden = ['id'];
    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_uuid', 'uuid');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->uuid = Generator::uuid4()->toString();
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}