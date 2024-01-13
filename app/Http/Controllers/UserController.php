<?php

namespace App\Http\Controllers;


use App\Models\user;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    function UserRegistration(Request $request){
        try {
            $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'email' => 'required|string|email|max:50|unique:users,email',
                'mobile' => 'required|string|max:50',
                'password' => 'required|string|min:3'
            ]);
            user::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => Hash::make($request->input('password'))
            ]);
           return response()->json(['status' => 'success', 'message' => 'User Registration Successfully']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }

     }


     function UserLogin(Request $request){
        try {
            $request->validate([
                'email' => 'required|string|email|max:50',
                'password' => 'required|string|min:3'
            ]);

            $user = user::where('email', $request->input('email'))->first();
            // Auth::login($user);



            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json(['status' => 'failed', 'message' => 'Invalid User']);
            }



            $token = $user->createToken('authToken')->plainTextToken;


            return response()->json(['status' => 'success', 'message' => 'Login Successful','token'=>$token]);
    



        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }




    function UserLogout(Request $request){
        $request->user()->tokens()->delete();
        //return redirect('/userLogin');
        return response()->json(['status' => 'success', 'message' => 'Logout Successful']);

    }



    function Index(Request $request){
        //return response()->json(['status' => 'ops!', 'message' => 'please login first']);
        return view('pages.dashboard.page-dashboard');

    }



    function SendOTPCode(Request $request){

        try {

            $request->validate([
                'email' => 'required|string|email|max:50'
            ]);

            $email=$request->input('email');
            $otp=rand(1000,9999);
            $count=user::where('email','=',$email)->count();

            if($count==1){
                Mail::to($email)->send(new OTPMail($otp));
                user::where('email','=',$email)->update(['otp'=>$otp]);
                return response()->json(['status' => 'success', 'message' => '4 Digit OTP Code has been send to your email !']);
            }
            else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Invalid Email Address or Email Address not found !'
                ]);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    function VerifyOTP(Request $request){

        try {
            $request->validate([
                'email' => 'required|string|email|max:50',
                'otp' => 'required|string|min:4'
            ]);

            $email=$request->input('email');
            $otp=$request->input('otp');

            $user = user::where('email','=',$email)->where('otp','=',$otp)->first();

            if(!$user){
                return response()->json(['status' => 'fail', 'message' => 'Invalid OTP']);
            }

            // CurrentDate-UpdatedTe=4>Min

            //user::where('email','=',$email)->update(['otp'=>'0']);
            $user->update(['otp'=>'0']);

            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['status' => 'success', 'message' => 'OTP Verification Successful','token'=>$token]);

        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }



    function ResetPassword(Request $request){

        try{
            $request->validate([
                'password' => 'required|string|min:3'
            ]);
            $id=Auth::id();
            $password=$request->input('password');
            user::where('id','=',$id)->update(['password'=>Hash::make($password)]);
            return response()->json(['status' => 'success', 'message' => 'Request Successful']);

        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(),]);
        }
    }




    function UserProfile(Request $request){
        return Auth::user();
    }


    function UpdateProfile(Request $request){

        try{
            $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'mobile' => 'required|string|max:50',
            ]);

           User::where('id','=',Auth::id())->update([
                'firstName'=>$request->input('firstName'),
                'lastName'=>$request->input('lastName'),
                'mobile'=>$request->input('mobile'),
                'password'=>Hash::make($request->input('password')),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Profile Updated Successfully']);


        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }





}





