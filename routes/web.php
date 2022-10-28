<?php

use Hyvor\Laradocs\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

$config = config('docgenpackage');

foreach($config as $doc){
    $route = strtolower($doc['name']);
    Route::get("/$route/{page?}", [DocsController::class, 'handle'])->name($route);
}
