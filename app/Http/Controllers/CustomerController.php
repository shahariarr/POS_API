<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    function CustomerCreate(Request $request){
        try{
            $request->validate([
                'name' => 'required|string|min:3|max:10',
                'email' => 'required|string|email|max:50|unique:users,email',
                'mobile' => 'required|string|max:50',
            ]);

            $user_id=Auth::id();
            customer::create([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'user_id'=>$user_id
            ]);
            return response()->json(['status' => 'success', 'message' => "Request Successful"]);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function CustomerList(){
        try{

            $user_id=Auth::id();
            $row=customer::where('user_id',$user_id)->get();
            return response()->json(['status' => 'success', 'message' => "Request Successful",'data'=>$row]);

        }
        catch(\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);

        }
     }


     function CustomerDelete(Request $request){
        try{
            $request->validate([
                'id' => 'required|string|min:1'
            ]);
            $user_id=Auth::id();
            $category_id=$request->input('id');
            customer::where('id',$category_id)->where('user_id',$user_id)->delete();
            return response()->json(['status' => 'success', 'message' => "Request Successful"]);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    function CustomerByID(Request $request){
        try{
            $request->validate([
                'id' => 'required|min:1'
            ]);
            $category_id=$request->input('id');
            $user_id=Auth::id();
            $rows=customer::where('id',$category_id)->where('user_id',$user_id)->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    function CustomerUpdate(Request $request){

        try{
            $request->validate([
                'id' => 'required|string|min:1'
            ]);
            $user_id=Auth::id();
            $category_id=$request->input('id');
            customer::where('id',$category_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
            ]);
            return response()->json(['status' => 'success', 'message' => "Request Successful,and updated your data"]);

        }
        catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }


    }





    }


