<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class AddForeignKeysToCarbonTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carbonTypes', function (Blueprint $table) {
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
        Schema::table('carbonTypes', function (Blueprint $table) {
            $table->dropForeign('carbonTypes_molecularId_foreign');
        });
    }
}
