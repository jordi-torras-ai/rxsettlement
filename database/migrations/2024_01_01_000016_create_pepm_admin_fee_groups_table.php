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
        Schema::create('pepm_admin_fee_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_design_year_id')->constrained()->cascadeOnDelete();
            $table->string('admin_fee_group')->nullable();
            $table->decimal('aso', 10, 2)->nullable();
            $table->decimal('hsa_hra_admin', 10, 2)->nullable();
            $table->decimal('disease_management', 10, 2)->nullable();
            $table->decimal('tele_health', 10, 2)->nullable();
            $table->decimal('pharmacy_rebate_credit', 10, 2)->nullable();
            $table->decimal('pharmacy_carveout_pbm_fee', 10, 2)->nullable();
            $table->decimal('wellness_fee_credit', 10, 2)->nullable();
            $table->decimal('misc_broker_fees', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pepm_admin_fee_groups');
    }
};
