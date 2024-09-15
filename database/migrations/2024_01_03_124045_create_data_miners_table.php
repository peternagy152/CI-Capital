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
        Schema::create('data_miners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("company_id") ;
            $table->foreign('company_id')
            ->references('id')
            ->on('companies')
            ->onDelete('cascade');

            // Data Miner
            $table->string("parameter") ;
            $table->string("py");
            $table->string("cy");
            $table->string("cy_1");
            $table->string("cy_2");
            $table->string("type");
            $table->string("cat");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_miners');
    }
};
