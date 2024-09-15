<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            //Hero Section
            $table->json('nav'); // Repeater
            $table->json('hero_section') ;

            //Section About
            $table->json('section_about');
            $table->json('about_repeater');
            // How to navigate section
            $table->json('navigate_section');
            $table->json('navigate_steps'); // Repeater

            $table->json('request_form_header');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
