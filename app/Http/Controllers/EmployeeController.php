<?php

namespace App\Http\Controllers;

use App\Helpers\StatusHelper;
use App\Http\Requests\Employeee\StoreEmployeeRequest;
use App\Http\Requests\Employeee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use DataTables;
use Inertia\Inertia;
use DB;

class EmployeeController extends Controller
{

    protected $employeeService;
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Employee/MainEmployee');
    }

    public function data(Request $request)
    {
        $employees = $this->employeeService->all();

        // if($request->ajax()) {
        return DataTables::of($employees)
            ->addIndexColumn()
            // ->addColumn('action', function($employee) {
            //     return view('components.action_button', [
            //         "id" => $employee->uuid,
            //         "name" => "Action",
            //         "data" => [[
            //             'name' => 'Edit',
            //             'icon' => 'pen-to-square',
            //             'color' => 'secondary',
            //             'click' => 'showModal',
            //         ]],
            //         "delete" => route('employee.delete', [
            //             'uuid' => $employee->uuid,
            //         ]),
            //     ]
            //     );
            // })
            ->editColumn('status', function ($employee) {
                return StatusHelper::status($employee->status);
            })
            ->rawColumns(['status'])
            ->toJson();
        // }

        // return 'error';

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Employee/FormEmployee/CreateEmployee');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();

        try {
            $store = $this->employeeService->store($request->all());

            if ($store) {
                DB::commit();
                SendEmailController::sendEmailNewEmployee($store);
                return response()->json([
                    'message' => 'Employee created successfully'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => 'Employee failed to create'
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Employee failed to create'
            ], 422);
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $data = $this->employeeService->findByUUID($uuid);

        return new EmployeeResource($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $data['employee'] = $this->employeeService->findByUUID($uuid);

        return Inertia::render('Employee/FormEmployee/EditEmployee', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, $uuid)
    {
        DB::beginTransaction();

        try {
            $update = $this->employeeService->update($uuid, $request->validated());

            if ($update) {
                DB::commit();
                return response()->json([
                    'message' => 'Employee updated successfully'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => 'Employee failed to update'
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Employee failed to update'
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $delete = $this->employeeService->delete($uuid);

        if ($delete) {
            return response()->json([
                'message' => 'Employee deleted successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Employee failed to delete'
            ], 422);
        }
    }
}