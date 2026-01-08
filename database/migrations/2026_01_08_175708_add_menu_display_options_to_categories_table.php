<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Rename show_in_header menjadi show_in_dropdown (optional)
            // Atau tambah kolom baru
            $table->boolean('show_in_main_menu')->default(false)->after('show_in_header');
            $table->boolean('show_in_dropdown')->default(false)->after('show_in_main_menu');
            
            // Jika mau rename kolom lama: 
            // $table->renameColumn('show_in_header', 'show_in_dropdown');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['show_in_main_menu', 'show_in_dropdown']);
        });
    }
};