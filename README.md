# Laradocs
Fully customizable, small libray for laravel projects to generate documentation quickly.

## Installation

Use the composer to install Doc generator to your laravel project.

```bash
composer require hyvor/laradocs 
```

## Usage

After installation you need to publish it's assets and configurations file using following commands to make it customizable. 

The `route` key in the configuration file is the subdomain given by Laradocs to the documentation. You cannot use your application without that subdomain route key.

The `theme` key defines your theme css file name. Default theme file is `theme.css`.

Your content files path can be set in `config.php` at `content_directory` as base path of your application. Default path is `docs`.

`navigation` key in config is an array which defines the design of navigation in your documentation.
### Publish assets to public folder
```bash
php artisan vendor:publish --provider="Hyvor\Laradocs\LaradocsServiceProvider" --tag="assets"
```

### Publish configuration files (You can also find it in verndor directory)
```bash
php artisan vendor:publish --provider="Hyvor\Laradocs\LaradocsServiceProvider" --tag="config"
```

### Publish view files (If you want to customize views)
```bash
php artisan vendor:publish --provider="Hyvor\Laradocs\LaradocsServiceProvider" --tag="views"
```
## Inside config file
You can change this file values according to your requirement.
```php
<?php

/**
    * you can have multiple documents as seperate arrays inside return array.
**/

return 
[
    [
        /**
         * @required
         * The subdomain given by Laradocs to the documentation
         */
        'route' => 'laradocs',
        /**
         * @optional
         * The theme file name of your documentation(without .css extention)
         */
        'theme' => null,
         /**
         * @required
         * where should we host your content files? path should be set from your application base path.
         */
        'content_directory' => 'resources/views/docs/laradocs',
        /**
         * @required
         * How is your document navigation should looks like?
         * It should have section and page links. each page link should have id,lable properties and file property is optional
         * Id represents link path, label defines title of page while option file field for define custom location for content file of relevant page.
         * All properties should be string
         * You can define multiples sections and multiple pages as you want
         */
        'navigation' => [
            'First Section' => [
                [
                    'id' => '', //page link url
                    'file' => 'index', // optional, you can define alternative file path here
                    'label' => 'Introduction' // page label
                ],
                [
                    'id' => 'description',
                    'label' => 'What is laradocs'
                ],
            ],
            'Second Section' => [
                [
                    'id' => 'about',
                    'label' => 'About us'
                ]
            ]
        ]
    ]
];
```
## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.