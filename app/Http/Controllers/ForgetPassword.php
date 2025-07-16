<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use Illuminate\Http\Request;

class ForgetPassword extends Controller
{
    function SendOtpForm()
    {
        return view('pages.auth.Send-otp-form');
    }

    function VerifyOtp()
    {
        return view('pages.auth.Verify-otp-form');
    }

    function UpdatePassword(Request $request)
    {
        $token = $_COOKIE['UpdatePassToken']??null;
        $tokenVerify = JWTToken::VerifyToken($token);

        if ($tokenVerify === "Unauthorized") {
            return redirect('/loginRegister'); // Already logged in → redirect to dashboard
        }

        return view('pages.auth.Update-password-form');
    }
}
