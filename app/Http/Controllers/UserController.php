<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\StatusHelper;
use App\Http\Resources\User\UserResource;
use App\Http\Controllers\SendEmailController;
use App\Services\RoleService;
use App\Services\UserRoleService;
use DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $userService;
    protected $userRoleService;

    public function __construct(UserService $userService, UserRoleService $userRoleService)
    {
        $this->userService = $userService;
        $this->userRoleService = $userRoleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/MainUser');
    }

    public function data(Request $request)
    {
        $users = $this->userService->all();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('status', function ($employee) {
                return StatusHelper::status($employee->status);
            })
            ->editColumn('user_roles', function ($user) {
                if ($user->userRoles->count() > 0) {
                    $roles = '';
                    foreach ($user->userRoles as $role) {
                        $roles .= $role->role->name . ', ';
                    }
                    return rtrim($roles, ', ');
                } else {
                    return 'N/A';
                }
            })
            ->rawColumns(['status', 'user_roles'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            'password' => bcrypt($request->password ?? 'password'),
            'created_by' => Auth::user()->name,
        ]);

        try {
            $user = $this->userService->store($request->all());

            if ($user) {

                if ($request->has('role_uuid')) {
                    foreach ($request->role_uuid as $key => $value) {
                        $this->userRoleService->store([
                            'user_uuid' => $user->uuid,
                            'role_uuid' => $value,
                        ]);
                    }
                }
                DB::commit();
                SendEmailController::sendEmailNewUser($user);
                return response()->json([
                    'message' => 'User created successfully'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => 'User failed to create'
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'User failed to create' . $e->getMessage()
            ], 422);
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $data = $this->userService->findByUUID($uuid);

        return new UserResource($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $uuid)
    {
        DB::beginTransaction();

        try {
            $update = $this->userService->update($uuid, $request->all());

            if ($update) {
                DB::commit();
                return response()->json([
                    'message' => 'User updated successfully'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => 'User failed to update'
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'User failed to update'
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $delete = $this->userService->delete($uuid);

        if ($delete) {
            return response()->json([
                'message' => 'User deleted successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'User failed to delete'
            ], 422);
        }
    }
}