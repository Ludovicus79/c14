<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 19/04/2016
 * Time: 17:20
 */

namespace App\Helpers;

use App\AtomicWeight;
use Httpful\Exception\ConnectionErrorException;

/**
 * Class Conversor
 * @package App\Helpers
 *
 * Esta clase sustituye a la antigua clase Transformar ce los proyectos anteriores.
 * Principalmente se encarga de hacer conversiones entre diferentes formatos de códigos smile y jme.
 * Si alguno de los algoritmos presentara algún problema, los algoritmos antiguos se pueden encontrar en la clase Transformar del proyecto en java.
 * También tiene otras funciones para la obtención de datos calculador a partir de otros datos.
 */
class Conversor
{
    //----------JME----------//
    /**
     * Transforma un jme con numeración en un jme sin numeración.
     * @param $jmeNum cadena con el jme numérico.
     * @return mixed cadena con el jme sin numeración.
     */
    public static function toJme($jmeNum)
    {
        return preg_replace('/:(.*?)\s/', ' ', $jmeNum);
    }

    /**
     * Transforma un jme con numeración en un jme con los desplazamientos de los carbonos.
     * @param $jmeNum cadena con el jme numérico a transformar.
     * @param $carbons array con los carbonos de la molécula en formato modelo Carbono de eloquent.
     * @return cadena con el jme con los desplazamientos.
     */
    public static function toJmeDis($jmeNum, $carbons)
    {
        foreach ($carbons as $carbon) {
            if (($carbon->shift == '-9999') || ($carbon->shift == '0')) {
                $jmeNum = str_replace(":" . $carbon->num2 . " ", " ", $jmeNum);
            } else {
                $jmeNum = str_replace(":" . $carbon->num2 . " ", ":" . (round($carbon->shift, 0, PHP_ROUND_HALF_UP)) . ";", $jmeNum);
            }
        }
        $jmeNum = str_replace(";", " ", $jmeNum);
        return $jmeNum;
    }

    //----------SMILES----------//
    /**
     * Transformación de smiles con numeración a smiles sin numeración
     * @param $smilesNum cadena con el smiles numérico.
     * @return cadena con el smiles sin numeración
     */
    public static function toSmiles($smilesNum)
    {
        $smilesNum = preg_replace('(\[?([c|C])H?\d?:\d+\]?)', '\1', $smilesNum);
        $smilesNum = preg_replace('(:\d+)', '', $smilesNum);

        return $smilesNum;
    }


    /**
     * Transforma el smiles numérico a smiles con desplazamientos.
     * @param $smilesNum cadena con el smiles numérico.
     * @param $carbons array con los carbonos de la molécula en formato modelo Carbono eloquent.
     * @return cadena con el smiles con desplazamientos.
     */
    public static function toSmileDis($smilesNum, $carbons)
    {
        foreach ($carbons as $carbon) {
            $smilesNum = str_replace(":" . $carbon->num2 . "]", ":" . (round($carbon->shift, 0, PHP_ROUND_HALF_UP)) . ";]", $smilesNum);
        }
        $smilesNum = str_replace(";", "", $smilesNum);
        return $smilesNum;
    }

    //----------FORMULA MOLECULAR Y PESO----------

    /**
     * Transformación de jme a fórmula química.
     * @param $jme cadena con el jme numérico de la molécula.
     * @return cadena, fórmula correspondiente al jme
     */
    public static function jmeToFormula($jme)
    {
        // CORRECCIÓN: Si el JME está vacío o es inválido, retornar cadena vacía
        if (empty($jme) || !is_string($jme)) {
            return '';
        }
        
        $maxH = array("C" => 4, "H" => 1, "N" => 3, "S" => 2, "F" => 1, "Cl" => 1, "Br" => 1, "I" => 1, "P" => 3, "O" => 2);
        $total = array("C" => 0, "H" => 0, "N" => 0, "S" => 0, "F" => 0, "Cl" => 0, "Br" => 0, "I" => 0, "P" => 0, "O" => 0);

        $jme = Conversor::toJme($jme);
        //quitamos las coordenadas para trabajar más facil.
        $jme = preg_replace("|(-?\d*\.-?\d*\s-?\d*\.-?\d*\s)|", "", $jme);
        $jmeAtoms = array();
        preg_match_all("|([a-zA-Z]+)|", $jme, $jmeAtoms);
        //Con los atomos recogidos creamos otro array donde asignamos a cada
        $atoms = $jmeAtoms[1];
        foreach ($atoms as $atom) {
            // CORRECCIÓN: Verificar que el átomo existe en la lista de átomos válidos
            // Ignorar palabras como "JME" que no son átomos
            if (!isset($maxH[$atom])) {
                continue; // Saltar átomos no reconocidos (como "JME")
            }
            //Aprovechamos también para sumar uno a su correspondiente tipo.
            $total[$atom]++;
            $total["H"] += $maxH[$atom];
        }
        //return $atoms;
        //Buscamos los enlaces
        $enlaces = array();
        // 1-atomo 1    2-atomo 2   3-tipo de enlace
        preg_match_all("|(\d+)\s(\d+)\s(-?\d+)|", $jme, $enlaces);

        for ($i = 0; $i < sizeof($enlaces[0]); $i++) {
            switch ($enlaces[3][$i]) {
                case "2":
                    $total["H"] -= 4;
                    break;
                default:
                    $total["H"] -= 2;
            }
        }

        $formula = "";
        foreach ($total as $atomo => $cantidad) {
            if (!empty($cantidad)) {
                $formula .= $atomo;
                if ($cantidad > 1) {
                    $formula .= $cantidad;
                }
            }
        }
        return $formula;
    }

    /**
     * Transformación de smiles a fórmula química.
     * Éste método ya no se usa, para evitar el uso de funcione que depende de java, se ha sustituido por el método jmeToFormula.
     * @param $smiles
     * @return array|object|string
     * @throws \Exception
     */
    public static function smilesToFor($smiles)
    {
        $formula = "";
        $smiles = preg_replace('|%|', ';', $smiles);
        $webServiceData = json_encode($smiles);
        $uri = config('c13javaWebServices.url') . "SmilesToFor?json=" . ($webServiceData);
        try {
            $response = \Httpful\Request::get($uri)->send();
        } catch (ConnectionErrorException $e) {
            throw new \Exception('Error de conexión con la aplicación java, no se pudo obtener fórmula molecular');
        }
        if (isset($response) && $response->code == 200) {
            $res = json_decode($response->body);
            if ($res == "-1") {
                throw new \Exception('Error en chemaxon al obtener fórmula molecular');
            } else {
                $formula = $res;
            }
        } else {
            throw new \Exception('Error en la aplicación al obtener la fórmula molecular');
        }
        return $formula;
    }

    /**
     * Calcula el peso atómico a partir de la fórmula molecular
     * @param $formula cadena con la fórmula molecular de la molécula.
     * @return int, peso de la molécula.
     */
    public static function atomicWeight($formula)
    {
        $totalWeight = 0;
        $weights = AtomicWeight::all();
        foreach ($weights as $weight) {
            preg_match('/' . $weight->atom . '(\d*)/', $formula, $matches);
            if (!empty($matches)) {
                if($matches[1]==null){
                    $matches[1]=1;
                }
                $totalWeight += $matches[1] * $weight->weight;
            }
        }
        return $totalWeight;
    }


    //----------BIBLIOGRAFIA----------//

    /**
     * Transforma un string de bibliografía en un array que contiene los datos de la bibliografía separados.
     * Este array nos sirve para después crear una instancia de Bibliography.
     * La cadena proporcionada sigue un formato especificado:
     * Autores;revista(año)volumen:páginas
     * @param $string
     * @return array
     */
    public static function formatBiblio($string)
    {
        if (strpos($string, "unpublished results") === false) {
            $matches = array();
            $authors = preg_match('/([^;]*);/', $string, $matches) ? trim($matches[1]) : "";
            $magazine = preg_match('/;(.*?)\(/', $string, $matches) ? trim($matches[1]) : "";
            $year = preg_match('@\(([^)]*)\)@', $string, $matches) ? trim($matches[1]) : "";
            $volume = preg_match('/\)(.*?):/', $string, $matches) ? trim($matches[1]) : "";
            $page = preg_match('/\:(.*?)\./', $string, $matches) ? trim($matches[1]) : "";
            $doi = preg_match('/[^;]*;.*?\([^)]*\).*?:.*?\.\s(https:\/\/doi\.org.*)/', $string, $matches) ? trim($matches[1]) : "";
            if (empty($doi)) {
                $doi = preg_match('/[^;]*;.*?\([^)]*\).*?:.*?\.\sDOI: (.*)/', $string, $matches) ? "https://doi.org/" . trim($matches[1]) : "";
            }
            if (empty($doi)) {
                $doi = preg_match('/[^;]*;.*?\([^)]*\).*?:.*?\.\s(.*)/', $string, $matches) ? "https://doi.org/" . trim($matches[1]) : "";
            }
        } else {
            $authors = explode(";", $string)[0];
            $magazine = explode(";", $string)[1];
            $year = "0";
            $volume = "0";
            $page = "0";
            $doi = "";
        }
        $values = ["authors" => $authors, "magazine" => $magazine, "year" => $year, "volume" => $volume, "page" => $page, "doi" => $doi];
        return $values;
    }

    //----------CARBONOS----------//
    /**
     * Tranforma la numeración de un carbono en formato jme (sin letras) a formato estándar (con letras).
     * @param $num cadena, numeración del carbono sin letras.
     * @return cadena, numeración del carbono con letras.
     */
    public static function getNumeration($num)
    {
        $new = "";
        $num = (ltrim($num, "0"));
        $entities = ['91' => '&#945;', '92' => '&#946;', '93' => '&#947;', '94' => '&#955;'];
        $error = "error";
        switch (strlen($num)) {
            case 1:
                $new = $num;
                break;
            case 2:
                if (array_key_exists($num, $entities)) {
                    $new = $entities[$num];
                } else {
                    if ($num[0] != 0) {
                        $new .= $num[0];
                    }
                    $new .= $num[1];
                }
                break;
            case 3:
                $dec = substr($num, -2);
                $new = self::getNumeration($dec);
                if ($new != $error) {
                    for ($i = 0; $i < $num[0]; $i++) {
                        $new .= "'";
                    }
                }
                break;
            case 4:
                $new .= $num[0];
                if (intval($num[1] > 0)) {
                    $new .= chr(intval($num[1] > 0) + 96);
                }
                $dec = intval(substr($num, -2));
                if ($dec > 0 && $dec + 96 <= 122) {
                    $new .= chr($dec + 96);
                } else {
                    $new = $error;
                }
                break;
            case 5:
                $left = substr($num, 0, 2);
                $left = self::getNumeration($left);

                $right = "*" . substr($num, -3);
                $right = self::getNumeration($right);

                if ($left != $error && $right != $error) {
                    $new .= $left . substr($right, 1);
                } else {
                    $new = $error;
                }
                break;
            case 6:
                $left = substr($num, 0, 3);
                $left = self::getNumeration($left);

                $right = "*" . substr($num, -3);
                $right = self::getNumeration($right);

                if ($left != $error && $right != $error) {
                    $new .= $left . substr($right, 1);
                } else {
                    $new = $error;
                }
                break;
            default:
                $new = $error;
        }
        return $new;
    }


    /**
     * Devuelve la numeracion en formato jme (sin letars) a partir de una numeracióne estándar (con letras).
     * @param $num cadena, numeración con letras.
     * @return null|string numeración sin letras.
     */
    public static function getNumerationInverse($num)
    {
        // pasar a numeros para la bd
        $flag = false;

        if ($num == ("alfa")) {
            $num = "91";
            $flag = true;
        } else if ($num == ("alpha")) {
            $num = "91";
            $flag = true;
        } else if ($num == ("α")) {
            $num = "91";
            $flag = true;
        } else if ($num == ("beta")) {
            $num = "92";
            $flag = true;
        } else if ($num == ("β")) {
            $num = "92";
            $flag = true;
        } else if ($num == ("gamma")) {
            $num = "93";
            $flag = true;
        } else if ($num == ("γ")) {
            $num = "93";
            $flag = true;
        } else if ($num == ("delta")) {
            $num = "94";
            $flag = true;
        } else if ($num == ("δ")) {
            $num = "94";
            $flag = true;
        } else if ($num == ("epsilon")) {
            $num = "95";
            $flag = true;
        } else if ($num == ("ε")) {
            $num = "95";
            $flag = true;
        } else if ($num == ("alfa'")) {
            $num = "191";
            $flag = true;
        } else if ($num == ("alpha'")) {
            $num = "191";
            $flag = true;
        } else if ($num == ("α'")) {
            $num = "191";
            $flag = true;
        } else if ($num == ("beta'")) {
            $num = "192";
            $flag = true;
        } else if ($num == ("β'")) {
            $num = "192";
            $flag = true;
        } else if ($num == ("gamma'")) {
            $num = "193";
            $flag = true;
        } else if ($num == ("γ'")) {
            $num = "193";
            $flag = true;
        } else if ($num == ("delta'")) {
            $num = "194";
            $flag = true;
        } else if ($num == ("δ'")) {
            $num = "194";
            $flag = true;
        } else if ($num == ("alfa''")) {
            $num = "291";
            $flag = true;
        } else if ($num == ("alpha''")) {
            $num = "291";
            $flag = true;
        } else if ($num == ("α''")) {
            $num = "291";
            $flag = true;
        } else if ($num == ("beta''")) {
            $num = "292";
            $flag = true;
        } else if ($num == ("β''")) {
            $num = "292";
            $flag = true;
        } else if ($num == ("gamma''")) {
            $num = "293";
            $flag = true;
        } else if ($num == ("γ''")) {
            $num = "293";
            $flag = true;
        } else if ($num == ("delta''")) {
            $num = "294";
            $flag = true;
        } else if ($num == ("δ''")) {
            $num = "294";
            $flag = true;
        } else if ($num == ("alfa'''")) {
            $num = "391";
            $flag = true;
        } else if ($num == ("alpha'''")) {
            $num = "391";
            $flag = true;
        } else if ($num == ("α'''")) {
            $num = "391";
            $flag = true;
        } else if ($num == ("beta'''")) {
            $num = "392";
            $flag = true;
        } else if ($num == ("β'''")) {
            $num = "392";
            $flag = true;
        } else if ($num == ("gamma'''")) {
            $num = "393";
            $flag = true;
        } else if ($num == ("γ'''")) {
            $num = "393";
            $flag = true;
        } else if ($num == ("delta'''")) {
            $num = "394";
            $flag = true;
        } else if ($num == ("δ'''")) {
            $num = "394";
            $flag = true;
        } else if ($num == ("alfa''''")) {
            $num = "491";
            $flag = true;
        } else if ($num == ("alpha''''")) {
            $num = "491";
            $flag = true;
        } else if ($num == ("α''''")) {
            $num = "491";
            $flag = true;
        } else if ($num == ("beta''''")) {
            $num = "492";
            $flag = true;
        } else if ($num == ("β''''")) {
            $num = "492";
            $flag = true;
        } else if ($num == ("gamma''''")) {
            $num = "493";
            $flag = true;
        } else if ($num == ("γ''''")) {
            $num = "493";
            $flag = true;
        } else if ($num == ("delta''''")) {
            $num = "494";
            $flag = true;
        } else if ($num == ("δ''''")) {
            $num = "494";
            $flag = true;
        } else if ($num == ("91") || $num == ("92") || $num == ("93") || $num == ("94") || $num == ("95") ||
            $num == ("191") || $num == ("192") || $num == ("193") || $num == ("194") ||
            $num == ("291") || $num == ("292") || $num == ("293") || $num == ("294") ||
            $num == ("391") || $num == ("392") || $num == ("393") || $num == ("394") ||
            $num == ("491") || $num == ("492") || $num == ("493") || $num == ("494")
        ) $flag = true;

        $number = $num;
        $num = null;

        if ($flag) return $number;

        switch (mb_strlen(strval($number))) {
            case 0:
                return null;
            case 1:
                $t = ord(strval($number[0]));
                if (($t > 48) && ($t < 58))
                    return $number;
                return null;
            case 2:
                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                if (($t > 48) && ($t < 58)) {
                    if (strval($number[1]) == chr(39)) {
                        $t = $t - 48;
                        $t = $t + 100;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else if (($x > 96) && ($x < 123)) {
                        $x = $x - 96;
                        $t = ($t - 48) * 1000;
                        $t = $t + $x;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else
                        return $number;
                }
                return null;
            case 3:
                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                $y = ord(strval($number[2]));
                if (strval($number[2]) == chr(39)) {
                    if (strval($number[1]) == chr(39)) {
                        $t = $t - 48 + 200;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else if (($x >= 48) && ($x < 58) && ($t > 48) && ($t < 58)) {
                        $x = ($x - 48);
                        $t = ($t - 48) * 10;
                        $t = $t + 100 + $x;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else
                        return null;
                } else if (($y > 96) && ($y < 123)) {
                    $y = $y - 96;
                    if (strval($number[1]) == chr(39)) {
                        $t = $t - 48;
                        $t = $t + 100;
                        $t = $t * 1000 + $y;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else if (($x >= 48) && ($x < 58)) {
                        $t = ($t - 48) * 10;
                        $x = $x - 48;
                        $t = $t + $x;
                        $t = $t * 1000 + $y;
                        $new = "";
                        $new .= strval($t);
                        return $new;

                    } else if (($x > 96) && ($x < 123)) {
                        $x = $x - 96;
                        $t = $t - 48;
                        if ($x > 9)
                            return null;
                        $t = $t * 1000 + $x * 100 + $y;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else
                        return null;
                }
                break;
            case 4:
                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                $y = ord(strval($number[2]));
                $z = ord(strval($number[3]));

                if (strval($number[2]) == chr(39) && (($z > 96) && ($z < 123))) {
                    if (strval($number[3]) != chr(39)) {
                        if (strval($number[1]) == chr(39)) {
                            $t = ($t - 48);
                            $temporal = ($t + 200) * 1000 + ($z - 96);
                            $new = "";
                            $new .= $temporal;
                            return $new;
                        } else {
                            $t = ($t - 48) * 10;
                            $x = $x - 48;
                            $temporal = ($t + $x + 100) * 1000 + ($z - 96);
                            $new = "";
                            $new .= $temporal;
                            return $new;
                        }
                    }
                }

                if (strval($number[3]) == chr(39)) {
                    if (strval($number[2]) == chr(39)) {
                        if (strval($number[1]) == chr(39)) {
                            $t = $t - 48 + 300;
                            $new = "";
                            $new .= strval($t);
                            return $new;

                        } else if ((($t > 48) && ($t < 58)) && (($x >= 48) && ($x < 58))) {
                            $t = ($t - 48) * 10 + ($x - 48) + 200;
                            $new = "";
                            $new .= strval($t);
                            return $new;
                        }
                    }
                }

                if (strval($number[3]) == chr(39)) {
                    if ((strval($number[2]) == chr(39)) && ($t > 48) && ($t < 58) && ($x > 48) && ($x < 58)) {
                        $t = ($t - 48) * 10;
                        $x = $x - 48;
                        $t = 200 + $t + $x;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else
                        return null;
                } else if ((($z > 96) && ($z < 123)) && (($y <= 96) && ($y >= 123))) {
                    if (strval($number[2]) == chr(39)) {
                        if ((strval($number[1]) == chr(39)) && ($t > 48) && ($t < 58)) {
                            $t = $t - 48 + 200;
                            $t = $t * 1000;
                            $z = $z - 96;
                            $t = $t + $z;
                            $new = "";
                            $new .= strval($t);
                            return $new;
                        } else if (($t > 48) && ($t < 58) && ($x > 48) && ($x < 58)) {
                            $$t = ($$t - 48) * 10;
                            $$x = $$x - 48;
                            $$t = (100 + $$t + $$x) * 1000;
                            $$t = $$t + $$z - 96;
                            $new = "";
                            $new .= strval($t);
                            return $new;
                        }

                    } else
                        return null;
                } else if ((($z > 96) && ($z < 123)) && (($y > 96) && ($y < 123))) {
                    $z = $z - 96;
                    $y = $y - 96;
                    if (strval($number[1]) == chr(39)) {
                        $t = $t - 48;
                        $t = ($t + 100) * 1000;
                        if ($y > 9)
                            return null;
                        $t = $t + $y * 100 + $z;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else {
                        $t = $t - 48;
                        $x = $x - 48;
                        if ($y > 9)
                            return null;
                        $t = ($t * 10 + $x) * 1000;
                        $t = $t + $y * 100 + $z;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    }
                } else
                    return null;
                break;
            case 5:
                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                $y = ord(strval($number[2]));
                $z = ord(strval($number[3]));
                $q = ord(strval($number[4]));

                if (strval($number[4]) == chr(39)) {
                    if (strval($number[3]) == chr(39)) {
                        if (strval($number[2]) == chr(39)) {
                            if (strval($number[1]) == chr(39)) {
                                $t = $t - 48 + 400;
                                $new = "";
                                $new .= strval($t);
                                return $new;
                            }
                        }
                    }
                }

                if (strval($number[4]) == chr(39)) {
                    if (strval($number[3]) == chr(39)) {
                        if ((strval($number[2]) == chr(39)) && ($t > 48) && ($t < 58) && ($x > 48) && ($x < 58)) {
                            $t = ($t - 48) * 10;
                            $x = $x - 48;
                            $t = 300 + $t + $x;
                            $new = "";
                            $new .= strval($t);
                            return $new;
                        } else
                            return null;
                    }
                }

                if (strval($number[1]) == chr(39) && strval($number[2]) == chr(39) && strval($number[3]) == chr(39)) {
                    if (($q > 96) && ($q < 123)) {
                        $t = ($t - 48) + 300;
                        $t = $t * 1000;
                        $t = ($q - 96) + $t;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    }
                }

                if ((($q > 96) && ($q < 123)) && (($z <= 96) && ($z >= 123))) {
                    if ((strval($number[2]) == chr(39)) && (strval($number[2]) == chr(39))) {
                        if (($t > 48) && ($t < 58) && ($x > 48) && ($x < 58)) {
                            $t = ($t - 48) * 10;
                            $x = $x - 48;
                            $t = (200 + $t + $x) * 1000;
                            $t = $t + $q - 96;
                            $new = "";
                            $new .= strval($t);
                            return $new;
                        }
                    } else
                        return null;
                } else if ((($q > 96) && ($q < 123)) && (($z > 96) && ($z < 123))) {
                    if (strval($number[1]) == chr(39) && strval($number[2]) == chr(39)) {
                        $z = $z - 96;
                        if ($z > 9)
                            return null;

                        $q = $q - 96;
                        $t = $t - 48 + 200;
                        $t = $t * 1000 + $z * 100 + $q;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else if ((strval($number[2]) == chr(39)) && (($x >= 48) && ($x < 58))) {
                        $t = $t - 48;
                        $x = $x - 48;
                        $z = $z - 96;

                        if ($z > 9)
                            return null;

                        $q = $q - 96;
                        $t = $t * 10 + $x + 100;
                        $t = $t * 1000 + $z * 100 + $q;
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    } else
                        return null;
                } else
                    return null;
                break;
            case 6:
                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                $y = ord(strval($number[2]));
                $z = ord(strval($number[3]));
                $q = ord(strval($number[4]));
                $s = ord(strval($number[5]));

                if (strval($number[5]) == chr(39)) {
                    if (strval($number[4]) == chr(39)) {
                        if (strval($number[3]) == chr(39)) {
                            if (strval($number[2]) == chr(39)) {
                                if (strval($number[1]) == chr(39)) {
                                    $t = $t - 48 + 500;
                                    $new = "";
                                    $new .= strval($t);
                                    return $new;
                                }
                            }
                        }
                    }
                }

                if (strval($number[1]) == chr(39) && strval($number[2]) == chr(39) && strval($number[3]) == chr(39) && strval($number[4]) == chr(39)) {
                    if (($t > 48) && ($t < 58) && ($s > 96) && ($s < 123)) {
                        $t = (($t - 48) + 400) * 1000;
                        $t = $t + ($s - 96);
                        $new = "";
                        $new .= strval($t);
                        return $new;
                    }
                }

                if (strval($number[5]) == chr(39)) {
                    if (strval($number[4]) == chr(39)) {
                        if (strval($number[3]) == chr(39)) {
                            if ((strval($number[2]) == chr(39)) && (t > 48) && (t < 58) && (x >= 48) && (x < 58)) {
                                $t = ($t - 48) * 10;
                                $x = $x - 48;
                                $t = 400 + $t + $x;
                                $new = "";
                                $new .= strval($t);
                                return $new;
                            } else return null;
                        }
                    }
                }


                if ($y == 39 && $z == 39) {
                    if ((($t > 48) && ($t < 58)) && (($x >= 48) && ($x < 58))) {
                        if ((($q > 96) && ($q < 123)) && (($s > 96) && ($s < 123))) {
                            $t = $t - 48;
                            $x = $x - 48;
                            $q = $q - 96;
                            if ($q > 9)
                                return null;
                            $s = $s - 96;
                            $t = $t * 10 + $x + 200;
                            $t = $t * 1000 + $q * 100 + $s;
                            $new = "";
                            $new .= strval($t);
                            return $new;
                        } else return null;
                    } else return null;
                } else return null;
            case 7:
                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                $y = ord(strval($number[2]));
                $z = ord(strval($number[3]));
                $q = ord(strval($number[4]));
                $s = ord(strval($number[5]));
                $o = ord(strval($number[6]));

                if (strval($number[6]) == chr(39)) {
                    if (strval($number[5]) == chr(39)) {
                        if (strval($number[4]) == chr(39)) {
                            if (strval($number[3]) == chr(39)) {
                                if (strval($number[2]) == chr(39)) {
                                    if (strval($number[1]) == chr(39)) {
                                        $t = $t - 48 + 600;
                                        $new = "";
                                        $new .= strval($t);
                                        return $new;
                                    }
                                }
                            }
                        }
                    }
                }

                if (strval($number[6]) == chr(39)) {
                    if (strval($number[5]) == chr(39)) {
                        if (strval($number[4]) == chr(39)) {
                            if (strval($number[3]) == chr(39)) {
                                if ((strval($number[2]) == chr(39)) && ($t > 48) && ($t < 58) && ($x > 48) && ($x < 58)) {
                                    $t = ($t - 48) * 10;
                                    $x = $x - 48;
                                    $t = 500 + $t + $x;
                                    $new = "";
                                    $new .= strval($t);
                                    return $new;
                                } else return null;
                            }
                        }
                    }

                }
                break;
            case 8:
                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                $y = ord(strval($number[2]));
                $z = ord(strval($number[3]));
                $q = ord(strval($number[4]));
                $s = ord(strval($number[5]));
                $o = ord(strval($number[6]));
                $p = ord(strval($number[7]));


                if (strval($number[7]) == chr(39)) {
                    if (strval($number[6]) == chr(39)) {
                        if (strval($number[5]) == chr(39)) {
                            if (strval($number[4]) == chr(39)) {
                                if (strval($number[3]) == chr(39)) {
                                    if (strval($number[2]) == chr(39)) {
                                        if (strval($number[1]) == chr(39)) {
                                            $t = $t - 48 + 700;
                                            $new = "";
                                            $new .= strval($t);
                                            return $new;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if (strval($number[7]) == chr(39)) {
                    if (strval($number[6]) == chr(39)) {
                        if (strval($number[5]) == chr(39)) {
                            if (strval($number[4]) == chr(39)) {
                                if (strval($number[3]) == chr(39)) {
                                    if ((strval($number[2]) == chr(39)) && ($t > 48) && ($t < 58) && ($x > 48) && ($x < 58)) {
                                        $t = ($t - 48) * 10;
                                        $x = $x - 48;
                                        $t = 600 + $t + $x;
                                        $new = "";
                                        $new .= strval($t);
                                        return $new;
                                    } else return null;
                                }
                            }
                        }
                    }
                }
                break;
            case 9:

                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                $y = ord(strval($number[2]));
                $z = ord(strval($number[3]));
                $q = ord(strval($number[4]));
                $s = ord(strval($number[5]));
                $o = ord(strval($number[6]));
                $p = ord(strval($number[7]));
                $a = ord(strval($number[8]));

                if (strval($number[8]) == chr(39)) {
                    if (strval($number[7]) == chr(39)) {
                        if (strval($number[6]) == chr(39)) {
                            if (strval($number[5]) == chr(39)) {
                                if (strval($number[4]) == chr(39)) {
                                    if (strval($number[3]) == chr(39)) {
                                        if (strval($number[2]) == chr(39)) {
                                            if (strval($number[1]) == chr(39)) {
                                                $t = $t - 48 + 800;
                                                $new = "";
                                                $new .= strval($t);
                                                return $new;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if (strval($number[8]) == chr(39)) {
                    if (strval($number[7]) == chr(39)) {
                        if (strval($number[6]) == chr(39)) {
                            if (strval($number[5]) == chr(39)) {
                                if (strval($number[4]) == chr(39)) {
                                    if (strval($number[3]) == chr(39)) {
                                        if ((strval($number[2]) == chr(39)) && ($t > 48) && ($t < 58) && ($x > 48) && ($x < 58)) {
                                            $t = ($t - 48) * 10;
                                            $x = $x - 48;
                                            $t = 700 + $t + $x;
                                            $new = "";
                                            $new .= strval($t);
                                            return $new;
                                        } else
                                            return null;
                                    }
                                }
                            }
                        }
                    }
                }
                break;
            case 10:
                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                $y = ord(strval($number[2]));
                $z = ord(strval($number[3]));
                $q = ord(strval($number[4]));
                $s = ord(strval($number[5]));
                $o = ord(strval($number[6]));
                $p = ord(strval($number[7]));
                $a = ord(strval($number[8]));
                $b = ord(strval($number[9]));

                if (strval($number[9]) == chr(39)) {
                    if (strval($number[8]) == chr(39)) {
                        if (strval($number[7]) == chr(39)) {
                            if (strval($number[6]) == chr(39)) {
                                if (strval($number[5]) == chr(39)) {
                                    if (strval($number[4]) == chr(39)) {
                                        if (strval($number[3]) == chr(39)) {
                                            if (strval($number[2]) == chr(39)) {
                                                if (strval($number[1]) == chr(39)) {
                                                    $t = $t - 48 + 900;
                                                    $new = "";
                                                    $new .= strval($t);
                                                    return $new;

                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if (strval($number[9]) == chr(39)) {
                    if (strval($number[8]) == chr(39)) {
                        if (strval($number[7]) == chr(39)) {
                            if (strval($number[6]) == chr(39)) {
                                if (strval($number[5]) == chr(39)) {
                                    if (strval($number[4]) == chr(39)) {
                                        if (strval($number[3]) == chr(39)) {
                                            if ((strval($number[2]) == chr(39)) && ($t > 48) && ($t < 58) && ($x > 48) && ($x < 58)) {
                                                $t = ($t - 48) * 10;
                                                $x = $x - 48;
                                                $t = 800 + $t + $x;
                                                $new = "";
                                                $new .= strval($t);
                                                return $new;
                                            } else return null;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                break;
            case 11:

                $t = ord(strval($number[0]));
                $x = ord(strval($number[1]));
                $y = ord(strval($number[2]));
                $z = ord(strval($number[3]));
                $q = ord(strval($number[4]));
                $s = ord(strval($number[5]));
                $o = ord(strval($number[6]));
                $p = ord(strval($number[7]));
                $a = ord(strval($number[8]));
                $b = ord(strval($number[9]));
                $c = ord(strval($number[10]));

                if (strval($number[10]) == chr(39)) {
                    if (strval($number[9]) == chr(39)) {
                        if (strval($number[8]) == chr(39)) {
                            if (strval($number[7]) == chr(39)) {
                                if (strval($number[6]) == chr(39)) {
                                    if (strval($number[5]) == chr(39)) {
                                        if (strval($number[4]) == chr(39)) {
                                            if (strval($number[3]) == chr(39)) {
                                                if ((strval($number[2]) == chr(39)) && ($t > 48) && ($t < 58) && ($x > 48) && ($x < 58)) {
                                                    $t = ($t - 48) * 10;
                                                    $x = $x - 48;
                                                    $t = 900 + $t + $x;
                                                    $new = "";
                                                    $new .= strval($t);
                                                    return $new;
                                                } else return null;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            default:
                return null;
        }
        return null;
    }
}