<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('cta_btn_2_url');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('gallery');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
        });

        Schema::table('highlights', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('sort_order');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('website');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
        });
    }

    public function down(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });
        Schema::table('highlights', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });
    }
};
