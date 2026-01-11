<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title_id',
        'title_en',
        'slug',
        'image',           // ← TAMBAHKAN INI (CRITICAL!)
        'content_id',
        'content_en',
        'meta_description_id',
        'meta_description_en',
        'is_active',
        'show_in_footer',
        'footer_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_footer' => 'boolean',
    ];

    /**
     * Scope untuk hanya pages yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk pages yang muncul di footer
     */
    public function scopeInFooter($query)
    {
        return $query->where('show_in_footer', true);
    }

    /**
     * Get title berdasarkan locale
     */
    public function getTitle($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $locale === 'en' ? $this->title_en : $this->title_id;
    }

    /**
     * Get content berdasarkan locale
     */
    public function getContent($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $locale === 'en' ? $this->content_en : $this->content_id;
    }

    /**
     * Get meta description berdasarkan locale
     */
    public function getMetaDescription($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $locale === 'en' ? $this->meta_description_en : $this->meta_description_id;
    }

    /**
     * Get image URL - TAMBAHKAN METHOD INI (CRITICAL!)
     */
    public function getImageUrl()
    {
        if ($this->image) {
            return asset('storage/pages/' . $this->image);
        }
        return null;
    }

    /**
     * Auto-generate slug from title_en
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title_en);
            }
        });
    }
}