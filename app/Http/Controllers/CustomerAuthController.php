<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Models\CartItem;
use App\Models\Customer;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
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
        $state = Str::random(40);
        session(['oauth_state' => $state]);
        $params = http_build_query([
            'client_id'     => env('GOOGLE_CLIENT_ID'),
            'redirect_uri'  => route('customer.google.callback'),
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'online',
            'state'         => $state,
        ]);
        return redirect('https://accounts.google.com/o/oauth2/auth?' . $params);
    }

    public function handleGoogleCallback(Request $request)
    {
        // Validate state to prevent OAuth CSRF
        $expectedState = session('oauth_state');
        session()->forget('oauth_state');
        if (!$expectedState || !$request->state || !hash_equals($expectedState, $request->state)) {
            return redirect()->route('customer.login')->with('error', 'Invalid OAuth state. Please try again.');
        }

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

    /* ── Forgot Password ── */
    public function showForgotPassword()
    {
        if (session('customer_id')) return redirect()->route('customer.dashboard');
        return view('customer.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $customer = Customer::where('email', $request->email)->first();

        if ($customer) {
            $token = Str::random(64);
            DB::table('customer_password_resets')->updateOrInsert(
                ['email' => $customer->email],
                ['token' => Hash::make($token), 'created_at' => now()]
            );
            $url = route('customer.reset-password') . '?token=' . $token . '&email=' . urlencode($customer->email);
            Mail::to($customer->email)->send(new PasswordResetMail($customer->name, $url));
        }

        return back()->with('success', 'If that email is registered, a reset link has been sent. Check your inbox (and spam folder).');
    }

    public function showResetPassword(Request $request)
    {
        $token = $request->query('token', '');
        $email = $request->query('email', '');
        if (!$token || !$email) return redirect()->route('customer.forgot-password')->with('error', 'Invalid reset link.');
        return view('customer.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $record = DB::table('customer_password_resets')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->with('error', 'Invalid or expired reset link. Please request a new one.');
        }

        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('customer_password_resets')->where('email', $request->email)->delete();
            return back()->with('error', 'This reset link has expired. Please request a new one.');
        }

        $customer = Customer::where('email', $request->email)->first();
        if (!$customer) return back()->with('error', 'Account not found.');

        $customer->update(['password' => Hash::make($request->password)]);
        DB::table('customer_password_resets')->where('email', $request->email)->delete();

        return redirect()->route('customer.login')->with('success', 'Password updated successfully. Please sign in.');
    }

    /* ── Logout ── */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    private function setSession(Customer $customer): void
    {
        session()->regenerate();
        session([
            'customer_id'     => $customer->id,
            'customer_name'   => $customer->name,
            'customer_email'  => $customer->email,
            'customer_avatar' => $customer->avatar,
        ]);

        // Merge any session cart into DB, then refresh from DB so nothing is lost
        $sessionCart = session('cart', []);
        if (!empty($sessionCart)) {
            foreach ($sessionCart as $slug => $item) {
                CartItem::updateOrCreate(
                    ['customer_id' => $customer->id, 'product_id' => $item['id']],
                    [
                        'product_name'     => $item['name'],
                        'product_slug'     => $item['slug'],
                        'product_image'    => $item['image'] ?? null,
                        'product_category' => $item['category'] ?? null,
                        'qty'              => $item['qty'],
                    ]
                );
            }
        }

        // Pull full DB cart into session
        $dbItems = CartItem::where('customer_id', $customer->id)->get();
        $merged = [];
        foreach ($dbItems as $row) {
            $merged[$row->product_slug] = [
                'id'       => $row->product_id,
                'name'     => $row->product_name,
                'slug'     => $row->product_slug,
                'image'    => $row->product_image,
                'category' => $row->product_category,
                'qty'      => $row->qty,
            ];
        }
        if (!empty($merged)) {
            session(['cart' => $merged]);
        }
    }
}
