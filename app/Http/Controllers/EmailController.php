<?php

namespace App\Http\Controllers;

use App\Mail\otpSender;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class EmailController extends Controller
{

    // public function sendEmail($toEmail)
    // {
    //     $subject = "Welcome!";
    //     $message = "Thanks for joining us.";

    //     try {
    //         Mail::to($toEmail)->send(new WelcomeEmail($subject, $message));
    //         return "true";
    //     } catch (\Exception $e) {
    //         logger('Email failed: ' . $e->getMessage());
    //         return "false";
    //     }
    // }

    public function otpSender(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // Check recent OTP for same email (60 sec rule)
        $lastOtp = Otp::where('email', $email)->latest()->first();

        if ($lastOtp && $lastOtp->created_at->diffInSeconds(now()) < 60) {
            return response()->json([
                'status' => false,
                'message' => 'Please wait before requesting OTP again.'
            ], 429);
        }

        // If OTP still valid, don't resend
        if ($lastOtp && Carbon::parse($lastOtp->expires_at)->isFuture()) {
            return response()->json([
                'status' => true,
                'message' => 'OTP already sent. Check your email.'
            ]);
        }

        // Generate secure OTP
        $otp = random_int(100000, 999999);

        Otp::create([
            'email' => $email,
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($email)->queue(new OtpSender(
            "Your OTP Code",
            "Do not share this OTP.",
            $otp
        ));

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully.'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $record = Otp::where('email', $request->email)->latest()->first();

        if (!$record || now()->gt($record->expires_at)) {
            return response()->json(['message' => 'OTP expired'], 400);
        }

        if (!Hash::check($request->otp, $record->otp_hash)) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
        
        $record->update([
        'verified' => true
    ]);

        return response()->json(['message' => 'OTP verified'], 200);
    }
}
