<?php

return [
    'docs_route' => 'docs', //default (resources/docs)
    'theme' => 'default',
    'views_path' => 'docs/pages',
    'nav' => [
        'Intro' => [
            [null, 'Getting Started'],
            ['writing', 'Writing'],
            ['theme', 'Theme'],
            ['how', 'How it works'],
        ],
        'Features' => [
            ['users', 'Users'],
            ['tags', 'Tags'],
            ['languages', 'Languages'],
            ['media', 'Media'],
            ['sso', 'Custom Domain'],
        ]
    ]
];
