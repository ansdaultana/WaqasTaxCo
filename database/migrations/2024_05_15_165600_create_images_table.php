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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ntn_id')->nullable();
            $table->unsignedBigInteger('sole_proprietorship_id')->nullable();
            $table->foreign('sole_proprietorship_id')->references('id')->on('sole_proprietorships')->onDelete('cascade');
            $table->unsignedBigInteger('aop_id')->nullable();
            $table->foreign('aop_id')->references('id')->on('aops')->onDelete('cascade');
            $table->string('path');
            $table->string('name')->nullable();
            $table->string('what_for')->nullable();
            $table->foreign('ntn_id')->references('id')->on('ntns')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
