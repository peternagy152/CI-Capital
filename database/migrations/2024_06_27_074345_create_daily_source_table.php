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
        Schema::create('daily_source', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daily_id');
            $table->unsignedBigInteger('source_id');
            $table->timestamps();

            $table->foreign('daily_id')->references('id')->on('dailies')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_source');
    }
};
