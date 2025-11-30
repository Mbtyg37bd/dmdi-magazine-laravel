<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // optional: batasi hanya untuk user admin
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->is_admin) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $ads = Ad::orderBy('priority')->paginate(20);
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        // kirim daftar artikel supaya placement_target menjadi dropdown di form
        $articles = Article::select('id','slug','title')->orderBy('created_at','desc')->get();
        return view('admin.ads.create', compact('articles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:191',
            'position' => 'required|string|max:191',
            'placement' => 'required|in:search,dashboard,article',
            'placement_target' => 'nullable|string|max:191',
            'url' => 'nullable|url|max:191',
            'is_active' => 'sometimes|boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'priority' => 'nullable|integer',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('ads', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $data['is_active'] = $request->has('is_active') ? (bool)$request->input('is_active') : true;
        $data['priority'] = $data['priority'] ?? 10;
        $data['click_count'] = $data['click_count'] ?? 0;

        Ad::create($data);

        return redirect()->route('ads.index')->with('success', 'Ad created.');
    }

    public function show(Ad $ad)
    {
        return view('admin.ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        $articles = Article::select('id','slug','title')->orderBy('created_at','desc')->get();
        return view('admin.ads.edit', compact('ad','articles'));
    }

    public function update(Request $request, Ad $ad)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:191',
            'position' => 'required|string|max:191',
            'placement' => 'required|in:search,dashboard,article',
            'placement_target' => 'nullable|string|max:191',
            'url' => 'nullable|url|max:191',
            'is_active' => 'sometimes|boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'priority' => 'nullable|integer',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('ads', 'public');
            if ($ad->image_path && str_starts_with($ad->image_path, 'storage/')) {
                $old = str_replace('storage/', '', $ad->image_path);
                Storage::disk('public')->delete($old);
            }
            $data['image_path'] = 'storage/' . $path;
        }

        $data['is_active'] = $request->has('is_active') ? (bool)$request->input('is_active') : $ad->is_active;
        $data['priority'] = $data['priority'] ?? $ad->priority;

        $ad->update($data);

        return redirect()->route('ads.index')->with('success', 'Ad updated.');
    }

    public function destroy(Ad $ad)
    {
        if ($ad->image_path && str_starts_with($ad->image_path, 'storage/')) {
            $old = str_replace('storage/', '', $ad->image_path);
            Storage::disk('public')->delete($old);
        }

        $ad->delete();
        return redirect()->route('ads.index')->with('success', 'Ad removed.');
    }
}