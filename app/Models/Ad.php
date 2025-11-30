<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Ad extends Model
{
    protected $fillable = [
        'name',
        'position',
        'image_path',
        'url',
        'is_active',
        'starts_at',
        'ends_at',
        'priority',
        'placement',
        'placement_target',
        'click_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'click_count' => 'integer',
    ];

    /**
     * Scope: only currently active ads (by is_active and schedule)
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            });
    }

    /**
     * Return a full URL for the ad image.
     * Handles:
     * - absolute URLs (http/https) -> returned as-is
     * - paths already starting with 'storage/' or 'images/' or leading '/' -> asset(ltrim(path))
     * - other relative paths (e.g. 'ads/xxx.png') -> assume stored on storage disk -> asset('storage/' . path)
     */
    public function imageUrl()
    {
        if (!$this->image_path) {
            return null;
        }

        $path = trim($this->image_path);

        // absolute URL
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        // already public path (storage/..., images/..., or starting with /)
        if (Str::startsWith($path, ['storage/', 'images/', '/'])) {
            return asset(ltrim($path, '/'));
        }

        // otherwise assume it is a storage disk path like "ads/filename.png"
        return asset('storage/' . ltrim($path, '/'));
    }
}