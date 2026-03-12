<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductsResources;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:products_create')->only(['store']);
        $this->middleware('permission:products_update')->only(['update']);
        $this->middleware('permission:products_delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $products = Product::paginate(getPerPage($request));

        return ProductsResources::collection($products);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $request, &$products) {

                $products = Product::create($data);

                if ($request->hasFile('image')) {

                    $file = $request->file('image');

                    $products->addOptimizedMediaToCollection($file, 'image');
                }

                return $products;
            });

            return backWithSuccess(
                data: new ProductsResources($products)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return new ProductsResources($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, $product, $request) {
                $product->update($data);

                if ($request->hasFile('image')) {
                    $file = $request->file('image');

                    $product->clearMediaCollection('image');
                    $product->addOptimizedMediaToCollection($file, 'image');
                }
            });

            return backWithSuccess(
                data: new ProductsResources($product)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        try {
            $product->delete();

            return backWithSuccess();
        } catch (\Exception $e) {
            backWithError($e);
        }
    }
}
