<?php

namespace App\Services;

use App\Models\UserRole as UserRoleModel;
use App\Services\Support\PengaturanMasterService;
use Illuminate\Support\Str;

class UserRoleService
{
    protected $userRoleModel;

    public function __construct(UserRoleModel $userRoleModel)
    {
        $this->userRoleModel = $userRoleModel;
    }

    public function all()
    {
        return $this->userRoleModel->query()->with(['role']);
    }

    public function store($data)
    {
        return $this->userRoleModel::create($data);
    }

    public function findByUUID($uuid)
    {
        return $this->userRoleModel::where('uuid', $uuid)->first();
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