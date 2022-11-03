<?php

namespace Hyvor\Laradocs\Http\Controllers;

use Hyvor\Laradocs\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use ParsedownExtra;

class DocsController extends Controller
{
    public function handle(Request $request) : mixed
    {
        $page = (string) $request->route('page');
        $route = Route::currentRouteName();

        $config = config('laradocs_config');
        if (!is_array($config))
            return abort(404);

        $key = array_search($route, array_column($config, 'route'));
        $documentConfig = $config[$key];
        $contentDir = $documentConfig['content_directory'] ?? 'docs';
        $navigation = $documentConfig['navigation'] ?? [];
        
        $linkData = $this->getLinkData($navigation, $page);
        $filePath = $linkData->getData()->file;
        $title = $linkData->getData()->label;

        $cacheKey = $route.'|'.$filePath;
        if(Cache::store('file')->get($cacheKey))
            $content = Cache::store('file')->get($cacheKey);
        else
            $content = $this->processContent($contentDir, $filePath);
        
        return view('laradocs_views::docs', [
            'pageName' => $page,
            'content' => $content,
            'title' => $title,
            'route' => $route,
            'theme' => $documentConfig['theme'] ?? 'theme',
            'nav' => $navigation,
        ]);
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param  array  $navigation
     * @param  string  $page
     * @return \Illuminate\Http\JsonResponse
     */
    private function getLinkData(array $navigation, string $page) : JsonResponse 
    {
        foreach($navigation as $section){
            foreach($section as $link){
                if($link['id'] == $page){
                    if(isset($link['file']))
                        return new JsonResponse(['label' => $link['label'], 'file' => $link['file']]);
                    else
                        return new JsonResponse(['label' => $link['label'], 'file' => !empty($link['id']) ? $link['id'] : 'index']);
                }
            }
        }

        return abort(404);
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
            return $this->error("Content file does not exist or empty");
        }
    }

    private function error(string $error) : string 
    {
        return <<<HTML
        <div class="error-message">
            $error
        </div>
        HTML;
    }

    private function replaceDynamicData(string $markdown) : string
    {
        $dynamicData = [];
        foreach ($dynamicData as $key => $value) {
            $markdown = str_replace('{{'.$key.'}}', $value, $markdown);
        }

        return $markdown;
    }
}