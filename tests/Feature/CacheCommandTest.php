<?php

use Hyvor\Laradocs\Facades\ContentProcessor;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

beforeEach(function(){
    $this->config = config('testing');
});

test('check if cache set for all config links',  function() {
    Artisan::call('laradocs:cache');
   
    foreach($this->config as $doc){
        foreach($doc['navigation'] as $page){
            foreach($page as $link){
                $pageLink = !empty($link['id']) ? $link['id'] : 'index';
                $cacheKey = $doc['route'].'|'.$pageLink;

                $response = ContentProcessor::cacheViews($doc['route'], $link['id'])->render();
                $this->assertEquals(Cache::store('file')->get($cacheKey), $response);
            }
        }
    }
});
