<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{
    /* ── Email Login ── */
    public function showLogin()
    {
        if (session('customer_id')) return redirect()->route('customer.dashboard');
        return view('customer.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !$customer->password || !Hash::check($request->password, $customer->password)) {
            return back()->withInput()->with('error', 'Invalid email or password.');
        }

        if (isset($customer->is_active) && !$customer->is_active) {
            return back()->withInput()->with('error', 'Your account has been disabled. Please contact us.');
        }

        $this->setSession($customer);
        return redirect()->intended(route('customer.dashboard'));
    }

    /* ── Register ── */
    public function showRegister()
    {
        if (session('customer_id')) return redirect()->route('customer.dashboard');
        [$question, $answer] = $this->makeCaptcha();
        session(['captcha_ans' => $answer]);
        return view('customer.register', compact('question'));
    }

    public function register(Request $request)
    {
        // Honeypot: bots fill the hidden field, humans leave it blank
        if ($request->filled('_hp')) {
            return redirect()->route('customer.register')->with('error', 'Registration blocked.');
        }

        // Math CAPTCHA
        $expected = session('captcha_ans');
        if (!$expected || trim($request->input('captcha')) !== (string)$expected) {
            [$question, $answer] = $this->makeCaptcha();
            session(['captcha_ans' => $answer]);
            return back()->withInput()->with('captcha_error', 'Incorrect answer — please try again.')->with('captcha_question', $question);
        }
        session()->forget('captcha_ans');

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:customers,email',
            'phone'    => 'nullable|string|max:20|unique:customers,phone',
            'company'  => 'nullable|string|max:100',
            'country'  => 'required|string|max:100',
            'password' => 'required|min:8|confirmed',
        ]);

        $customer = Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'company'  => $request->company,
            'country'  => $request->country,
            'password' => $request->password,
        ]);

        $this->setSession($customer);
        return redirect()->route('customer.dashboard')->with('success', 'Welcome to Ceylon Aroma!');
    }

    private function makeCaptcha(): array
    {
        $a = rand(2, 12);
        $b = rand(1, 9);
        $type = rand(0, 1);
        if ($type === 0) {
            return ["$a + $b", $a + $b];
        } else {
            $big = max($a, $b); $small = min($a, $b);
            return ["$big − $small", $big - $small];
        }
    }

    /* ── Google OAuth ── */
    public function redirectToGoogle()
    {
        $params = http_build_query([
            'client_id'     => env('GOOGLE_CLIENT_ID'),
            'redirect_uri'  => route('customer.google.callback'),
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'online',
        ]);
        return redirect('https://accounts.google.com/o/oauth2/auth?' . $params);
    }

    public function handleGoogleCallback(Request $request)
    {
        if (!$request->code) {
            return redirect()->route('customer.login')->with('error', 'Google login failed.');
        }

        $tokenResp = Http::post('https://oauth2.googleapis.com/token', [
            'code'          => $request->code,
            'client_id'     => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri'  => route('customer.google.callback'),
            'grant_type'    => 'authorization_code',
        ]);

        $accessToken = $tokenResp->json('access_token');
        if (!$accessToken) {
            return redirect()->route('customer.login')->with('error', 'Google authentication failed.');
        }

        $gUser = Http::withToken($accessToken)
            ->get('https://www.googleapis.com/oauth2/v3/userinfo')
            ->json();

        $customer = Customer::updateOrCreate(
            ['google_id' => $gUser['sub']],
            [
                'name'   => $gUser['name'] ?? $gUser['email'],
                'email'  => $gUser['email'],
                'avatar' => $gUser['picture'] ?? null,
            ]
        );

        // If email exists without google_id, link it
        if (!$customer->wasRecentlyCreated && !$customer->google_id) {
            $customer->update(['google_id' => $gUser['sub'], 'avatar' => $gUser['picture'] ?? null]);
        }

        $this->setSession($customer);
        return redirect()->route('customer.dashboard')->with('success', 'Logged in with Google!');
    }

    /* ── Phone OTP ── */
    public function showPhoneLogin()
    {
        return view('customer.otp-phone');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['phone' => 'required|string|max:20']);

        $phone    = preg_replace('/[^0-9+]/', '', $request->phone);
        $customer = Customer::where('phone', $phone)->first();

        if (!$customer) {
            return back()->with('error', 'No account found with this phone number. Please register first.');
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $customer->update([
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $sent = SmsService::sendOtp($phone, $otp);

        if (!$sent) {
            return back()->with('error', 'Failed to send OTP. Please try again.');
        }

        session(['otp_phone' => $phone]);
        return redirect()->route('customer.otp.verify')->with('success', 'OTP sent to your phone.');
    }

    public function showVerifyOtp()
    {
        if (!session('otp_phone')) return redirect()->route('customer.otp.phone');
        return view('customer.otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $phone    = session('otp_phone');
        $customer = Customer::where('phone', $phone)->first();

        if (!$customer || $customer->otp_code !== $request->otp || now()->gt($customer->otp_expires_at)) {
            return back()->with('error', 'Invalid or expired OTP. Please try again.');
        }

        $customer->update(['otp_code' => null, 'otp_expires_at' => null]);
        session()->forget('otp_phone');

        $this->setSession($customer);
        return redirect()->route('customer.dashboard')->with('success', 'Phone verified. Welcome back!');
    }

    /* ── Logout ── */
    public function logout()
    {
        session()->forget(['customer_id','customer_name','customer_email','customer_avatar']);
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    private function setSession(Customer $customer): void
    {
        session([
            'customer_id'     => $customer->id,
            'customer_name'   => $customer->name,
            'customer_email'  => $customer->email,
            'customer_avatar' => $customer->avatar,
        ]);
    }
}
