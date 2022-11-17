<?php

beforeEach(function(){
    $this->config = [
        [
            'route' => 'docsv3',
            'view' => null,
            'content_directory' => 'resources/views/docs/pages',
            'navigation' => [
                'Getting Started' => [
                    [
                        'id' => '',
                        'label' => 'Introduction'
                    ],
                    [
                        'id' => 'install',
                        'label' => 'Installing'
                    ]
                ]
            ]
        ]
    ];
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
                $this->get($route.'/'.$page['id'])->assertStatus(200);
            }
       }
    }
});

test('test invalid page route not found status', function () {
    foreach($this->config as $section){
        $route = strtolower($section['route']);
        $this->get($route.'/testing')->assertStatus(404);
    }
});