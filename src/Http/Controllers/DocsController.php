<?php

namespace Hyvor\Laradocs\Http\Controllers;

use Hyvor\Laradocs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use ParsedownExtra;

class DocsController extends Controller
{
    protected $dynamicData = [];
    public function handle(Request $request)
    {
        $page = $request->route('page') ?? 'index';
        $route = $request->route()->getName();
        $pageName = $page ? $page : 'index';

        $cacheKey = $route.'|'.$pageName;
        if(Cache::get($cacheKey))
            $content =  Cache::get($cacheKey);
        else
            $content = $this->processContent($route, $pageName);
        
        preg_match('/<h1>(.+)<\/h1>/', $content, $matches);
        $title = $matches[1] ?? 'Documentation';
        $config = config('docgenpackage');

        return view('docgenviews::docs', [
            'pageName' => $page,
            'content' => $content,
            'title' => $title,
            'route' => $route,
            'theme' => $config['theme'],
            'nav' => $config['nav'][$route],
        ]);
    }

    public function processContent(string $route, string $name)
    {
        $config = config('docgenpackage');
        if(!$config)
            return;

        $dir = $config['content_directory'];
        $file = resource_path("views/$dir/$route/$name.md");
        if (file_exists($file)) {
            $content = file_get_contents($file);

            if (is_null($content))
                return abort(404);

            $parseDown = new ParsedownExtra();
            $content = $parseDown->text($content);
            $content = $this->replaceDynamicData($content);

            return $content;
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

    private function replaceDynamicData(string $markdown){
        foreach ($this->dynamicData as $key => $value) {
            $markdown = str_replace('{{'.$key.'}}', $value, $markdown);
        }

        return $markdown;
    }

    protected function setDynamicData(array $dynamicData){
        $this->dynamicData = $dynamicData;
    }
}