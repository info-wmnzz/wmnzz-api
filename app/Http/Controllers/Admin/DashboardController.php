<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatus;
use App\Enums\serviceStatus;
use App\Http\Controllers\Controller;
use App\Models\CreateService;
use App\Models\SellerProducts;
use App\Models\User;
use App\Services\FileUploadService;

class DashboardController extends Controller
{
    public function index(FileUploadService $fileService)
    {
        $totalSellers = User::where(['role_id' => 2, 'status' => 0])->count();

        $totalServiceProviders = User::where(['role_id' => 3, 'status' => 0])->count();

        $totalProducts = SellerProducts::where('status', ProductStatus::PENDING->value)->count();

        $totalServices = CreateService::where('status', ServiceStatus::PENDING->value)->count();

        $newSellers = User::where('role_id', 2)
            ->where('status', 0)
            ->latest()
            ->take(10)
            ->get();

        $newServiceProviders = User::where('role_id', 3)
            ->where('status', 0)
            ->latest()
            ->take(10)
            ->get();

        $latestProducts = SellerProducts::with('seller')
            ->where('status', ProductStatus::PENDING->value)
            ->latest()
            ->take(10)
            ->get()
            ->transform(function ($product) use ($fileService) {

                $product->image = $fileService->getUrl($product->image);

                return $product;
            });

        $latestServices = CreateService::with('serviceProviderDetail')
            ->where('status', ServiceStatus::PENDING->value)
            ->latest()
            ->take(10)
            ->get()
            ->transform(function ($service) use ($fileService) {

                $service->image = $fileService->getUrl($service->image);

                return $service;
            });

        return view('admin.onboarddashboard', compact(
            'totalSellers',
            'totalServiceProviders',
            'totalProducts',
            'totalServices',
            'newSellers',
            'newServiceProviders',
            'latestProducts',
            'latestServices'
        ));
    }

    public function approveSeller($id)
    {
        $seller = User::findOrFail($id);

        $seller->status = 1;

        $seller->save();

        return back()->with('success', 'Seller Approved');
    }

    public function approveProduct($id)
    {
        $product = SellerProducts::findOrFail($id);

        $product->status = ProductStatus::APPROVED;

        $product->save();

        return back()->with('success', 'Product Approved');
    }

    public function approveService($id)
    {
        $service = CreateService::findOrFail($id);

        $service->status = serviceStatus::APPROVED;

        $service->save();

        return back()->with('success', 'Service Approved');
    }
}
