<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            // Drop the foreign key and the column
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');

            // Add the new column
            $table->date('published_at')->nullable();
        });

    }

    public function down(): void
    {

    }

};
