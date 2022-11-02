<?php

namespace Hyvor\Laradocs\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Hyvor\Laradocs\LaradocsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaradocsServiceProvider::class,
        ];
    }
}