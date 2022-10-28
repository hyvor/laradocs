<?php

return 
[
    'laradocs' => [
        'name' => 'laradocs',
        'theme' => 'theme',//theme css file name
        'content_directory' => 'docs/laradocs',//md files path
        'navigation' => [
            'Intro' => [
                [null, 'Getting Started'],
                ['export', 'Export'],
                ['invalid', 'Invalid']
            ],
            'Features' => [
                ['sso', 'SSO'],
            ]
        ]
    ],
    'docsv3' => [
        'name' => 'docsv3',
        'theme' => 'theme',//theme css file name
        'content_directory' => 'docs/sample',//md files path
        'navigation' => [
            'Intro' => [
                [null, 'Getting Started']
            ],
            'Features' => [
                ['premium', 'Premium'],
                ['business', 'Business']
            ]
        ]
   ]
];
