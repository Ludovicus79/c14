<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class CarbonType extends Model
{
    use Rememberable;
    protected $table = 'carbonTypes';
}
