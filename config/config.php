<?php

return 
[
    'laradocs' => [ //first documentation path
        'name' => 'laradocs',
        'theme' => 'theme',//theme css file name
        'content_directory' => 'docs/laradocs',//md files path
        'navigation' => [
            'Intro' => [
                ['', 'Getting Started'],
                ['export', 'Export'],
                ['invalid', 'Invalid']
            ],
            'Features' => [
                ['sso', 'SSO'],
            ]
        ]
    ],
    'docsv3' => [//second documentation path
        'name' => 'docsv3',
        'theme' => 'theme',//theme css file name
        'content_directory' => 'docs/sample',//md files path
        'navigation' => [
            'Intro' => [
                ['', 'Getting Started']
            ],
            'Features' => [
                ['premium', 'Premium'],
                ['business', 'Business']
            ]
        ]
   ]
];
