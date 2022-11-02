<?php

return 
[
    [ //first documentation path
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
                    'label' => 'Export'
                ],
                [
                    'id' => 'invalid',
                    'file' => 'index',
                    'label' => 'Invalid'
                ]
            ],
            'Features' => [
                [
                    'id' => 'sso',
                    'file' => 'export',
                    'label' => 'SSO'
                ]
            ]
        ]
    ],
    [//second documentation path
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
