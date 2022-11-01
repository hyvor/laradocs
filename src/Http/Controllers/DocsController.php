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

        $filePath = $this->getFilePath($route, $page);
       
        $cacheKey = $route.'|'.$filePath;
        if(Cache::get($cacheKey))
            $content = Cache::get($cacheKey);
        else
            $content = $this->processContent($route, $filePath);
        
        preg_match('/<h1>(.+)<\/h1>/', $content, $matches);
        $title = $matches[1] ?? 'Documentation';
        $config = config('docgenpackage');

        return view('docgenviews::docs', [
            'pageName' => $page,
            'content' => $content,
            'title' => $title,
            'route' => $route,
            'theme' => is_array($config) ? $config[$route]['theme'] : 'theme',
            'nav' => is_array($config) ? $config[$route]['navigation']: [],
        ]);
    }

    private function getFilePath(string $route, string $page) : string 
    {
        $config = config('docgenpackage');
        if(!is_array($config))
            return 'index';

        $nav = $config[$route]['navigation'];
        foreach($nav as $section){
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

    public function processContent(string $route, string $name) : string
    {
        $config = config('docgenpackage');
        if(!is_array($config) || !$config[$route])
            return $this->error("Invalid config file");

        $dir = $config[$route]['content_directory'];
        $file = resource_path("views/$dir/$name.md");
        if (file_exists($file)) {
            $content = file_get_contents($file);

            if (!$content)
                return abort(404);

            $parseDown = new ParsedownExtra();
            $content = $parseDown->text($content);
            $content = $this->replaceDynamicData($content);

            return $content;
        } else {
            return $this->error("Content file not exist in defined path");
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