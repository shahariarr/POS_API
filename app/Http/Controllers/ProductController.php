<?php

namespace App\Http\Controllers;

use App\Models\product;
//use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function ProductCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:1|max:10',
                'price' => 'required|string|min:1|max:10',
                'unit' => 'required|string|min:1|max:10',
                //'img'=>'required|string|min:3|max:10',

            ]);
            $user_id = Auth::id();
            $category_id = $request->input('category_id');
            $img = $request->file('img');
            $t = time();
            $img_name = "{$user_id}_{$t}.{$img->getClientOriginalName()}";
            $img_url = "uploads/{$img_name}";
            $img->move(public_path('uploads'), $img_name);



            return product::create([
                'name' => $request->input('name'),
                'user_id' => $user_id,
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'img' => $img_url,
                'category_id' => $category_id
            ]);
            //return response()->json(['status' => 'success', 'message' => "Request Successful"]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function ProductDelete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|string|min:1'
            ]);

            $user_id = Auth::id();
            $product_id = $request->input('id');
            $img = $request->input('file_path');


            if (File::exists($img)) {
                File::delete($img);
            } else {
                return response()->json(['status' => 'fail', 'message' => "File not found: $img"]);
            }


            $product = Product::where('id', $product_id)->where('user_id', $user_id)->first();
            if ($product) {
                $product->delete();
            } else {
                return response()->json(['status' => 'fail', 'message' => "Product not found: $product_id"]);
            }

            return response()->json(['status' => 'success', 'message' => "Request Successful"]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    function ProductList()
    {

        try {

            $user_id = Auth::id();
            $row = product::where('user_id', $user_id)->get();
            return response()->json(['status' => 'success', 'message' => "Request Successful", 'data' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    function ProductByID(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|min:1'
            ]);
            $product_id = $request->input('id');
            $user_id = Auth::id();
            $rows = product::where('id', $product_id)->where('user_id', $user_id)->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }




    function ProductUpdate(Request $request)
    {

        try {
            $request->validate([
                'id' => 'required|string|min:1',
                'name' => 'required|string|min:1|max:10',
                'price' => 'required|string|min:1|max:10',
                'unit' => 'required|string|min:1|max:10',
            ]);
            $user_id = Auth::id();
            $product_id = $request->input('id');

            if ($request->hasFile('img')) {

                $img = $request->file('img');
                $t = time();
                $img_name = "{$user_id}_{$t}.{$img->getClientOriginalName()}";
                $img_url = "uploads/{$img_name}";
                $img->move(public_path('uploads'), $img_name);

                $img = $request->input('file_path');

                if (File::exists($img)) {
                    File::delete($img);
                } else {
                    return response()->json(['status' => 'fail', 'message' => "File not found: $img"]);
                }


                product::where('id', $product_id)->where('user_id', $user_id)->update([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'unit' => $request->input('unit'),
                    'img' => $img_url,
                    'category_id' => $request->input('category_id'),
                    'user_id' => $user_id,


                ]);
                return response()->json(['status' => 'success', 'message' => "Request Successful,and updated your data"]);
            } else {

                product::where('id', $product_id)->where('user_id', $user_id)->update([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'unit' => $request->input('unit'),
                    //'img'=>$img_url,
                    'category_id' => $request->input('category_id'),
                    'user_id' => $user_id,

                ]);
                return response()->json(['status' => 'success', 'message' => "Request Successful,and updated your data"]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
