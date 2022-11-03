<?php

use Hyvor\Laradocs\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

$config = config('laradocs_config');

foreach($config as $doc){
    $route = strtolower($doc['route']);
    Route::get("/$route/{page?}", [DocsController::class, 'handle'])->name($route);
}