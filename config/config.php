<?php

return 
[
    [
        /**
         * @required
         * The subdomain given by Laradocs to the documentation
         */
        'route' => '',
        /**
         * @optional
         * The theme file name of your documentation(without .css extention)
         */
        'view' => null,
         /**
         * @required
         * where should we host your content files? path should be set from your application base path.
         */
        'content_directory' => '',
        /**
         * @required
         * How is your document navigation should looks like?
         * It should have section and each section link should have id,file,lable properties
         * Id represents link path, label indcaties title of page while option file field for define custom location for content file.
         */
        'navigation' => [
            'Section' => [
                [
                    'id' => '',
                    'label' => 'label'
                ],
            ]
        ]
    ]
];
