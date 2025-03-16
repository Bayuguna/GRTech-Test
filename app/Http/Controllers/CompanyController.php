<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Resources\Company\CompanyCollection;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\StatusHelper;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Company\CompanyResource;
use DB;
use Illuminate\Support\Str;

class CompanyController extends Controller
{

    protected $companyService;
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Company/MainCompany');
    }

    public function select()
    {
        $company = $this->companyService->all()->get();

        $data = [];
        foreach ($company as $key => $value) {
            $data[] = [
                'value' => $value->uuid,
                'label' => $value->name . ' (' . $value->email . ')',
            ];
        }

        return response()->json($data);
        // return new CompanyCollection($data);
    }

    public function data(Request $request)
    {
        $companies = $this->companyService->all();

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
            ->addColumn('contact', function ($company) {
                return "<div class='flex flex-col'>
                        <span class='font-semibold'>$company->email</span>
                        <span class='text-xs'>$company->phone</span>
                    </div>";
            })
            ->editColumn('name', function ($company) {
                return "<div class='flex items-center gap-2'>
                        <div class=' flex items-center justify-center border rounded-full h-20 w-20'>
                            <img src='/$company->logo_url' alt='logo' class='h-16 w-16 rounded-full'>
                        </div>
                        <div class='flex flex-col'>
                            <span class='font-semibold'>$company->name</span>
                            <a href=$company->website target='_blank' class='text-xs'>$company->website</a>
                        </div>
                    </div>";
            })
            ->editColumn('status', function ($company) {
                return StatusHelper::status($company->status);
            })
            ->editColumn('address', function ($company) {
                return $company->address ?? '-';
            })
            ->rawColumns(['status', 'name', 'contact', 'address'])
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
    public function store(StoreCompanyRequest $request)
    {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('logo')) {
                $logoFile = $request->file('logo');

                // dd($request->all(), $logoFile);
                $fileName = $logoFile->getFilename() . '.' . Str::random($length = 5) . '.' . $logoFile->getClientOriginalExtension();
                $logoFile->storeAs(
                    'companies',
                    $fileName,
                    'public'
                );
            }

            $store = $this->companyService->store([
                ...$request->all(),
                'logo' => $fileName,
            ]);

            // return $store;
            if ($store) {
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
                'message' => 'Company failed to create ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $data = $this->companyService->findByUUID($uuid);

        return new CompanyResource($data);
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
    public function update(UpdateCompanyRequest $request, string $uuid)
    {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('logo')) {
                $logoFile = $request->file('logo');

                $fileName = $logoFile->getFilename() . '.' . Str::random($length = 5) . '.' . $logoFile->getClientOriginalExtension();
                $logoFile->storeAs(
                    'companies',
                    $fileName,
                    'public'
                );

                $request->merge([
                    'logo' => $fileName,
                ]);
            }

            $update = $this->companyService->update($uuid, $request->all());

            if ($update) {
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
        $delete = $this->companyService->delete($uuid);

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