<?php

namespace App\Imports;

use App\Molecule;
use App\Bibliography;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MoleculesWithDOIImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Buscar o crear bibliografía con DOI
        $bibliography = Bibliography::firstOrCreate([
            'authors' => $row['authors'] ?? '',
            'year' => $row['year'] ?? '',
            'magazine' => $row['magazine'] ?? '',
            'volume' => $row['volume'] ?? '',
            'page' => $row['page'] ?? '',
        ], [
            'doi' => $row['doi'] ?? null,
        ]);

        // Si ya existe y tiene DOI, actualizarlo
        if (!empty($row['doi']) && empty($bibliography->doi)) {
            $bibliography->doi = $row['doi'];
            $bibliography->save();
        }

        // Crear o actualizar molécula
        return Molecule::updateOrCreate(
            ['name' => $row['name']], // Buscar por nombre
            [
                'family' => $row['family'] ?? '',
                'subFamily' => $row['subfamily'] ?? '',
                'subSubFamily' => $row['subsubfamily'] ?? '',
                'molecularFormula' => $row['formula'] ?? '',
                'molecularWeight' => $row['weight'] ?? 0,
                'bibliography' => $bibliography->id,
                'smiles' => $row['smiles'] ?? '',
                'jme' => $row['jme'] ?? '',
                // ... otros campos según tu Excel
            ]
        );
    }
}