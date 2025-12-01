<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImpressionCountToAdsTable extends Migration
{
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            if (!Schema::hasColumn('ads', 'impression_count')) {
                $table->unsignedBigInteger('impression_count')->default(0)->after('click_count');
            }
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            if (Schema::hasColumn('ads', 'impression_count')) {
                $table->dropColumn('impression_count');
            }
        });
    }
}