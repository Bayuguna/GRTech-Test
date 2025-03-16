<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleAccessService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use DB;


class RoleController extends Controller
{

    protected $roleService;
    protected $roleAccessService;

    public function __construct(RoleService $roleService, RoleAccessService $roleAccessService)
    {
        $this->roleService = $roleService;
        $this->roleAccessService = $roleAccessService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Setting/Role/MainRole');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function select()
    {
        $roles = $this->roleService->all()->get();

        $data = [];
        foreach ($roles as $key => $value) {
            $data[] = [
                'value' => $value->uuid,
                'label' => $value->name,
            ];
        }

        return response()->json($data);
        // return new CompanyCollection($data);
    }


    public function data(Request $request)
    {
        $roles = $this->roleService->all();

        // if($request->ajax()) {
        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('access_count', function ($role) {
                return $role->roleAccess->count() . ' Access';
            })
            // ->addColumn('action', function($role) {
            //     return view('components.action_button', [
            //         "id" => $role->uuid,
            //         "name" => "Action",
            //         "data" => [[
            //             'name' => 'Edit',
            //             'url' => '#',
            //         ]],
            //         "delete" => route('setting.role.destroy', [
            //             'uuid' => $role->uuid,
            //         ]),
            //     ]
            //     );
            // })
            ->rawColumns(['access_count'])
            ->toJson();
        // }

        // return 'error';

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        DB::beginTransaction();

        try {
            $role = $this->roleService->store(['name' => $request->name]);

            if ($role) {
                if ($request->access_uuid) {
                    foreach ($request->access_uuid as $key => $value) {
                        $this->roleAccessService->store([
                            'role_uuid' => $role->uuid,
                            'access_uuid' => $value,
                        ]);
                    }
                }
                DB::commit();
                return response()->json([
                    'message' => 'Company created successfully'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => 'Company failed to create'
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Company failed to create'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $data = $this->roleService->findByUUID($uuid);

        return new RoleResource($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $uuid)
    {
        DB::beginTransaction();

        try {
            $update = $this->roleService->update($uuid, $request->all());

            if ($update) {
                if ($request->access_uuid) {
                    //Truncate
                    $this->roleAccessService->all()->where('role_uuid', $uuid)->delete();

                    //Store Role
                    foreach ($request->access_uuid as $key => $value) {
                        $this->roleAccessService->store([
                            'role_uuid' => $uuid,
                            'access_uuid' => $value,
                        ]);
                    }
                }
                DB::commit();
                return response()->json([
                    'message' => 'Company updated successfully'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => 'Company failed to update'
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Company failed to update'
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $delete = $this->roleService->delete($uuid);

        if ($delete) {
            return response()->json([
                'message' => 'Company deleted successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Company failed to delete'
            ], 422);
        }
    }
}