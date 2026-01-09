<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema:: create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title_id'); // Title in Indonesian
            $table->string('title_en'); // Title in English
            $table->string('slug')->unique(); // URL slug
            $table->longText('content_id')->nullable(); // Content in Indonesian
            $table->longText('content_en')->nullable(); // Content in English
            $table->string('meta_description_id')->nullable();
            $table->string('meta_description_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};