<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use DateTime;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserContorller extends Controller
{
    public function loginRegisterLoad(Request $request)
    {
        $token = $request->cookie('token');
        $userEmail = JWTToken::VerifyToken($token);

        if ($userEmail !== "Unauthorized") {
            return redirect('/dashboard'); // Already logged in → redirect to dashboard
        }

        return view('pages.auth.LoginRegister');
    }

    // register from api
    public function register(Request $request)
    {
        try {
            $res = User::create($request->input());
            return response()->json([
                'status' => 'Success',
                'message' => 'Registration success',
                'id' => $res->id
            ]);
        } catch (Error $e) {
            return "User not created";
        }
    }

    // User login
    public function login(Request $request)
    {
        $userCount = User::where($request->input())->select('id')->first();
        if ($userCount !== null) {
            $token = JWTToken::CreateToken($request->input('email'), $userCount->id);
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful',
            ])->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    // user logout
    public function Logout(Request $request)
    {
        return redirect("/loginRegister")->cookie("token", "", -1);
    }


    // Send forget password OTP
    public function SendOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();

        if ($count === 1) {
            // OTP Email Address
            Mail::to($email)->send(new OTPMail($otp));
            // OTP Code Table Update from database
            User::where('email', '=', $email)->update(['otp' => $otp]);

            // Return message
            return response()->json([
                'status' => 'success',
                'message' => '4 Digit OTP has been send',
                'email' => $email
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }



    public function VerifyOTP(Request $request)
    {

        $email = $request->input('email');
        $otp = $request->input('otp');

        // otp time check 5 minit
        $user = User::where('email', '=', $email)->first();
        $currentTime = new DateTime();
        $otpTime = new DateTime($user->updated_at);
        $interval = $currentTime->getTimestamp() - $otpTime->getTimestamp(); // in seconds
        if ($interval > 300) {
            User::where('email', '=', $email)->update(['otp' => NULL]);
        }
        // 
        $coutnUser = User::where('email', '=', $email)
            ->where('otp', '=', $otp)->count();

        if ($coutnUser === 1 && $otp > 999) {
            User::where('email', '=', $email)->update(['otp' => NULL]);
            // jwt token create for change password
            $UpdatePassToken = JWTToken::CreateTokenForVerifyOtp($email);

            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful'
            ])->cookie('UpdatePassToken', $UpdatePassToken, 5);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function UpdatePassword(Request $request)
    {
        $email = $request->header('email');
        $password = $request->input('password');
        User::where('email', '=', $email)->update(['password' => $password]);
        return response()->json([
            'status' => 'success',
            'message' => 'New Password updated success'
        ])->cookie('UpdatePassToken', '', 0);
    }

    // profile
    public function Profile(Request $request)
    {
        return view("pages.profile.Profile");
    }

    public function GetUserData(Request $request)
    {
        $email = $request->header("email");
        $user = User::where("email", "=", $email)->first();

        return response()->json([
            "status" => "success",
            "message" => "Request Successful",
            "data" => $user,
        ]);
    }

    // update user data
    public function UpdateUserData(Request $request)
    {
        try {
            $email = $request->header("email");
            $firestName = $request->input("firstName");
            $lastName = $request->input("lastName");
            $mobile = $request->input("mobile");
            $password = $request->input("password");
            // profile photo
            if ($request->hasFile('profilePhoto')) {
                Storage::deleteDirectory('public/userphoto');
                $file = $request->file('profilePhoto');

                // Generate unique filename to avoid conflicts
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Store in 'storage/app/public/photos'
                $file->storeAs('public/userphoto', $filename);


                // Prepare profile photo path
                $profilePhotoPath = 'storage/userphoto/' . $filename;
                User::where("email", "=", $email)->update([
                    "profilePhoto" => $profilePhotoPath,
                ]);
            }

            User::where("email", "=", $email)->update([
                "first_name" => $firestName,
                "last_name" => $lastName,
                "mobile" => $mobile,
                "password" => $password,
            ]);
            
            return response()->json([
                "status" => "success",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
