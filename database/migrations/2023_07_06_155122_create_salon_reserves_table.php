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
        Schema::create('salon_reserves', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('salon_id');
            $table->string('day');
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('user_id');
            $table->integer('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salon_reserves');
    }
};
