<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Carbon extends Model
{
    use Rememberable;
    public function molecule() {
        return $this->hasOne('App\Molecule', 'id');
    }



    /**
     * Devuelve un array con los indices de los atomos que cumplen ese desplazamiento acorde con el jme
     * @param $shift
     * @param $id de la molecula
     * @return array
     */
    static function getShiftIndexes($shift, $id) {

        $molecule = Molecule::find($id);
        $subKey = array();

        //$re = "/[aA-zZ]:?[0-9]*/";
        preg_match_all("/[aA-zZ]:?[0-9]*/" , $molecule->jmeDisplacement ,$matches);
        foreach($matches[0] as $key) {
            $result[] = explode(':', $key);
        }


        foreach($result as $key => $item){
            if (is_array($item) && isset($item[1])){
                if ($item[1] == round($shift)){ //Desplazamiento a comprobar
                    $subKey[$key+1] = $item;
                }
            }
        }

        $indexes = array();

        foreach($subKey as $key => $value) {
            array_push($indexes, (int)$key);
        }

        return $indexes;
    }

    /*funcion que devuelve los indices del atomo que hay que pintar.
        busca dentro del jmeNumeracion por el numero que tiene de referencia el atomo
        y lo guarda en un array
    */
    static function indices($id, $numero) {

        $molecule = Molecule::find($id);
        $subKey = array();

        //$re = "/[aA-zZ]:?[0-9]*/";
        preg_match_all("/[aA-zZ]+:?[0-9]*/" , $molecule->jmeNumeration ,$matches);
        foreach($matches[0] as $key) {
            $result[] = explode(':', $key);
        }
        foreach($result as $key => $item){
            if (is_array($item) && isset($item[1])){
                if ($item[1] == $numero){ //Desplazamiento a comprobar
                    $subKey[$key+1] = $item;
                }
            }
        }

        $indexes = array();

        foreach($subKey as $key => $value) {
            array_push($indexes, (int)$key);
        }


        return $indexes;
    }




}
