<?php

namespace App\Services;

use App\Models\Company as CompanyModel;
use App\Services\Support\PengaturanMasterService;
use Illuminate\Support\Str;

class CompanyService{
     protected $companyModel;

    public function __construct(CompanyModel $companyModel)
    {
        $this->companyModel = $companyModel;
    }

    public function all()
    {
        return $this->companyModel->query();
    }

       public function store($data)
    {
        return $this->companyModel::create($data);
    }

    public function findByUUID($uuid)
    {
        return $this->companyModel::where('uuid', $uuid)->first();
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