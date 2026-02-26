<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class AtomicWeight extends Model
{
    use Rememberable;
    protected $table = 'atomicWeights';
}
