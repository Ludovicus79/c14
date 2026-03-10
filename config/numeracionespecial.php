<?php

return [
    'families' => [
        // 'Familia-Generica' => [
        //     'global' => "",
        //     'groups' => [
        //         'global' => "",
        //         'Tipo-cualquiera' => [
        //             'global' => "",
        //             'types' => [
        //                 'Grupo-cualquiera' => [
        //                 ],
        //             ],
        //         ],
        //     ],
        // ],
        'Alkaloids' => [
            'groups' => [
                'Acridones' => [
                    'global' => "1,2,3,4,4a,5,6,7,8,8a,9,9a,10a",
                ],
                'Pyrrolizidines' => [
                    'global' => "1,2,3,5,6,7,7a,8",
                ],
                'Pyrimidin_Quinoxalines' => [
                    'global' => "2,4,4a,5a,6,7,8,9,9a,10a",
                ],
                ' Indolopyridoquinazolines' => [
                    'global' => "1,1a,2,3,4,4a,5,7,8,8a,8b,9,10,11,12,12a,13a",
                ],
                'Indolo-quinolines' => [
                    'global' => "1,2,3,4,4a,5a,5b,6,7,8,9,9a,10a,11,11a",
                ],
                'Indolizidines' => [
                    'global' => "1,2,3,5,6,7,8,8a",
                ],
                'Aporphines' => [
                    'global' => "1,2,3,3a,4,5,6a,7,7a,8,9,10,11,11a,11b,11c",
                ],
                'Pyrrolo[d,e]phenanthridines' => [
                    'global' => "1,2,3,4,4a,6,6a,7,8,9,10,10a,10b",
                ],
                'Benzo[c][2,7]naphthyridines' => [
                    'global' => "1,3,4,4a,4b,5,6,7,8,8a,10,10a",
                ],
                'Carbazoles' => [
                    'global' => "1,2,3,4,4a,4b,5,6,7,8,8a,9a",
                ],
                'β-Carbolines' => [
                    'global' => "1,3,4,4a,4b,5,6,7,8,8a,9a",
                ],
                'Quinolines' => [
                    'types' => [
                       'Furo-quinolines' => "2,3,3a,4,4a,5,6,7,8,8a,9a",
                    ],
                ],
            ],
        ],
        'Aromatics' => [
            'groups' => [
                'Anthraquinones' => [
                    'global' => "1,2,3,4,4a,5,6,7,8,8a,9,9a,10,10a",
                    'types' => [
                        'Angucyclines' => "1,2,3,4,4a,5,6,6a,7,7a,8,9,10,11,11a,12,12a,12b,13",
                        'Anthraquinones' => "1,2,3,4,4a,5,6,7,8,8a,9,9a,10,10a",
                        '1-Azaanthraquinones' => "2,3,4,4a,5,6,7,8,8a,9,9a,10,10a",
                        '2-Azaanthraquinones' => "1,3,4,4a,5,6,7,8,8a,9,9a,10,10a",
                        'Pluramycins' => "2,3,4,4a,5,6,6a,7,7a,8,9,10,11,11a,12,12a,12b",
                    ],
                ],
                'Pyrenees' => [
                    'global' => "1,2,3,3a,4,5,5a,6,7,8,8a,9,10,10a,10b,10c",
                ],
                'Stilbenes' => [
                    'global' => "1,2,3,4,5,6,101,102,103,104,105,106,91,92",
                ],
                'Xanthones' => [
                    'global' => "1,2,3,4,4a,5,6,7,8,8a,9,9a,10a",
                    'types' => [
                        'Benzoxanthones' => "1,2,3,4,4a,5,6,6a,7a,8,9,10,11,11a,12,12a,12b",
                    ],
                ],
                // 'Tetracyclines' => [
                //     'global' => "",
                // ],
            ],
        ],
        'Chromans' => [
            'groups' => [
                'Chromones' => [
                    'global' => "1,2,3,4,4a,5,6,7,8,8a,9,9a,10,10a",
                    'types' => [
                        'Benzochromones' => "1,2,3,4,4a,5,6,6a,7,7a,8,9,10,11,11a,12,12a,12b,13",
                    ],
                ],
            ],
        ],
        'Flavonoids' => [
            'groups' => [
                'Coumestrans' => "1,2,3,4,4a,6,6a,6b,7,8,9,10,10a,10b,11a,11b",
                'Flavaglines' => "1,2,3,3a,4a,5,6,7,8,8a,8b",
                'Pterocarpanoids' => "1,2,3,4,4a,6,6a,6b,7,8,9,10,10a,11a,11b",
                'Rotenoids' => "1,1a,2,3,4,4a,6,6a,7a,8,9,10,11,11a,12,12a",
            ],
        ],
    ],
];
