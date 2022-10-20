<?php

namespace Hyvor\DocGenerator\Http\Controllers;

use Hyvor\DocGenerator\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ParsedownExtra;

class DocsController extends Controller
{

    public function handle(Request $request)
    {
        $page = $request->route('page') ?? 'index';
        $content = $this->getContentFromName($page);
       
        if (is_null($content)) {
            return abort(404);
        }

        $parseDown = new ParsedownExtra();
        $content = $parseDown->text($content);

        // $content = $this->replaceDynamicData($page, $content);
        
        preg_match('/<h1>(.+)<\/h1>/', $content, $matches);
        $title = $matches[1] ?? 'Hyvor Blogs Docs';

        return view('docgenviews::docs', [
            'pageName' => $page,
            'content' => $content,
            'title' => $title,
            'nav' => include(resource_path('views/docs/nav.php')),
        ]);
    }

    private function getContentFromName($name)
    {
        $name = $name ? $name : 'index';
        $file = resource_path("views/docs/$name.md");

        if (file_exists($file)) {
            return file_get_contents($file);
        } else {
            return null;
        }
    }
}