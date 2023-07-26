<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('complexes', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id')->change();
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('complexes', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
            $table->unsignedBigInteger('creator_id')->change();
        });
    }
};
