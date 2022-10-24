<?php

return [
    'app_url' => 'laradocs', //your app url
    'content_files_path' => 'docs/pages', //md files path
    'brand_name' => 'Laradocs', //your blog name
    'logo_url' => 'https://blogs.hyvor.com/img/logo.png', //logo image url
    'main_link' => '/laradocs', //redirect link when click on logo
   
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
