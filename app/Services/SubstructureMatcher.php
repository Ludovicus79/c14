<?php

namespace App\Services;

/**
 * Búsqueda de subestructura 100% PHP.
 * 
 * Parsea SMILES y JME, y usa backtracking (VF2 simplificado)
 * para encontrar todas las ocurrencias de un patrón en una molécula.
 *
 * Dos modos de matching:
 *   ESTRICTO (búsqueda SMILES vs SMILES): aromaticidad debe coincidir.
 *   RELAJADO (coloración SMILES vs JME): aromaticidad ignorada (JME no la marca).
 */
class SubstructureMatcher
{
    // ================================================================
    //  API PÚBLICA
    // ================================================================

    /**
     * Búsqueda rápida: devuelve IDs de moléculas que contienen la subestructura.
     * Usa matching ESTRICTO (aromaticidad debe coincidir).
     */
    public static function searchBatch($querySmiles, $molecules)
    {
        $query = self::parseSMILES($querySmiles);
        if (!$query || empty($query['atoms'])) return [];

        $matches = [];
        foreach ($molecules as $entry) {
            $id = $entry[0];
            $smiles = $entry[1] ?? '';
            if (empty($smiles)) continue;

            $target = self::parseSMILES($smiles);
            if (!$target) continue;

            if (self::hasMatch($query, $target, false)) {
                $matches[] = $id;
            }
        }
        return $matches;
    }

    /**
     * Coloración: para cada molécula, devuelve los índices de átomos (1-based).
     * Usa matching RELAJADO para JME (aromaticidad ignorada).
     * Las moléculas ya fueron confirmadas por searchBatch, aquí solo calculamos índices.
     */
    public static function colorBatch($querySmiles, $molecules)
    {
        $query = self::parseSMILES($querySmiles);
        if (!$query || empty($query['atoms'])) return [];

        $result = [];
        foreach ($molecules as $entry) {
            $id = $entry[0];
            $smiles = $entry[1] ?? '';
            $jme = $entry[2] ?? null;
            if (empty($smiles)) continue;

            // Intentar JME primero (relajado, índices compatibles con JSME)
            $target = null;
            if (!empty($jme)) {
                $jmeMol = self::parseJME($jme);
                if ($jmeMol && self::hasMatch($query, $jmeMol, true)) {
                    $target = $jmeMol;
                }
            }

            // Fallback a SMILES (relajado también, ya sabemos que matchea)
            $relaxed = true;
            if (!$target) {
                $target = self::parseSMILES($smiles);
                if (!$target || !self::hasMatch($query, $target, true)) continue;
            }

            $allMatches = self::getAllMatches($query, $target, true);

            $atomSet = [];
            foreach ($allMatches as $match) {
                foreach ($match as $atomIdx) {
                    $atomSet[$atomIdx + 1] = true;
                }
            }

            if (!empty($atomSet)) {
                $indices = array_keys($atomSet);
                sort($indices);
                $result[strval($id)] = $indices;
            }
        }
        return $result;
    }

    // ================================================================
    //  SMILES PARSER
    // ================================================================

    public static function parseSMILES($smiles)
    {
        if (empty($smiles)) return null;

        // Limpiar atom map numbers [CH2:1] → [CH2]
        $smiles = preg_replace('/:\d+(?=\])/', '', $smiles);

        $atoms = [];
        $bonds = [];
        $ringOpenings = [];
        $stack = [];
        $prev = -1;
        $bondType = null;
        $i = 0;
        $len = strlen($smiles);

        while ($i < $len) {
            $ch = $smiles[$i];

            if ($ch === '/' || $ch === '\\' || $ch === '-') {
                $bondType = 1; $i++; continue;
            }
            if ($ch === '=') { $bondType = 2; $i++; continue; }
            if ($ch === '#') { $bondType = 3; $i++; continue; }
            if ($ch === ':') { $bondType = 4; $i++; continue; }
            if ($ch === '.') { $prev = -1; $bondType = null; $i++; continue; }

            if ($ch === '(') { $stack[] = $prev; $i++; continue; }
            if ($ch === ')') { $prev = array_pop($stack); $bondType = null; $i++; continue; }

            if ($ch === '%' && $i + 2 < $len) {
                $rn = intval(substr($smiles, $i + 1, 2));
                $i += 3;
                self::handleRing($rn, $prev, $bondType, $atoms, $bonds, $ringOpenings);
                $bondType = null;
                continue;
            }

            if (ctype_digit($ch)) {
                self::handleRing(intval($ch), $prev, $bondType, $atoms, $bonds, $ringOpenings);
                $bondType = null;
                $i++;
                continue;
            }

            if ($ch === '[') {
                $end = strpos($smiles, ']', $i);
                if ($end === false) return null;
                $atom = self::parseBracketAtom(substr($smiles, $i + 1, $end - $i - 1));
                $idx = count($atoms);
                $atoms[] = $atom;
                self::addBond($prev, $idx, $bondType, $atoms, $bonds);
                $prev = $idx;
                $bondType = null;
                $i = $end + 1;
                continue;
            }

            $atom = self::parseOrganicAtom($smiles, $i, $newI);
            if ($atom !== null) {
                $idx = count($atoms);
                $atoms[] = $atom;
                self::addBond($prev, $idx, $bondType, $atoms, $bonds);
                $prev = $idx;
                $bondType = null;
                $i = $newI;
                continue;
            }

            $i++;
        }

        if (empty($atoms)) return null;
        return ['atoms' => $atoms, 'bonds' => $bonds];
    }

    private static function handleRing($ringNum, $currentAtom, $bondType, &$atoms, &$bonds, &$ringOpenings)
    {
        if (isset($ringOpenings[$ringNum])) {
            $other = $ringOpenings[$ringNum]['atom'];
            $bt = $bondType ?? $ringOpenings[$ringNum]['bond'] ?? null;
            if ($bt === null) {
                $bt = ($atoms[$other]['aromatic'] && $atoms[$currentAtom]['aromatic']) ? 4 : 1;
            }
            $bonds[] = [$other, $currentAtom, $bt];
            unset($ringOpenings[$ringNum]);
        } else {
            $ringOpenings[$ringNum] = ['atom' => $currentAtom, 'bond' => $bondType];
        }
    }

    private static function addBond($from, $to, $bondType, &$atoms, &$bonds)
    {
        if ($from < 0) return;
        if ($bondType === null) {
            $bondType = ($atoms[$from]['aromatic'] && $atoms[$to]['aromatic']) ? 4 : 1;
        }
        $bonds[] = [$from, $to, $bondType];
    }

    private static function parseOrganicAtom($smiles, $pos, &$newPos)
    {
        $len = strlen($smiles);
        $ch = $smiles[$pos];

        if ($pos + 1 < $len) {
            $two = $ch . $smiles[$pos + 1];
            if (in_array($two, ['Cl', 'Br', 'Si', 'Se', 'As', 'Te', 'Ge', 'Sn'])) {
                $newPos = $pos + 2;
                return ['element' => $two, 'aromatic' => false];
            }
        }

        if (in_array($ch, ['b', 'c', 'n', 'o', 'p', 's'])) {
            $newPos = $pos + 1;
            return ['element' => strtoupper($ch), 'aromatic' => true];
        }

        if (in_array($ch, ['B', 'C', 'N', 'O', 'P', 'S', 'F', 'I'])) {
            $newPos = $pos + 1;
            return ['element' => $ch, 'aromatic' => false];
        }

        return null;
    }

    private static function parseBracketAtom($content)
    {
        $i = 0;
        $len = strlen($content);
        $aromatic = false;
        $element = '';

        while ($i < $len && ctype_digit($content[$i])) $i++;

        if ($i < $len) {
            if (ctype_lower($content[$i])) {
                $aromatic = true;
                $element = strtoupper($content[$i]);
                $i++;
            } elseif (ctype_upper($content[$i])) {
                $element = $content[$i];
                $i++;
                if ($i < $len && ctype_lower($content[$i])) {
                    $element .= $content[$i];
                    $i++;
                }
            }
        }

        return ['element' => $element, 'aromatic' => $aromatic];
    }

    // ================================================================
    //  JME PARSER
    // ================================================================

    public static function parseJME($jme)
    {
        if (empty($jme)) return null;
        $parts = preg_split('/\s+/', trim($jme));
        if (count($parts) < 2) return null;

        $nAtoms = intval($parts[0]);
        $nBonds = intval($parts[1]);
        if ($nAtoms <= 0) return null;
        if (count($parts) < 2 + $nAtoms * 3 + $nBonds * 3) return null;

        $atoms = [];
        $idx = 2;
        for ($a = 0; $a < $nAtoms; $a++) {
            $raw = $parts[$idx];

            if (($cp = strpos($raw, ':')) !== false) {
                $raw = substr($raw, 0, $cp);
            }
            $raw = rtrim($raw, '+-');
            if (strlen($raw) > 0 && $raw[0] === '[' && $raw[strlen($raw) - 1] === ']') {
                $raw = substr($raw, 1, -1);
            }

            $el = '';
            for ($c = 0; $c < strlen($raw); $c++) {
                if (ctype_alpha($raw[$c])) $el .= $raw[$c];
                else break;
            }
            if (empty($el)) $el = 'C';
            $el = ucfirst(strtolower($el));

            $atoms[] = ['element' => $el, 'aromatic' => false];
            $idx += 3;
        }

        $bonds = [];
        for ($b = 0; $b < $nBonds; $b++) {
            if ($idx + 2 >= count($parts)) break;
            $from = intval($parts[$idx]) - 1;
            $to = intval($parts[$idx + 1]) - 1;
            $bt = intval($parts[$idx + 2]);
            if ($bt < 0) $bt = 1;
            $bonds[] = [$from, $to, $bt];
            $idx += 3;
        }

        if (empty($atoms)) return null;
        return ['atoms' => $atoms, 'bonds' => $bonds];
    }

    // ================================================================
    //  SUBSTRUCTURE MATCHING (VF2 simplificado)
    // ================================================================

    /**
     * @param bool $relaxAromatic  false=estricto (SMILES vs SMILES), true=relajado (vs JME)
     */
    public static function hasMatch($query, $target, $relaxAromatic = false)
    {
        return !empty(self::findMatches($query, $target, true, $relaxAromatic));
    }

    public static function getAllMatches($query, $target, $relaxAromatic = false)
    {
        return self::findMatches($query, $target, false, $relaxAromatic);
    }

    private static function findMatches($query, $target, $firstOnly, $relaxAromatic)
    {
        $nQ = count($query['atoms']);
        $nT = count($target['atoms']);
        if ($nQ === 0 || $nQ > $nT) return [];

        // Pre-filtro: ¿hay suficientes átomos de cada elemento?
        $qCounts = [];
        $tCounts = [];
        foreach ($query['atoms'] as $a) {
            $k = $a['element'];
            $qCounts[$k] = ($qCounts[$k] ?? 0) + 1;
        }
        foreach ($target['atoms'] as $a) {
            $k = $a['element'];
            $tCounts[$k] = ($tCounts[$k] ?? 0) + 1;
        }
        foreach ($qCounts as $k => $c) {
            if (($tCounts[$k] ?? 0) < $c) return [];
        }

        $qAdj = self::buildAdj($query);
        $tAdj = self::buildAdj($target);

        // Pre-computar candidatos
        $candidates = [];
        for ($qi = 0; $qi < $nQ; $qi++) {
            $candidates[$qi] = [];
            for ($ti = 0; $ti < $nT; $ti++) {
                if (self::atomsCompatible($query['atoms'][$qi], $target['atoms'][$ti], $relaxAromatic)) {
                    $candidates[$qi][] = $ti;
                }
            }
            if (empty($candidates[$qi])) return [];
        }

        $order = self::matchOrder($query, $qAdj);

        $matches = [];
        $mapping = [];
        $usedTarget = [];

        self::matchRecurse(
            $query, $target, $qAdj, $tAdj, $candidates,
            $order, 0, $nQ,
            $mapping, $usedTarget, $matches, $firstOnly, $relaxAromatic
        );

        return self::uniquifyMatches($matches);
    }

    private static function matchOrder($query, $qAdj)
    {
        $nQ = count($query['atoms']);
        if ($nQ <= 1) return range(0, $nQ - 1);

        $degrees = array_map('count', $qAdj);
        $start = array_keys($degrees, max($degrees))[0];

        $order = [];
        $visited = [];
        $queue = [$start];
        $visited[$start] = true;

        while (!empty($queue)) {
            $node = array_shift($queue);
            $order[] = $node;
            $neighbors = array_keys($qAdj[$node]);
            usort($neighbors, function ($a, $b) use ($degrees) {
                return $degrees[$b] - $degrees[$a];
            });
            foreach ($neighbors as $nb) {
                if (!isset($visited[$nb])) {
                    $visited[$nb] = true;
                    $queue[] = $nb;
                }
            }
        }

        for ($i = 0; $i < $nQ; $i++) {
            if (!isset($visited[$i])) {
                $order[] = $i;
            }
        }

        return $order;
    }

    private static function matchRecurse(
        $query, $target, $qAdj, $tAdj, $candidates,
        $order, $depth, $nQ,
        &$mapping, &$usedTarget, &$matches, $firstOnly, $relaxAromatic
    ) {
        if ($firstOnly && !empty($matches)) return;

        if ($depth === $nQ) {
            $result = array_fill(0, $nQ, -1);
            foreach ($mapping as $qi => $ti) {
                $result[$qi] = $ti;
            }
            $matches[] = $result;
            return;
        }

        $qi = $order[$depth];

        foreach ($candidates[$qi] as $ti) {
            if (isset($usedTarget[$ti])) continue;

            $ok = true;
            foreach ($qAdj[$qi] as $qNeighbor => $qBondType) {
                if (!isset($mapping[$qNeighbor])) continue;
                $tNeighbor = $mapping[$qNeighbor];
                if (!isset($tAdj[$ti][$tNeighbor])) {
                    $ok = false;
                    break;
                }
                if (!self::bondsCompatible($qBondType, $tAdj[$ti][$tNeighbor], $relaxAromatic)) {
                    $ok = false;
                    break;
                }
            }
            if (!$ok) continue;

            $mapping[$qi] = $ti;
            $usedTarget[$ti] = true;

            self::matchRecurse(
                $query, $target, $qAdj, $tAdj, $candidates,
                $order, $depth + 1, $nQ,
                $mapping, $usedTarget, $matches, $firstOnly, $relaxAromatic
            );

            unset($mapping[$qi]);
            unset($usedTarget[$ti]);

            if ($firstOnly && !empty($matches)) return;
        }
    }

    private static function buildAdj($graph)
    {
        $n = count($graph['atoms']);
        $adj = array_fill(0, $n, []);
        foreach ($graph['bonds'] as $b) {
            $adj[$b[0]][$b[1]] = $b[2];
            $adj[$b[1]][$b[0]] = $b[2];
        }
        return $adj;
    }

    /**
     * Compatibilidad de átomos.
     * Estricto: elemento Y aromaticidad deben coincidir.
     * Relajado: solo elemento (JME no marca aromaticidad).
     */
    private static function atomsCompatible($qAtom, $tAtom, $relaxAromatic)
    {
        if ($qAtom['element'] !== $tAtom['element']) return false;

        if ($relaxAromatic) {
            // Relajado (vs JME): ignorar aromaticidad, JME nunca la marca
            return true;
        }

        // Estricto (SMILES vs SMILES): aromaticidad debe coincidir
        if ($qAtom['aromatic'] !== $tAtom['aromatic']) return false;
        return true;
    }

    /**
     * Compatibilidad de enlaces.
     * Estricto: tipo debe coincidir, pero aromático(4) también acepta doble(2) por Kekulé.
     * Relajado: aromático(4) acepta simple(1) o doble(2) para JME.
     */
    private static function bondsCompatible($qType, $tType, $relaxAromatic)
    {
        if ($qType === $tType) return true;

        if ($relaxAromatic) {
            // Relajado (vs JME): aromático matchea simple o doble
            if ($qType === 4 && ($tType === 1 || $tType === 2)) return true;
            return false;
        }

        // Estricto (SMILES vs SMILES):
        // aromático(4) ↔ doble(2) para compatibilidad Kekulé
        // (c1ccccc1 debe matchear C1=CC=CC=C1)
        if ($qType === 4 && $tType === 2) return true;
        if ($qType === 2 && $tType === 4) return true;
        // aromático(4) ↔ simple(1) también para Kekulé (enlaces simples alternos)
        if ($qType === 4 && $tType === 1) return true;
        if ($qType === 1 && $tType === 4) return true;

        return false;
    }

    private static function uniquifyMatches($matches)
    {
        $unique = [];
        $seen = [];
        foreach ($matches as $m) {
            $sorted = $m;
            sort($sorted);
            $key = implode(',', $sorted);
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $unique[] = $m;
            }
        }
        return $unique;
    }
}
