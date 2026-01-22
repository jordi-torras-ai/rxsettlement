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
            $table->string('authorized_contact_name')->nullable()->after('zip_code');
            $table->string('authorized_contact_email')->nullable()->after('authorized_contact_name');
            $table->string('authorized_contact_phone')->nullable()->after('authorized_contact_email');
            $table->string('billing_contact_name')->nullable()->after('authorized_contact_phone');
            $table->string('billing_contact_email')->nullable()->after('billing_contact_name');
            $table->string('billing_contact_phone')->nullable()->after('billing_contact_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn([
                'authorized_contact_name',
                'authorized_contact_email',
                'authorized_contact_phone',
                'billing_contact_name',
                'billing_contact_email',
                'billing_contact_phone',
            ]);
        });
    }
};
