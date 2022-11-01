<?php

return 
[
    'laradocs' => [ //first documentation path
        'route' => 'laradocs',
        'theme' => 'theme',//theme css file name
        'content_directory' => 'docs/laradocs',//md files path
        'navigation' => [
            'Intro' => [
                [
                    'id' => '',
                    'label' => 'Getting Started'
                ],
                [
                    'id' => 'export',
                    'file' => 'ex',
                    'label' => 'Export'
                ],
                [
                    'id' => 'invalid',
                    'file' => 'inv',
                    'label' => 'Invalid'
                ]
            ],
            'Features' => [
                [
                    'id' => 'sso',
                    'label' => 'SSO'
                ]
            ]
        ]
    ],
    'docsv3' => [//second documentation path
        'route' => 'docsv3',
        'theme' => 'theme',//theme css file name
        'content_directory' => 'docs/sample',//md files path
        'navigation' => [
            'Intro' => [
                [
                    'id' => '',
                    'label' => 'Getting Started'
                ]
            ],
            'Features' => [
                [
                    'id' => 'sso',
                    'label' => 'SSO'
                ]
            ]
        ]
   ]
];
