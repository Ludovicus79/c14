<?php

namespace App\Imports;

use App\Molecule;
use Maatwebsite\Excel\Concerns\ToModel;

class MoleculesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Molecule([
            //
        ]);
    }
}
