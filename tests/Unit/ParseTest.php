<?php

test('test valid content parsing', function () {
    $content = "# heading1\n ## heading 2\n ### heading 3 \n > blockquote \n `hyvor_talk_id` \n [Console](/console)";

    $rendered = "<h1>heading1</h1>\n<h2>heading 2</h2>\n<h3>heading 3</h3>\n<blockquote>\n<p>blockquote\n<code>hyvor_talk_id</code>\n<a href=\"/console\">Console</a></p>\n</blockquote>";

    $response = $this->parseContent($content);
    expect($response)->toBe($rendered);
});