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
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            //Section About
            $table->json('header');
            $table->json('primary_header');
            $table->json('contact_info');
            $table->json('faqs_header');
            $table->json("faqs") ; //Repeater
            $table->json('theme_settings_1')->nullable();
            $table->json('theme_settings_2')->nullable();
            $table->json('theme_settings_3')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
