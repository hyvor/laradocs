<?php

beforeEach(function(){
    $this->config = config('testing');
});

test('test document routes in configuration', function () {
    foreach($this->config as $section){
        $route = strtolower($section['route']);
        $this->get($route)->assertStatus(200);
    }
});

test('test invalid document route', function () {
    $this->get('invalid')->assertStatus(404);
});

test('test pages routes in each doc', function () {
    foreach($this->config as $section){
       foreach($section['navigation'] as $nav){
            foreach($nav as $page){
                $route = strtolower($section['route']);
                $pagePath = strval($page['id']);
                $this->get($route.'/'. $pagePath)->assertStatus(200);
            }
       }
    }
})->skip();

test('test invalid page route not found status', function () {
    foreach($this->config as $section){
        $route = strtolower($section['route']);
        $this->get($route.'/testing')->assertStatus(404);
    }
});