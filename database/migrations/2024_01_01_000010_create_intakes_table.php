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
        Schema::create('intakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('primary_name')->nullable();
            $table->string('primary_title')->nullable();
            $table->string('primary_email')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('escalation_name')->nullable();
            $table->string('escalation_title')->nullable();
            $table->string('escalation_email')->nullable();
            $table->string('escalation_phone')->nullable();
            $table->string('other_name')->nullable();
            $table->string('other_title')->nullable();
            $table->string('other_email')->nullable();
            $table->string('other_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intakes');
    }
};
