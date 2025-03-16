<?php

namespace App\Services;

use App\Models\Employee as EmployeeModel;
use App\Services\Support\PengaturanMasterService;
use Illuminate\Support\Str;

class EmployeeService{
     protected $employeeModel;

    public function __construct(EmployeeModel $employeeModel)
    {
        $this->employeeModel = $employeeModel;
    }

    public function all()
    {
        return $this->employeeModel->query()->with(['company', 'createdBy']);
    }

       public function store($data)
    {
        return $this->employeeModel::create($data);
    }

    public function findByUUID($uuid)
    {
        return $this->employeeModel::where('uuid', $uuid)->first();
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