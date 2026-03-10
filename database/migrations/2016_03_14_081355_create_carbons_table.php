<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateCarbonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carbons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('molecularId')->index();
            $table->string('numeration');
            $table->string('carbonType');
            $table->double('displacement');
            $table->integer('num2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('carbons');
    }
}