<?php

use Hyvor\DocGenerator\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

$config = config('docgenpackage');
$docsPath = $config['docs_route'];

// Route::get('/docs/writing', [DocsController::class, 'handle']);
Route::get("/".$docsPath."/{page?}", [DocsController::class, 'handle']);
