<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid as Generator;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Company extends Model
{
    use SoftDeletes;

    protected $table = 'companies';
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'phone',
        'address',
        'logo',
        'website',
        'status'
    ];
    protected $protected = ['id'];
    protected $hidden = ['id'];
    public $timestamps = true;
    protected $appends = ['logo_url'];

    public function getLogoUrlAttribute()
    {
        return $this->logo ? ('public-files/companies/' . $this->logo) : null;
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