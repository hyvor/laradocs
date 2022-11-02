<?php

namespace Hyvor\Laradocs\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Hyvor\Laradocs\LaradocsServiceProvider;
use ParsedownExtra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaradocsServiceProvider::class,
        ];
    }

    protected function parseContent(string $content)
    {
        $parseDown = new ParsedownExtra();
        $response = $parseDown->text($content);
        return $response;
    }
}