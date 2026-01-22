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
        Schema::create('budget_premium_equivalent_funding_monthly_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_design_year_id')->constrained()->cascadeOnDelete();
            $table->string('plan_name');
            $table->string('admin_fee_group')->nullable();
            $table->decimal('employee', 10, 2)->nullable();
            $table->decimal('emp_spouse', 10, 2)->nullable();
            $table->decimal('emp_child', 10, 2)->nullable();
            $table->decimal('emp_children', 10, 2)->nullable();
            $table->decimal('family', 10, 2)->nullable();
            $table->date('plan_term_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_premium_equivalent_funding_monthly_rates');
    }
};
