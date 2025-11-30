<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClickCountToAdsTable extends Migration
{
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            if (!Schema::hasColumn('ads', 'click_count')) {
                $table->unsignedBigInteger('click_count')->default(0)->after('placement_target');
            }
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            if (Schema::hasColumn('ads', 'click_count')) {
                $table->dropColumn('click_count');
            }
        });
    }
}