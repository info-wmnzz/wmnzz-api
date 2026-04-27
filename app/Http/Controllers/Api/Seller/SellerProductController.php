<?php

namespace App\Http\Controllers\Api\Seller;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Models\SellerProducts;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FileUploadService $fileService)
    {
        $tip = 'Product List';
        $message = 'Products fetched successfully';
        $user = Auth::user();

        $products = SellerProducts::with([
            'businessDetail:id,seller_id,store_name,store_phone,store_email,business_category,image',
        ])->where('seller_id', $user->id)
            ->latest()
            ->get();

        $products->transform(function ($product) use ($fileService) {
            $product->image = $fileService->getUrl($product->image);

            if ($product->businessDetail && $product->businessDetail->image) {
                // print_r($product->businessDetail->image);exit;
                $product->businessDetail->image = $fileService->getUrl($product->businessDetail->image);
            }

            return $product;
        });

        $responseArray = apiResponse('Success', '', false, $products, 200, $tip, $message);

        return response()->json($responseArray, 200);
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
        $tip = 'Product Create';
        $message = 'Products Created successfully';

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'required|max:150',
            'selling_price' => 'required|numeric|min:0',
            'mrp_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($validator->fails()) {
            $responseArray = apiResponse('Failed', $validator, false, '', 422, $tip);

            return response()->json($responseArray, 422);
        }

        DB::beginTransaction();

        try {
            $imagePath = null;
            $user = Auth::user();

            if ($request->hasFile('image')) {
                $upload = $fileService->upload($request->file('image'), 'products');
                $imagePath = $upload['path'];
            }

            $product = SellerProducts::create([
                'category_id' => $request->category_id,
                'seller_id' => $user->id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'desc' => $request->desc,
                'image' => $imagePath,
                'status' => ProductStatus::PENDING->value,
                'brand_name' => $request->brand_name,
                'selling_price' => $request->selling_price,
                'mrp_price' => $request->mrp_price,
                'stock' => $request->stock,
            ]);

            DB::commit();

            $responseArray = apiResponse('Success', '', false, '', 200, $tip, $message);

            return response()->json($responseArray, 200);

        } catch (\Exception $e) {
            DB::rollBack();

            $responseArray = apiResponse('Failed', $e, false, '', 500, $tip);

            return response()->json($responseArray, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = SellerProducts::findOrFail($id);

        return response()->json($product);
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
    public function update(Request $request, $id, FileUploadService $fileService)
    {
        $tip = 'Product Update';
        $message = 'Products Updated successfully';

        $product = SellerProducts::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|unique:products,product_id',
            'name' => 'required|max:100',
            'selling_price' => 'required|numeric|min:0',
            'mrp_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($validator->fails()) {
            $responseArray = apiResponse('Failed', $validator, false, '', 422, $tip);

            return response()->json($responseArray, 422);
        }

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $upload = $fileService->update(
                    $request->file('image'),
                    $product->image,
                    'products'
                );

                $product->image = $upload['path'];
            }

            $product->update([
                'product_id' => $request->product_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'desc' => $request->desc,
                'status' => $request->status ?? $product->status,
                'brand_name' => $request->brand_name,
                'selling_price' => $request->selling_price,
                'mrp_price' => $request->mrp_price,
                'stock' => $request->stock,
            ]);

            DB::commit();

            $responseArray = apiResponse('Success', '', false, '', 200, $tip, $message);

            return response()->json($responseArray, 200);

        } catch (\Exception $e) {
            DB::rollBack();

            $responseArray = apiResponse('Failed', $e, false, '', 500, $tip);

            return response()->json($responseArray, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $tip = 'Product Delete';
        $message = 'Products Deleted successfully';

        $product = SellerProducts::findOrFail($id);

        DB::beginTransaction();

        try {
            $disk = config('filesystems.default');
            if ($product->image && Storage::disk($disk)->exists($product->image)) {
                Storage::disk($disk)->delete($product->image);
            }
            $product->delete();

            DB::commit();

            $responseArray = apiResponse('Success', '', false, '', 200, $tip, $message);

            return response()->json($responseArray, 200);

        } catch (\Exception $e) {
            DB::rollBack();

            $responseArray = apiResponse('Failed', $e, false, '', 500, $tip);

            return response()->json($responseArray, 500);
        }
    }
}
