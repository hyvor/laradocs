# Laradocs
Fully customizable, small libray for laravel projects to generate documentation quickly.

## Installation

Use the composer to install Doc generator to your laravel project.

```bash
composer require hyvor/laradocs 
```

## Usage

After installation you need to publish it's assets and configurations file using following commands to make it customizable. You can define multiple documentation by using several arrays in config. Each array represents seperate configurations for specific documentation of your application.

The `route` key in the configuration file is the subdomain given by Laradocs to the documentation. You cannot use your application without that subdomain route key.

The `theme` key defines your theme css file name. Default theme file is `theme.css`.

Your content files path can be set in `config.php` at `content_directory` as base path of your application. Default path is `docs`.

`navigation` key in config is an array which defines the design of navigation in your documentation. There is a section array inside navigation array. The `section` seperates the links of your navigation panel.

Inside a section, there are multiple arrays for navigation `links` with each link comprised three keys. They are `id, file, label`

- `id` is required, it defines the path for the link and content file. 
- `file` is optional, specify the path for content file if it is different from default `id` value
- `lable` is also required which establish title of the page and navigation menu lable

### Publish assets to public folder (* Required)
```bash
php artisan vendor:publish --provider="Hyvor\Laradocs\LaradocsServiceProvider" --tag="assets"
```
Asset file publication is required to make them accessible for laradocs.

### Publish configuration files (* Required)
```bash
php artisan vendor:publish --provider="Hyvor\Laradocs\LaradocsServiceProvider" --tag="config"
```
Config file publish to your application directory is required. You must define its required fields to make your laradocs plugin work.

### Publish view files (Optional)
```bash
php artisan vendor:publish --provider="Hyvor\Laradocs\LaradocsServiceProvider" --tag="views"
```
You only need to publish views to your application directory if you want to customize default structure of views.

## How to create your own theme for documentation
There is an option provided in laradocs to create your own design for the documentation. You have to define path to your view files using the `view` value in config. There are several important dynamic variables returns from laradocs backend as displayed in table bellow.

| Variable Name | Data Type | Description |
| ------ | ------ | ------ |
| `$content` | mixed | Returns the `content` of the page |
| `$pageName` | string | Returns the `id` value of page link |
| `$label` | string | Returns the `label` value of page link |
| `$route` | string | Returns the `route name` of the page |
| `$nav` | array | Returns `navigation` array of documentation |

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
         * You can define path to your own theme here, laradocs default theme will display if null provided
         */
        'view' => null,
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