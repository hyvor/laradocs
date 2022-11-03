<?php

test('parsing paragraph',  function() {
    $this->assertEquals('<p>hello</p>', $this->parseContent('hello'));
});

test('parsing heading',  function() {
    $this->assertEquals('<h1>hello</h1>', $this->parseContent('#hello'));

    $this->assertEquals('<h2>hello</h2>', $this->parseContent('##hello'));

    $this->assertEquals('<h3>hello</h3>', $this->parseContent('###hello'));
});

test('parsing links',  function() {
    $this->assertEquals('<p>Link test <a href="/console">Console Link</a></p>', $this->parseContent('Link test [Console Link](/console)'));
});

test('parsing bullet points',  function() {
    $this->assertEquals("<ul>\n<li>point 1</li>\n</ul>", $this->parseContent("* point 1"));
});

test('parsing code block syntax',  function() {
    $code = "```json\n{'hyvor_talk_id': 1,'name': 'hyvor'}\n```";

    $this->assertEquals("<pre><code class=\"language-json\">{'hyvor_talk_id': 1,'name': 'hyvor'}</code></pre>", $this->parseContent($code));
});

test('parsing table syntax',  function(){
    $table = "Key | Value | Description\n----|-------|-------------\n`hyvor_talk_id` | int | ID of the page";

    $parsed = "<table>\n<thead>\n<tr>\n<th>Key</th>\n<th>Value</th>\n<th>Description</th>\n</tr>\n</thead>\n<tbody>\n<tr>\n<td><code>hyvor_talk_id</code></td>\n<td>int</td>\n<td>ID of the page</td>\n</tr>\n</tbody>\n</table>";
    
    $this->assertEquals($parsed, $this->parseContent($table));
});

test('parsing text highlight',  function(){
    $this->assertEquals("<p><code>hightligher</code></p>", $this->parseContent("`hightligher`"));
});

test('parsing quotes',  function(){
    $this->assertEquals("<blockquote>\n<p>quoted text</p>\n</blockquote>", $this->parseContent("> quoted text"));
});

test('image rendering', function(){
    $this->assertEquals("<p><img src=\"/img/docs/appearance-colors.png\" alt=\"Colors Editor\" /></p>", $this->parseContent("![Colors Editor](/img/docs/appearance-colors.png)"));
});