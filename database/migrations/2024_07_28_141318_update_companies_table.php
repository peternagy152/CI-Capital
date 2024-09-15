<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            // Change existing columns from integer to string
            $table->string('market_cap')->nullable()->change();
            $table->string('market_cap_local')->nullable()->change();
            $table->string('adtv')->nullable()->change();

            // Add new column
            $table->string('conversion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            // Revert columns back to integer
            $table->integer('market_cap')->nullable()->change();
            $table->integer('market_cap_local')->nullable()->change();
            $table->integer('adtv')->nullable()->change();

            // Drop the new column
            $table->dropColumn('conversion');
        });
    }
};
