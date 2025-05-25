<?php
namespace App\Http\Controllers\Api\HomePage;

use App\Http\Controllers\Controller;
use App\Models\Product;
use \App\Models\Category;

class CustomerHomePageController extends Controller
{
    public function getCatgorys()
    {
        $categories = Category::select('id', 'categor_id', 'name', 'slug', 'image', 'desc as description')
            ->where('status', 1)
            ->get();

        foreach ($categories as $key => $value) {
            $categories[$key]['image'] = $value->image ? asset('uploads/category/' . $value->image) : asset('favicon.png'); // default image in /public
        }

        return response()->json([
            'status' => 200,
            'data'   => $categories,
        ]);
    }

    public function getProducts()
    {
        $products = Product::with('category:id,categor_id,name,slug,image,desc')
            ->where('status', 1)
            ->get();

        $products = $products->map(function ($product) {
            return [
                'id'          => $product->id,
                'product_id'  => $product->product_id,
                'name'        => $product->name,
                'slug'        => $product->slug,
                'description' => $product->desc,
                'image'       => $product->image
                ? asset('uploads/product/' . $product->image)
                : asset('favicon.png'),
                'category'    => [
                    'id'          => $product->category?->id,
                    'categor_id'  => $product->category?->categor_id,
                    'name'        => $product->category?->name,
                    'slug'        => $product->category?->slug,
                    'image'       => $product->category?->image
                    ? asset('uploads/category/' . $product->category->image)
                    : asset('favicon.png'),
                    'description' => $product->category?->desc,
                ],
            ];
        });

        return response()->json([
            'status' => 200,
            'data'   => $products,
        ]);
    }


    public function getCategoryWithProducts()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->where('status', 1);
        }])
            ->where('status', 1)
            ->get();

        $categories = $categories->map(function ($category) {
            return [
                'id'          => $category->id,
                'categor_id'  => $category->categor_id,
                'name'        => $category->name,
                'slug'        => $category->slug,
                'description' => $category->desc,
                'image'       => $category->image
                ? asset('uploads/category/' . $category->image)
                : asset('favicon.png'),
                'products'    => $category->products->map(function ($product) {
                    return [
                        'id'          => $product->id,
                        'product_id'  => $product->product_id,
                        'name'        => $product->name,
                        'slug'        => $product->slug,
                        'description' => $product->desc,
                        'image'       => $product->image
                        ? asset('uploads/product/' . $product->image)
                        : asset('favicon.png'),
                    ];
                }),
            ];
        });

        return response()->json([
            'status' => 200,
            'data'   => $categories,
        ]);
    }

}
