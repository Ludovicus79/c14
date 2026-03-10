<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class AddForeignKeysToCarbonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carbons', function (Blueprint $table) {
            $table->foreign('molecularId')->references('id')->on('molecules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carbons', function (Blueprint $table) {
            $table->dropForeign('carbons_molecularId_foreign');
        });
    }
}
