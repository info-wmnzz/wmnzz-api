<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $path,
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Banner $banner)
    {
        return view('admin.banner.form', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = ['title' => $request->title];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banner.index')->with('success', 'Banner deleted successfully!');
    }
}
