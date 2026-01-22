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
        Schema::table('employers', function (Blueprint $table) {
            $table->string('fein')->nullable()->after('operating_states');
            $table->string('naics_sector')->nullable()->after('fein');
            $table->text('other_comments')->nullable()->after('naics_sector');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn(['fein', 'naics_sector', 'other_comments']);
        });
    }
};
