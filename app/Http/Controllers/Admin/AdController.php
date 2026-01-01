<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

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

    /**
     * Prepare $articles as collection of objects with id, slug and title.
     * This maps whichever title column exists in your articles table (title_id/title_en/etc).
     */
    protected function getArticlesForSelect()
    {
        $columns = Schema::getColumnListing('articles');
        $candidates = ['title', 'title_id', 'title_en', 'judul', 'name', 'headline'];

        $found = null;
        foreach ($candidates as $c) {
            if (in_array($c, $columns)) {
                $found = $c;
                break;
            }
        }

        if ($found) {
            $raw = Article::orderBy('created_at', 'desc')->get(['id', 'slug', $found]);
            $articles = $raw->map(function ($a) use ($found) {
                return (object)[
                    'id' => $a->id,
                    'slug' => $a->slug,
                    'title' => $a->{$found},
                ];
            });
        } else {
            $raw = Article::orderBy('created_at', 'desc')->get(['id', 'slug']);
            $articles = $raw->map(function ($a) {
                return (object)[
                    'id' => $a->id,
                    'slug' => $a->slug,
                    'title' => $a->slug,
                ];
            });
        }

        return $articles;
    }

    public function create()
    {
        $articles = $this->getArticlesForSelect();
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
        $data['impression_count'] = $data['impression_count'] ?? 0;

        Ad::create($data);

        return redirect()->route('ads.index')->with('success', 'Ad created.');
    }

    public function show(Ad $ad)
    {
        return view('admin.ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        $articles = $this->getArticlesForSelect();
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

    /**
     * Return JSON stats for admin charts.
     * optional query params: start (Y-m-d), end (Y-m-d), ad_id
     */
    public function stats(Request $request)
    {
        $end = $request->query('end') ? Carbon::parse($request->query('end'))->endOfDay() : Carbon::now()->endOfDay();
        $start = $request->query('start') ? Carbon::parse($request->query('start'))->startOfDay() : (clone $end)->subDays(29)->startOfDay();

        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end->copy()->addDay());
        $labels = [];
        foreach ($period as $dt) {
            $labels[] = $dt->format('Y-m-d');
        }

        $clicksQuery = \App\Models\AdClick::query()
            ->whereBetween('created_at', [$start, $end]);

        if ($request->has('ad_id')) {
            $clicksQuery->where('ad_id', (int)$request->query('ad_id'));
        }

        $rows = $clicksQuery
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('total', 'day')
            ->toArray();

        $data = [];
        foreach ($labels as $lab) {
            $data[] = isset($rows[$lab]) ? (int)$rows[$lab] : 0;
        }

        $today = \App\Models\AdClick::whereDate('created_at', Carbon::today())->count();
        $yesterday = \App\Models\AdClick::whereDate('created_at', Carbon::yesterday())->count();
        $last7 = \App\Models\AdClick::whereBetween('created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])->count();
        $thisMonth = \App\Models\AdClick::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'summary' => [
                'today' => $today,
                'yesterday' => $yesterday,
                'last7' => $last7,
                'thisMonth' => $thisMonth,
            ],
        ]);
    }
}