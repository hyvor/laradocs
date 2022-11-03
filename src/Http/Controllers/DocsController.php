<?php

namespace Hyvor\Laradocs\Http\Controllers;

use Hyvor\Laradocs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use ParsedownExtra;

class DocsController extends Controller
{
    protected array $dynamicData = [];
    public function handle(Request $request)
    {
        $page = (string) $request->route('page');
        $route = $request->route()->getName();

        $config = config('docgenpackage');
        if (!is_array($config))
            return abort(404);

        $key = array_search($route, array_column($config, 'route'));
        $documentConfig = $config[$key];
        $contentDir = $documentConfig['content_directory'] ?? 'docs';
        $navigation = $documentConfig['navigation'] ?? [];

        $filePath = $this->getFilePath($navigation, $page);
       
        $cacheKey = $route.'|'.$filePath;
        if(Cache::get($cacheKey))
            $content = Cache::get($cacheKey);
        else
            $content = $this->processContent($contentDir, $filePath);
        
        preg_match('/<h1>(.+)<\/h1>/', $content, $matches);
        $title = $matches[1] ?? 'Documentation';
        
        return view('docgenviews::docs', [
            'pageName' => $page,
            'content' => $content,
            'title' => $title,
            'route' => $route,
            'theme' => $documentConfig['theme'] ?? 'theme',
            'nav' => $navigation,
        ]);
    }

    private function getFilePath(array $navigation, string $page) : string 
    {
        foreach($navigation as $section){
            foreach($section as $link){
                if($link['id'] == $page){
                    if(isset($link['file']))
                        return $link['file'];
                    else
                        return !empty($link['id']) ? $link['id'] : 'index';
                }
            }
        }
        
    }

    public function processContent(string $directory, string $name) : string
    {
        $file = resource_path("views/$directory/$name.md");
        if (file_exists($file)) {
            $content = file_get_contents($file);

            if (!$content)
                return abort(404);

            $parseDown = new ParsedownExtra();
            $content = $parseDown->text($content);
            $content = $this->replaceDynamicData($content);

            return $content;
        } else {
            return $this->error("Content file not exist or empty");
        }
    }

    private function error(string $error) : string 
    {
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

    private function replaceDynamicData(string $markdown) : string
    {
        foreach ($this->dynamicData as $key => $value) {
            $markdown = str_replace('{{'.$key.'}}', $value, $markdown);
        }

        return $markdown;
    }

    protected function setDynamicData(array $dynamicData) : void
    {
        $this->dynamicData = $dynamicData;
    }
}