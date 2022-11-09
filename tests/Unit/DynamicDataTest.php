<?php

use Hyvor\Laradocs\Facades\ContentProcessor;

test('if variable without spaces working',  function() {
    ContentProcessor::setData(['name' => 'Supun', 'age' => 20]);
    $html = "<p>hello {{name}}, are you {{age}} years old</p>";

    $content = ContentProcessor::replaceDynamicData($html);
    $this->assertEquals('<p>hello Supun, are you 20 years old</p>', $content);
});

test('if variable with front space working',  function() {
    ContentProcessor::setData(['name' => 'Saman', 'age' => 14]);
    $html = "<p>hello {{   name}}, are you {{ age}} years old</p>";

    $content = ContentProcessor::replaceDynamicData($html);
    $this->assertEquals('<p>hello Saman, are you 14 years old</p>', $content);
});

test('if variable with front back working',  function() {
    ContentProcessor::setData(['name' => 'Rachel', 'age' => 22]);
    $html = "<p>hello {{name  }}, are you {{age  }} years old</p>";

    $content = ContentProcessor::replaceDynamicData($html);
    $this->assertEquals('<p>hello Rachel, are you 22 years old</p>', $content);
});


test('if variable with both end spaces working',  function() {
    ContentProcessor::setData(['name' => 'Saman', 'age' => 14]);
    $html = "<p>hello {{   name }}, are you {{ age    }} years old</p>";

    $content = ContentProcessor::replaceDynamicData($html);
    $this->assertEquals('<p>hello Saman, are you 14 years old</p>', $content);
});

test('if words are not replacing without curly bracket',  function() {
    ContentProcessor::setData(['name' => 'Saman', 'age' => 18]);
    $html = "<p>hello name, are you age years old</p>";

    $content = ContentProcessor::replaceDynamicData($html);
    $this->assertEquals('<p>hello name, are you age years old</p>', $content);
});

test('if invalid variables not replacing',  function() {
    ContentProcessor::setData(['name' => 'Saman', 'age' => 44]);
    $html = "<p>hello {{invalid}}, are you {{false}} years old</p>";

    $content = ContentProcessor::replaceDynamicData($html);
    $this->assertEquals('<p>hello {{invalid}}, are you {{false}} years old</p>', $content);
});