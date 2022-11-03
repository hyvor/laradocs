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
        $config = config('laradocs_config');

        if(is_array($config)){
            foreach($config as $docKey => $doc){
                foreach($doc['navigation'] as $page){
                    foreach($page as $link){
                        $pageLink = $link[0] ?? 'index';
                        $key = $docKey.'|'.$pageLink;
                       
                        $response = (new DocsController)->processContent($docKey, $pageLink);
                        Cache::store('file')->put($key, $response);
                    }
                }
            }
        }
    }
}