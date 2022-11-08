# Laradocs
Fully customizable, small libray for laravel projects to generate documentation quickly.

## Installation

Use the composer to install Doc generator to your laravel project.

```bash
composer require hyvor/laradocs 
```

## Usage

After installation you need to publish it's assets and configurations file using folowing commands to make it customizable. 
Your content files can be placed inside `views` directory in your project and define path in `config.php` file. Default path is `views/docs/pages`.
Then you can check it using doc generator default path `{Your project url}/docgen`. Default path can be changed in `config.php`

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
         * It should have section and each section link should have id,file,lable properties
         * Id represents link path, label indcaties title of page while option file field for define custom location for content file.
         */
        'navigation' => [
            'First Section' => [
                [
                    'id' => '',
                    'label' => 'Introduction'
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