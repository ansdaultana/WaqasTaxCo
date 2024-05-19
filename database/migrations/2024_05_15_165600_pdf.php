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
        //
        Schema::create('pdfs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sole_proprietorship_id')->nullable();
            $table->foreign('sole_proprietorship_id')->references('id')->on('sole_proprietorships')->onDelete('cascade');
            $table->unsignedBigInteger('aop_id')->nullable();
            $table->foreign('aop_id')->references('id')->on('aops')->onDelete('cascade');
            $table->string('path');
            $table->string('what_for');
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pdfs');
    }
};
