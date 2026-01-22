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
        Schema::create('vendor_coverages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('intake_id')->constrained()->cascadeOnDelete();
            $table->string('vendor_name');
            $table->string('vendor_year')->nullable();
            $table->string('vendor_contact_name')->nullable();
            $table->string('vendor_contact_email')->nullable();
            $table->string('insurance_type')->nullable();
            $table->date('plan_year_start_date')->nullable();
            $table->date('plan_year_end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_coverages');
    }
};
