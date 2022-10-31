<?php

namespace Hyvor\Laradocs\Console;

use Hyvor\Laradocs\Http\Controllers\DocsController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CacheDocs extends Command
{
    protected $signature = 'laradocs:cache';

    protected $description = 'Store content files in cache';

    public function handle() : void
    {
        $config = config('docgenpackage');

        if(is_array($config)){
            foreach($config as $docKey => $doc){
                foreach($doc['navigation'] as $page){
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
}