<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Jobs\ProductCreatedJob;
use App\Jobs\ProductDeletedJob;
use App\Jobs\ProductUpdatedJob;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    public function index(){
        return Product::all();
    }
    public function show(Product $product){
        return $product;
    }

    public function store(Request $request)
    {
        $product = Product::create($request->only('title', 'image'));

        ProductCreatedJob::dispatch($product->toArray());


        return response($product, Response::HTTP_CREATED);
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);

        $product->update($request->only('title', 'image'));

        ProductUpdatedJob::dispatch($product->toArray());


        return response($product, Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        Product::destroy($id);

        ProductDeletedJob::dispatch($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

