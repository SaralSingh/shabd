<?php

namespace App\Http\Controllers;

use App\Mail\otpSender;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function sendEmail($toEmail)
    {
        $subject = "Welcome!";
        $message = "Thanks for joining us.";

        try {
            Mail::to($toEmail)->send(new WelcomeEmail($subject, $message));
            return "true";
        } catch (\Exception $e) {
            logger('Email failed: ' . $e->getMessage());
            return "false";
        }
    }

    public function otpSender(Request $request)
    {
        $otp = rand(1000, 9999);
        $toEmail = $request->email;

        session(
            [
                'otp' => $otp,
                'email' => $toEmail
            ]
        );

        $subject = "Your One-Time Password (OTP)";
        $message = "Please do not share this code with anyone.\n\nRegards,\nTeam Blogify";

        $status = Mail::to($toEmail)->send(new otpSender($subject, $message, $otp));
        if ($status) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'OTP sent successfully!'
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'otp sending failed'
                ],
                500
            );
        }
    }
}
