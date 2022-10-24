<?php

namespace Hyvor\Laradocs\Http\Controllers;

use Hyvor\Laradocs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ParsedownExtra;

class DocsController extends Controller
{
    protected $config;
    public function handle(Request $request)
    {
        $page = $request->route('page') ?? 'index';
        $this->config = config('docgenpackage');
        $content = $this->getContentFromName($page);

        if (is_null($content)) {
            return abort(404);
        }

        $parseDown = new ParsedownExtra();
        $content = $parseDown->text($content);

        // $content = $this->replaceDynamicData($page, $content);
        
        preg_match('/<h1>(.+)<\/h1>/', $content, $matches);
        $title = $matches[1] ?? 'Documentation';

        return view('docgenviews::docs', [
            'pageName' => $page,
            'content' => $content,
            'title' => $title,
            'theme' => $this->config['theme'],
            'nav' => $this->config['nav'],
        ]);
    }

    private function getContentFromName($name)
    {
        $path = $this->config['content_files_path'];

        $name = $name ? $name : 'index';
        $file = resource_path("views/$path/$name.md");

        if (file_exists($file)) {
            return file_get_contents($file);
        } else {
            return null;
        }
    }
}