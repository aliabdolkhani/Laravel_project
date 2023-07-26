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
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('complex_id')->change();
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('complex_id')->references('id')->on('complexes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['complex_id']);
            $table->unsignedBigInteger('complex_id')->change();
            $table->dropForeign(['user_id']);
            $table->unsignedBigInteger('user_id')->change();
        });
    }
};
