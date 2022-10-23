<?php

return [
    'logo_url' => 'https://blogs.hyvor.com/img/logo.png', //logo image url
    'brand_name' => 'My Blog', //your blog name
    'main_link' => '', //redirect link when click on logo
   
    'theme' => 'default', //not yet implemented
    'app_url' => 'docs', //your app url
    'content_files_path' => 'docs/pages', //md files path
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
