<?php

use Hyvor\Laradocs\Facades\ContentProcessor;

test('if variable without spaces working',  function() {
    ContentProcessor::setData(['name' => 'Supun', 'age' => 20]);
    $html = "<p>hello {{name}}, are you {{age}} years old</p>";

    $content = ContentProcessor::replaceDynamicData($html);
    $this->assertEquals('<p>hello Supun, are you 20 years old</p>', $content);
});


test('if variable with spaces working',  function() {
    ContentProcessor::setData(['name' => 'Saman', 'age' => 14]);
    $html = "<p>hello {{ name }}, are you {{ age }} years old</p>";

    $content = ContentProcessor::replaceDynamicData($html);
    $this->assertEquals('<p>hello Saman, are you 14 years old</p>', $content);
});
