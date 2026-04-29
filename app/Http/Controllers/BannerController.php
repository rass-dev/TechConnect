<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('id', 'DESC')->paginate(10);
        return view('backend.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('backend.banner.create');
    }

    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'title'       => 'required|string|max:255', // title is now required
            'description' => 'nullable|string',
            'photo'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'      => 'required|in:active,inactive',
            'button_url'  => 'nullable|url'
        ]);

        $banner = new Banner();
        $banner->title       = $request->title;
        $banner->description = $request->description;
        $banner->status      = $request->status;

        // Checkboxes (default to 0 if not set)
        $banner->show_title       = $request->has('show_title') ? 1 : 0;
        $banner->show_description = $request->has('show_description') ? 1 : 0;
        $banner->show_button      = $request->has('show_button') ? 1 : 0;

        $banner->button_url = $request->button_url ?? null;

        // Slug generation
        $banner->slug = Str::slug($request->title);

        // Upload photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/banners'), $filename);
            $banner->photo = 'uploads/banners/' . $filename;
        }

        $banner->save();

        return redirect()->route('banner.index')->with('success', 'Banner added successfully!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('backend.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255', // title is now required
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'      => 'required|in:active,inactive',
            'button_url'  => 'nullable|url'
        ]);

        $banner->title       = $request->title;
        $banner->description = $request->description;
        $banner->status      = $request->status;

        $banner->show_title       = $request->has('show_title') ? 1 : 0;
        $banner->show_description = $request->has('show_description') ? 1 : 0;
        $banner->show_button      = $request->has('show_button') ? 1 : 0;

        $banner->button_url = $request->button_url ?? null;

        $banner->slug = Str::slug($request->title);

        // Update photo
        if ($request->hasFile('photo')) {
            if ($banner->photo && File::exists(public_path($banner->photo))) {
                File::delete(public_path($banner->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/banners'), $filename);
            $banner->photo = 'uploads/banners/' . $filename;
        }

        $banner->save();

        return redirect()->route('banner.index')->with('success', 'Banner successfully updated!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->photo && File::exists(public_path($banner->photo))) {
            File::delete(public_path($banner->photo));
        }

        $banner->delete();

        return redirect()->route('banner.index')->with('success', 'Banner successfully deleted!');
    }
}
