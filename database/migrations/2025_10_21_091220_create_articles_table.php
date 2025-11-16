<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            
            // Bahasa Indonesia
            $table->string('title_id');
            $table->text('excerpt_id');
            $table->longText('content_id');
            
            // Bahasa Inggris  
            $table->string('title_en');
            $table->text('excerpt_en');
            $table->longText('content_en');
            
            $table->string('featured_image')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('author');
            $table->integer('view_count')->default(0);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('qr_code_path')->nullable();
            $table->timestamps();
            
            // Index untuk performa
            $table->index('is_published');
            $table->index('is_featured');
            $table->index('category_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};