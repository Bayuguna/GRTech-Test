<?php

namespace App\Http\Controllers;

use App\Services\UserRoleService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;

class UserRoleController extends Controller
{

    protected $userRoleService;
    public function __construct(UserRoleService $userRoleService)
    {
        $this->userRoleService = $userRoleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function data(Request $request)
    {
        $user_roles = $this->userRoleService->all()->where('user_uuid', $request->user_uuid);

        return DataTables::of($user_roles)
            ->addIndexColumn()
            ->addColumn('role', function ($user_role) {
                return $user_role->role->name;
            })
            ->rawColumns(['role'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $checkRole = $this->userRoleService->all()->where('user_uuid', $request->user_uuid)->where('role_uuid', $request->role_uuid)->first();

            if ($checkRole) {
                return response()->json([
                    'message' => 'User Role already exists'
                ], 422);
            }

            $user = $this->userRoleService->store($request->all());

            if ($user) {
                DB::commit();
                return response()->json([
                    'message' => 'User Role created successfully'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => 'User Role failed to create'
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'User Role failed to create' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $this->userRoleService->delete($uuid);
        return response()->json([
            'message' => 'User Role deleted successfully'
        ]);
    }
}