<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Internal label for admin');
            $table->string('position')->index()->comment('Ad slot identifier, e.g. search-ad-1');
            $table->string('image_path')->nullable()->comment('Path to image (e.g. storage/ads/xxx.png or images/ads/xxx.png)');
            $table->string('url')->nullable()->comment('Target URL when ad clicked');
            $table->boolean('is_active')->default(true)->comment('Active flag');
            $table->timestamp('starts_at')->nullable()->comment('Optional start datetime');
            $table->timestamp('ends_at')->nullable()->comment('Optional end datetime');
            $table->integer('priority')->default(10)->comment('Lower = higher priority');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ads');
    }
};