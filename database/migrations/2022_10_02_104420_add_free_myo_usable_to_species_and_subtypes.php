<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFreeMyoUsableToSpeciesAndSubtypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('specieses', function (Blueprint $table) {
            $table->boolean('is_free_myo_usable')->default(0);
        });

        Schema::table('subtypes', function (Blueprint $table) {
            $table->boolean('is_free_myo_usable')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('specieses', function (Blueprint $table) {
            $table->dropColumn('is_free_myo_usable');
        });

        Schema::table('subtypes', function (Blueprint $table) {
            $table->dropColumn('is_free_myo_usable');
        });
    }
}
