<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMyoCountsToCharactersAndUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->boolean('is_free_myo')->default(0)->after('is_myo_slot');
        });

        Schema::table('user_settings', function (Blueprint $table) {
            $table->integer('free_myos_made')->default(0)->after('is_fto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('is_free_myo');
        });

        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropColumn('free_myos_made');
        });
    }
}
