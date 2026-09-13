<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Mail\InquiryAdminMail;
use App\Mail\InquiryConfirmMail;
use App\Models\Inquiry;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function show()
    {
        $categories = Category::whereNull('parent_id')->where('status', true)->orderBy('sort_order')->get();
        return view('pages.contact', compact('categories'));
    }

    public function store(StoreInquiryRequest $request)
    {
        $inquiry = Inquiry::create([
            ...$request->safe()->except(['_pot', 'recaptcha_token']),
            'products' => $request->products ?? [],
            'status'   => 'new',
        ]);

        try {
            $adminEmail = config('mail.admin_address', env('ADMIN_EMAIL', 'info@ceylonaroma.com'));

            Mail::to($adminEmail)
                ->send(new InquiryAdminMail($inquiry));

            Mail::to($inquiry->email, $inquiry->name)
                ->bcc($adminEmail)
                ->send(new InquiryConfirmMail($inquiry));

        } catch (\Exception $e) {
            \Log::error('Inquiry mail failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you! Your inquiry has been received. Our team will respond within 24 hours.');
    }
}
