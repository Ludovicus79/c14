<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class AddForeignKeysToMoleculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('molecules', function (Blueprint $table) {
            $table->foreign('bibliography')->references('id')->on('bibliographies');
            $table->foreign('authorId')->references('id')->on('authors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('molecules', function (Blueprint $table) {
            $table->dropForeign('molecules_bibliography_foreign');
            $table->dropForeign('molecules_authorId_foreign');
        });
    }
}