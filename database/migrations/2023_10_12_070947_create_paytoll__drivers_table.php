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
        Schema::create('paytoll__drivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paytoll_id');
            $table->foreign('paytoll_id')->references('id')->on('paytolls');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->string('status')->default('0');
            $table->string('way');
            $table->string('date');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paytoll__drivers');
    }
};
