<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

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

    public function imageUrl()
    {
        if (!$this->image_path) {
            return null;
        }
        if (preg_match('#^https?://#i', $this->image_path)) {
            return $this->image_path;
        }
        if (str_starts_with($this->image_path, 'storage/')) {
            return asset($this->image_path);
        }
        return asset('images/' . ltrim($this->image_path, '/'));
    }
}