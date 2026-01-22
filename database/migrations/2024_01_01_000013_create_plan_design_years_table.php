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
        Schema::create('plan_design_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('intake_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('year');
            $table->string('employer_plan_sponsor_name');
            $table->date('plan_effective_date')->nullable();
            $table->string('current_vendor_name')->nullable();
            $table->boolean('is_new_vendor')->default(false);
            $table->timestamps();

            $table->unique(['intake_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_design_years');
    }
};
