<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function __construct()
    {
        // pastikan controller mewarisi Controller agar $this->middleware() tersedia
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
        return view('admin.ads.create');
    }

    public function store(Request $request)
    {
// di method store() dan update() ganti $data = $request->validate([...]) ke:

$data = $request->validate([
    'name' => 'nullable|string|max:191',
    'position' => 'required|string|max:191',
    'placement' => 'required|in:search,dashboard,article',
    'placement_target' => 'nullable|string|max:191', // slug atau id tergantung implementasi
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

        Ad::create($data);

        return redirect()->route('ads.index')->with('success', 'Ad created.');
    }

    public function show(Ad $ad)
    {
        return view('admin.ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:191',
            'position' => 'required|string|max:191',
            'url' => 'nullable|url|max:191',
            'is_active' => 'sometimes|boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'priority' => 'nullable|integer',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('ads', 'public');
            // optional: delete previous file
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
        // optional: delete file
        if ($ad->image_path && str_starts_with($ad->image_path, 'storage/')) {
            $old = str_replace('storage/', '', $ad->image_path);
            Storage::disk('public')->delete($old);
        }

        $ad->delete();
        return redirect()->route('ads.index')->with('success', 'Ad removed.');
    }
}