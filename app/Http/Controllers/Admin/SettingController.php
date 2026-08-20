<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllKeyed();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowed = [
            'site_name','site_tagline','site_email','site_phone','site_address',
            'stat_countries','stat_products','stat_years','hero_title','hero_subtitle',
            'facebook_url','instagram_url','linkedin_url','youtube_url',
            'meta_description','meta_keywords',
        ];

        foreach ($allowed as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
