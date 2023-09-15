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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('image');
            $table->string('make');
            $table->string('capacity');
            $table->year('year');
            $table->date('dor');
            $table->string('rde')->default('not');
            $table->string('euro')->default('not');
            $table->string('fuel');
            $table->string('co');
            $table->string('status');
            $table->string('export')->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
