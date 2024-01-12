<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{
    public function create_product(Request $request){
        try{

            $validated = $request->validate([
                'title' => ['required', 'string', 'max:100'],
                'description' => ['required', 'string', 'max:1000'],
                'price' => ['required', 'integer'],
                'photo' => ['nullable', 'string']
            ]);

            $data = [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'photo' => $validated['photo'] ?? null,
            ];

            Product::create($data);
            return self::send_success();

        }catch(Exception $error){
            return self::send_error($error->getMessage());
        }
    }

    public function get_product(Request $request){
        try{
            $validated = $request->validate(['product_id' => ['required', 'integer']]);
            $product = Product::findOrFail($validated['product_id']);
            return $product;

        }catch(Exception $error){
            return self::send_error($error->getMessage());
        }
    }

    public function update_product(Request $request){
        try{
            $product_id = $request->product_id;

            $validated = $request->validate([
                'title' => ['nullable', 'string', 'max:100'],
                'description' => ['nullable', 'string', 'max:1000'],
                'price' => ['nullable', 'integer'],
                'photo' => ['nullable', 'string']
            ]);

            $data = [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'photo' => $validated['photo'],
            ];

            Product::where('product_id', $product_id)->get()->first()->update($data);
            return self::send_success();

        }catch(Exception $error){
            return self::send_error($error->getMessage());
        }
    }

    public function delete_product(Request $request){
        try{
            $validated = $request->validate(['product_id' => ['required', 'integer']]);
            $product = Product::findOrFail($validated['product_id'])->delete();
            return self::send_success();

        }catch(Exception $error){
            return self::send_error($error->getMessage());
        }
    }

    public function get_products(Request $request){
        try{
            $validated = $request->validate([
                'page' => ['required', 'integer'],
            ]);
            $page = $validated['page'];
            $products = Product::offset(($page-1)*5)->limit(5)->get();
            return $products;

        }catch(Exception $error){
            return self::send_error($error->getMessage());
        }
    }
}
