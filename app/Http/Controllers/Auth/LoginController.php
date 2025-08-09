<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a successful authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // 1. Generate OTP
        $otp = rand(100000, 999999);

        // 2. Send OTP to user's email
        Mail::to($user->email)->send(new SendOtpMail($otp));

        // 3. Store OTP, user ID, and expiry in session
        $request->session()->put('otp', $otp);
        $request->session()->put('user_id', $user->id);
        $request->session()->put('otp_expires_at', Carbon::now()->addMinutes(5));

        // 4. Log the user out to force OTP verification
        Auth::logout();

        // 5. Redirect to the OTP verification page
        return redirect()->route('otp.show')->with('status', 'An OTP has been sent to your email address.');
    }

    /**
     * Show the OTP verification form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOtpForm()
    {
        // Prevent access if session data is missing
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp-verify');
    }

    /**
     * Verify the OTP and log the user in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        // Check if session data exists
        if (!session()->has('user_id') || !session()->has('otp')) {
            return redirect()->route('login')->withErrors(['email' => 'Your session has expired. Please login again.']);
        }

        // Check if OTP has expired
        if (Carbon::now()->gt(session('otp_expires_at'))) {
            $request->session()->forget(['otp', 'user_id', 'otp_expires_at']);
            return redirect()->route('login')->withErrors(['email' => 'OTP has expired. Please login again.']);
        }

        // Check if OTP is correct
        if ($request->otp == session('otp')) {
            // Log the user in
            Auth::loginUsingId(session('user_id'));

            // Clear session data
            $request->session()->forget(['otp', 'user_id', 'otp_expires_at']);

            // Redirect to the intended page or dashboard
            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors(['otp' => 'The provided OTP is incorrect.']);
    }
}