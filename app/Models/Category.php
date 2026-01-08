<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
    'name_id', 
    'name_en', 
    'slug', 
    'description_id', 
    'description_en', 
    'is_active',
    'show_in_header',      // Keep untuk backward compatibility
    'show_in_main_menu',   // NEW
    'show_in_dropdown'     // NEW
];
    
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    
    public function getNameAttribute()
    {
        return app()->getLocale() === 'en' ? $this->name_en : $this->name_id;
    }
}