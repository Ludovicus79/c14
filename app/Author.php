<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Author extends Model
{
    use Rememberable;
    public function molecules()
    {
        return $this->hasMany('App\Molecule', 'authorId');
    }

    public function getExisting()
    {
        return Author::where('email', 'like', '%' . $this->email . '%')->first();
    }
}
