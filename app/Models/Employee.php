<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid as Generator;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Employee extends Model
{
    use SoftDeletes;

    protected $table = 'employees';
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'company_uuid',
        'email',
        'phone',
        'status',
        'created_by',
    ];
    protected $protected = ['id'];
    protected $hidden = ['id'];
    public $timestamps = true;

    // Appends
    protected $appends = ['full_name'];
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_uuid', 'uuid');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->uuid = Generator::uuid4()->toString();
                $model->created_by = auth()->user()->uuid ?? 'system';
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}