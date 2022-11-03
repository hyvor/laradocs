<?php

namespace Hyvor\Laradocs\Http\Controllers;

use Hyvor\Laradocs\Facades\ContentProcessor;
use Hyvor\Laradocs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DocsController extends Controller
{
    public function handle(Request $request) : mixed
    {
        $page = (string) $request->route('page');
        $route = Route::currentRouteName();

        return ContentProcessor::process($route, $page);
    }
}