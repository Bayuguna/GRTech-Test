<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid as Generator;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Role extends Model
{

    use SoftDeletes;
    
    protected $table = 'roles';
    protected $fillable = [
        'uuid', 
        'name'
    ];
    protected $protected = ['id'];
    protected $hidden = ['id'];
    public $timestamps = true;

    public function roleAccess()
    {
        return $this->hasMany(RoleAccess::class, 'role_uuid', 'uuid');
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