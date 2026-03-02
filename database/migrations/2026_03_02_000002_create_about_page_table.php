<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_page', function (Blueprint $table) {
            $table->id();
            $table->string('hero_image')->nullable();
            $table->string('hero_title')->default('About Us');
            $table->text('hero_subtitle')->nullable();
            $table->string('story_image')->nullable();
            $table->string('story_eyebrow')->nullable();
            $table->string('story_heading')->nullable();
            $table->longText('story_content')->nullable();
            $table->text('story_quote')->nullable();
            $table->string('stat_1_number')->nullable();
            $table->string('stat_1_label')->nullable();
            $table->string('stat_2_number')->nullable();
            $table->string('stat_2_label')->nullable();
            $table->string('stat_3_number')->nullable();
            $table->string('stat_3_label')->nullable();
            $table->string('stat_4_number')->nullable();
            $table->string('stat_4_label')->nullable();
            $table->string('values_eyebrow')->nullable();
            $table->string('values_heading')->nullable();
            $table->text('values_intro')->nullable();
            $table->string('value_1_icon')->nullable();
            $table->string('value_1_title')->nullable();
            $table->text('value_1_text')->nullable();
            $table->string('value_2_icon')->nullable();
            $table->string('value_2_title')->nullable();
            $table->text('value_2_text')->nullable();
            $table->string('value_3_icon')->nullable();
            $table->string('value_3_title')->nullable();
            $table->text('value_3_text')->nullable();
            $table->string('team_eyebrow')->nullable();
            $table->string('team_heading')->nullable();
            $table->string('team_1_image')->nullable();
            $table->string('team_1_name')->nullable();
            $table->string('team_1_role')->nullable();
            $table->string('team_1_region')->nullable();
            $table->string('team_2_image')->nullable();
            $table->string('team_2_name')->nullable();
            $table->string('team_2_role')->nullable();
            $table->string('team_2_region')->nullable();
            $table->string('cta_heading')->nullable();
            $table->text('cta_text')->nullable();
            $table->string('cta_btn_1_text')->nullable();
            $table->string('cta_btn_1_url')->nullable();
            $table->string('cta_btn_2_text')->nullable();
            $table->string('cta_btn_2_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_page');
    }
};
