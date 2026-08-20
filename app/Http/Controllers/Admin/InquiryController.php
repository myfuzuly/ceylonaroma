<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::query();
        if ($request->status) $query->where('status', $request->status);
        if ($request->search) $query->where(function($q) use ($request) {
            $q->where('name','like','%'.$request->search.'%')
              ->orWhere('email','like','%'.$request->search.'%')
              ->orWhere('company','like','%'.$request->search.'%');
        });
        $inquiries = $query->latest()->paginate(15)->withQueryString();
        $newCount  = Inquiry::where('status','new')->count();
        return view('admin.inquiries.index', compact('inquiries','newCount'));
    }

    public function show(Inquiry $inquiry)
    {
        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'read']);
        }
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $request->validate(['status' => 'required|in:new,read,replied,closed']);
        $inquiry->update(['status' => $request->status]);
        return back()->with('success', 'Status updated.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success','Inquiry deleted.');
    }
}
