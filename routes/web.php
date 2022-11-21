<?php

use Hyvor\Laradocs\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

$config = [];

if(env('APP_ENV') == 'testing')
    $config = config('testing');
else
    $config = config('laradocs');

foreach($config as $doc){
    $route = strtolower($doc['route']);
    if(empty($route))
        continue;
    Route::get("/$route/{page?}", [DocsController::class, 'handle'])->name($route);
}