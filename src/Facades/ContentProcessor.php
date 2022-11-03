<?php

namespace Hyvor\Laradocs\Facades;

use Illuminate\Support\Facades\Facade;

class ContentProcessor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ContentProcessor';
    }
}