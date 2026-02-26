<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDisplacementColumnToShift extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carbons', function ($table) {
            $table->renameColumn('displacement', 'shift');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carbons', function ($table) {
            $table->renameColumn('shift', 'displacement');
        });
    }
}
