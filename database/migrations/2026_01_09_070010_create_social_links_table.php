<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema:: create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // x, tiktok, youtube, facebook, instagram
            $table->string('name'); // Display name
            $table->string('url')->nullable(); // Profile URL
            $table->string('icon'); // SVG filename (x.svg, tiktok.svg, etc)
            $table->boolean('is_active')->default(false);
            $table->integer('order')->default(0); // Display order
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};