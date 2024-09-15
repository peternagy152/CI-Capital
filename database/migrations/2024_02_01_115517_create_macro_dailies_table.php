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
        Schema::create('macro_dailies', function (Blueprint $table) {
          $table->id();
            $table->string("title") ;
            $table->longText("desc");
            $table->unsignedBigInteger("source_id") ;
            $table->foreign('source_id')
            ->references('id')
            ->on('sources')
            ->onDelete('cascade');

            $table->unsignedBigInteger("macro_id") ;
            $table->foreign('macro_id')
            ->references('id')
            ->on('macros')
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macro_dailies');
    }
};
