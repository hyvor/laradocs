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
You can change this file values according to your need.
```php
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
        'pricing' => [//second documentation
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
```
## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.