<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $fillable = ['filename', 'original_name', 'mime_type', 'path', 'size', 'article_id'];
    
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
