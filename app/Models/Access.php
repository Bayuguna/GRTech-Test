<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid as Generator;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Access extends Model
{
    use SoftDeletes;
    
    protected $table = 'accesses';
    protected $fillable = [
        'uuid',
        'name'
    ];
    public $timestamps = true;
    protected $hidden = ['id'];

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