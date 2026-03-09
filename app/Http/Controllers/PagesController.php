<?php

namespace App\Http\Controllers;

use App;
use App\Author;
use App\Http\Requests;

class PagesController extends Controller
{
    public function contributors()
    {
        $contributors = Author::all();
        return view('contributors', compact('contributors'));
    }

    public function conditions()
    {
        return view('conditions');
    }

    public function acknow()
    {
        return view('acknowledgment');
    }

    public function help()
    {
        return view('help/help');
    }

    public function developers() {
        return view('developers');
    }

     public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function rssFeed()
    {
        // Europe PMC — artículos relacionados con NAPROC-13 y el grupo USAL
        $query  = urlencode(
            '(NAPROC-13 OR NAPROC13 OR "natural products 13C NMR database")'
            . ' OR ("13C NMR" AND "natural products" AND Salamanca)'
        );
        $apiUrl = 'https://www.ebi.ac.uk/europepmc/webservices/rest/search'
                . '?query=' . $query
                . '&format=json&resultType=lite&pageSize=6&sort=P_PDATE_D+desc';

        $items = [];
        $error = null;
        $raw   = false;

        // cURL
        if (function_exists('curl_init')) {
            $ch = curl_init($apiUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_USERAGENT      => 'NAPROC-13/1.0 (research; contact@usal.es)',
                CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            ]);
            $raw      = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if (!$raw || $httpCode !== 200) {
                $raw = false;
            }
        }

        // Fallback file_get_contents
        if (!$raw && ini_get('allow_url_fopen')) {
            $ctx = stream_context_create([
                'http' => [
                    'timeout'    => 8,
                    'user_agent' => 'NAPROC-13/1.0',
                    'header'     => 'Accept: application/json',
                ],
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
            ]);
            $raw = @file_get_contents($apiUrl, false, $ctx) ?: false;
        }

        if (!$raw) {
            $error = 'No se pudo conectar con Europe PMC.';
        } else {
            $data = json_decode($raw, true);
            if (!$data || !isset($data['resultList']['result'])) {
                $error = 'Respuesta inesperada de la API.';
            } else {
                foreach ($data['resultList']['result'] as $pub) {
                    // Limpiar título: decodificar entidades HTML y quitar etiquetas
                    $rawTitle = trim($pub['title'] ?? '');
                    $title    = strip_tags(html_entity_decode($rawTitle, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                    $title    = trim(rtrim($title, '.')) . '.'; // normalizar punto final

                    $pmid  = $pub['pmid']   ?? '';
                    $doi   = $pub['doi']    ?? '';
                    $year  = (string)($pub['pubYear'] ?? '');
                    $type  = strtolower($pub['pubType'] ?? '');

                    // Saltar resultados sin título real o tipo congreso/poster
                    if (!$title || strlen($title) < 15) continue;
                    if (in_array($type, ['poster', 'meeting abstract', 'conference'])) continue;
                    if (!$doi && !$pmid) continue; // sin link real, probablemente basura

                    if ($doi) {
                        $link = 'https://doi.org/' . $doi;
                    } elseif ($pmid) {
                        $link = 'https://pubmed.ncbi.nlm.nih.gov/' . $pmid;
                    } else {
                        $link = 'https://europepmc.org/search?query=' . urlencode($title);
                    }

                    $items[] = ['title' => $title, 'link' => $link, 'year' => $year];

                    if (count($items) >= 4) {
                        break;
                    }
                }
                if (empty($items)) {
                    $error = 'No se encontraron publicaciones.';
                }
            }
        }

        return response()->json(['items' => $items, 'error' => $error]);
    }
}