<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateMoleculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('molecules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('semiSystematicName');
            $table->string('family');
            $table->string('subFamily');
            $table->string('subSubFamily');
            $table->text('smilesNumeration');
            $table->text('smiles');
            $table->text('smilesDisplacement');
            $table->text('jmeNumeration');
            $table->text('jme');
            $table->text('jmeDisplacement');
            $table->string('molecularFormula');
            $table->double('molecularWeight');
            $table->string('thinner');
            $table->string('reference');
            $table->unsignedInteger('bibliography')->index();
            $table->string('publicCom');
            $table->string('privateCom');
            $table->enum('state', ['1','2','3','4','No fiable','Sin validar']);
            $table->unsignedInteger('authorId')->index();
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
        Schema::drop('molecules');
    }
}