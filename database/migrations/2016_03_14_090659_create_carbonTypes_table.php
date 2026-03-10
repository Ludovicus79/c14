<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateCarbonTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('carbonTypes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('molecularId')->index();
            $table->tinyInteger('Cs');
            $table->tinyInteger('CHs');
            $table->tinyInteger('CH2s');
            $table->tinyInteger('CH3s');
            $table->tinyInteger('COs');
            $table->tinyInteger('CHOs');
            $table->tinyInteger('CH2Os');
            $table->tinyInteger('CH3Os');
            $table->tinyInteger('CNs');
            $table->tinyInteger('CHNs');
            $table->tinyInteger('CH2Ns');
            $table->tinyInteger('CH3Ns');
            $table->tinyInteger('C');
            $table->tinyInteger('CH');
            $table->tinyInteger('CH2');
            $table->tinyInteger('CH3');
            $table->tinyInteger('CO');
            $table->tinyInteger('CHO');
            $table->tinyInteger('CH2O');
            $table->tinyInteger('CH3O');
            $table->tinyInteger('CN');
            $table->tinyInteger('CHN');
            $table->tinyInteger('CH2N');
            $table->tinyInteger('CH3N');
            $table->tinyInteger('O');
            $table->tinyInteger('N');
            $table->tinyInteger('H');
            $table->tinyInteger('F');
            $table->tinyInteger('Cl');
            $table->tinyInteger('Br');
            $table->tinyInteger('I');
            $table->tinyInteger('P');
            $table->tinyInteger('S');
            $table->tinyInteger('CTali');
            $table->tinyInteger('CTaro');
            $table->tinyInteger('CTole');
            $table->tinyInteger('Csp2');
            $table->tinyInteger('Cali');
            $table->tinyInteger('CHali');
            $table->tinyInteger('CH2ali');
            $table->tinyInteger('CH3ali');
            $table->tinyInteger('COali');
            $table->tinyInteger('CHOali');
            $table->tinyInteger('CNali');
            $table->tinyInteger('CHNali');
            $table->tinyInteger('Caro');
            $table->tinyInteger('CHaro');
            $table->tinyInteger('COaro');
            $table->tinyInteger('CHOaro');
            $table->tinyInteger('CNaro');
            $table->tinyInteger('CHNaro');
            $table->tinyInteger('Cole');
            $table->tinyInteger('CHole');
            $table->tinyInteger('CH2ole');
            $table->tinyInteger('CCarbonil');
            $table->tinyInteger('realizado');
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
        //
        Schema::drop('carbonTypes');
    }
}
