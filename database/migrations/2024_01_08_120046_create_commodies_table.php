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
        Schema::create('commodies', function (Blueprint $table) {
            $table->id();
            $table->string("name") ;
            $table->string("category");
            $table->string("unit");
            $table->string("spot") ;
            $table->string("wow") ;
            $table->string("mom");
            $table->string("ytd");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodies');
    }
};