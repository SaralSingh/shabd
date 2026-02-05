<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Otp;
use Illuminate\Support\Carbon;


class AuthController extends Controller
{
    public function registerPage()
    {
        return view('Visitor.register');
    }


    public function registerCheck(Request $request)
{
    // 1) Validate basic inputs first (email needed for OTP gate)
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'username' => 'required|string|max:50|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'avatar' => 'required|image|mimes:png,jpg,jpeg|max:10240'
    ]);

    $email = $validated['email'];

    // 2) OTP gate (DB based)
    $otpRecord = Otp::where('email', $email)
        ->where('verified', true)
        ->latest()
        ->first();

    if (!$otpRecord) {
        return back()->withErrors(['otp' => 'Please verify OTP first'])->withInput();
    }

    if (Carbon::parse($otpRecord->expires_at)->isPast()) {
        return back()->withErrors(['otp' => 'OTP expired'])->withInput();
    }

    try {
        // 3) Avatar processing
        $path = null;

        if ($request->hasFile('avatar')) {
            $userName = $validated['username'];
            $image = $request->file('avatar');

            $filename = uniqid() . '.webp';
            $folder = "images/avatars/{$userName}";

            $compressedImage = Image::make($image)
                ->fit(300, 300, function ($constraint) {
                    $constraint->upsize();
                })
                ->encode('webp', 70);

            Storage::disk('public')->put("{$folder}/{$filename}", $compressedImage);

            $path = "{$folder}/{$filename}";
        }

        // 4) Create user
        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $email,
            'password' => bcrypt($validated['password']),
            'avatar' => $path
        ]);

        // 5) Cleanup OTPs for this email (important)
        Otp::where('email', $email)->delete();

        // 6) Welcome mail
        // app(EmailController::class)->sendEmail($email);

        return redirect()->route('login.page')
            ->with('success', 'Registration successful. Please login.');

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
    }
}

    public function loginPage()
    {
        return view('Visitor.login');
    }

    public function loginCheck(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $token = $user->createToken('login_token')->plainTextToken;
            session(['auth_token' => $token]);
            return redirect()->route('dashboard.page');
        }
        return back()->with('error', 'Invalid credentials.');
    }


    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // ✅ Delete only current token (not all tokens)
            if ($request->user() && $request->user()->currentAccessToken()) {
                $request->user()->currentAccessToken()->delete();
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home.page');
    }
}
