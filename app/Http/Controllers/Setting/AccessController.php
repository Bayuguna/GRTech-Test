<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Access\StoreAccessRequest;
use App\Http\Requests\Access\UpdateAccessRequest;
use App\Http\Resources\Access\AccessResource;
use App\Services\AccessService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use DB;

class AccessController extends Controller
{

    protected $accessService;
    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Setting/Access/MainAccess');
    }

    public function data(Request $request)
    {
        $companies = $this->accessService->all()->orderBy('name', 'asc')->get();

        // if($request->ajax()) {
        return DataTables::of($companies)
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

            ->rawColumns([])
            ->toJson();
        // }

        // return 'error';

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
    public function store(StoreAccessRequest $request)
    {
        DB::beginTransaction();

        try {
            $store = $this->accessService->store($request->all());

            if ($store) {
                DB::commit();
                return response()->json([
                    'message' => 'Access created successfully'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => 'Access failed to create'
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $data = $this->accessService->findByUUID($uuid);

        return new AccessResource($data);
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
    public function update(UpdateAccessRequest $request, string $uuid)
    {
        $update = $this->accessService->update($uuid, $request->validated());

        if ($update) {
            return response()->json([
                'message' => 'Access updated successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Access failed to update'
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $delete = $this->accessService->delete($uuid);

        if ($delete) {
            return response()->json([
                'message' => 'Access deleted successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Access failed to delete'
            ], 422);
        }
    }
}