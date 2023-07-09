<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            if (!Schema::hasColumn('games', 'game_type_id')) {
                $table->unsignedBigInteger('game_type_id');
                $table->foreign('game_type_id')->references('id')->on('game_types');
            }
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['game_type_id']);
            $table->dropColumn('game_type_id');
        });
    }
};
