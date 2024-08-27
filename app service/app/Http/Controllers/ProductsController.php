<?php

namespace App\Http\Controllers;

use App\Jobs\ProductLikedJob;
use App\Models\Product;
use App\Models\ProductUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    public function index()
    {
        return Product::all();
    }

   public function like(Product $product,Request $request){
    $response = Http::get('http://host.docker.internal:8080/api/user');

    $user = $response->json();

    try {
        ProductUser::create([
            'user_id' => $user['id'],
            'product_id' => $product->id
        ]);

        ProductLikedJob::dispatch($product->id);

        return response([
            'message' => 'success'
        ]);
    } catch (\Exception $exception) {
        return response([
            'error' => 'You already liked this product!'
        ], Response::HTTP_BAD_REQUEST);
    }
   }
}
