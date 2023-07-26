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
        Schema::table('available_times', function (Blueprint $table) {
            $table->unsignedBigInteger('salon_id')->change();
            $table->foreign('salon_id')->references('id')->on('salons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_times', function (Blueprint $table) {
            $table->dropForeign(['salon_id']);
            $table->unsignedBigInteger('salon_id')->change();
        });
    }
};
