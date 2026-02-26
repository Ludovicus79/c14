<?php

namespace App\Http\Controllers;

use App\Carbon;
use App\Http\Requests\Request;
use App\Molecule;

class SpectrumController extends Controller
{
   
    public function get($id) {
        //Alturas de los carbonos
        $size = [
            'C' => 50,
            'CH' => 120,
            'CH2' => 100,
            'CH3' => 110,
        ];

        $data['molecule'] = Molecule::find($id);
        // Orden corregido: 0=lower (todos), 1=middle (CH), 2=top (CH,CH2,CH3)
        $data['charts'][] = $this->getLowerChart($id, $size);    // índice 0 - Todos los tipos
        $data['charts'][] = $this->getMiddleChart($id, $size);   // índice 1 - Solo CH
        $data['charts'][] = $this->getTopChart($id, $size);      // índice 2 - CH, CH2, CH3
        
        if(isset($_GET['atomos'])){
            $data['atomos']=$_GET['atomos'];
        }

        return view('search.spectrum', $data);
    }

    /**
     * Muestra la vista 3D de un espectro CON MOLÉCULA 3D
     */
    public function spectrum3d($id) {
        $molecule = Molecule::find($id);
        
        if (!$molecule) {
            abort(404, 'Molecule not found');
        }
        
        $chartType = request()->get('chart', 'top');
        
        // Obtener datos de carbonos
        $carbons = Carbon::select('shift', 'num2', 'carbonType')
            ->where('molecularId', $id)
            ->where('shift', '<>', '-9999')
            ->orderBy('shift', 'asc')
            ->get();
        
        // Preparar datos para el gráfico
        $chartData = $this->prepareChartDataFor3D($carbons, $chartType);
        
        // Buscar estructura 3D desde PubChem
        $mol3D = $this->get3DFromPubChem($molecule->name);
        
        // Si no encuentra por nombre, intentar por fórmula
        if (!$mol3D && $molecule->molecularFormula) {
            $mol3D = $this->get3DFromPubChem($molecule->molecularFormula);
        }
        
        return view('search.spectrum3d', [
            'molecule' => $molecule,
            'chartData' => $chartData,
            'chartType' => $chartType,
            'mol3D' => $mol3D,
            'has3D' => !is_null($mol3D)
        ]);
    }

    /**
     * Obtiene estructura 3D desde PubChem
     */
    private function get3DFromPubChem($name) {
        if (empty($name)) return null;
        
        try {
            $url = "https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/" . 
                   urlencode($name) . "/SDF?record_type=3d";
            
            $context = stream_context_create([
                'http' => ['timeout' => 10]
            ]);
            
            $sdf = @file_get_contents($url, false, $context);
            
            if ($sdf && strpos($sdf, 'V2000') !== false) {
                return $sdf;
            }
            
            return null;
            
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Prepara los datos del gráfico para la vista 3D
     */
    private function prepareChartDataFor3D($carbons, $chartType) {
        $data = [
            'series' => []
        ];
        
        // Tamaños por defecto
        $size = [
            'C' => 50,
            'CH' => 120,
            'CH2' => 100,
            'CH3' => 110,
        ];
        
        switch($chartType) {
            case 'top':
                // CH, CH2, CH3
                $types = ['CH', 'CH2', 'CH3'];
                foreach($types as $type) {
                    $filtered = $carbons->where('carbonType', $type);
                    if($filtered->count() > 0) {
                        $data['series'][] = [
                            'name' => $type,
                            'data' => $filtered->map(function($c) use ($size) {
                                return [
                                    'x' => floatval($c->shift), 
                                    'y' => $size[$c->carbonType],
                                    'id' => $c->num2
                                ];
                            })->values()->all()
                        ];
                    }
                }
                break;
                
            case 'middle':
                // Solo CH
                $filtered = $carbons->where('carbonType', 'CH');
                if($filtered->count() > 0) {
                    $data['series'][] = [
                        'name' => 'CH',
                        'data' => $filtered->map(function($c) use ($size) {
                            return [
                                'x' => floatval($c->shift), 
                                'y' => $size[$c->carbonType],
                                'id' => $c->num2
                            ];
                        })->values()->all()
                    ];
                }
                break;
                
            case 'lower':
                // Todos los tipos
                $types = ['CH3', 'CH2', 'CH', 'C'];
                foreach($types as $type) {
                    $filtered = $carbons->where('carbonType', $type);
                    if($filtered->count() > 0) {
                        $data['series'][] = [
                            'name' => $type,
                            'data' => $filtered->map(function($c) use ($size) {
                                return [
                                    'x' => floatval($c->shift), 
                                    'y' => $size[$c->carbonType] ?? 100,
                                    'id' => $c->num2
                                ];
                            })->values()->all()
                        ];
                    }
                }
                break;
        }
        
        return $data;
    }

    /**
     * Devuelve la formula con formato
     * @param $molecule
     * @return string
     */
    public function getFormula($molecule) {
        $form = "";
        for ($i = 0; $i < strlen($molecule->molecularFormula); $i++) {
            if (is_numeric(substr($molecule->molecularFormula, $i, 1))) {
                $form .= "<sub>".substr($molecule->molecularFormula, $i, 1)."</sub>";
            } else {
                $form .= substr($molecule->molecularFormula, $i, 1);
            }
        }
        return $form;
    }

    /**
     * Devuelve el disolvente a partir de la letra de la base de datos
     * @param $char
     * @return string
     */
    public function getThinner($char) {
        if(strpos(trans('applicationResource.solvent.'.$char), 'applicationResource') != null) {
            return $char;
        }
        else {
            return trans('applicationResource.solvent.'.$char);
        }
    }

    /**
     * Devuelve el grafico que representa todos los datos
     * @param $id
     * @param $size
     * @return array
     */
    public function getLowerChart($id, $size) {
        //Cogemos los datos para esta grafica
        $data = $this->getChartData($id, $size, 1, false);

        foreach($data as $key) {
            $series[] = $key;
        }
        if($this->getDataSolvent($id, 1))
            $series[] = $this->getDataSolvent($id, 1);

        //Configuracion de la grafica CON OPCIONES 3D
        return [
            'renderTo' => 'lowerLinechart',
            'type' => 'column',
            'title' => null,
            'tooltip' => [
                'headerFormat' => '',
                'pointFormat' => '<b>{point.x}</b> ppm<br/><b>Num: {point.id}</b><br/>'
            ],
            'zoomType' => 'xy',
            'options3d' => [
                'enabled' => true,
                'alpha' => 15,
                'beta' => 15,
                'depth' => 50,
                'viewDistance' => 25
            ],
            'xAxis' => [
                'reversed' => true,
                'title' => ['text' => trans('applicationResource.molecule.shift').' (ppm)'],
                'min' => 0,
                'max' => 235,
                'tickInterval' => 20
            ],
            'yAxis' => [
                'labels' => ['enabled' => false],
                'title' => ['text' => null]
            ],
            'plotOptions' => [
                'column' => [
                    'depth' => 25,
                    'groupPadding' => 0.1,
                    'pointPadding' => 0.05,
                    'borderWidth' => 0,
                    'dataLabels' => [
                        'enabled' => true,
                        'rotation' => -45,
                        'y' => -20,
                        'crop' => false,
                        'overflow' => 'none',
                        'format' => '{x}'
                    ]
                ]
            ],
            'series' => $series
        ];
    }

    /**
     * Devuelve el grafico que representa solo los CH
     * @param $id
     * @param $size
     * @return array
     */
    public function getMiddleChart($id, $size) {
        //Cogemos los datos para esta grafica
        $data = $this->getChartData($id, $size, 1, false);
        $series[] = $data['CH'];

        //Configuracion de la grafica CON OPCIONES 3D
        return [
            'renderTo' => 'middleLinechart',
            'type' => 'column',
            'title' => null,
            'tooltip' => [
                'headerFormat' => '',
                'pointFormat' => '<b>{point.x}</b> ppm<br/><b>Num: {point.id}</b><br/>'
            ],
            'zoomType' => 'xy',
            'options3d' => [
                'enabled' => true,
                'alpha' => 15,
                'beta' => 15,
                'depth' => 50,
                'viewDistance' => 25
            ],
            'xAxis' => [
                'reversed' => true,
                'title' => ['text' => trans('applicationResource.molecule.shift').' (ppm)'],
                'min' => 0,
                'max' => 235,
                'tickInterval' => 20
            ],
            'yAxis' => [
                'labels' => ['enabled' => false],
                'title' => ['text' => null]
            ],
            'plotOptions' => [
                'column' => [
                    'depth' => 25,
                    'groupPadding' => 0.1,
                    'pointPadding' => 0.05,
                    'borderWidth' => 0,
                    'dataLabels' => [
                        'enabled' => true,
                        'rotation' => -45,
                        'y' => -20,
                        'crop' => false,
                        'overflow' => 'none',
                        'format' => '{x}'
                    ]
                ]
            ],
            'series' => $series
        ];
    }

    /**
     * Devuelve el grafico que representa los CH, CH2 y CH3
     * @param $id
     * @param $size
     * @return array
     */
    public function getTopChart($id, $size) {
        //Cogemos los datos para esta grafica
        $data = $this->getChartData($id, $size, 1, false);

        $series[] = $data['CH'];
        $series[] = $data['CH2'];
        $series[] = $data['CH3'];

        //Configuracion de la grafica CON OPCIONES 3D
        return [
            'renderTo' => 'topLinechart',
            'type' => 'column',
            'title' => null,
            'tooltip' => [
                'headerFormat' => '',
                'pointFormat' => '<b>{point.x}</b> ppm<br/><b>Num: {point.id}</b><br/>'
            ],
            'zoomType' => 'xy',
            'options3d' => [
                'enabled' => true,
                'alpha' => 15,
                'beta' => 15,
                'depth' => 50,
                'viewDistance' => 25
            ],
            'xAxis' => [
                'reversed' => true,
                'title' => ['text' => trans('applicationResource.molecule.shift').' (ppm)'],
                'min' => 0,
                'max' => 235,
                'tickInterval' => 20
            ],
            'yAxis' => [
                'labels' => ['enabled' => false],
                'title' => ['text' => null]
            ],
            'plotOptions' => [
                'column' => [
                    'depth' => 25,
                    'groupPadding' => 0.1,
                    'pointPadding' => 0.05,
                    'borderWidth' => 0,
                    'dataLabels' => [
                        'enabled' => true,
                        'rotation' => -45,
                        'y' => -20,
                        'crop' => false,
                        'overflow' => 'none',
                        'format' => '{x}'
                    ]
                ]
            ],
            'series' => $series
        ];
    }

    /**
     * Devuelve los datos para la grafica
     * @param $id
     * @param $size
     * @param $height
     * @param $isSolvent
     * @return array
     */
    public function getChartData($id, $size, $height, $isSolvent) {
        $carbons = Carbon::where('molecularId', $id)->where('shift', '<>', '-9999')->orderBy('shift', 'asc')->get();
        $data = [];
        foreach($carbons as $carbon) {
            $point = [
                'x' => floatval($carbon->shift),
                'y' => $size[$carbon->carbonType],
                'id' => $carbon->num2,
                'indexes' => [$carbon->num2]
            ];
            
            if(!isset($data[$carbon->carbonType])) {
                $data[$carbon->carbonType] = [
                    'name' => $carbon->carbonType,
                    'data' => []
                ];
            }
            $data[$carbon->carbonType]['data'][] = $point;
        }
        return $data;
    }

    /**
     * Devuelve los datos del solvente
     * @param $id
     * @param $height
     * @return array|null
     */
    public function getDataSolvent($id, $height) {
        $carbons = Carbon::where('molecularId', $id)->where('shift', '-9999')->get();
        if($carbons->count() == 0) return null;
        
        $data = [];
        foreach($carbons as $carbon) {
            $data[] = [
                'x' => 0,
                'y' => $height,
                'id' => $carbon->num2,
                'indexes' => [$carbon->num2]
            ];
        }
        
        return [
            'name' => 'Solvent',
            'data' => $data
        ];
    }
/**
 * Muestra SOLO la molécula en 3D (sin espectro)
 */
public function molecule3d($id) {
    $molecule = Molecule::find($id);
    
    if (!$molecule) {
        abort(404, 'Molecule not found');
    }
    
    return view('search.molecule3d', [
        'molecule' => $molecule
    ]);
}
    }
