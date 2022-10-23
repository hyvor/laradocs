<?php

use Hyvor\DocGenerator\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

$config = config('docgenpackage');
$docsPath = $config['view_files_path'];

// Route::get('/docs/writing', [DocsController::class, 'handle']);
Route::get("/".$docsPath."/{page?}", [DocsController::class, 'handle']);
