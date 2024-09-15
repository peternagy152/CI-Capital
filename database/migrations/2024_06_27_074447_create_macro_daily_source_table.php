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
        Schema::create('macro_daily_source', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('macro_daily_id');
            $table->unsignedBigInteger('source_id');
            $table->timestamps();

            $table->foreign('macro_daily_id')->references('id')->on('macro_dailies')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macro_daily_source');
    }
};
