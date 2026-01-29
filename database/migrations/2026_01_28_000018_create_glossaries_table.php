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
        Schema::create('glossaries', function (Blueprint $table) {
            $table->id();
            $table->integer('order');
            $table->string('type')->nullable();
            $table->string('rates')->nullable();
            $table->text('definition')->nullable();
            $table->text('other_industry_terms_used')->nullable();
            $table->timestamps();

            $table->index('order');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glossaries');
    }
};
