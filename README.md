# Document Generator
Fully customizable, small libray for laravel projects to generate documentation quickly.

## Installation

Use the composer to install Doc generator to your laravel project.

```bash
composer require hyvor/doc-generator 
```

## Usage

After installation you need to publish it's assets and configurations file using folowing commands to make it customizable. 
Your content files can be placed inside `views` directory in your project and define path in `config.php` file. Default path is `views/docs/pages`.
Then you can check it using doc generator default path `{Your project url}/docgen`. Default path can be changed in `config.php`

### Publish assets to public folder
```bash
php artisan vendor:publish --provider="Hyvor\DocGenerator\DocGeneratorServiceProvider" --tag="assets"
```

### Publish configuration files (You can also find it in verndor directory)
```bash
php artisan vendor:publish --provider="Hyvor\DocGenerator\DocGeneratorServiceProvider" --tag="config"
```

### Publish view files (If you want to customize views)
```bash
php artisan vendor:publish --provider="Hyvor\DocGenerator\DocGeneratorServiceProvider" --tag="views"
```
## Inside config file
You can change this file values according to your need.
```php
<?php

return [
    'app_url' => 'test', //your app url
    'content_files_path' => 'docs/pages', //md files path in views
    'brand_name' => 'My Blog', //your blog name
    'logo_url' => 'https://blogs.hyvor.com/img/logo.png', //logo image url
    'main_link' => '/test', //redirect link when click on logo
   
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
```
## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.