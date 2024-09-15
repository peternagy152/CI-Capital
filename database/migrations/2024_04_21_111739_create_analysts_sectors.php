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
        Schema::create('analysts_sectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('analyst_id');
            $table->unsignedBigInteger('sector_id');
            $table->foreign('analyst_id')
                ->references('id')
                ->on('analysts')->onDelete('cascade');

            $table->foreign('sector_id')
                ->references('id')
                ->on('sectors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysts_sectors');
    }
};
