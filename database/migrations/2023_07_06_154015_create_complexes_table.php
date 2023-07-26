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
        Schema::create('complexes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('phone');
            $table->string('email');
            $table->string('name');
            $table->integer('creator_id');
            $table->boolean('verify')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complexes');
    }
};
