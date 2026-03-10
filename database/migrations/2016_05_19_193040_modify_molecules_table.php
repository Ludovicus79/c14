<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMoleculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE molecules MODIFY state ENUM("1","2","3","4","5","6")');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE molecules MODIFY state ENUM(\'1\',\'2\',\'3\',\'4\',\'No fiable\',\'Sin validar\')');
    }
}
