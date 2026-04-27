<?php

namespace App\Http\Controllers;

use App\Enums\serviceStatus;
use App\Models\CreateService;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FileUploadService $fileService)
    {
        $services = CreateService::where('service_provider_id', auth()->id())
            ->latest()
            ->get();

        $services->transform(function ($service) use ($fileService) {
            $service->image = $fileService->getUrl($service->image);
            $service->status = ServiceStatus::from($service->status)->label();

            return $service;
        });

        $responseArray = apiResponse('Success', '', false, $services, 200, 'Create service', 'Service created successfully');

        return response()->json($responseArray, 201);
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
    public function store(Request $request, FileUploadService $fileService)
    {
        DB::beginTransaction();

        try {
            $data = $request->validate([
                'service_title' => 'required',
                'service_category' => 'required',
                'city_of_operation' => 'required',
                'service_desc' => 'required',
                'price' => 'required|numeric',
                'experience' => 'required|integer',
                'image' => 'nullable|file',
            ]);

            // Upload image
            if ($request->hasFile('image')) {
                $upload = $fileService->upload($request->file('image'), 'service');
                $data['image'] = $upload['path'];
            }

            $data['service_provider_id'] = auth()->id();
            $data['status'] = serviceStatus::PENDING;

            $service = CreateService::create($data);

            DB::commit();

            $responseArray = apiResponse('Success', '', false, '', 200, 'Create service', 'Service created successfully');

            return response()->json($responseArray, 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            if (isset($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            $responseArray = apiResponse('Failed', $e, false, '', 500, 'Create service');

            return response()->json($responseArray, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, FileUploadService $fileService)
    {
        try {
            $service = CreateService::select('id','service_provider_id','service_title','service_category','city_of_operation','service_desc','price','experience','image','status','service_provider_address','city','pincode','latitude','longitude')->where('id', $id)
                ->where('service_provider_id', auth()->id())
                ->firstOrFail();
            $service->image = $fileService->getUrl($service->image);
            $service->status = ServiceStatus::from($service->status)->label();

            $responseArray = apiResponse('Success', '', false, $service, 200, 'Create service', 'Service fetched successfully');

            return response()->json($responseArray, 201);

        } catch (\Throwable $e) {
            $responseArray = apiResponse('Failed', $e, false, '', 500, 'Create service');

            return response()->json($responseArray, 500);
        }
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
    public function update(Request $request, CreateService $service, FileUploadService $fileService)
    {
        if ($service->service_provider_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        DB::beginTransaction();

        try {
            $data = $request->validate([
                'service_title' => 'sometimes',
                'service_category' => 'sometimes',
                'city_of_operation' => 'sometimes',
                'service_desc' => 'sometimes',
                'price' => 'sometimes|numeric',
                'experience' => 'sometimes|integer',
                'image' => 'nullable|file',
            ]);

            // Replace image
            if ($request->hasFile('image')) {

                // delete old
                if ($service->image) {
                    $fileService->delete($service->image);
                }

                $upload = $fileService->upload($request->file('image'), 'service');
                $data['image'] = $upload['path'];
            }

            $service->update($data);

            DB::commit();

            $responseArray = apiResponse('Success', '', false, '', 200, 'update service', 'Service updated successfully');

            return response()->json($responseArray, 200);

        } catch (\Throwable $e) {

            DB::rollBack();

            $responseArray = apiResponse('Failed', $e, false, '', 500, 'Create service');

            return response()->json($responseArray, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreateService $service, FileUploadService $fileService)
    {
        if ($service->service_provider_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        DB::beginTransaction();

        try {
            // delete image
            if ($service->image) {
                $fileService->delete($service->image);
            }

            $service->delete();

            DB::commit();

            $responseArray = apiResponse('Success', '', false, '', 200, 'Delete service', 'Service deleted successfully');

            return response()->json($responseArray, 200);

        } catch (\Throwable $e) {

            DB::rollBack();

            $responseArray = apiResponse('Failed', $e, false, '', 500, 'Create service');

            return response()->json($responseArray, 500);
        }
    }
}
