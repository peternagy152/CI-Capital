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
        Schema::create('macro_publications_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('macro_publication_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('macro_publication_id')
                ->references('id')
                ->on('macro_publications')->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macro_publications_users');
    }
};
