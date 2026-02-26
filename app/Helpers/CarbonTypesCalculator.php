<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 24/05/2016
 * Time: 10:12
 */

namespace App\Helpers;


use App\CarbonType;
use App\Molecule;
use Illuminate\Support\Str;

class CarbonTypesCalculator
{

    /**
     * Guarda los tipos de carbono de una molecula
     * @param $id
     * @param $smilesNumeration
     * @param $formula
     */
    public static function saveCarbonTypes($id, $smilesNumeration, $formula)
    {
        $exceptions = self::getSpecificSkeletonExceptions($id);

        //$smilesNumeration = '[H][C@@:17]2([c:20]1[cH:22][cH:23]o[cH:21]1)[CH2:16][CH2:15][C@@:14]4([H])[C@@:13]2([CH3:18])[CH2:12][CH2:11][C@:9]5([H])[C@@:10]3([CH3:19])[C:1](=O)[C@:2](O)([CH2:3][C@:4]([CH3:29])([CH3:28])[C@@H:5]3[CH2:6][CH3:7])[C@@:30]6([H])O[C@@:8]456';
        $data['smiles'] = $smilesNumeration;
        $data['formula'] = $formula;

        $smilesNumeration = self::fixStereoCarbons($smilesNumeration);

        //C, CH, CH2, CH3
        preg_match_all('/(\[[C|c]\@{0,2}:\d+\])/', $smilesNumeration, $matches);
        $data['C'] = sizeof($matches[0]);

        $data['Cs'] = self::getSkeletonTypes($exceptions, $matches[0]);

        preg_match_all('/(\[[C|c]\@{0,2}[H|h]:\d+])/', $smilesNumeration, $matches);
        $data['CH'] = sizeof($matches[0]);

        $data['CHs'] = self::getSkeletonTypes($exceptions, $matches[0]);

        preg_match_all('/\[[C|c]\@{0,2}[H|h]2:\d+\]/', $smilesNumeration, $matches);
        $data['CH2'] = sizeof($matches[0]);

        $data['CH2s'] = self::getSkeletonTypes($exceptions, $matches[0]);

        preg_match_all('/\[[C|c]\@{0,2}[H|h]3:\d+\]/', $smilesNumeration, $matches);
        $data['CH3'] = sizeof($matches[0]);

        $data['CH3s'] = self::getSkeletonTypes($exceptions, $matches[0]);

        //PARA LOS ENLACES DESPEDAZAMOS EL SMILES
        $smilesSlices = self::getSmilesSlices($smilesNumeration);
        $cycla = array();
        foreach ($smilesSlices as $slice) {
            $cycla = array_unique(array_merge($cycla, self::getSmilesCyc($slice)));
        }
        $smilesSlices = array_merge($smilesSlices, $cycla);

        //ENLAZADOS A OXIGENO
        $linked = self::getSimpleLinkedCarbons('C', 'O', $smilesSlices, null);
        $data['C-O'] = sizeof($linked);

        $data['C-Os'] = self::getSkeletonTypes($exceptions, $linked);

        $linked = self::getSimpleLinkedCarbons('CH', 'O', $smilesSlices, null);
        $data['CH-O'] = sizeof($linked);

        $data['CH-Os'] = self::getSkeletonTypes($exceptions, $linked);

        $linked = self::getSimpleLinkedCarbons('CH2', 'O', $smilesSlices, null);
        $data['CH2-O'] = sizeof($linked);

        $data['CH2-Os'] = self::getSkeletonTypes($exceptions, $linked);

        $linked = self::getSimpleLinkedCarbons('CH3', 'O', $smilesSlices, null);
        $data['CH3-O'] = sizeof($linked);

        $data['CH3-Os'] = self::getSkeletonTypes($exceptions, $linked);

        //ENLAZADOS A NITROGENO
        $linked = self::getSimpleLinkedCarbons('C', 'N', $smilesSlices, null);
        $data['C-N'] = sizeof($linked);

        $data['C-Ns'] = self::getSkeletonTypes($exceptions, $linked);

        $linked = self::getSimpleLinkedCarbons('CH', 'N', $smilesSlices, null);
        $data['CH-N'] = sizeof($linked);

        $data['CH-Ns'] = self::getSkeletonTypes($exceptions, $linked);

        $linked = self::getSimpleLinkedCarbons('CH2', 'N', $smilesSlices, null);
        $data['CH2-N'] = sizeof($linked);

        $data['CH2-Ns'] = self::getSkeletonTypes($exceptions, $linked);

        $linked = self::getSimpleLinkedCarbons('CH3', 'N', $smilesSlices, null);
        $data['CH3-N'] = sizeof($linked);

        $data['CH3-Ns'] = self::getSkeletonTypes($exceptions, $linked);

        //HETEROATOMOS
        preg_match_all('/[O|o]/', $smilesNumeration, $matches);
        $data['O'] = sizeof($matches[0]);

        preg_match_all('/[N|n]/', $smilesNumeration, $matches);
        $data['N'] = sizeof($matches[0]);

        preg_match_all('/[H|h](\d+)/', $formula, $matches);
        $data['H'] = intval($matches[1][0]);

        preg_match_all('/[F|f]/', $smilesNumeration, $matches);
        $data['F'] = sizeof($matches[0]);

        preg_match_all('/[C|c][L|l]/', $smilesNumeration, $matches);
        $data['Cl'] = sizeof($matches[0]);

        preg_match_all('/[B|b][R|r]/', $smilesNumeration, $matches);
        $data['Br'] = sizeof($matches[0]);

        preg_match_all('/[I|i]/', $smilesNumeration, $matches);
        $data['I'] = sizeof($matches[0]);

        preg_match_all('/[P|p]/', $smilesNumeration, $matches);
        $data['P'] = sizeof($matches[0]);

        preg_match_all('/[S|s]/', $smilesNumeration, $matches);
        $data['S'] = sizeof($matches[0]);

        preg_match_all('/[c]/', $smilesNumeration, $matches);
        $data['CTaro'] = sizeof($matches[0]);

        $data['CTole'] = sizeof(self::getOlefinicCarbons($smilesSlices));

        $data['COcarbonilos'] = sizeof(self::getCarbonilCarbons($smilesSlices));

        $CNdouble = self::getDoubleLinkedCarbons('N', $smilesSlices, 'upper');
        $CSdouble = self::getDoubleLinkedCarbons('S', $smilesSlices, 'upper');
        $data['Csp2'] = $data['CTaro'] + $data['CTole'] + $data['COcarbonilos'] + sizeof($CNdouble) + sizeof($CSdouble);

        $data['Cole'] = sizeof(self::getOlefinicCarbons($smilesSlices, 'C'));

        $data['CHole'] = sizeof(self::getOlefinicCarbons($smilesSlices, 'CH'));

        $data['CH2Ole'] = sizeof(self::getOlefinicCarbons($smilesSlices, 'CH2'));

        preg_match_all('/(\[[c]\@{0,2}:\d+\])/', $smilesNumeration, $matches);
        $data['Caro'] = sizeof($matches[0]);

        preg_match_all('/(\[[c]\@{0,2}[H|h]:\d+])/', $smilesNumeration, $matches);
        $data['CHAro'] = sizeof($matches[0]);

        $linked = self::getSimpleLinkedCarbons('C', 'O', $smilesSlices, 'lower');
        $data['C-Oaro'] = sizeof($linked);

        $linked = self::getSimpleLinkedCarbons('CH', 'O', $smilesSlices, 'lower');
        $data['CH-Oaro'] = sizeof($linked);

        $linked = self::getSimpleLinkedCarbons('C', 'N', $smilesSlices, 'lower');
        $data['C-Naro'] = sizeof($linked);

        $linked = self::getSimpleLinkedCarbons('CH', 'N', $smilesSlices, 'lower');
        $data['CH-Naro'] = sizeof($linked);

        preg_match_all('/[C]/', $smilesNumeration, $matches);
        $Ctot = sizeof($matches[0]);
        $data['CTali'] = $Ctot - $data['CTole'] - $data['COcarbonilos'] - sizeof($CNdouble) - sizeof($CSdouble);

        //ALIFATICOS, NO DEBEN TENER DOBLE ENLACE. EXCLUIMOS CTole, COcarbonilos, C=N, C=S, Cole, CHole, CH2ole
        $exclusions = array_merge(self::getOlefinicCarbons($smilesSlices), self::getCarbonilCarbons($smilesSlices),
            $CNdouble, $CSdouble, self::getOlefinicCarbons($smilesSlices, 'C'), self::getOlefinicCarbons($smilesSlices, 'CH'), self::getOlefinicCarbons($smilesSlices, 'CH2'));

        preg_match_all('/(?<!\[[H|h]\])(\[[C]\@{0,2}:\d+\])(?!\d+\(\[[H|h]\]\))/', $smilesNumeration, $matches);
        $data['Cali'] = sizeof(array_diff($matches[0], $exclusions));

        preg_match_all('/((\[H\])(\[[C]\@{0,2}:\d+\]))|((\[[C]\@{0,2}:\d+\]\d*?)(\(\[H\]\)))|(\[[C]\@{0,2}[H|h]:\d+])/', $smilesNumeration, $matches);
        $data['CHali'] = sizeof(array_diff($matches[0], $exclusions));

        preg_match_all('/\[[C]\@{0,2}[H|h]2:\d+\]/', $smilesNumeration, $matches);
        $data['CH2ali'] = sizeof(array_diff($matches[0], $exclusions));

        preg_match_all('/\[[C]\@{0,2}[H|h]3:\d+\]/', $smilesNumeration, $matches);
        $data['CH3ali'] = sizeof(array_diff($matches[0], $exclusions));

        $linked = self::getSimpleLinkedCarbons('C', 'O', $smilesSlices, 'upper');
        $data['C-Oali'] = sizeof($linked);

        $linked = self::getSimpleLinkedCarbons('CH', 'O', $smilesSlices, 'upper');
        $data['CH-Oali'] = sizeof($linked);

        $linked = self::getSimpleLinkedCarbons('CH2', 'O', $smilesSlices, 'upper');
        $data['CH2-Oali'] = sizeof($linked);

        $linked = self::getSimpleLinkedCarbons('C', 'N', $smilesSlices, 'upper');
        $data['C-Nali'] = sizeof($linked);

        $linked = self::getSimpleLinkedCarbons('CH', 'N', $smilesSlices, 'upper');
        $data['CH-Nali'] = sizeof($linked);

        $carbon = CarbonType::where('molecularId', $id)->get();
        if (isset($carbon[0])) {
            $carbon = $carbon[0];
            $carbon = CarbonType::find($carbon->id);
        } else
            $carbon = new CarbonType();

        $carbon->molecularId = $id;
        $carbon->Cs = $data['Cs'];
        $carbon->CHs = $data['CHs'];
        $carbon->CH2s = $data['CH2s'];
        $carbon->CH3s = $data['CH3s'];
        $carbon->COs = $data['C-Os'];
        $carbon->CHOs = $data['CH-Os'];
        $carbon->CH2Os = $data['CH2-Os'];
        $carbon->CH3Os = $data['CH3-Os'];
        $carbon->CNs = $data['C-Ns'];
        $carbon->CHNs = $data['CH-Ns'];
        $carbon->CH2Ns = $data['CH2-Ns'];
        $carbon->CH3Ns = $data['CH3-Ns'];
        $carbon->C = $data['C'];
        $carbon->CH = $data['CH'];
        $carbon->CH2 = $data['CH2'];
        $carbon->CH3 = $data['CH3'];
        $carbon->CO = $data['C-O'];
        $carbon->CHO = $data['CH-O'];
        $carbon->CH2O = $data['CH2-O'];
        $carbon->CH3O = $data['CH3-O'];
        $carbon->CN = $data['C-N'];
        $carbon->CHN = $data['CH-N'];
        $carbon->CH2N = $data['CH2-N'];
        $carbon->CH3N = $data['CH3-N'];
        $carbon->O = $data['O'];
        $carbon->N = $data['N'];
        $carbon->H = $data['H'];
        $carbon->F = $data['F'];
        $carbon->Cl = $data['Cl'];
        $carbon->Br = $data['Br'];
        $carbon->I = $data['I'];
        $carbon->P = $data['P'];
        $carbon->S = $data['S'];
        $carbon->CTali = $data['CTali'];
        $carbon->CTaro = $data['CTaro'];
        $carbon->CTole = $data['CTole'];
        $carbon->Csp2 = $data['Csp2'];
        $carbon->Cali = $data['Cali'];
        $carbon->CHali = $data['CHali'];
        $carbon->CH2ali = $data['CH2ali'];
        $carbon->CH3ali = $data['CH3ali'];
        $carbon->COali = $data['C-Oali'];
        $carbon->CHOali = $data['CH-Oali'];
        $carbon->CNali = $data['C-Nali'];
        $carbon->CHNali = $data['CH-Nali'];
        $carbon->Caro = $data['Caro'];
        $carbon->CHaro = $data['CHAro'];
        $carbon->COaro = $data['C-Oaro'];
        $carbon->CHOaro = $data['CH-Oaro'];
        $carbon->CNaro = $data['C-Naro'];
        $carbon->CHNaro = $data['CH-Naro'];
        $carbon->Cole = $data['Cole'];
        $carbon->CHole = $data['CHole'];
        $carbon->CH2ole = $data['CH2Ole'];
        $carbon->CCarbonil = $data['COcarbonilos'];
        $carbon->save();
    }

    /**
     * Devuelve un listado de las excepciones que afectan a los carbonos del esqueleto
     * @return array
     */
    private static function getAllSkeletonExceptions()
    {
        $data = array();
        $exceptions = file(base_path('/resources/esqueletos.txt'), FILE_IGNORE_NEW_LINES);
        foreach ($exceptions as $exception) {
            $families = array_filter(explode('--', $exception));
            $num = array_filter(explode('*', array_pop($families)));
            $data[] = [
                'families' => $families,
                'numerations' => $num,
            ];
        }
        return $data;
    }

    /**
     * Devuelve las excepciones para un compuesto concreto
     * @param $id
     * @return mixed
     */
    private static function getSpecificSkeletonExceptions($id)
    {
        $exceptions = self::getAllSkeletonExceptions();
        $excKey = null;
        $molecule = Molecule::find($id);
        foreach ($exceptions as $key => $exception) {
            if (!isset($exception['families'][3])) { //Buscamos subSubfamilia
                if (!isset($exception['families'][2])) { //Buscamos subfamilia
                    if (!isset($exception['families'][1])) { //Buscamos familia
                        //Do nothing...
                    } else {
                        if ($exception['families'][1] == $molecule->family) {
                            $excKey = $key;
                        }
                    }
                } else {
                    if ($exception['families'][2] == $molecule->subFamily) {
                        $excKey = $key;
                    }
                }
            } else {
                if ($exception['families'][3] == $molecule->subSubFamily) {
                    $excKey = $key;
                }
            }
        }
        if ($excKey == null) {
            return array();
        } else {
            return $exceptions[$excKey]['numerations'];
        }
    }

    /**
     * Convierte los CH de la estereoquimica en CH normales
     * @param $smiles
     * @return mixed
     */
    private static function fixStereoCarbons($smiles)
    {
        preg_match_all('/((\[H\])(\[[C|c]\@{0,2}:\d+\]))|((\[[C|c]\@{0,2}:\d+\]\d*?)(\(\[H\]\)))|(\[[C|c]\@{0,2}[H|h]:\d+])/', $smiles, $matches);
        foreach ($matches[0] as $match) {
            if (preg_match('/\(?\[H\]\)?/', $match, $matchesAux)) {
                $newStr = str_replace($matchesAux[0], "", $match);
                preg_match('/[:]/', $newStr, $matchesDot, PREG_OFFSET_CAPTURE);
                $newStr = substr($newStr, 0, $matchesDot[0][1]) . 'H' . substr($newStr, $matchesDot[0][1]);
                $smiles = str_replace($match, $newStr, $smiles);
            }
        }
        return $smiles;
    }

    /**
     * Calcula los carbonos que pertenecen al esqueleto
     * @param $exceptions
     * @param $carbons
     * @return int
     */
    private static function getSkeletonTypes($exceptions, $carbons)
    {
        $counter = 0;
        foreach ($carbons as $carbon) {
            preg_match_all('/:(\d+)/', $carbon, $matches);
            $num = intval($matches[1][0]);
            if ($num < 99 || in_array($num, $exceptions)) $counter++;
        }
        return $counter;
    }

    /**
     * Despedaza el smiles en todas sus posibles rutas para facilitar la busqueda de tipos de carbono
     * @param $smiles
     * @return array
     */
    private static function getSmilesSlices($smiles)
    {
        $ramas = array();
        while (preg_match_all('/\(/', $smiles, $matches, PREG_OFFSET_CAPTURE)) {
            $parOpen = $matches[0][0][1];
            $parClose = self::findClosingParen($smiles, $parOpen);
            $head = substr($smiles, 0, $parOpen);
            $subBranch = substr($smiles, $parOpen + 1, $parClose - $parOpen - 1);
            $nextStr = substr($smiles, $parClose + 1);
            if (Str::contains($subBranch, '(')) {
                $ramasAux = self::getSmilesSlices($subBranch);
                array_pop($ramas);
                foreach ($ramasAux as $rama) {
                    array_push($ramas, $head . $rama);
                }
                array_push($ramas, $head . $nextStr);
            } else {
                array_pop($ramas);
                array_push($ramas, $head . $subBranch);
                array_push($ramas, $head . $nextStr);
            }
            $smiles = $head . $nextStr;
        }
        if (sizeof($ramas) == 0) array_push($ramas, $smiles);
        return $ramas;
    }

    /**
     * Devuelve los atomos enlazados por ciclaciones
     * @param $smiles
     * @return array
     */
    private static function getSmilesCyc($smiles)
    {
        preg_match_all('/(\[.*?\]\d+)|(\(.*?\)\d+)|(\w?\D(?<!:)\d+(?!:))/', $smiles, $matches);
        $ciclos = array();
        foreach ($matches[0] as $match) {
            preg_match('/[0-9]+$/', $match, $matchAux, PREG_OFFSET_CAPTURE);
            $matchStr = substr($match, 0, $matchAux[0][1]);
            $matchNum = substr($match, $matchAux[0][1]);
            for ($i = 0; $i < strlen($matchNum); $i++) {
                $match = $matchStr . $matchNum[$i];
                preg_match('/(\[(([C|c]\@{0,2})|([C|c]\@{0,2}[H|h])|([C|c]\@{0,2}[H|h]\d)):\d+\]\d)$|(\(?\w?\D\)?\d)$/', $match, $matchAux);
                $match = $matchAux[0];
                $cyc = substr($match, -1);
                if (!empty($ciclos[$cyc]))
                    $ciclos[$cyc] .= substr($match, 0, strlen($match) - 1);
                else
                    $ciclos[$cyc] = substr($match, 0, strlen($match) - 1);
            }
        }
        return $ciclos;
    }

    /**
     * Devuelve los carbonos enlazados a un atomo concreto
     * @param $type
     * @param $link
     * @param $smilesSlices
     * @param $charType ['upper', 'lower', null]
     * @return int
     */
    private static function getSimpleLinkedCarbons($type, $link, $smilesSlices, $charType)
    {
        switch ($type) {
            case 'C':
                if ($charType == null) $typeExpr = '[C|c]\@{0,2}';
                elseif ($charType == 'upper') $typeExpr = '[C]\@{0,2}';
                elseif ($charType == 'lower') $typeExpr = '[c]\@{0,2}';
                break;
            case 'CH':
                if ($charType == null) $typeExpr = '[C|c]\@{0,2}[H|h]';
                elseif ($charType == 'upper') $typeExpr = '[C]\@{0,2}[H|h]';
                elseif ($charType == 'lower') $typeExpr = '[c]\@{0,2}[H|h]';
                break;
            case 'CH2':
                if ($charType == null) $typeExpr = '[C|c]\@{0,2}[H|h]2';
                elseif ($charType == 'upper') $typeExpr = '[C]\@{0,2}[H|h]2';
                elseif ($charType == 'lower') $typeExpr = '[c]\@{0,2}[H|h]2';
                break;
            case 'CH3':
                if ($charType == null) $typeExpr = '[C|c]\@{0,2}[H|h]3';
                elseif ($charType == 'upper') $typeExpr = '[C]\@{0,2}[H|h]3';
                elseif ($charType == 'lower') $typeExpr = '[c]\@{0,2}[H|h]3';
                break;
        }

        $carbons = array();
        foreach ($smilesSlices as $slice) {
            preg_match_all('/(\[' . $typeExpr . ':\d+\])[\d+]*[' . mb_strtoupper($link) . '|' . mb_strtolower($link) . ']/', $slice, $matches);
            if (isset($matches[1]))
                foreach ($matches[1] as $match)
                    array_push($carbons, $match);
            preg_match_all('/[' . mb_strtoupper($link) . '|' . mb_strtolower($link) . '][\d+]*(\[' . $typeExpr . ':\d+\])/', $slice, $matches);
            if (isset($matches[1]))
                foreach ($matches[1] as $match)
                    array_push($carbons, $match);
        }
        return array_unique($carbons);
    }

    /**
     * Devuelve los carbonos enlazados por un enlace doble a un atomo concreto
     * @param $link
     * @param $smilesSlices
     * @param $charType ['upper', 'lower', null]
     * @return array
     * @internal param $type
     * @internal param $smilesSlice
     */
    private static function getDoubleLinkedCarbons($link, $smilesSlices, $charType)
    {
        switch ($charType) {
            case 'upper':
                $typeExpr = '[C]\@{0,2}[H|h]?2?';
                break;
            case 'lower':
                $typeExpr = '[c]\@{0,2}[H|h]?2?';
                break;
            case null:
                $typeExpr = '[C|c]\@{0,2}[H|h]?2?';
                break;
        }

        $carbons = array();
        foreach ($smilesSlices as $slice) {
            preg_match_all('/(\[' . $typeExpr . ':\d+\])[\d+]*=[' . mb_strtoupper($link) . '|' . mb_strtolower($link) . ']/', $slice, $matches);
            if (isset($matches[1]))
                foreach ($matches[1] as $match)
                    array_push($carbons, $match);
            preg_match_all('/[' . mb_strtoupper($link) . '|' . mb_strtolower($link) . '][\d+]*=(\[' . $typeExpr . ':\d+\])/', $slice, $matches);
            if (isset($matches[1]))
                foreach ($matches[1] as $match)
                    array_push($carbons, $match);

        }
        return array_unique($carbons);
    }

    /**
     * Devuelve los carbonos olefinicos
     * @param $smilesSlices
     * @param null $type
     * @return array
     */
    private static function getOlefinicCarbons($smilesSlices, $type = null)
    {
        $carbons = array();
        if ($type == null) {
            foreach ($smilesSlices as $slice) {
                preg_match_all('/(\[[C]\@{0,2}[H]?2?:\d+\])[\d+]*=(\[[C]\@{0,2}[H]?2?:\d+\])/', $slice, $matches);
                if (isset($matches[1])) {
                    foreach ($matches[1] as $match)
                        array_push($carbons, $match);
                }
                if (isset($matches[2])) {
                    foreach ($matches[2] as $match)
                        array_push($carbons, $match);
                }
            }
        } else {
            switch ($type) {
                case 'C':
                    $typeExpr = '[C]\@{0,2}';
                    break;
                case 'CH':
                    $typeExpr = '[C]\@{0,2}[H|h]';
                    break;
                case 'CH2':
                    $typeExpr = '[C]\@{0,2}[H|h]2';
                    break;
                case 'CH3':
                    $typeExpr = '[C]\@{0,2}[H|h]3';
                    break;
            }

            foreach ($smilesSlices as $slice) {
                preg_match_all('/(\[' . $typeExpr . ':\d+\])[\d+]*=(\[[C]\@{0,2}[H]?2?:\d+\])/', $slice, $matches);
                if (isset($matches[1])) {
                    foreach ($matches[1] as $match)
                        array_push($carbons, $match);
                }
                preg_match_all('/(\[[C]\@{0,2}[H]?2?:\d+\])[\d+]*=(\[' . $typeExpr . ':\d+\])/', $slice, $matches);
                if (isset($matches[2])) {
                    foreach ($matches[2] as $match)
                        array_push($carbons, $match);
                }
            }
        }
        return array_unique($carbons);
    }

    /**
     * Devuelve los carbonos carbonilos
     * @param $smilesSlices
     * @return array
     */
    private static function getCarbonilCarbons($smilesSlices)
    {
        $carbons = array();
        foreach ($smilesSlices as $slice) {
            preg_match_all('/(\[[C]\@{0,2}[H]?2?3?:\d+\])[\d+]*=[O|o]/', $slice, $matches);
            if (isset($matches[1]))
                foreach ($matches[1] as $match)
                    array_push($carbons, $match);
            preg_match_all('/[O|o][\d+]*=(\[[C]\@{0,2}[H]?2?3?:\d+\])/', $slice, $matches);
            if (isset($matches[1]))
                foreach ($matches[1] as $match)
                    array_push($carbons, $match);

        }
        return array_unique($carbons);
    }

    /**
     * Devuelve la posicion del parentesis de cierre de una cadena dada la posicion del parentesis de apertura
     * @param $str
     * @param $openPos
     * @return mixed
     */
    public static function findClosingParen($str, $openPos)
    {
        $closePos = $openPos;
        $counter = 1;
        while ($counter > 0) {
            $char = $str[++$closePos];
            if ($char == '(')
                $counter++;
            else if ($char == ')')
                $counter--;
        }
        return $closePos;
    }
}