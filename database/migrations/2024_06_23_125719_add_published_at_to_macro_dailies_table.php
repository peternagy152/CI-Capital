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
        Schema::table('macro_dailies', function (Blueprint $table) {
            // Add the new column
            $table->date('published_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('macro_dailies', function (Blueprint $table) {
            // Drop the new column
            $table->dropColumn('published_at');
        });
    }
};
