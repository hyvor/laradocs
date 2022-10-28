<?php

namespace Hyvor\Laradocs\Console;

use Hyvor\Laradocs\Http\Controllers\DocsController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;

class CacheDocs extends Command
{
    protected $signature = 'laradocs:cache';

    protected $description = 'Store content files in cache';

    protected $config;
    
    public function handle()
    {
        $this->config = config('docgenpackage');
        $nav = $this->config['nav'];

        foreach($nav as $docKey => $doc){
            foreach($doc as $page){
                foreach($page as $link){
                    $pageLink = $link[0] ?? 'index';
                    $key = $docKey.'|'.$pageLink;
                    // $request = new Request();

                    // $request->setRouteResolver(function () use ($request,$docKey,$pageLink) {
                    //     return (new Route('GET', "/$docKey/$pageLink", []))->name($docKey)->bind($request);
                    // });
                   
                    $response = (new DocsController)->processContent($docKey, $pageLink);
                    Cache::put($key, $response);
                }
            }
        }
    }
}