<?php

use Hyvor\Laradocs\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

$config = config('docgenpackage');
$navigation = $config['nav'];

foreach($navigation as $path => $nav){
    $path = strtolower($path);
    Route::get("/$path/{page?}", [DocsController::class, 'handle'])->name($path);
}
