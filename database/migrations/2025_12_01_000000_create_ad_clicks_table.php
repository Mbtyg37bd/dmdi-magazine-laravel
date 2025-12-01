<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdClicksTable extends Migration
{
    public function up()
    {
        Schema::create('ad_clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id')->index();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamps();

            // optional foreign key if you want integrity (uncomment if Ads table exists and you want FK)
            // $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ad_clicks');
    }
}