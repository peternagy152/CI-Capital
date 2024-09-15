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
        Schema::create('companies_analysts', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->unsignedBigInteger("company_id");
            $table->unsignedBigInteger("analyst_id") ;

             $table->foreign('company_id')
              ->references('id')
              ->on('companies')->onDelete('cascade');

            $table->foreign('analyst_id')
            ->references('id')
            ->on('analysts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('companies_analysts');
    }
};
