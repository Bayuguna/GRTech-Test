<?php

namespace App\Services;

use App\Models\Access as AccessModel;
use App\Services\Support\PengaturanMasterService;
use Illuminate\Support\Str;

class AccessService{
     protected $accessModel;

    public function __construct(AccessModel $accessModel)
    {
        $this->accessModel = $accessModel;
    }

    public function all()
    {
        return $this->accessModel->query();
    }

       public function store($data)
    {
        return $this->accessModel::create($data);
    }

    public function findByUUID($uuid)
    {
        return $this->accessModel::where('uuid', $uuid)->first();
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