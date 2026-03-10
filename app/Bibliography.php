<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Bibliography extends Model
{
    use Rememberable;
    protected $table = 'bibliographies';
    protected $fillable = array('authors', 'year', 'magazine', 'volume', 'page', 'doi');

    public function getExisting()
    {
        // Hemos quitado la comprobacion de los autores, para evitar repeticiones innecesarias
        // where('authors', 'like',$this->authors )->
        return Bibliography::where('year', 'like',$this->year)->where('magazine', 'like', $this->magazine )->where('volume', 'like', $this->volume )->where('page', 'like', $this->page )->where('doi', 'like', $this->doi )->first();
    }
}
