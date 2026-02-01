<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    public function registerPage()
    {
        return view('Visitor.register');
    }


    public function registerCheck(Request $request)
    {
        $otp = $request->otp;
        $email = $request->email;

        if ($email != session('email')) {
            return redirect()->back()->withErrors(['email' => 'Email does not match.'])->withInput();
        }

        if ($otp != session('otp')) {
            return redirect()->back()->withErrors(['otp' => 'Invalid OTP.'])->withInput();
        }

        session()->forget(['otp', 'email']);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'avatar' => 'required|image|mimes:png,jpg,jpeg|max:10240'
        ]);

        try {
            $path = null;

            if ($request->hasFile('avatar')) {

                $userName = $validated['username']; // ✅ from form
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

            User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'avatar' => $path
            ]);

            app(EmailController::class)->sendEmail($validated['email']);

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
