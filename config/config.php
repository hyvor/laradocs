<?php

return [
    'app_url' => 'documents', //your app url
    'content_files_path' => 'docs/pages', //md files path
    'brand_name' => 'My Blog', //your blog name
    'logo_url' => 'https://blogs.hyvor.com/img/logo.png', //logo image url
    'main_link' => '/documents', //redirect link when click on logo
   
    'theme' => 'theme', //theme css file name

    'nav' => [
        'Intro' => [
            [null, 'Getting Started'],
            ['export', 'Export'],
            ['invalid', 'Invalid']
        ],
        'Features' => [
            ['sso', 'SSO'],
        ]
    ]
];
