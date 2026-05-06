<?php

namespace App\Http\Controllers\Api\Customer;

use App\Enums\ProductStatus;
use App\Enums\serviceStatus;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CreateService;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerProducts;
use App\Models\ServiceBooking;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse('Failed', $validator, false, '', 422, 'Add to cart');

            return response()->json($responseArray, 422);
        }
        try {
            DB::beginTransaction();

            // Get or create cart
            $cart = Cart::firstOrCreate([
                'user_id' => auth('api')->id(),
            ]);

            // Check item already exists
            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $request['product_id'] ?? null)
                ->first();

            if ($item) {
                $item->quantity += $request['quantity'];
                $item->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $request['product_id'] ?? null,
                    'service_id' => $request['service_id'] ?? null,
                    'quantity' => $request['quantity'],
                    'price' => 100, // 👉 fetch from product/service
                ]);
            }

            DB::commit();

            $responseArray = apiResponse('Success', '', false, '', 200, 'Add to cart', 'Added to cart');

            return response()->json($responseArray, 200);

        } catch (\Throwable $e) {
            DB::rollBack();

            $responseArray = apiResponse('Failed', $e, false, '', 500);

            return response()->json($responseArray, 500);
        }
    }

    public function placeOrder()
    {
        try {
            DB::beginTransaction();
            $user = auth('api')->user();

            $cart = Cart::with('items')->where('user_id', $user->id)->first();

            if (! $cart || $cart->items->isEmpty()) {
                $responseArray = apiResponse('Failed', 'Cart is empty', false, '', 400);

                return response()->json($responseArray, 400);
            }

            // Create order
            $order = Order::create([
                'order_id' => 'ORD-'.time(),
                'customer_id' => $user->id,
                'customer_name' => $user->name,
                'total_amount' => 0,
                'order_status' => 0,
                'order_date_time' => now(),
            ]);

            $total = 0;

            foreach ($cart->items as $item) {

                $itemTotal = $item->price * $item->quantity;
                $product = SellerProducts::where('id',$item->product_id)->first();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'item_name' => $product->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $itemTotal,
                ]);

                $total += $itemTotal;
            }

            // Update total
            $order->update(['total_amount' => $total]);

            // Clear cart
            CartItem::where('cart_id', $cart->id)->delete();

            DB::commit();

            $responseArray = apiResponse('Success', '', false, '', 200, 'Place Order', 'Order placed successfully');

            return response()->json($responseArray, 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            $responseArray = apiResponse('Failed', $e, false, '', 500);

            return response()->json($responseArray, 500);
        }
    }

    public function bookService(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validate([
                'service_id' => 'required|exists:create_services,id',
                'booking_date' => 'required|date',
                'booking_time' => 'required',
                'address' => 'required',
            ]);

            $service = CreateService::findOrFail($data['service_id']);

            $booking = ServiceBooking::create([
                'booking_id' => 'BkG-'.time(),
                'user_id' => auth('api')->id(),
                'service_id' => $service->id,
                'service_provider_id' => $service->service_provider_id,
                'booking_date' => $data['booking_date'],
                'booking_time' => $data['booking_time'],
                'address' => $data['address'],
                'price' => $service->price,
                'status' => 0,
            ]);

            DB::commit();

            $responseArray = apiResponse('Success', '', false, $booking, 200, 'Book Service', 'Service booked successfully');

            return response()->json($responseArray, 200);

        } catch (\Throwable $e) {

            DB::rollBack();

            $responseArray = apiResponse('Failed', $e, false, '', 500);

            return response()->json($responseArray, 500);
        }
    }

    public function viewAllProduct(Request $request, FileUploadService $fileService)
    {
        $tip = 'Product List';
        $message = 'Products fetched successfully';

        $products = SellerProducts::with([
            'businessDetail:id,seller_id,store_name,store_phone,store_email,business_category,image',
        ])->where('status', ProductStatus::ACTIVE)
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

    public function viewAllServices(Request $request, FileUploadService $fileService)
    {
        $tip = 'Service List';
        $message = 'Products fetched successfully';

        $services = CreateService::with([
            'serviceProviderDetail:id,name,mobile,email',
        ])->where('status', serviceStatus::ACTIVE)
            ->latest()
            ->get();

        $services->transform(function ($service) use ($fileService) {
            $service->image = $fileService->getUrl($service->image);

            return $service;
        });

        $responseArray = apiResponse('Success', '', false, $services, 200, $tip, $message);

        return response()->json($responseArray, 200);
    }
}
