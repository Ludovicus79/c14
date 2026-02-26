<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class ShiftLimit extends Model
{
    use Rememberable;
    protected $table = 'shiftLimits';
}
