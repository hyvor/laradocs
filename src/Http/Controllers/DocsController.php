<?php

namespace Hyvor\Laradocs\Http\Controllers;

use Hyvor\Laradocs\Facades\ContentProcessor;
use Hyvor\Laradocs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class DocsController extends Controller
{
    public function handle(Request $request) : mixed
    {
        $page = (string) $request->route('page');
        $route = Route::currentRouteName();

        $pageLink = !empty($page) ? $page : 'index';
        $cacheKey = $route.'|'.$pageLink;
        if(Cache::store('file')->get($cacheKey))
            return Cache::store('file')->get($cacheKey);

        $data =  ContentProcessor::process($route, $page); /** @phpstan-ignore-line */
        return view('laradocs::docs', (array) json_decode($data->content(), true));
    }
}