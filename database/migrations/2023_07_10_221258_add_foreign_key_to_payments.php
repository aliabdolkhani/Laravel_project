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
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('salon_id')->change();
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('salon_id')->references('id')->on('salons');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['salon_id']);
            $table->unsignedBigInteger('salon_id')->change();
            $table->dropForeign(['user_id']);
            $table->unsignedBigInteger('user_id')->change();
        });
    }
};
