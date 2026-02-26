<?php

namespace App;

use Httpful\Exception\ConnectionErrorException;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Molecule extends Model
{
    use Rememberable;
    use SoftDeletes;
    
    protected $casts = ['deleted_at' => 'datetime'];

    public function bibliography() {
        return $this->hasOne('App\Bibliography', 'id');
    }

    public function author() {
        return $this->hasOne('App\Author', 'id');
    }

    public function carbons(){
        return $this->hasMany('App\Carbon','molecularId');
    }

    public function carbonTypes() {
        return $this->hasOne('App\CarbonType', 'molecularId');
    }

    /*
     * Busca si una molecula ya existe en la base de datos
     */
    public static function searchDuplicate($smiles,$disolvente){
        $result="";
        $smiles=preg_replace('|%|', ';', $smiles);
        $webServiceData=json_encode(array($smiles,$disolvente));
        $uri=config('c13javaWebServices.url')."Duplicate?json=".($webServiceData);
        try {
            $response = \Httpful\Request::get($uri)->send();
        }catch(ConnectionErrorException $e){
            throw new \Exception('Error de conexión con la aplicación java de la USAL, no se pudo comprobar si la molécula está duplicada.');
        }
        //var_dump($response->code);
        //var_dump($response);
        //exit();
        if (isset($response) && $response->code == 200) {
            $res = json_decode($response->body);
            if ($res == "-1") {
                throw new \Exception('Error en chemaxon al buscar duplicados');
            } else {
                $result = $res;
            }
        } else {
            throw new \Exception('Error en la aplicación al buscar duplicados. Error en el servidor');
        }
        /*var_dump($result);
        exit();*/
        return $result;
    }
}
