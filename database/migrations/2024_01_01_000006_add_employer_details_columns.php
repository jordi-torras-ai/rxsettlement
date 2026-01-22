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
        Schema::table('employers', function (Blueprint $table) {
            $table->string('legal_name')->nullable()->after('id');
            $table->string('dba')->nullable()->after('legal_name');
            $table->string('address_line_1')->nullable()->after('dba');
            $table->string('address_line_2')->nullable()->after('address_line_1');
            $table->string('city')->nullable()->after('address_line_2');
            $table->string('state')->nullable()->after('city');
            $table->string('zip_code')->nullable()->after('state');
        });

        DB::table('employers')->whereNull('legal_name')->update(['legal_name' => DB::raw('name')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn([
                'legal_name',
                'dba',
                'address_line_1',
                'address_line_2',
                'city',
                'state',
                'zip_code',
            ]);
        });
    }
};
