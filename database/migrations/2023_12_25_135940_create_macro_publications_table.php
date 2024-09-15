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
        Schema::create('macro_publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("macro_id") ;
            $table->string("name") ;
            $table->longText("desc") ;
            $table->string("read_in") ;
            $table->string("report");
            $table->timestamps();

            $table->foreign('macro_id')
              ->references('id')
              ->on('macros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macro_publications');
    }
};
