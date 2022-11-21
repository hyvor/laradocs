<?php

return [
    [
        'route' => 'docsv3',
        'view' => null,
        'content_directory' => 'tests/contents',
        'navigation' => [
            'Getting Started' => [
                [
                    'id' => '',
                    'label' => 'Introduction'
                ],
                [
                    'id' => 'install',
                    'label' => 'Installing'
                ],
                [
                    'id' => 'custom',
                    'file' => 'install',
                    'label' => 'custom file'
                ]
            ]
        ]
    ]
];