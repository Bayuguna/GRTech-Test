<?php

namespace App\Services;

use App\Models\Role as RoleModel;
use App\Services\Support\PengaturanMasterService;
use Illuminate\Support\Str;

class RoleService
{
    protected $roleModel;

    public function __construct(RoleModel $roleModel)
    {
        $this->roleModel = $roleModel;
    }

    public function all()
    {
        return $this->roleModel->query()->with('roleAccess');
    }

    public function store($data)
    {
        return $this->roleModel::create($data);
    }

    public function findByUUID($uuid)
    {
        return $this->roleModel::with('roleAccess')->where('uuid', $uuid)->first();
    }

    public function update($uuid, $request)
    {
        $data = $this->findByUUID($uuid);
        return $data->update($request);
    }

    public function delete($uuid)
    {
        $data = $this->findByUUID($uuid);
        return $data->delete();
    }
}