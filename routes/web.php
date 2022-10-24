<?php

use Hyvor\Laradocs\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

$config = config('docgenpackage');
$url = $config['app_url'];

// Route::get('/docs/writing', [DocsController::class, 'handle']);
Route::get("/$url/{page?}", [DocsController::class, 'handle']);
