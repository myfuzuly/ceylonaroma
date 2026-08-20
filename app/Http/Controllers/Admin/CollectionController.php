<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::orderBy('sort_order')->paginate(15);
        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.collections.form', ['collection' => new Collection]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'tag'         => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'sort_order'  => 'integer',
            'status'      => 'boolean',
        ]);
        $data['slug']   = Str::slug($data['name']);
        $data['status'] = $request->boolean('status', true);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('collections','public');
        }
        Collection::create($data);
        return redirect()->route('admin.collections.index')->with('success','Collection created.');
    }

    public function edit(Collection $collection)
    {
        return view('admin.collections.form', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'tag'         => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'sort_order'  => 'integer',
            'status'      => 'boolean',
        ]);
        $data['status'] = $request->boolean('status', true);
        if ($request->boolean('remove_image')) {
            $data['image'] = null;
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('collections','public');
        }
        $collection->update($data);
        return redirect()->route('admin.collections.index')->with('success','Collection updated.');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
        return back()->with('success','Collection deleted.');
    }
}
