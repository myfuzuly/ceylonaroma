<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.form', ['slider' => new Slider]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'nullable|string|max:200',
            'subtitle'   => 'nullable|string|max:300',
            'image'      => 'required|image|max:4096',
            'link'       => 'nullable|url|max:500',
            'sort_order' => 'integer|min:0',
            'status'     => 'boolean',
        ]);

        $data['status']     = $request->boolean('status', true);
        $data['sort_order'] = $request->integer('sort_order', 0);
        $data['image']      = $request->file('image')->store('slider', 'public');

        Slider::create($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slide added.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title'      => 'nullable|string|max:200',
            'subtitle'   => 'nullable|string|max:300',
            'image'      => 'nullable|image|max:4096',
            'link'       => 'nullable|url|max:500',
            'sort_order' => 'integer|min:0',
            'status'     => 'boolean',
        ]);

        $data['status']     = $request->boolean('status', true);
        $data['sort_order'] = $request->integer('sort_order', 0);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slider->image);
            $data['image'] = $request->file('image')->store('slider', 'public');
        } else {
            unset($data['image']);
        }

        $slider->update($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slide updated.');
    }

    public function destroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->image);
        $slider->delete();
        return back()->with('success', 'Slide deleted.');
    }

    // AJAX — save reordered sort_order values
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);
        foreach ($request->order as $position => $id) {
            Slider::where('id', $id)->update(['sort_order' => $position]);
        }
        return response()->json(['ok' => true]);
    }
}
