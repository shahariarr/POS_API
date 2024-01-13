<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    function CategoryCreate(Request $request){
        try{
            $request->validate([
                'name' => 'required|string|min:3|max:10'
            ]);
            $user_id=Auth::id();
            category::create([
                'name'=>$request->input('name'),
                'user_id'=>$user_id
            ]);
            return response()->json(['status' => 'success', 'message' => "Request Successful"]);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

     function CategoryList(){
        try{

            $user_id=Auth::id();
            $row=category::where('user_id',$user_id)->get();
            return response()->json(['status' => 'success', 'message' => "Request Successful",'data'=>$row]);

        }
        catch(\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);

        }
     }

     function CategoryByID(Request $request){
        try{
            $request->validate([
                'id' => 'required|min:1'
            ]);
            $category_id=$request->input('id');
            $user_id=Auth::id();
            $rows=category::where('id',$category_id)->where('user_id',$user_id)->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    function CategoryDelete(Request $request){
        try{
            $request->validate([
                'id' => 'required|string|min:1'
            ]);
            $user_id=Auth::id();
            $category_id=$request->input('id');
            category::where('id',$category_id)->where('user_id',$user_id)->delete();
            return response()->json(['status' => 'success', 'message' => "Request Successful"]);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    function CategoryUpdate(Request $request){

        try{
            $request->validate([
                'id' => 'required|string|min:1'
            ]);
            $user_id=Auth::id();
            $category_id=$request->input('id');
            category::where('id',$category_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name')
            ]);
            return response()->json(['status' => 'success', 'message' => "Request Successful,and updated your data"]);

        }
        catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }


    }



}
