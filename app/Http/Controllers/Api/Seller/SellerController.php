<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerBusinessDetail;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    public function updateBusinessDetails(Request $request, FileUploadService $fileService)
    {
        $tip = 'Update Business Derails';
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'business_category' => 'required|string|max:255',
            'gst_number' => 'nullable|string|size:15',
            'cin' => 'nullable|string|max:21',
            'store_email' => 'required|email',
            'store_phone' => 'required|string|max:15',
            'business_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse('Failed', $validator, false, '', 422, $tip);

            return response()->json($responseArray, 422);
        }

        try {
            $user = $request->user();

            if (! $user) {
                $responseArray = apiResponse('Failed', '', false, '', 404, $tip, 'User not found');

                return response()->json($responseArray, 404);
            }
            $data = $request->only([
                'store_name',
                'business_category',
                'gst_number',
                'cin',
                'store_email',
                'store_phone',
                'business_address',
                'city',
                'pincode',
                'latitude',
                'longitude',
            ]);

            if ($request->hasFile('image')) {
                $upload = $fileService->upload($request->file('image'), 'storeImage');
                $data['image'] = $upload['path'];
            }

            $business = SellerBusinessDetail::updateOrCreate(
                ['seller_id' => $user->id],
                $data
            );

            $responseArray = apiResponse('Success', '', false, '', 200, $tip, 'Updated successfully');

            return response()->json($responseArray, 200);

        } catch (\Exception $ex) {

            $responseArray = apiResponse('Failed', $ex, false, '', 500, $tip);

            return response()->json($responseArray, 500);
        }
    }
}
