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
        $route = $request->route()->getName();
        $content = $this->getContentFromName($page, $route);

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
            'route' => $route,
            'theme' => $this->config['theme'],
            'nav' => $this->config['nav'][$route],
        ]);
    }

    private function getContentFromName(string $name, string $route)
    {
        $dir = $this->config['content_directory'];

        $name = $name ? $name : 'index';
        $file = resource_path("views/$dir/$route/$name.md");

        if (file_exists($file)) {
            return file_get_contents($file);
        } else {
            return $this->error("Content file not exist in defined path");
        }
    }

    private function error(string $error) {
        return <<<HTML
        <div style="padding: 10px;
            text-align: center;
            background: #f9bdbd;
            font-weight: 600;
            border-radius: 5px;
            font-size: 15px;
        ">
            $error
        </div>
        HTML;
    }
}