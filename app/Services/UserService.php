<?php

namespace App\Services;

use App\Models\User as UserModel;
use App\Services\Support\PengaturanMasterService;
use Illuminate\Support\Str;

class UserService
{
    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function all()
    {
        return $this->userModel->query()->with(['userRoles']);
    }

    public function store($data)
    {
        return $this->userModel::create($data);
    }

    public function findByUUID($uuid)
    {
        return $this->userModel::where('uuid', $uuid)->first();
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