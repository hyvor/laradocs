<?php

return [
    'content_directory' => 'docs', //md files path
    'theme' => 'theme', //theme css file name

    //Define your navigations here
    'nav' =>[
        'laradocs' => [//first documentation
            'Intro' => [
                [null, 'Getting Started'],
                ['export', 'Export'],
                ['invalid', 'Invalid']
            ],
            'Features' => [
                ['sso', 'SSO'],
            ]
        ],
        'sample' => [//second documentation
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
