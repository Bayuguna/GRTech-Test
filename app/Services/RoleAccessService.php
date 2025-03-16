<?php

namespace App\Services;

use App\Models\RoleAccess as RoleAccessModel;
use App\Services\Support\PengaturanMasterService;
use Illuminate\Support\Str;

class RoleAccessService
{
    protected $roleAccessModel;

    public function __construct(RoleAccessModel $roleAccessModel)
    {
        $this->roleAccessModel = $roleAccessModel;
    }

    public function all()
    {
        return $this->roleAccessModel->query();
    }

    public function store($data)
    {
        return $this->roleAccessModel::create($data);
    }

    public function findByUUID($uuid)
    {
        return $this->roleAccessModel::where('uuid', $uuid)->first();
    }

    public function update($uuid, $request)
    {
        $data = $this->findByUUID($uuid);
        return $data->update($request);
    }
}